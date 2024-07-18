<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderDitempat;

class makan_tempat extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        $total_price = $this->calculateTotalPrice($cart);
        $tables = Table::all();
        
        return view('layouts.makan_di_tempat.makan', compact('products', 'cart', 'total_price', 'tables'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        if (!in_array($product_id, array_column($cart, 'id'))) {
            $cart[] = [
                'id' => $product_id,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $request->input('product_img'),
                'quantity' => 1,
                'stock' => $product->stock
            ];
        } else {
            foreach ($cart as &$item) {
                if ($item['id'] == $product_id && $item['quantity'] < $product->stock) {
                    $item['quantity'] += 1;
                    break;
                }
            }
        }

        session()->put('cart', $cart);
        return response()->json(['cart' => $cart, 'total_price' => $this->calculateTotalPrice($cart)]);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $product_id = $request->input('product_id');
    
        $cart = array_values(array_filter($cart, function($item) use ($product_id) {
            return $item['id'] != $product_id;
        }));
    
        session()->put('cart', $cart);
    
        return response()->json(['cart' => $cart, 'total_price' => $this->calculateTotalPrice($cart)]);
    }
    
    // private function calculateTotalPrice($cart)
    // {
    //     return array_reduce($cart, function($total, $item) {
    //         return $total + $item['price'] * $item['quantity'];
    //     }, 0);
    // }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $action = $request->input('action');
    
        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                if ($action == 'increase' && $item['quantity'] < $item['stock']) {
                    $item['quantity'] += 1;
                } elseif ($action == 'decrease' && $item['quantity'] > 1) {
                    $item['quantity'] -= 1;
                } else {
                    $item['quantity'] = $quantity;
                }
                break;
            }
        }
    
        session()->put('cart', $cart);
    
        return response()->json([
            'cart' => $cart,
            'total_price' => $this->calculateTotalPrice($cart),
        ]);
    }
    
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total_price = $this->calculateTotalPrice($cart);
        
        return response()->json(['cart' => $cart, 'total_price' => $total_price]);
    }
    public function saveOrder(Request $request)
    {
        // Setel zona waktu ke Asia/Jakarta untuk WIB
        date_default_timezone_set('Asia/Jakarta');
    
        $validatedData = $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'table_id' => 'required|exists:tables,id',
            'product' => 'required|json',
            'price' => 'required|numeric',
        ]);
    
        $order = new OrderDitempat();
        $order->nama_pemesan = $validatedData['nama_pemesan'];
        $order->table_id = $validatedData['table_id'];
        $order->product = $validatedData['product'];
        $order->price = $validatedData['price'];
        $order->jam_pesan = now()->toTimeString(); 
        $order->tanggal_pesan = now()->toDateString(); 
        $order->status_bayar = 'Belum bayar';
        $order->save();
    
        // Update status meja
        // $table = Table::find($request->input('table_id'));
        // if ($table) {
        //     $table->status = 'terbooking';
        //     $table->save();
        // }
    
        $products = json_decode($validatedData['product'], true);
        foreach ($products as $productDetail) {
            $product = Product::find($productDetail['id']);
            if ($product) {
                $product->stock -= $productDetail['qty'];
                $product->save();
            }
        }
    
        session()->forget('cart');
    
        return response()->json(['success' => 'Order has been saved successfully.']);
    }
    
    

    private function calculateTotalPrice($cart)
    {
        return array_reduce($cart, function($total, $item) {
            return $total + $item['price'] * $item['quantity'];
        }, 0);
    }
}

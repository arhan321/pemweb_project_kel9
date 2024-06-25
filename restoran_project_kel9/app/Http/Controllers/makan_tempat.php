<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class makan_tempat extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        $total_price = $this->calculateTotalPrice($cart);
        
        return view('layouts.makan_di_tempat.makan', compact('products', 'cart', 'total_price'));
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
                    $item['quantity'] = $quantity; // Untuk memastikan quantity di-set langsung
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

    private function calculateTotalPrice($cart)
    {
        return array_reduce($cart, function($total, $item) {
            return $total + $item['price'] * $item['quantity'];
        }, 0);
    }
}

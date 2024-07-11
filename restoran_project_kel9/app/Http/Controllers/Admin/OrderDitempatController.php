<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderDitempat;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreMakanditempatRequest;
use App\Http\Requests\UpdateMakanditempatRequest;
use App\Http\Requests\MassDestroyMakanditempatRequest;

class OrderDitempatController extends Controller
{
    public function index()
    {   
        abort_if(Gate::denies('orderditempat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $orderditempats = OrderDitempat::all();
    
        foreach ($orderditempats as $orderditempat) {
            Log::info('Processing orderditempat ID: ' . $orderditempat->id);
    
            $productDetails = json_decode($orderditempat->product, true);
            Log::info('Decoded product details: ', ['details' => $productDetails]);
    
            if (json_last_error() === JSON_ERROR_NONE && is_array($productDetails)) {
                $product_ids = array_column($productDetails, 'id');
                $product_names = Product::whereIn('id', $product_ids)->pluck('name', 'id')->toArray();
                Log::info('Product names: ', ['names' => $product_names]);
    
                foreach ($productDetails as &$product) {
                    if (is_array($product) && isset($product['id'])) {
                        $product['name'] = $product_names[$product['id']] ?? 'Unknown';
                    } else {
                        Log::warning('Invalid product format: ', ['product' => $product]);
                        $product = ['name' => 'Unknown', 'id' => null, 'qty' => null];
                    }
                }
    
                $orderditempat->product_details = $productDetails;
            } else {
                $orderditempat->product_details = [];
                Log::warning('Failed to decode JSON or not an array for orderditempat ID: ' . $orderditempat->id);
            }
        }
    
        return view('admin.orderditempats.index', compact('orderditempats'));
    }

    public function create()
    {
        abort_if(Gate::denies('orderditempat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $products = Product::all()->pluck('name', 'id');
        $productPrices = Product::all()->pluck('price', 'id');
        
        return view('admin.orderditempats.create', compact('products', 'productPrices'));
    }

    public function store(StoreMakanditempatRequest $request)
    {
        $requestData = $request->all();
    
        if ($request->has('product_qty')) {
            $productDetails = [];
            foreach ($request->input('product_qty') as $productId => $qty) {
                $productDetails[] = [
                    'id' => $productId,
                    'qty' => $qty
                ];
            }
    
            $requestData['product'] = json_encode($productDetails);
        }
    
        OrderDitempat::create($requestData);
    
        return redirect()->route('admin.orderditempats.index');
    }

    public function edit(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all()->pluck('name', 'id');
        $orderditempat->product_details = json_decode($orderditempat->product, true);

        return view('admin.orderditempats.edit', compact('orderditempat', 'products'));
    }

    public function update(UpdateMakanditempatRequest $request, OrderDitempat $orderditempat)
    {
        $requestData = $request->all();

        if ($request->has('product')) {
            $products = $request->input('product');
            $qtys = $request->input('qty');

            $productDetails = [];
            foreach ($products as $productId) {
                $productDetails[] = [
                    'id' => $productId,
                    'qty' => $qtys[$productId] ?? 1
                ];
            }

            $requestData['product'] = json_encode($productDetails);
        }

        $orderditempat->update($requestData);

        return redirect()->route('admin.orderditempats.index');
    }

    public function show(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.orderditempats.show', compact('orderditempat'));
    }

    public function destroy(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderditempat->delete();

        return back();
    }

    public function massDestroy(MassDestroyMakanditempatRequest $request)
    {
        $orderditempats = OrderDitempat::find(request('ids'));

        foreach ($orderditempats as $orderditempat) {
            $orderditempat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restartSession(Request $request)
    {
        $request->session()->forget(['nama_pemesan', 'product', 'qty', 'price', 'jam_pesan', 'tanggal_pesan']);
        return redirect()->route('admin.orderditempats.create');
    }
}


<?php

namespace App\Http\Controllers\Admin;

use Log;
use Gate;
use App\Models\Product;
use App\Models\OrderDitempat;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class HistoryOrderDitempatController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('history_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

        return view('admin.history_orderditempats.index', compact('orderditempats'));
    }
}

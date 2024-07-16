<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Table;
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
        $tables = Table::all();
        $statusBayarOptions = OrderDitempat::STATUS_SELECT; 
    
        return view('admin.orderditempats.create', compact('products', 'productPrices', 'tables', 'statusBayarOptions'));
    }
    
    public function store(StoreMakanditempatRequest $request)
    {
        $requestData = $request->all();
    
        if ($request->has('product_qty')) {
            $productDetails = [];
            foreach ($request->input('product_qty') as $productId => $qty) {
                $product = Product::find($productId);
                if ($product) {
                    if ($product->stock < $qty) {
                        return redirect()->back()->withErrors(['product_qty' => 'Product ' . $product->name . ' is out of stock.']);
                    }
                    $productDetails[] = [
                        'id' => $productId,
                        'qty' => $qty
                    ];
                }
            }
            $requestData['product'] = json_encode($productDetails);
        }
    
        $requestData['status_bayar'] = $request->input('status_bayar', 'Belum bayar'); 
    
        $order = OrderDitempat::create($requestData);
    
        foreach ($request->input('product_qty') as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $product->stock -= $qty;
                $product->save();
            }
        }
    
        return redirect()->route('admin.orderditempats.index')->with('success', 'Order has been created successfully.');
    }
    

    public function edit(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::all();
        $productPrices = Product::pluck('price', 'id');
        $tables = Table::pluck('name', 'id');
        $orderditempat->product_details = collect(json_decode($orderditempat->product, true) ?: []);
        $statusBayarOptions = OrderDitempat::STATUS_SELECT;

        return view('admin.orderditempats.edit', compact('orderditempat', 'products', 'productPrices', 'statusBayarOptions', 'tables'));
    }

    public function update(UpdateMakanditempatRequest $request, OrderDitempat $orderditempat)
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

        $previousStatusBayar = $orderditempat->status_bayar;

        $orderditempat->update($requestData);

        // Hapus logika untuk mengubah status meja
        // if ($previousStatusBayar != 'Sudah bayar' && $requestData['status_bayar'] == 'Sudah bayar') {
        //     if ($orderditempat->table_id) {
        //         $table = Table::find($orderditempat->table_id);
        //         if ($table) {
        //             $table->status = 'kosong';
        //             $table->save();
        //         }
        //     }
        // }

        return redirect()->route('admin.orderditempats.index');
    }

    public function show(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
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
    
        return view('admin.orderditempats.show', compact('orderditempat'));
    }

    public function destroy(OrderDitempat $orderditempat)
    {
        abort_if(Gate::denies('orderditempat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        // Hapus logika untuk mengubah status meja
        // if ($orderditempat->table_id) {
        //     $table = Table::find($orderditempat->table_id);
        //     if ($table) {
        //         $table->status = 'kosong';
        //         $table->save();
        //     }
        // }
    
        $orderditempat->delete();
    
        return back();
    }
    
    public function massDestroy(MassDestroyMakanditempatRequest $request)
    {
        $orderditempats = OrderDitempat::find(request('ids'));
    
        foreach ($orderditempats as $orderditempat) {
            // Hapus logika untuk mengubah status meja
            // if ($orderditempat->table_id) {
            //     $table = Table::find($orderditempat->table_id);
            //     if ($table) {
            //         $table->status = 'kosong';
            //         $table->save();
            //     }
            // }
            
            $orderditempat->delete();
        }
    
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restartSession(Request $request)
    {
        $request->session()->forget(['nama_pemesan', 'product', 'qty', 'price', 'jam_pesan', 'tanggal_pesan']);
        return redirect()->route('admin.orderditempats.create');
    }

    private function isTableAvailable($tableId, $tanggalPesan, $jamPesan)
    {
        $tanggalPesan = Carbon::parse($tanggalPesan)->toDateString();
        
        $orderExists = OrderDitempat::where('table_id', $tableId)
            ->whereDate('tanggal_pesan', $tanggalPesan)
            ->whereTime('jam_pesan', $jamPesan)
            ->exists();

        return !$orderExists;
    }
}



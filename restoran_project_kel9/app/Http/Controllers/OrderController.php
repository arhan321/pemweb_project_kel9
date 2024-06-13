<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Table;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $availableTables = Table::where('status', 'kosong')->get();
        return view('layouts.reservasi', compact('availableTables'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'days' => 'required|date',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'customer_email' => 'required|string|email|max:255',
            'qty' => 'required|integer|min:1',
            'table_id' => 'required|exists:tables,id',
        ]);

        $table = Table::find($request->table_id);
        $start = new \DateTime($table->start);
        $end = new \DateTime($table->finish);

        $total_price = 250000;
        $order = Order::create([
            'days' => $request->days,
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'name' => $request->name,
            'phone' => $request->phone,
            'customer_email' => $request->customer_email,
            'qty' => $request->qty,
            'table_id' => $request->table_id,
            'total_price' => $total_price,
            'status' => 'Unpaid',
        ]);

        $uniqueOrderId = 'order-' . $order->id . '-' . time();

        $table->status = 'terbooking';
        $table->save();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $uniqueOrderId,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'name' => $request->name,
                'email' => $request->customer_email,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('midtrans.checkout', compact('snapToken', 'order'));
    }

    public function callback(Request $request)
    {
        Log::info('Callback received', $request->all());

        $server_key = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);

        Log::info('Callback validation', ['hashed' => $hashed, 'signature_key' => $request->signature_key]);

        if ($hashed == $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                Log::info('Transaction status valid', ['order_id' => $request->order_id]);

                $orderIdParts = explode('-', $request->order_id);
                $orderId = $orderIdParts[1];

                $order = Order::find($orderId);
                if ($order) {
                    Log::info('Order found', ['order_id' => $orderId, 'status' => $order->status]);
                    $order->update(['status' => 'Paid']);
                    Log::info('Order status updated to Paid', ['order_id' => $orderId]);

                    try {
                        Booking::create([
                            'nama_customer' => $order->name,
                            'jumlah_orang' => $order->qty,
                            'start_book' => Carbon::parse($order->days . ' ' . $order->start_time),
                            'finish_book' => Carbon::parse($order->days . ' ' . $order->end_time),
                            'category' => 'reservasi',
                            'customer_email' => $order->customer_email,
                            'phone' => $order->phone,
                            'total_price' => $order->total_price, 
                            'status' => 'Booking',
                            'table_id' => $order->table_id,
                        ]);

                        Log::info('Booking created successfully for order ID: ' . $order->id);
                    } catch (\Exception $e) {
                        Log::error('Failed to create booking for order ID: ' . $order->id . ' with error: ' . $e->getMessage());
                    }

                    $table = Table::find($order->table_id);
                    if ($table) {
                        $table->status = 'terbooking';  // Pastikan status berubah ke 'terbooking'
                        $table->save();
                        Log::info('Table status updated to terbooking', ['table_id' => $table->id]);
                    }

                    return redirect()->route('order.show', ['id' => $order->id]);
                } else {
                    Log::warning('Order not found for order ID: ' . $orderId);
                }
            } else {
                Log::warning('Transaction status invalid', ['transaction_status' => $request->transaction_status]);
            }
        } else {
            Log::warning('Callback validation failed', ['hashed' => $hashed, 'signature_key' => $request->signature_key]);
        }
        return response()->json(['status' => 'success']);
    }

    public function showOrder($id)
    {
        $order = Order::with('table')->find($id);
        if ($order && $order->status != 'Paid') {
            $order->update(['status' => 'Paid']);

            try {
                Booking::create([
                    'nama_customer' => $order->name,
                    'jumlah_orang' => $order->qty,
                    'start_book' => Carbon::parse($order->days . ' ' . $order->start_time),
                    'finish_book' => Carbon::parse($order->days . ' ' . $order->end_time),
                    'category' => 'reservasi',
                    'customer_email' => $order->customer_email,
                    'phone' => $order->phone,
                    'total_price' => $order->total_price, 
                    'status' => 'Booking',
                    'table_id' => $order->table_id,
                ]);

                Log::info('Booking created successfully for order ID: ' . $order->id);
            } catch (\Exception $e) {
                Log::error('Failed to create booking for order ID: ' . $order->id . ' with error: ' . $e->getMessage());
            }

            $table = Table::find($order->table_id);
            if ($table) {
                $table->status = 'terbooking';  // Pastikan status berubah ke 'terbooking'
                $table->save();
                Log::info('Table status updated to terbooking', ['table_id' => $table->id]);
            }
        }

        return view('midtrans.showOrder', compact('order'));
    }
}





// namespace App\Http\Controllers;

// use Carbon\Carbon;
// use App\Models\Order;
// use App\Models\Table;
// use App\Models\Booking;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

// class OrderController extends Controller
// {
//     public function index()
//     {
//         $availableTables = Table::where('status', 'kosong')->get();
//         return view('layouts.reservasi', compact('availableTables'));
//     }

//     public function checkout(Request $request)
//     {
//         $request->validate([
//             'days' => 'required|date',
//             'name' => 'required|string|max:255',
//             'phone' => 'required|string|max:15',
//             'qty' => 'required|integer|min:1',
//             'table_id' => 'required|exists:tables,id',
//         ]);

//         // Find the selected table
//         $table = Table::find($request->table_id);
//         $start = new \DateTime($table->start);
//         $end = new \DateTime($table->finish);

//         $total_price = $request->qty * 400000;
//         $order = Order::create([
//             'days' => $request->days,
//             'start_time' => $start->format('H:i'), // Store start time
//             'end_time' => $end->format('H:i'),     // Store end time
//             'name' => $request->name,
//             'phone' => $request->phone,
//             'qty' => $request->qty,
//             'table_id' => $request->table_id,
//             'total_price' => $total_price,
//             'status' => 'Unpaid',
//         ]);

//         // Generate unique order ID for Midtrans
//         $uniqueOrderId = 'order-' . $order->id . '-' . time();

//         // Update table status to 'terbooking'
//         $table->status = 'terbooking';
//         $table->save();

//         \Midtrans\Config::$serverKey = config('midtrans.server_key');
//         \Midtrans\Config::$isProduction = false;
//         \Midtrans\Config::$isSanitized = true;
//         \Midtrans\Config::$is3ds = true;

//         $params = [
//             'transaction_details' => [
//                 'order_id' => $uniqueOrderId,
//                 'gross_amount' => $order->total_price,
//             ],
//             'customer_details' => [
//                 'name' => $request->name,
//                 'phone' => $request->phone,
//             ],
//         ];

//         $snapToken = \Midtrans\Snap::getSnapToken($params);
//         return view('midtrans.checkout', compact('snapToken', 'order'));
//     }

//     public function callback(Request $request)
//     {
//         Log::info('Callback received', $request->all());

//         $server_key = config('midtrans.server_key');

//         $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);

//         Log::info('Callback validation', ['hashed' => $hashed, 'signature_key' => $request->signature_key]);

//         if ($hashed == $request->signature_key) {
//             if (in_array($request->transaction_status, ['capture', 'settlement'])) {
//                 Log::info('Transaction status valid', ['order_id' => $request->order_id]);

//                 // Extract order ID from the custom unique order ID
//                 $orderIdParts = explode('-', $request->order_id);
//                 $orderId = $orderIdParts[1];

//                 $order = Order::find($orderId);
//                 $order->update(['status' => 'Paid']);

//                 // Add booking record
//                 try {
//                     Booking::create([
//                         'nama_customer' => $order->name,
//                         'jumlah_orang' => $order->qty,
//                         'start_book' => Carbon::parse($order->days . ' ' . $order->start_time),
//                         'finish_book' => Carbon::parse($order->days . ' ' . $order->end_time),
//                         'category' => 'reservasi',
//                         'status' => 'Booking',
//                         'table_id' => $order->table_id,
//                     ]);

//                     Log::info('Booking created successfully for order ID: ' . $order->id);
//                 } catch (\Exception $e) {
//                     Log::error('Failed to create booking for order ID: ' . $order->id . ' with error: ' . $e->getMessage());
//                 }

//                 $table = Table::find($order->table_id);
//                 $table->status = 'kosong';
//                 $table->save();
//             } else {
//                 Log::warning('Transaction status invalid', ['transaction_status' => $request->transaction_status]);
//             }
//         } else {
//             Log::warning('Callback validation failed', ['hashed' => $hashed, 'signature_key' => $request->signature_key]);
//         }
//         return response()->json(['status' => 'success']);
//     }

//     public function showOrder($id)
    // {
    //     $order = Order::find($id);
    //     return view('midtrans.checkout', compact('order'));
    // }
// }

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('layouts.reservasi');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'days' => 'required|date',
            'hours' => 'required|date_format:H:i',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'qty' => 'required|integer|min:1',
        ]);

        $total_price = $request->qty * 250000;
        $order = Order::create([
            'days' => $request->days,
            'hours' => $request->hours,
            'name' => $request->name,
            'phone' => $request->phone,
            'qty' => $request->qty,
            'total_price' => $total_price,
            'status' => 'Unpaid',
        ]);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'name' => $request->name,
                'phone' => $request->phone,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('midtrans.checkout', compact('snapToken', 'order'));
    }

    public function callback(Request $request)
    {
        $server_key = config('midtrans.server_key');

        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);

        if ($hashed == $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function showOrder($id)
    {
        $order = Order::find($id);
        return view('midtrans.checkout', compact('order'));
    }
}
// namespace App\Http\Controllers;

// use App\Models\Order;
// use App\Models\Table;
// use Illuminate\Http\Request;

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
//             'date' => 'required|date',
//             'time_slot' => 'required|string',
//             'name' => 'required|string|max:255',
//             'phone' => 'required|string|max:15',
//             'qty' => 'required|integer|min:1',
//             'table_id' => 'required|exists:tables,id',
//         ]);

//         $total_price = $request->qty * 250000;
//         $order = Order::create([
//             'days' => $request->date,
//             'hours' => explode('-', $request->time_slot)[0],
//             'name' => $request->name,
//             'phone' => $request->phone,
//             'qty' => $request->qty,
//             'table_id' => $request->table_id,
//             'total_price' => $total_price,
//             'status' => 'Unpaid',
//         ]);

//         $table = Table::find($request->table_id);
//         $table->status = 'terbooking';
//         $table->save();

//         \Midtrans\Config::$serverKey = config('midtrans.server_key');
//         \Midtrans\Config::$isProduction = false;
//         \Midtrans\Config::$isSanitized = true;
//         \Midtrans\Config::$is3ds = true;

//         $params = [
//             'transaction_details' => [
//                 'order_id' => $order->id,
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
//         $server_key = config('midtrans.server_key');

//         $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);

//         if ($hashed == $request->signature_key) {
//             if (in_array($request->transaction_status, ['capture', 'settlement'])) {
//                 $order = Order::find($request->order_id);
//                 $order->update(['status' => 'Paid']);

//                 $table = Table::find($order->table_id);
//                 $table->status = 'kosong';
//                 $table->save();
//             }
//         }
//         return response()->json(['status' => 'success']);
//     }

//     public function showOrder($id)
//     {
//         $order = Order::find($id);
//         return view('midtrans.checkout', compact('order'));
//     }
// }

<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Table;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\OrderDitempat;
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
            'qty' => 'required|integer|min:1|max:8',
            'table_id' => 'required|exists:tables,id',
        ]);
    
        $table = Table::find($request->table_id);
        $start = new \DateTime($table->start);
        $end = new \DateTime($table->finish);
    
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $date = $request->days;
    
        // Cek ketersediaan meja
        if (!$this->isTableAvailable($request->table_id, $date, $startTime, $endTime)) {
            return redirect()->back()->with('error', 'Table is not available at the selected time on the selected day');
        }
    
        $total_price = 250000;
        $order = Order::create([
            'days' => $request->days,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'name' => $request->name,
            'phone' => $request->phone,
            'customer_email' => $request->customer_email,
            'qty' => $request->qty,
            'table_id' => $request->table_id,
            'total_price' => $total_price,
            'status' => 'Unpaid',
        ]);
    
        // Generate unique order ID with a maximum length of 20 characters
        $uniqueOrderId = 'ORD-' . $order->id . '-' . substr(time(), -5);
    
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
        }

        return view('midtrans.showOrder', compact('order'));
    }

    private function isTableAvailable($tableId, $date, $startTime, $endTime)
    {
        $startBook = Carbon::parse($date . ' ' . $startTime);
        $finishBook = Carbon::parse($date . ' ' . $endTime);

        $bookingExists = Booking::where('table_id', $tableId)
            ->where(function($query) use ($startBook, $finishBook) {
                $query->whereBetween('start_book', [$startBook, $finishBook])
                      ->orWhereBetween('finish_book', [$startBook, $finishBook])
                      ->orWhere(function($query) use ($startBook, $finishBook) {
                          $query->where('start_book', '<', $startBook)
                                ->where('finish_book', '>', $finishBook);
                      });
            })
            ->where('status', '!=', 'Selesai')
            ->exists();

        $orderDitempatExists = OrderDitempat::where('table_id', $tableId)
            ->whereDate('tanggal_pesan', $startBook->toDateString())
            ->where(function($query) use ($startBook, $finishBook) {
                $query->whereTime('jam_pesan', '<=', $finishBook->toTimeString())
                      ->whereTime('jam_pesan', '>=', $startBook->toTimeString());
            })
            ->exists();

        return !$bookingExists && !$orderDitempatExists;
    }
}





// namespace App\Http\Controllers;

// use Carbon\Carbon;
// use Midtrans\Snap;
// use Midtrans\Config;
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
//             'customer_email' => 'required|string|email|max:255',
//             'qty' => 'required|integer|min:1|max:8',
//             'table_id' => 'required|exists:tables,id',
//         ]);

//         $table = Table::find($request->table_id);
//         $start = new \DateTime($table->start);
//         $end = new \DateTime($table->finish);

//         $total_price = 250000;
//         $order = Order::create([
//             'days' => $request->days,
//             'start_time' => $start->format('H:i'),
//             'end_time' => $end->format('H:i'),
//             'name' => $request->name,
//             'phone' => $request->phone,
//             'customer_email' => $request->customer_email,
//             'qty' => $request->qty,
//             'table_id' => $request->table_id,
//             'total_price' => $total_price,
//             'status' => 'Unpaid',
//         ]);

//         // Generate unique order ID with a maximum length of 20 characters
//         $uniqueOrderId = 'ORD-' . $order->id . '-' . substr(time(), -5);

//         $table->status = 'terbooking';
//         $table->save();

//         Config::$serverKey = config('midtrans.server_key');
//         Config::$isProduction = false;
//         Config::$isSanitized = true;
//         Config::$is3ds = true;

//         $params = [
//             'transaction_details' => [
//                 'order_id' => $uniqueOrderId,
//                 'gross_amount' => $order->total_price,
//             ],
//             'customer_details' => [
//                 'name' => $request->name,
//                 'email' => $request->customer_email,
//                 'phone' => $request->phone,
//             ],
//         ];

//         $snapToken = Snap::getSnapToken($params);
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

//                 $orderIdParts = explode('-', $request->order_id);
//                 $orderId = $orderIdParts[1];

//                 $order = Order::find($orderId);
//                 if ($order) {
//                     Log::info('Order found', ['order_id' => $orderId, 'status' => $order->status]);
//                     $order->update(['status' => 'Paid']);
//                     Log::info('Order status updated to Paid', ['order_id' => $orderId]);

//                     try {
//                         Booking::create([
//                             'nama_customer' => $order->name,
//                             'jumlah_orang' => $order->qty,
//                             'start_book' => Carbon::parse($order->days . ' ' . $order->start_time),
//                             'finish_book' => Carbon::parse($order->days . ' ' . $order->end_time),
//                             'category' => 'reservasi',
//                             'customer_email' => $order->customer_email,
//                             'phone' => $order->phone,
//                             'total_price' => $order->total_price, 
//                             'status' => 'Booking',
//                             'table_id' => $order->table_id,
//                         ]);

//                         Log::info('Booking created successfully for order ID: ' . $order->id);
//                     } catch (\Exception $e) {
//                         Log::error('Failed to create booking for order ID: ' . $order->id . ' with error: ' . $e->getMessage());
//                     }

//                     $table = Table::find($order->table_id);
//                     if ($table) {
//                         $table->status = 'terbooking';  // Pastikan status berubah ke 'terbooking'
//                         $table->save();
//                         Log::info('Table status updated to terbooking', ['table_id' => $table->id]);
//                     }

//                     return redirect()->route('order.show', ['id' => $order->id]);
//                 } else {
//                     Log::warning('Order not found for order ID: ' . $orderId);
//                 }
//             } else {
//                 Log::warning('Transaction status invalid', ['transaction_status' => $request->transaction_status]);
//             }
//         } else {
//             Log::warning('Callback validation failed', ['hashed' => $hashed, 'signature_key' => $request->signature_key]);
//         }
//         return response()->json(['status' => 'success']);
//     }

//     public function showOrder($id)
//     {
//         $order = Order::with('table')->find($id);
//         if ($order && $order->status != 'Paid') {
//             $order->update(['status' => 'Paid']);

//             try {
//                 Booking::create([
//                     'nama_customer' => $order->name,
//                     'jumlah_orang' => $order->qty,
//                     'start_book' => Carbon::parse($order->days . ' ' . $order->start_time),
//                     'finish_book' => Carbon::parse($order->days . ' ' . $order->end_time),
//                     'category' => 'reservasi',
//                     'customer_email' => $order->customer_email,
//                     'phone' => $order->phone,
//                     'total_price' => $order->total_price, 
//                     'status' => 'Booking',
//                     'table_id' => $order->table_id,
//                 ]);

//                 Log::info('Booking created successfully for order ID: ' . $order->id);
//             } catch (\Exception $e) {
//                 Log::error('Failed to create booking for order ID: ' . $order->id . ' with error: ' . $e->getMessage());
//             }

//             $table = Table::find($order->table_id);
//             if ($table) {
//                 $table->status = 'terbooking';  // Pastikan status berubah ke 'terbooking'
//                 $table->save();
//                 Log::info('Table status updated to terbooking', ['table_id' => $table->id]);
//             }
//         }

//         return view('midtrans.showOrder', compact('order'));
//     }
// }



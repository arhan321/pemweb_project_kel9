<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Order;
// use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StorePriceRequest;
// use App\Http\Requests\UpdatePriceRequest;
// use App\Http\Requests\MassDestroyPriceRequest;
use Symfony\Component\HttpFoundation\Response;

class HistoryOrderReservationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('history_order_reservation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::with('table')->get();

        return view('admin.history_order_reservations.index', compact('orders'));
    }

    // public function show(Order $order)
    // {
    //     abort_if(Gate::denies('history_order_reservation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.history_order_reservations.show', compact('order'));
    // }

}

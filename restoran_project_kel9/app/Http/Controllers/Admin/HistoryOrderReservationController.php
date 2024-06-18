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

        $order = Order::with('table')->get();

        return view('admin.history_order_reservations.index', compact('order'));
    }

    // public function create()
    // {
    //     abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.prices.create');
    // }

    // public function store(StorePriceRequest $request)
    // {
    //     $order = Booking::create($request->all());

    //     return redirect()->route('admin.prices.index');
    // }

    // public function edit(Booking $order)
    // {
    //     abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return view('admin.prices.edit', compact('order'));
    // }

    // public function update(UpdatePriceRequest $request, Booking $order)
    // {
    //     $order->update($request->all());

    //     return redirect()->route('admin.prices.index');
    // }

    public function show(Order $order)
    {
        abort_if(Gate::denies('history_order_reservation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.history_order_reservations.show', compact('order'));
    }

    // public function destroy(Booking $order)
    // {
    //     abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $order->delete();

    //     return back();
    // }

    // public function massDestroy(MassDestroyPriceRequest $request)
    // {
    //     $order = Booking::find(request('ids'));

    //     foreach ($order as $order) {
    //         $order->delete();
    //     }

    //     return response(null, Response::HTTP_NO_CONTENT);
    // }
}

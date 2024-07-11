<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\StorePriceRequest;
// use App\Http\Requests\UpdatePriceRequest;
// use App\Http\Requests\MassDestroyPriceRequest;
use Symfony\Component\HttpFoundation\Response;

class HistoryBookingManualController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('history_booking_manual_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::with('table')->get();

        return view('admin.history_booking_manuals.index', compact('bookings'));
    }


}

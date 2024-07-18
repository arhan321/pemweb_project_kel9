<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class HistoryBookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('history_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::with(['table'])->get();

        return view('admin.history_bookings.index', compact('bookings'));
    }


}

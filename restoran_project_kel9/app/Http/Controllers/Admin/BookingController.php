<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Table;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyBookingRequest;

class BookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::with('table')->get(); // Pastikan memuat relasi 'table'
    
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $availableTables = Table::where('status', 'kosong')->get();

        return view('admin.bookings.create', compact('availableTables'));
    }

    public function store(StoreBookingRequest $request)
    {
        $table = Table::find($request->table_id);
        if ($table->status != 'kosong') {
            return back()->withErrors(['table_id' => 'Table is not available']);
        }

        $booking = Booking::create($request->all());
        $table->status = 'terbooking';
        $table->save();

        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tables = Table::pluck('name', 'id')->all(); // Ganti 'name' dengan field yang sesuai di model Table
    
        return view('admin.bookings.edit', compact('booking', 'tables'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $previousStatus = $booking->status;
        $booking->update($request->all());

        $table = Table::find($booking->table_id);
        if ($table) {
            if ($request->status == 'Cancel' && $previousStatus != 'Cancel') {
                $table->status = 'kosong';
            } elseif ($request->status == 'Selesai' && $previousStatus != 'Selesai') {
                $table->status = 'kosong';
            } elseif ($request->status == 'Booking' && $previousStatus != 'Booking') {
                $table->status = 'terbooking';
            }
            $table->save();
        }

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $booking->load('table');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $table = Table::find($booking->table_id);
        if ($table && $booking->status != 'Cancel' && $booking->status != 'Selesai') {
            $table->status = 'kosong';
            $table->save();
        }

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        $bookings = Booking::find(request('ids'));

        foreach ($bookings as $booking) {
            $table = Table::find($booking->table_id);
            if ($table && $booking->status != 'Cancel' && $booking->status != 'Selesai') {
                $table->status = 'kosong';
                $table->save();
            }
            $booking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

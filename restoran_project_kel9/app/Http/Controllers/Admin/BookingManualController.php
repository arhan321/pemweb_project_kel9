<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\Booking_manual;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreBooking_manualRequest;
use App\Http\Requests\UpdateBooking_manualRequest;
use App\Http\Requests\MassDestroyBooking_manualRequest;

class BookingManualController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bookingmanual_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $currentDateTime = Carbon::now();

        // Update status booking otomatis jika sudah selesai
        $bookings = Booking_manual::with(['table'])->get();
        foreach ($bookings as $booking) {
            if ($currentDateTime->greaterThanOrEqualTo(Carbon::parse($booking->finish_book)) && $booking->status != 'Selesai') {
                $booking->update(['status' => 'Selesai']);
                $table = Table::find($booking->table_id);
                if ($table) {
                    $table->status = 'kosong';
                    $table->save();
                }
            }
        }

        return view('admin.booking_manuals.index', compact('bookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('bookingmanual_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $availableTables = Table::where('status', 'kosong')->get();

        return view('admin.booking_manuals.create', compact('availableTables'));
    }

    public function store(StoreBooking_manualRequest $request)
    {
        $table = Table::find($request->table_id);
        if ($table->status != 'kosong') {
            return back()->withErrors(['table_id' => 'Table is not available']);
        }

        $booking = Booking_manual::create($request->all());
        $table->status = 'terbooking';
        $table->save();

        return redirect()->route('admin.booking_manuals.index');
    }

    public function edit(Booking_manual $booking)
    {
        abort_if(Gate::denies('bookingmanual_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tables = Table::pluck('name', 'id')->all(); // Ganti 'name' dengan field yang sesuai di model Table
    
        return view('admin.booking_manuals.edit', compact('booking', 'tables'));
    }

    public function update(UpdateBooking_manualRequest $request, Booking_manual $booking)
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

        return redirect()->route('admin.booking_manuals.index');
    }

    public function show(Booking_manual $booking)
    {
        abort_if(Gate::denies('bookingmanual_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $booking->load('table');

        return view('admin.booking_manuals.show', compact('booking'));
    }

    public function destroy(Booking_manual $booking)
    {
        abort_if(Gate::denies('bookingmanual_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $table = Table::find($booking->table_id);
        if ($table && $booking->status != 'Cancel' && $booking->status != 'Selesai') {
            $table->status = 'kosong';
            $table->save();
        }

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBooking_manualRequest $request)
    {
        $bookings = Booking_manual::find(request('ids'));

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
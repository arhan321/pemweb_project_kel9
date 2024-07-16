<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\Models\Table;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\OrderDitempat;
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

        $currentDateTime = Carbon::now();

        // Update status booking otomatis jika sudah selesai
        $bookings = Booking::with(['table'])->get();
        foreach ($bookings as $booking) {
            if ($currentDateTime->greaterThanOrEqualTo(Carbon::parse($booking->finish_book)) && $booking->status != 'Selesai') {
                $booking->update(['status' => 'Selesai']);
            }
        }

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
        if ($this->isTableAvailable($request->table_id, $request->start_book, $request->finish_book)) {
            $booking = Booking::create($request->all());
            return redirect()->route('admin.bookings.index');
        }

        return back()->withErrors(['table_id' => 'Table is not available at the selected time on the selected day']);
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tables = Table::pluck('name', 'id')->all(); // Ganti 'name' dengan field yang sesuai di model Table

        return view('admin.bookings.edit', compact('booking', 'tables'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

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

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        $bookings = Booking::find(request('ids'));

        foreach ($bookings as $booking) {
            $booking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function isTableAvailable($tableId, $startBook, $finishBook)
    {
        $startBook = Carbon::parse($startBook);
        $finishBook = Carbon::parse($finishBook);

        // Cek ketersediaan di tabel bookings
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

        // Cek ketersediaan di tabel order_ditempats
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

// namespace App\Http\Controllers\Admin;

// use Gate;
// use Carbon\Carbon;
// use App\Models\Table;
// use App\Models\Booking;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreBookingRequest;
// use App\Http\Requests\UpdateBookingRequest;
// use Symfony\Component\HttpFoundation\Response;
// use App\Http\Requests\MassDestroyBookingRequest;

// class BookingController extends Controller
// {
//     public function index()
//     {
//         abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//         $currentDateTime = Carbon::now();

//         // Update status booking otomatis jika sudah selesai
//         $bookings = Booking::with(['table'])->get();
//         foreach ($bookings as $booking) {
//             if ($currentDateTime->greaterThanOrEqualTo(Carbon::parse($booking->finish_book)) && $booking->status != 'Selesai') {
//                 $booking->update(['status' => 'Selesai']);
//             }
//         }

//         return view('admin.bookings.index', compact('bookings'));
//     }

//     public function create()
//     {
//         abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//         $availableTables = Table::where('status', 'kosong')->get();

//         return view('admin.bookings.create', compact('availableTables'));
//     }

//     public function store(StoreBookingRequest $request)
//     {
//         if ($this->isTableAvailable($request->table_id, $request->start_book, $request->finish_book)) {
//             $booking = Booking::create($request->all());
//             return redirect()->route('admin.bookings.index');
//         }

//         return back()->withErrors(['table_id' => 'Table is not available at the selected time on the selected day']);
//     }

//     public function edit(Booking $booking)
//     {
//         abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//         $tables = Table::pluck('name', 'id')->all(); // Ganti 'name' dengan field yang sesuai di model Table

//         return view('admin.bookings.edit', compact('booking', 'tables'));
//     }

//     public function update(UpdateBookingRequest $request, Booking $booking)
//     {
//         $booking->update($request->all());

//         return redirect()->route('admin.bookings.index');
//     }

//     public function show(Booking $booking)
//     {
//         abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//         $booking->load('table');

//         return view('admin.bookings.show', compact('booking'));
//     }

//     public function destroy(Booking $booking)
//     {
//         abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//         $booking->delete();

//         return back();
//     }

//     public function massDestroy(MassDestroyBookingRequest $request)
//     {
//         $bookings = Booking::find(request('ids'));

//         foreach ($bookings as $booking) {
//             $booking->delete();
//         }

//         return response(null, Response::HTTP_NO_CONTENT);
//     }

//     private function isTableAvailable($tableId, $startBook, $finishBook)
//     {
//         $startBookDate = Carbon::parse($startBook)->toDateString();
//         $finishBookDate = Carbon::parse($finishBook)->toDateString();
        
//         $bookings = Booking::where('table_id', $tableId)
//                             ->where(function($query) use ($startBook, $finishBook, $startBookDate, $finishBookDate) {
//                                 $query->whereBetween('start_book', [$startBook, $finishBook])
//                                       ->orWhereBetween('finish_book', [$startBook, $finishBook])
//                                       ->orWhere(function($query) use ($startBook, $finishBook) {
//                                           $query->where('start_book', '<', $startBook)
//                                                 ->where('finish_book', '>', $finishBook);
//                                       })
//                                       ->orWhere(function($query) use ($startBookDate, $finishBookDate) {
//                                           $query->whereDate('start_book', $startBookDate)
//                                                 ->orWhereDate('finish_book', $finishBookDate);
//                                       });
//                             })
//                             ->where('status', '!=', 'Selesai')
//                             ->exists();

//         return !$bookings;
//     }
// }

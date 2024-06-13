@extends('layouts.admin')
@section('content')
@can('booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.bookings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Booking">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.nama_customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.jumlah_orang') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.start_book') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.finish_book') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.table') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.customer_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.total_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $booking->id ?? '' }}
                            </td>
                            <td>
                                {{ $booking->nama_customer ?? '' }}
                            </td>
                            <td>
                                {{ $booking->jumlah_orang ?? '' }}
                            </td>
                            <td>
                                {{ $booking->start_book ?? '' }}
                            </td>
                            <td>
                                {{ $booking->finish_book ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Booking::CATEGORY_SELECT[$booking->category] ?? '' }}
                            </td>
                            <td>
                                {{ $booking->table->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->customer_email ?? '' }}
                            </td>
                            <td>
                                {{ $booking->phone ?? '' }}
                            </td>
                            <td>
                                Rp {{ number_format($booking->total_price, 2) }}
                            </td>
                            <td>
                                @if($booking->status == 'Cancel')
                                    <span class="status-cancel">{{ App\Models\Booking::STATUS_SELECT[$booking->status] ?? '' }}</span>
                                @elseif($booking->status == 'Booking')
                                    <span class="status-booking">{{ App\Models\Booking::STATUS_SELECT[$booking->status] ?? '' }}</span>
                                @elseif($booking->status == 'Selesai')
                                    <span class="status-selesai">{{ App\Models\Booking::STATUS_SELECT[$booking->status] ?? '' }}</span>
                                @else
                                    {{ App\Models\Booking::STATUS_SELECT[$booking->status] ?? '' }}
                                @endif
                            </td>
                            <td>
                                @can('booking_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.bookings.show', $booking->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('booking_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('booking_delete')
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
<style>
.status-cancel {
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-booking {
    background-color: green;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-selesai {
    background-color: green;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold; /* Atur warna atau gaya lainnya sesuai kebutuhan */
}

</style>
@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('booking_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.bookings.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    Swal.fire({
                        title: '{{ trans('global.datatables.zero_selected') }}',
                        icon: 'warning',
                    })

                    return
                }

                Swal.fire({
                    title: '{{ trans('global.areYouSure') }}',
                    text: "{{ trans('global.areYouSureDelete') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ trans('global.confirmDelete') }}',
                    cancelButtonText: '{{ trans('global.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload() })
                    }
                })
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        });
        let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })

    $('.delete-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: '{{ trans('global.areYouSure') }}',
            text: "{{ trans('global.areYouSureDelete') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ trans('global.confirmDelete') }}',
            cancelButtonText: '{{ trans('global.cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    });
</script>
@endsection
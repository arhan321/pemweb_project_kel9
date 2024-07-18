@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.history_booking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-history_booking">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.nama_customer') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.history_booking.fields.date') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.history_booking.fields.start_book') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.finish_book') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.customer_email') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.table') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.jumlah_orang') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.total_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.history_booking.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $key => $b)
                        <tr data-entry-id="{{ $b->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $b->id ?? '' }}
                            </td>
                            <td>
                                {{ $b->nama_customer ?? '' }}
                            </td>
                            <td>
                                {{ $b->start_book ?? '' }}
                            </td>
                            <td>
                                {{ $b->finish_book ?? '' }}
                            </td>
                            <td>
                                {{ $b->phone ?? '' }}
                            </td>
                            <td>
                                {{ $b->customer_email ?? '' }}
                            </td>
                            <td>
                                {{ trans('cruds.table_information.table') }} {{ $b->table_id ?? '' }}
                            </td>
                            <td>
                                {{ $b->jumlah_orang ?? '' }}
                            </td>
                            <td>
                                Rp {{ number_format($b->total_price, 2) }}
                            </td>
                            <td>
                                @if($b->status == 'Cancel')
                                    <span class="status-cancel">{{ App\Models\Booking::STATUS_SELECT[$b->status] ?? '' }}</span>
                                @elseif($b->status == 'Booking')
                                    <span class="status-booking">{{ App\Models\Booking::STATUS_SELECT[$b->status] ?? '' }}</span>
                                @elseif($b->status == 'Selesai')
                                    <span class="status-selesai">{{ App\Models\Booking::STATUS_SELECT[$b->status] ?? '' }}</span>
                                @else
                                    {{ App\Models\Booking::STATUS_SELECT[$b->status] ?? '' }}
                                @endif
                            </td>
                            <td>
                             

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
// @can('order_delete')
//   let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
//   let deleteButton = {
//     text: deleteButtonTrans,
//     url: "{{ route('admin.prices.massDestroy') }}",
//     className: 'btn-danger',
//     action: function (e, dt, node, config) {
//       var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
//           return $(entry).data('entry-id')
//       });

//       if (ids.length === 0) {
//         alert('{{ trans('global.datatables.zero_selected') }}')

//         return
//       }

//       if (confirm('{{ trans('global.areYouSure') }}')) {
//         $.ajax({
//           headers: {'x-csrf-token': _token},
//           method: 'POST',
//           url: config.url,
//           data: { ids: ids, _method: 'DELETE' }})
//           .done(function () { location.reload() })
//       }
//     }
//   }
//   dtButtons.push(deleteButton)
// @endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-history_booking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
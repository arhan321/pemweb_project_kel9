@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header">
    {{ trans('cruds.history_order_reservation.title_singular') }} {{ trans('global.list') }}
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class=" table table-bordered table-striped table-hover datatable datatable-history_order_reservation">
        <thead>
          <tr>
            <th width="10">

            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.id') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.name') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.days') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.start_time') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.end_time') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.phone') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.email') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.table') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.number_of_people') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.total') }}
            </th>
            <th>
              {{ trans('cruds.history_order_reservation.fields.status') }}
            </th>
            <th>
              &nbsp;
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($order as $key => $p)
          <tr data-entry-id="{{ $p->id }}">
            <td>

            </td>
            <td>
              {{ $p->id ?? '' }}
            </td>
            <td>
              {{ $p->name ?? '' }}
            </td>
            <td>
              {{ $p->days ?? '' }}
            </td>
            <td>
              {{ $p->start_time ?? '' }}
            </td>
            <td>
              {{ $p->end_time ?? '' }}
            </td>
            <td>
              {{ $p->phone ?? '' }}
            </td>
            <td>
              {{ $p->customer_email ?? '' }}
            </td>
            <td>
              {{ $p->table->name ?? '' }}
            </td>
            <td>
              {{ $p->qty ?? '' }}
            </td>
            <td>
              Rp {{ number_format($p->total_price, 2) }}
            </td>
            <td>
                <span class="badge @if($p->status == 'unpaid') badge-danger @else badge-success @endif">
                  {{ $p->status ?? '' }}
                </span>
              </td>
            <td>
              @can('history_order_reservation_show')
              <a class="btn btn-xs btn-primary" href="{{ route('admin.history_order_reservations.show', $p->id) }}">
                {{ trans('global.view') }}
              </a>
              @endcan
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
    .badge {
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 12px;
      text-align: center;
      display: inline-block;
      margin-right: 5px;
    }

    .badge-success {
      background-color: #4CAF50; /* Green */
      color: white;
    }

    .badge-danger {
      background-color: #f44336; /* Red */
      color: white;
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
  let table = $('.datatable-history_order_reservation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
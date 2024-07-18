@extends('layouts.admin')
@section('content')
<div class="card">
  <div class="card-header">
    {{ trans('cruds.history_orderditempat.title_singular') }} {{ trans('global.list') }}
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class=" table table-bordered table-striped table-hover datatable datatable-history_order_reservation">
        <thead>
          <tr>
            <th width="10"></th>
            <th>{{ trans('cruds.history_orderditempat.fields.id') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.nama_pemesan') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.product') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.price') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.jam_pesan') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.tanggal_pesan') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.table') }}</th>
            <th>{{ trans('cruds.history_orderditempat.fields.status_bayar') }}</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orderditempats as $key => $h)
          <tr data-entry-id="{{ $h->id }}">
            <td></td>
            <td>{{ $h->id ?? '' }}</td>
            <td>{{ $h->nama_pemesan ?? '' }}</td>
            <td>
                @if(isset($h->product_details))
                    @php
                        $productDetails = [];
                        foreach ($h->product_details as $product) {
                            $productDetails[] = $product['name'] . ' (Qty: ' . $product['qty'] . ')';
                        }
                        echo implode(', ', $productDetails);
                    @endphp
                @endif
            </td>
            <td class="price-column">
                {{ 'Rp ' . number_format($h->price ?? 0, 2, ',', '.') }}
            </td>
            <td>{{ $h->jam_pesan ?? '' }}</td>
            <td>{{ $h->tanggal_pesan ?? '' }}</td>
            <td>{{ trans('cruds.table_information.table') }} {{ $h->table_id ?? '' }}</td>
            <td>
                @if($h->status_bayar == 'Belum bayar')
                    <span class="status-unpaid">{{ App\Models\OrderDitempat::STATUS_SELECT['Belum_bayar'] ?? 'Belum bayar' }}</span>
                @elseif($h->status_bayar == 'Sudah bayar')
                    <span class="status-selesai">{{ App\Models\OrderDitempat::STATUS_SELECT['Sudah_bayar'] ?? 'Sudah bayar' }}</span>
                @else
                    {{ App\Models\Booking::STATUS_SELECT[$h->status_bayar] ?? '' }}
                @endif
            </td>
            <td></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
    
  .status-unpaid {
      background-color: red;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
      margin: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s, box-shadow 0.3s;
      display: inline-block;
  }

  .status-unpaid:hover {
      background-color: darkred;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
  }

  .status-selesai {
      background-color: green;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
      margin: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s, box-shadow 0.3s;
      display: inline-block;
  }

  .status-selesai:hover {
      background-color: darkgreen;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
  }
</style>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true,
            order: [[1, 'desc']],
            pageLength: 100,
        });
        let table = $('.datatable-history_order_reservation:not(.ajaxTable)').DataTable({ buttons: dtButtons });
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });
</script>
@endsection

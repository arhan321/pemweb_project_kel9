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
      background-color: #4CAF50; 
      color: white;
    }

    .badge-danger {
      background-color: #f44336; 
      color: white;
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

@extends('layouts.admin')
@section('content')
@can('orderditempat_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.orderditempats.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.orderditempat.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.orderditempat.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-orderditempat">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.nama_pemesan') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.product') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.jam_pesan') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.tanggal_pesan') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.table') }}
                        </th>
                        <th>
                            {{ trans('cruds.orderditempat.fields.status_bayar') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderditempats as $key => $orderditempat)
                        <tr data-entry-id="{{ $orderditempat->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $orderditempat->id ?? '' }}
                            </td>
                            <td>
                                {{ $orderditempat->nama_pemesan ?? '' }}
                            </td>
                            <td>
                                @if(isset($orderditempat->product_details))
                                    @php
                                        $productDetails = [];
                                        foreach ($orderditempat->product_details as $product) {
                                            $productDetails[] = $product['name'] . ' (Qty: ' . $product['qty'] . ')';
                                        }
                                        echo implode(', ', $productDetails);
                                    @endphp
                                @endif
                            </td>
                            <td class="price-column">
                                {{ 'Rp ' . number_format($orderditempat->price ?? 0, 2, ',', '.') }}
                            </td>
                            <td>
                                {{ $orderditempat->jam_pesan ?? '' }}
                            </td>
                            <td>
                                {{ $orderditempat->tanggal_pesan ?? '' }}
                            </td>
                            <td>
                                {{ trans('cruds.table_information.table') }} {{ $orderditempat->table_id ?? '' }}
                             </td>
                             <td>
                                @if($orderditempat->status_bayar == 'Belum bayar')
                                    <span class="status-unpaid">{{ App\Models\orderditempat::STATUS_SELECT['Belum_bayar'] ?? 'Belum bayar' }}</span>
                                @elseif($orderditempat->status_bayar == 'Sudah bayar')
                                    <span class="status-selesai">{{ App\Models\orderditempat::STATUS_SELECT['Sudah_bayar'] ?? 'Sudah bayar' }}</span>
                                @else
                                    {{ App\Models\Booking::STATUS_SELECT[$orderditempat->status] ?? '' }}
                                @endif
                            </td>
                            <td>
                                @can('orderditempat_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.orderditempats.show', $orderditempat->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('orderditempat_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.orderditempats.edit', $orderditempat->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('orderditempat_delete')
                                    <form action="{{ route('admin.orderditempats.destroy', $orderditempat->id) }}" method="POST" class="delete-form" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger delete-button" value="{{ trans('global.delete') }}">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('orderditempat_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.orderditempats.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                Swal.fire({
                    title: '{{ trans('global.areYouSure') }}',
                    text: '{{ trans('global.areYouSureDelete') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ trans('global.delete') }}',
                    cancelButtonText: '{{ trans('global.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        })
                        .done(function () { location.reload() })
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
        let table = $('.datatable-orderditempat:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })

    $('.delete-button').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        Swal.fire({
            title: '{{ trans('global.areYouSure') }}',
            text: '{{ trans('global.areYouSureDelete') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ trans('global.delete') }}',
            cancelButtonText: '{{ trans('global.cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection

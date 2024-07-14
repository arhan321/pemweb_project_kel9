@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.orderditempat.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orderditempats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.id') }}
                        </th>
                        <td>
                            {{ $orderditempat->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.nama_pemesan') }}
                        </th>
                        <td>
                            {{ $orderditempat->nama_pemesan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.product') }}
                        </th>
                        <td>
                            @if(isset($orderditempat->product_details) && count($orderditempat->product_details) > 0)
                                @php
                                    $productDetails = [];
                                    foreach ($orderditempat->product_details as $product) {
                                        $productDetails[] = $product['name'] . ' (Qty: ' . $product['qty'] . ')';
                                    }
                                    echo implode(', ', $productDetails);
                                @endphp
                            @else
                                <div>No product details available</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.price') }}
                        </th>
                        <td>
                            {{ 'Rp ' . number_format($orderditempat->price ?? 0, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.jam_pesan') }}
                        </th>
                        <td>
                            {{ $orderditempat->jam_pesan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.tanggal_pesan') }}
                        </th>
                        <td>
                            {{ $orderditempat->tanggal_pesan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.table') }}
                        </th>
                        <td>
                          {{trans('cruds.table_information.table')}}  {{ $orderditempat->table_id ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.orderditempat.fields.status_bayar') }}
                        </th>
                        <td>
                            @if($orderditempat->status_bayar == 'Belum bayar')
                                <span class="status-unpaid">{{ App\Models\Orderditempat::STATUS_SELECT['Belum bayar'] ?? 'Belum bayar' }}</span>
                            @elseif($orderditempat->status_bayar == 'Sudah bayar')
                                <span class="status-selesai">{{ App\Models\Orderditempat::STATUS_SELECT['Sudah bayar'] ?? 'Sudah bayar' }}</span>
                            @else
                                {{ $orderditempat->status_bayar }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.orderditempats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
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

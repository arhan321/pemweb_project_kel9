@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.orderditempat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.orderditempats.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_pemesan">{{ trans('cruds.orderditempat.fields.nama_pemesan') }}</label>
                <input class="form-control {{ $errors->has('nama_pemesan') ? 'is-invalid' : '' }}" type="text" name="nama_pemesan" id="nama_pemesan" value="{{ old('nama_pemesan', '') }}">
                @if($errors->has('nama_pemesan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_pemesan') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="products">{{ trans('cruds.orderditempat.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" multiple>
                    @foreach($products as $id => $product)
                        <option value="{{ $id }}" {{ (in_array($id, old('products', [])) ? 'selected' : '') }}>{{ $product }}</option>
                    @endforeach
                </select>
                @if($errors->has('products'))
                    <div class="invalid-feedback">
                        {{ $errors->first('products') }}
                    </div>
                @endif
            </div>

            <div id="product-quantities">
                <!-- Placeholder for dynamic product quantities -->
            </div>

            <div class="form-group">
                <label for="price">{{ trans('cruds.orderditempat.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" readonly>
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="jam_pesan">{{ trans('cruds.orderditempat.fields.jam_pesan') }}</label>
                <input class="form-control {{ $errors->has('jam_pesan') ? 'is-invalid' : '' }}" type="time" name="jam_pesan" id="jam_pesan" value="{{ old('jam_pesan', '') }}">
                @if($errors->has('jam_pesan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jam_pesan') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="tanggal_pesan">{{ trans('cruds.orderditempat.fields.tanggal_pesan') }}</label>
                <input class="form-control {{ $errors->has('tanggal_pesan') ? 'is-invalid' : '' }}" type="date" name="tanggal_pesan" id="tanggal_pesan" value="{{ old('tanggal_pesan', '') }}">
                @if($errors->has('tanggal_pesan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tanggal_pesan') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function() {
        const productPrices = @json($productPrices);

        function updateProductQuantities() {
            let selectedProducts = $('#products').val();
            let productQuantitiesContainer = $('#product-quantities');
            productQuantitiesContainer.empty();

            selectedProducts.forEach(function(productId, index) {
                let productLabel = $('#products option[value="'+productId+'"]').text();
                let productPrice = productPrices[productId];
                productQuantitiesContainer.append(`
                    <div class="form-group">
                        <label for="qty_${productId}">${productLabel} {{ trans('cruds.orderditempat.fields.qty') }}</label>
                        <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="1">
                        <input type="hidden" class="product-price" data-product-id="${productId}" value="${productPrice}">
                    </div>
                `);
            });

            updateTotalPrice();
        }

        function updateTotalPrice() {
            let totalPrice = 0;
            $('.product-qty').each(function() {
                let productId = $(this).data('product-id');
                let quantity = parseFloat($(this).val());
                let price = parseFloat($('.product-price[data-product-id="'+productId+'"]').val());
                totalPrice += quantity * price;
            });
            $('#price').val(totalPrice.toFixed(2));
        }

        $('#products').change(function() {
            updateProductQuantities();
        });

        $('#product-quantities').on('input', '.product-qty', function() {
            updateTotalPrice();
        });

        updateProductQuantities();
    });

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

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() })
                }
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
</script>
@endsection

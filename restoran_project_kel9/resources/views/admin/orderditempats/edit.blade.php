@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.orderditempat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orderditempats.update", [$orderditempat->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nama_pemesan">{{ trans('cruds.orderditempat.fields.nama_pemesan') }}</label>
                <input class="form-control {{ $errors->has('nama_pemesan') ? 'is-invalid' : '' }}" type="text" name="nama_pemesan" id="nama_pemesan" value="{{ old('nama_pemesan', $orderditempat->nama_pemesan) }}">
                @if($errors->has('nama_pemesan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_pemesan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderditempat.fields.nama_pemesan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="products">{{ trans('cruds.orderditempat.fields.product') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" multiple required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ (in_array($product->id, old('products', [])) || (collect($orderditempat->product_details ?? [])->pluck('id')->contains($product->id))) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('products'))
                    <div class="invalid-feedback">
                        {{ $errors->first('products') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderditempat.fields.product_helper') }}</span>
            </div>
            <div id="product-quantities">
                <!-- Placeholder for dynamic product quantities -->
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.orderditempat.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $orderditempat->price) }}" step="0.01">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderditempat.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_bayar">{{ trans('cruds.orderditempat.fields.status_bayar') }}</label>
                <select class="form-control {{ $errors->has('status_bayar') ? 'is-invalid' : '' }}" name="status_bayar" id="status_bayar" required>
                    <option value disabled {{ old('status_bayar', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\OrderDitempat::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status_bayar', $orderditempat->status_bayar) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_bayar'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status_bayar') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.orderditempat.fields.status_bayar_helper') }}</span>
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
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.orderditempats.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($orderditempat) && $orderditempat->image)
      var file = {!! json_encode($orderditempat->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

$(document).ready(function() {
    const productPrices = @json($productPrices);
    const oldQuantities = @json(old('product_qty', $orderditempat->product_details->pluck('qty', 'id')->toArray()));

    function updateProductQuantities() {
        let selectedProducts = $('#products').val();
        let productQuantitiesContainer = $('#product-quantities');
        productQuantitiesContainer.empty();

        selectedProducts.forEach(function(productId, index) {
            let productLabel = $('#products option[value="'+productId+'"]').text();
            let productPrice = productPrices[productId];
            let oldQuantity = oldQuantities[productId] || 1; // Default value to 1 if old quantity not available
            productQuantitiesContainer.append(`
                <div class="form-group">
                    <label for="qty_${productId}">${productLabel} {{ trans('cruds.orderditempat.fields.qty') }}</label>
                    <input class="form-control product-qty" data-product-id="${productId}" type="number" name="product_qty[${productId}]" id="qty_${productId}" value="${oldQuantity}">
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

</script>
@endsection

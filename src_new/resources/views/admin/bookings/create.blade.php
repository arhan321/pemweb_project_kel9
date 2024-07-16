@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="nama_customer">{{ trans('cruds.booking.fields.nama_customer') }}</label>
                <input class="form-control {{ $errors->has('nama_customer') ? 'is-invalid' : '' }}" type="text" name="nama_customer" id="nama_customer" value="{{ old('nama_customer', '') }}">
                @if($errors->has('nama_customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama_customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="jumlah_orang">{{ trans('cruds.booking.fields.jumlah_orang') }}</label>
                <input class="form-control {{ $errors->has('jumlah_orang') ? 'is-invalid' : '' }}" type="number" name="jumlah_orang" id="jumlah_orang" value="{{ old('jumlah_orang', '') }}" max="8">
                @if($errors->has('jumlah_orang'))
                    <div class="invalid-feedback">
                        {{ $errors->first('jumlah_orang') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.jumlah_orang_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="booking_date">{{ trans('cruds.booking.fields.booking_date') }}</label>
                <input class="form-control date {{ $errors->has('booking_date') ? 'is-invalid' : '' }}" type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" required>
                @if($errors->has('booking_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('booking_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.booking_date_helper') }}</span>
            </div>
            <div class="form-group">
                <input type="hidden" name="start_book" id="start_book" value="{{ old('start_book') }}">
                <input type="hidden" name="finish_book" id="finish_book" value="{{ old('finish_book') }}">
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.booking.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category" required>
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Booking::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.category_helper') }}</span>
            </div>
         
            <div class="form-group">
                <label class="required" for="table_id">{{ trans('cruds.booking.fields.table') }}</label>
                <select class="form-control {{ $errors->has('table_id') ? 'is-invalid' : '' }}" name="table_id" id="table_id" required>
                    <option value disabled {{ old('table_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($availableTables as $table)
                        <option value="{{ $table->id }}" data-start="{{ $table->start }}" data-finish="{{ $table->finish }}" {{ old('table_id', '') === (string) $table->id ? 'selected' : '' }}>{{ $table->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('table_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('table_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.table_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="customer_email">{{ trans('cruds.booking.fields.customer_email') }}</label>
                <input class="form-control {{ $errors->has('customer_email') ? 'is-invalid' : '' }}" type="text" name="customer_email" id="customer_email" value="{{ old('customer_email', '') }}">
                @if($errors->has('customer_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.customer_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.booking.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_price">{{ trans('cruds.booking.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', '') }}">
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.booking.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Booking::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('table_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var startBookTime = selectedOption.getAttribute('data-start');
    var finishBookTime = selectedOption.getAttribute('data-finish');
    var bookingDate = document.getElementById('booking_date').value;

    if (bookingDate) {
        document.getElementById('start_book').value = bookingDate + ' ' + startBookTime;
        document.getElementById('finish_book').value = bookingDate + ' ' + finishBookTime;
    } else {
        document.getElementById('start_book').value = '';
        document.getElementById('finish_book').value = '';
    }
});

document.getElementById('booking_date').addEventListener('change', function() {
    var selectedOption = document.getElementById('table_id').options[document.getElementById('table_id').selectedIndex];
    var startBookTime = selectedOption.getAttribute('data-start');
    var finishBookTime = selectedOption.getAttribute('data-finish');
    var bookingDate = this.value;

    if (startBookTime && finishBookTime) {
        document.getElementById('start_book').value = bookingDate + ' ' + startBookTime;
        document.getElementById('finish_book').value = bookingDate + ' ' + finishBookTime;
    }
});
</script>

@endsection

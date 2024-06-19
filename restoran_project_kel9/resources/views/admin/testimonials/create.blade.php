@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.testimonial.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.testimonials.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="nama">{{ trans('cruds.testimonial.fields.nama') }}</label>
                <input class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" type="text" name="nama" id="nama" value="{{ old('nama', '') }}" required>
                @if($errors->has('nama'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testimonial.fields.nama_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.testimonial.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testimonial.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
              <label for="nomor_telfon">{{ trans('cruds.testimonial.fields.nomor_telfon') }}</label>
              <input class="form-control {{ $errors->has('nomor_telfon') ? 'is-invalid' : '' }}" type="text" name="nomor_telfon" id="nomor_telfon" value="{{ old('nomor_telfon', '') }}">
              @if($errors->has('nomor_telfon'))
                  <div class="invalid-feedback">
                      {{ $errors->first('nomor_telfon') }}
                  </div>
              @endif
              <span class="help-block">{{ trans('cruds.testimonial.fields.nomor_telfon_helper') }}</span>
          </div>
            <div class="form-group">
                <label for="pesan">{{ trans('cruds.testimonial.fields.pesan') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('pesan') ? 'is-invalid' : '' }}" name="pesan" id="pesan">{!! old('pesan') !!}</textarea>
                @if($errors->has('pesan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pesan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testimonial.fields.pesan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.testimonial.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.testimonial.fields.image_helper') }}</span>
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
    url: '{{ route('admin.testimonials.storeMedia') }}',
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
@if(isset($testimonials) && $testimonials->image)
      var file = {!! json_encode($testimonials->image) !!}
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

</script>
@endsection
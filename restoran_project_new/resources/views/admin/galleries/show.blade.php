@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.gallery.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.galleries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.gallery.fields.id') }}
                        </th>
                        <td>
                            {{ $gallery->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gallery.fields.title_1') }}
                        </th>
                        <td>
                            {{ $gallery->title_1 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gallery.fields.title_2') }}
                        </th>
                        <td>
                            {{ $gallery->title_2 }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gallery.fields.description') }}
                        </th>
                        <td>
                            {!! $gallery->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.gallery.fields.image') }}
                        </th>
                        <td>
                            @if($gallery->image)
                                <a href="{{ $gallery->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $gallery->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.galleries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
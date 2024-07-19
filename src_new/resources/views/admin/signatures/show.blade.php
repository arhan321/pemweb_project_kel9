@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.signature.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.signatures.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.signature.fields.id') }}
                        </th>
                        <td>
                            {{ $signature->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.signature.fields.image') }}
                        </th>
                        <td>
                            @if($signature->image)
                                <a href="{{ $signature->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $signature->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.signature.fields.product') }}
                        </th>
                        <td>
                            {{ $signature->product->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.signature.fields.description') }}
                        </th>
                        <td>
                            {!! $signature->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.signature.fields.category') }}
                        </th>
                        <td>
                            {{ App\Models\Product::CATEGORY_SELECT[$signature->category] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.signatures.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

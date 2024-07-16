@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tim.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tims.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tim.fields.id') }}
                        </th>
                        <td>
                            {{ $tim->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tim.fields.name') }}
                        </th>
                        <td>
                            {{ $tim->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tim.fields.position') }}
                        </th>
                        <td>
                            {{ App\Models\Tim::POSITION[$tim->position] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tim.fields.status') }}
                        </th>
                        <td>
                            <span class="status-badge {{ $tim->status == 'bekerja' ? 'badge-success' : 'badge-danger' }}">
                                {{ App\Models\Tim::STATUS[$tim->status] ?? '' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tim.fields.image') }}
                        </th>
                        <td>
                            @if($tim->image)
                                <a href="{{ $tim->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $tim->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tims.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
<style>
    .status-badge {
        font-size: 1em; 
        padding: 0.8em; 
    }
    .badge-success {
    background-color: green;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    }
    .badge-danger {
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    }
</style>
@endsection
@extends('layouts.admin')
@section('content')
@can('tim_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tims.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.tim.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.tim.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-Tim">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.tim.fields.id') }}</th>
                        <th>{{ trans('cruds.tim.fields.name') }}</th>
                        <th>{{ trans('cruds.tim.fields.position') }}</th>
                        <th>{{ trans('cruds.tim.fields.status') }}</th>
                        <th>{{ trans('cruds.tim.fields.image') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tims as $key => $tim)
                        <tr data-entry-id="{{ $tim->id }}">
                            <td></td>
                            <td>{{ $tim->id ?? '' }}</td>
                            <td>{{ $tim->name ?? '' }}</td>
                            <td>{{ App\Models\Tim::POSITION[$tim->position] ?? '' }}</td>
                            <td>
                                <span class="status-badge {{ $tim->status == 'bekerja' ? 'badge-success' : 'badge-danger' }}">
                                    {{ App\Models\Tim::STATUS[$tim->status] ?? '' }}
                                </span>
                            </td>
                            <td>
                                @if($tim->image)
                                    <a href="{{ $tim->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $tim->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('tim_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tims.show', $tim->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('tim_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tims.edit', $tim->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('tim_delete')
                                    <form class="delete-form" action="{{ route('admin.tims.destroy', $tim->id) }}" method="POST" style="display: inline-block;">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-xs btn-danger delete-button">{{ trans('global.delete') }}</button>
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
@endsection

@section('styles')
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

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('tim_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.tims.massDestroy') }}",
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
                    text: "{{ trans('global.areYouSureDelete') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ trans('global.confirmDelete') }}',
                    cancelButtonText: '{{ trans('global.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
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
        let table = $('.datatable-Tim:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('.delete-button').click(function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: '{{ trans('global.areYouSure') }}',
                text: "{{ trans('global.areYouSureDelete') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ trans('global.confirmDelete') }}',
                cancelButtonText: '{{ trans('global.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endsection

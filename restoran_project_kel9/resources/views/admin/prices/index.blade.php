@extends('layouts.admin')
@section('content')
@can('order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.prices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Price">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.end_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.table') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.number_of_people') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.total') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $key => $p)
                        <tr data-entry-id="{{ $p->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $p->id ?? '' }}
                            </td>
                            <td>
                                {{ $p->name ?? '' }}
                            </td>
                            <td>
                                {{ $p->days ?? '' }}
                            </td>
                            <td>
                                {{ $p->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $p->end_time ?? '' }}
                            </td>
                            <td>
                                {{ $p->phone ?? '' }}
                            </td>
                            <td>
                                {{ $p->customer_email ?? '' }}
                            </td>
                            <td>
                                {{ $p->table->name ?? '' }}
                            </td>
                            <td>
                                {{ $p->qty ?? '' }}
                            </td>
                            <td>
                                Rp {{ number_format($p->total_price, 2) }}
                            </td>
                            <td>
                               {{ $p->status ?? '' }}
                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.prices.show', $p->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('order_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.prices.edit', $p->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('order_delete')
                                    <form action="{{ route('admin.prices.destroy', $p->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('order_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.prices.massDestroy') }}",
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
  let table = $('.datatable-Price:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
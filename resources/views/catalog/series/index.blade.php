@extends('layout.default')

@section('title', trans_choice('general.series', 2))
@section('header', trans_choice('general.series', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.series', 2) }}</li>
@endsection

@permission('create-catalog-series')
@section('new_button')
    <span class="new-button"><a href="{{ url('catalog/series/create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
@endsection
@endpermission

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'catalog/series', 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-left">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
            </div>
            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', 25), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-series">
                    <thead>
                    <tr>
                        <th class="col-md-2">@sortablelink('title', trans('general.title.default'))</th>
                        <th class="col-md-1">{{ trans('general.total') }} {{ strtolower(trans_choice('general.books', 2)) }}</th>
                        <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($series as $item)
                        <tr>
                            <td>
                                <a href="{{ url('catalog/series/' . $item->id . '/edit') }}">
                                    {{ $item->title }}
                                </a>
                            </td>
                            <td>{{ count($item->books) }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ url('catalog/series/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                        @permission('delete-catalog-series')
                                            <li class="divider"></li>
                                            <li>{!! Form::deleteLink($item, 'catalog/series') !!}</li>
                                        @endpermission
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $series, 'type' => 'series'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop
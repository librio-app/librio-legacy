@extends('layout.default')

@section('title', trans_choice('general.subscriptions', 2))
@section('header', trans_choice('general.subscriptions', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.subscriptions', 2) }}</li>
@endsection

@permission('create-administration-subscriptions')
@section('new_button')
    <span class="new-button"><a href="{{ url('administration/subscriptions/create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
@endsection
@endpermission

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'administration/subscriptions', 'role' => 'form', 'method' => 'GET']) !!}
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
                <table class="table table-striped table-hover" id="tbl-subscriptions">
                    <thead>
                    <tr>
                        <th class="col-md-1">@sortablelink('name', trans('general.name'))</th>
                        <th class="col-md-2">{{ trans('general.description') }}</th>
                        <th class="col-md-1">{{ trans('general.book_limit') }}</th>
                        <th class="col-md-1">{{ trans('general.book_lending_days') }}</th>
                        <th class="col-md-1">@sortablelink('subscription_price', trans('general.subscription_price'))</th>
                        <th class="col-md-1">@sortablelink('enabled', trans('general.enabled'))</th>
                        <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subscriptions as $item)
                        <tr>
                            <td>
                                <a href="{{ url('administration/subscriptions/' . $item->id . '/edit') }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ mb_strimwidth($book->description ?? '-', 0, 50, '...') }}</td>
                            <td>{{ $item->book_limit }}</td>
                            <td>{{ $item->book_lending_days }}</td>
                            <td>
                                @money($item->subscription_price * 100, $item->currency)
                            </td>
                            <td>
                                @if ($item->enabled)
                                    <span class="label label-success">{{ trans('general.enabled') }}</span>
                                @else
                                    <span class="label label-danger">{{ trans('general.disabled') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ url('administration/subscriptions/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                        @if ($item->enabled)
                                            <li><a href="{{ route('subscriptions.disable', $item->id) }}">{{ trans('general.disable') }}</a></li>
                                        @else
                                            <li><a href="{{ route('subscriptions.enable', $item->id) }}">{{ trans('general.enable') }}</a></li>
                                        @endif
                                        @permission('delete-administration-subscriptions')
                                        <li class="divider"></li>
                                        <li>{!! Form::deleteLink($item, 'administration/subscriptions', '', 'name') !!}</li>
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
            @include('partials.default.pagination', ['items' => $subscriptions, 'type' => 'subscriptions'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop

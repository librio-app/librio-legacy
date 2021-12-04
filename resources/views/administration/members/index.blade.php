@extends('layout.default')

@section('title', trans_choice('general.members', 2))
@section('header', trans_choice('general.members', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.members', 2) }}</li>
@endsection

@permission('create-administration-members')
@section('new_button')
    <span class="new-button"><a href="{{ url('administration/members/create') }}" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
@endsection
@endpermission

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'administration/members', 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-left">
                <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
                {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
            </div>
            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', 25), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}

                @permission('read-administration-export')
                    {!! Form::button('<span class="fa fa-download"></span>', ['id' => 'download-members', 'type' => 'button', 'class' => 'btn btn-sm btn-danger btn-filter button-submit']) !!}
                @endpermission
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-members">
                    <thead>
                    <tr>
                        <th class="col-md-2">@sortablelink('last_name', trans('general.name'))</th>
                        <th class="col-md-1">{{ trans('general.subscription_nr') }}</th>
                        <th class="col-md-1">{{ trans_choice('general.subscriptions', 1) }}</th>
                        <th class="col-md-1">{{ trans('general.account') }}</th>
                        <th class="col-md-3">@sortablelink('email', trans('general.email'))</th>
                        <th class="col-md-3">{{ trans('general.city') }}</th>
                        <th class="col-md-1">{{ trans('general.enabled') }}</th>
                        <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($members as $item)
                        <tr>
                            <td>
                                <a href="{{ url('administration/members/' . $item->id . '/details') }}">
                                    {{ $item->getNameWithSalutation() }}
                                </a>
                            </td>
                            <td>{{ $item->code }}</td>
                            <td>{{ (count($item->subscriptions()) === 1) ? $item->subscriptions()->first()->name : '-' }}</td>
                            <td style="color: <?php echo ($item->account) ? '#00a65a' : '#9f191f' ?>">
                                @if($item->account)
                                    {{ trans('general.yes') }}
                                @else
                                    {{ trans('general.no') }}
                                @endif
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->city }}</td>
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
                                        <li><a href="{{ url('administration/members/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                        @if ($item->enabled)
                                            <li><a href="{{ route('members.disable', $item->id) }}">{{ trans('general.disable') }}</a></li>
                                        @else
                                            <li><a href="{{ route('members.enable', $item->id) }}">{{ trans('general.enable') }}</a></li>
                                        @endif
                                        @permission('delete-administration-members')
                                        <li class="divider"></li>
                                        <li>{!! Form::deleteLink($item, 'administration/members', '', 'last_name') !!}</li>
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
            @include('partials.default.pagination', ['items' => $members, 'type' => 'members'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#download-members').click(function() {
                window.open('<?php echo route('members.download', request()->query()) ?>','_blank');
            });
        });
    </script>
@endpush

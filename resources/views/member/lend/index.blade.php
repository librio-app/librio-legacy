@extends('layout.default')

@section('title', trans_choice('general.lend', 2))
@section('header', trans_choice('general.lend', 2))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.lend', 2) }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body">
                    {!! Form::open(['url' => 'member/lend', 'role' => 'form', 'method' => 'GET']) !!}

                    <div class="form-group col-md-12 {{ $errors->has('search') ? 'has-error' : '' }}">
                        <label for="lend" class="control-label">{{ trans('general.search') }}</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input autocomplete="off" autofocus class="form-control" placeholder="{{ trans('general.form.enter', ['field' => trans_choice('general.name_or_code', 1)]) }}" name="search" type="text" id="search">

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success button-submit" data-loading-text="{{ trans('general.loading') }}"><span class="fa fa-save"></span> &nbsp;{{ trans('general.search') }}</button>
                            </span>
                        </div>

                        {!! $errors->first('search', '<p class="help-block">:message</p>') !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('partials.info-box.take-in')
        </div>
    </div>

    @if(isset($search))
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table table-responsive">
                            <table class="table table-striped table-hover" id="tbl-members">
                                <thead>
                                <tr>
                                    <th class="col-md-2">@sortablelink('last_name', trans('general.name'))</th>
                                    <th class="col-md-1">{{ trans('general.code') }}</th>
                                    <th class="col-md-1">{{ trans('general.account') }}</th>
                                    <th class="col-md-3">@sortablelink('address_line_1', trans('general.address_line_1'))</th>
                                    <th class="col-md-3">{{ trans('general.city') }}</th>
                                    <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ url('member/lend/' . $item->id) }}">
                                                {{ $item->getNameWithSalutation() }}
                                            </a>
                                        </td>
                                        <td>{{ $item->code }}</td>
                                        <td style="color: <?php echo ($item->account) ? '#00a65a' : '#9f191f' ?>">
                                            @if($item->account)
                                                {{ trans('general.yes') }}
                                            @else
                                                {{ trans('general.no') }}
                                            @endif
                                        </td>
                                        <td>{{ $item->address_line_1 }}</td>
                                        <td>{{ $item->city }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle-position="left" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ url('administration/members/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer">
                        @include('partials.default.pagination', ['items' => $members, 'type' => 'members'])
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop

@extends('layout.default')

@section('title', trans('general.pay'))
@section('header', trans('general.pay'))
@section('breadcrumb')
    <li><a href="{{ url('member/lend') }}"></i>{{ trans('general.lend') }}</a></li>
    <li>{{ $member->getName() }}</li>
@endsection

@section('new_button')
    <span class="new-button"><a href="{{ url('member/lend/' . $member->id ) }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left"></span> {{ trans('general.lend') }} {{ $member->getName() }}</a></span>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            {!! Form::open(['url' => 'administration/members', 'role' => 'form', 'method' => 'GET']) !!}
            <div class="pull-right">
                <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
                {!! Form::select('limit', $limits, request('limit', 25), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table table-responsive">
                <table class="table table-striped table-hover" id="tbl-members">
                    <thead>
                    <tr>
                        <th class="col-md-1">{{ trans_choice('general.barcodes', 1) }}</th>
                        <th class="col-md-3">{{ trans('general.title.default') }}</th>
                        <th class="col-md-1">{{ trans('general.penalty_price') }}</th>
                        <th class="col-md-1">{{ trans('general.costs_price') }}</th>
                        <th class="col-md-1">{{ trans('general.total') }}</th>
                        <th class="col-md-1 text-center">{{ trans('general.pay') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($openPayments as $item)
                        <tr>
                            <td class="barcode">{{ $item->barcode }}</td>
                            <td><a href="{{ url('catalog/books/' . $item->barcode->book->id . '/details') }}">{{ $item->barcode->book->title }}</a></td>
                            <td>@money($item->penalty * 100, (isset($subscription) ? $subscription->currency : 'EUR'))</td>
                            <td>@money($item->costs * 100, (isset($subscription) ? $subscription->currency : 'EUR'))</td>
                            <td>@money(($item->costs + $item->penalty) * 100, (isset($subscription) ? $subscription->currency : 'EUR'))</td>
                            <td class="text-center">
                                {!! Form::open(['url' => 'member/pay/' . $member->id, 'role' => 'form', 'method' => 'POST']) !!}
                                    <input hidden="hidden" name="member_book_id" type="text" id="member_book_id" value="{{ $item->id }}">
                                    <button type="submit" class="btn bg-green button-submit" data-loading-text="{{ trans('general.loading') }}">
                                        <i class="fa fa-money"></i>
                                    </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- TODO set all paid -->
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @include('partials.default.pagination', ['items' => $openPayments, 'type' => 'books'])
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
@stop

@extends('layout.default')

@section('title', trans('general.title.new', ['type' => trans_choice('general.subscriptions', 1)]))
@section('header', trans('general.title.new', ['type' => trans_choice('general.subscriptions', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.subscriptions', 2) }}</li>
@endsection

@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::open(['url' => 'administration/subscriptions', 'role' => 'form']) !!}

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans('general.data') }}</h4>

            {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}
        </div>

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans_choice('general.prices', 2) }}</h4>

            <p class="col-md-12">{{ trans('general.unlimited_books') }}</p>
            {{ Form::selectGroup('currency', trans('general.currency'), 'bookmark', config('enums.currency')) }}

            {{ Form::numberGroup('subscription_price', trans('general.subscription_price'), 'bookmark', ['step' => '0.01']) }}

            {{ Form::selectGroup('payment_period', trans('general.payment_period'), 'bookmark', array_map(function ($value) {
                return trans('general.' . $value);
            }, config('enums.payment_period'))) }}
        </div>

        <div class="box-body">
            <h4 class="col-md-12">{{ trans_choice('general.subscriptions', 1) }}</h4>

            <p class="col-md-12">{{ trans('general.unlimited_books') }}</p>
            {{ Form::numberGroup('book_limit', trans('general.book_limit'), 'bookmark') }}
        </div>

        <div class="box-body">
            <h4 class="col-md-12">{{ trans_choice('general.penalties', 2) }}</h4>
            <div class="row" style="margin: 0">
                {{ Form::radioGroup('penalty', trans_choice('general.penalties', 1)) }}
            </div>

            <div class="row" style="margin: 0">
                {{ Form::numberGroup('book_lending_days', trans('general.book_lending_days'), 'bookmark') }}

                {{ Form::numberGroup('penalty_price', trans('general.penalty_price'), 'bookmark', ['step' => '0.01']) }}
            </div>
        </div>

        <div class="box-body">
            {{ Form::radioGroup('enabled', trans('general.enabled'), true) }}

            {{ Form::selectGroup('expire_date', trans('general.expire_date'), 'calendar', array_map(function ($value) {
                return trans('general.' . $value);
            }, config('enums.expire_date'))) }}
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {{ Form::saveButtons() }}
        </div>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var text_yes = '{{ trans('general.yes') }}';
        var text_no = '{{ trans('general.no') }}';

        $(document).ready(function(){
            $('input[type=checkbox]').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush

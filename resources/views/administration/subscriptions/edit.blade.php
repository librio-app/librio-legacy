@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.subscriptions', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.subscriptions', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.subscriptions', 2) }}</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($subscription, [
            'method' => 'PATCH',
            'url' => ['administration/subscriptions', $subscription->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body" style="padding-bottom: 0px;">
            <div class="alert alert-warning" role="alert" style="margin-bottom: 0px;">
                <i class="icon fa fa-warning"></i>
                {{ trans('general.effects_all_members') }}
            </div>
        </div>

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans('general.data') }}</h4>

            {{ Form::textGroup('name', trans('general.name'), 'bookmark') }}

            {{ Form::textareaGroup('description', trans('general.description')) }}
        </div>

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans_choice('general.prices', 2) }}</h4>

            {{ Form::selectGroup('currency', trans('general.currency'), 'bookmark', config('enums.currency')) }}

            {{ Form::numberGroup('subscription_price', trans('general.subscription_price'), 'bookmark', ['step' => '0.01']) }}

            {{ Form::selectGroup('payment_period', trans('general.payment_period'), 'bookmark', array_map(function ($value) {
                return trans('general.' . $value);
            }, config('enums.payment_period'))) }}
        </div>

        <div class="box-body">
            <h4 class="col-md-12">{{ trans_choice('general.subscriptions', 1) }}</h4>

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
            {{ Form::radioGroup('enabled', trans('general.enabled')) }}

            {{ Form::selectGroup('expire_date', trans('general.expire_date'), 'calendar', array_map(function ($value) {
                return trans('general.' . $value);
            }, config('enums.expire_date'))) }}
        </div>
        <!-- /.box-body -->

        @permission('update-administration-subscriptions')
        <div class="box-footer">
            {{ Form::saveButtons('administration/subscriptions') }}
        </div>
        <!-- /.box-footer -->
        @endpermission

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

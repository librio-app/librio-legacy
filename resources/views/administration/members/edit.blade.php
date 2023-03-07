@extends('layout.default')

@section('title', trans('general.title.edit', ['type' => trans_choice('general.members', 1)]))
@section('header', trans('general.title.edit', ['type' => trans_choice('general.members', 1)]))
@section('breadcrumb')
    <li class="active">{{ trans_choice('general.members', 2) }}</li>
@endsection


@section('content')
    <!-- Default box -->
    <div class="box box-primary">
        {!! Form::model($member, [
            'method' => 'PATCH',
            'url' => ['administration/members', $member->id],
            'role' => 'form',
        ]) !!}

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans('general.data') }}</h4>

            {{ Form::selectGroup('salutation', trans('general.salutation'), 'user', array_map(function ($value) {
                return trans('salutation.' . $value);
            }, config('enums.salutation')), $member->salutation) }}

            {{ Form::textGroup('email', trans('general.email'), 'at') }}

            {{ Form::textGroup('first_name', trans('general.first_name'), 'user') }}

            {{ Form::textGroup('insertion', trans('general.insertion'), 'user', []) }}

            {{ Form::textGroup('last_name', trans('general.last_name'), 'user') }}

            {{--            {{ Form::dateRange('birthday', trans('general.birthday'), 'calendar') }}--}}

            {{ Form::textGroup('code', trans('general.subscription_nr'), 'barcode') }}

            {{ Form::textGroup('comment', trans('general.comment'), 'comment', [], null, 'col-md-12') }}
        </div>

        <div class="box-body col-md-6">
            <h4 class="col-md-12">{{ trans('general.address.billing') }}</h4>

            {{ Form::textGroup('address_line_1', trans('general.address_line_1'), 'address-card') }}

            {{ Form::textGroup('address_line_2', trans('general.address_line_2'), 'address-card', []) }}

            {{ Form::textGroup('zipcode', trans('general.zipcode'), 'map') }}

            {{ Form::textGroup('city', trans('general.city'), 'building') }}

            <?php /** {{ Form::textGroup('state', trans('general.state'), 'globe', []) }} */ ?>
        </div>

        <div class="box-body">
            <h4 class="col-md-12">{{ trans_choice('general.subscriptions', 1) }}</h4>

            {{ Form::selectGroup('subscription_id', trans_choice('general.subscriptions', 1), 'money', $subscriptions, $selectedSubscription) }}
        </div>

        <div class="box-body">
            <h4 class="col-md-12">{{ trans('general.change') }}</h4>
            <p class="col-md-12">{{ trans('general.subscription_message') }}</p>

            {{ Form::radioGroup('enabled', trans('general.enabled')) }}
        </div>
        <!-- /.box-body -->

        @permission('update-administration-members')
        <div class="box-footer">
            {{ Form::saveButtons('administration/members') }}
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

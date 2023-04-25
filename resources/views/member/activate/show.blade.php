@extends('layout.login')

@section('title', trans('general.activate_account'))
@section('header', trans('general.activate_account'))
@section('breadcrumb')
    <li>{{ trans('general.activate_account') }}</li>
@endsection

@section('content')
    <form role="form" method="POST" action="{{ route('member.confirm', ['confirmationKey' => $confirmationKey]) }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input name="password" type="password" class="form-control" placeholder="{{ trans('auth.password.new') }}" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ trans('auth.password.new_confirm') }}" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
        </div>

        <div class="row">
            <!-- /.col -->
            <div class="col-sm-offset-8 col-sm-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">{{ trans('auth.activate') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection

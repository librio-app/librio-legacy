@extends('layout.login')

@section('title', trans('auth.forgot_password_title'))

@section('content')
    <form role="form" method="POST" action="{{ url('admin/auth/forgot') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input name="email" type="email" class="form-control" placeholder="{{ trans('auth.enter_email') }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>

        <div class="row">
            <!-- /.col -->
            <div class="col-sm-offset-8 col-sm-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">{{ trans('general.send') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection()

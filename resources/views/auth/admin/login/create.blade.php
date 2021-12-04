@extends('layout.login')

@section('title', trans('auth.login_admin'))

@section('content')
    <form role="form" method="POST" action="{{ url('admin/auth/login') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input name="email" type="email" class="form-control" placeholder="{{ trans('general.email') }}" required autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input name="password" type="password" class="form-control" placeholder="{{ trans('auth.password.current') }}" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="checkbox icheck">
                    <label>
                        <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}> &nbsp;{{ trans('auth.remember_me') }}
                    </label>
                </div>
            </div>
        <!-- /.col -->

            <div class="col-sm-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">{{ trans('auth.login') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ url('admin/auth/forgot') }}">{{ trans('auth.forgot_password') }}</a><br>
            <a href="{{ url('auth/login') }}">{{ trans('auth.login_member') }}</a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endpush

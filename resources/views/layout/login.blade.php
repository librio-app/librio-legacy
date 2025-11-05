<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ env('APP_LOCALE') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Librio | @yield('title', config('app.timezone'))</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <link rel="stylesheet" href="{{ asset("css/app.css") }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src="{{ asset("js/app.js") }}"></script>

        @stack('scripts')
    </head>
    <body class="hold-transition login-page">

    <div class="login-box">

        <div class="login-logo">
            <img src="{{ asset('images/librio-default.png') }}" alt="Librio" />
            <p style="color: white">{{ config('app.name', 'Librio') }}</p>
        </div>
        <!-- /.login-logo -->

        <div class="login-box-body">
            <p class="login-box-msg">@yield('title')</p>

            @include('flash::message')

            @yield('content')
        </div>
        <!-- /.login-box-body -->

        <a href="{{ route('opac') }}" class="btn btn-primary btn-block btn-flat">
            {{ trans('auth.open_opac', ['opac' => trans_choice('general.opac', 2)]) }}
        </a>

        <?php /** ?>
        <div class="login-box-footer">
            {{ trans('footer.powered') }}: <a href="{{ trans('footer.link') }}" target="_blank">{{ trans('footer.software') }}</a>
        </div>
        **/ ?>
        <!-- /.login-box-footer -->
    </div>

    </body>
<!-- /.register-box -->
</html>

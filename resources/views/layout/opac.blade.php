<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Librio | @yield('title', config('app.name'))</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <link rel="stylesheet" href="{{ mix("css/app.css") }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @stack('css')
    </head>

    @php
        $type = 'layout-top-nav';
        // Als je ingelogd bent krijg je een sidebar
        if (Auth()->user() instanceof App\Models\User) {
            $type = 'sidebar-mini';
        }
    @endphp
    <body class="hold-transition skin-librio {{ $type }}">
        <div class="wrapper">

        @include('partials.opac.header')

        @if (Auth()->user() instanceof App\Models\User && !Auth::user()->isAdmin())
            @include('partials.opac.sidebar')
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header content-center">
                <h1>
                    @yield('header', 'Page Header')
                    <small>@yield('description', '')</small>

                    @yield('new_button')
                </h1>

                <ol class="breadcrumb">
                    <li><a href="{{ url("/opac") }}"><i class="fa fa-home"></i> {{ trans('general.home') }}</a></li>
                    @yield('breadcrumb')
                </ol>
            </section>

            <!-- Main content -->
            <section class="content content-center">
                @include('flash::message')

                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @include('partials.opac.footer')
    </div>
        <!-- ./wrapper -->

        <script type="text/javascript" src="{{ mix("js/app.js") }}"></script>

        <script type="text/javascript" async src="{{ asset("js/custom.js") }}"></script>

        @stack('scripts')

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
            Both of these plugins are recommended to enhance the
            user experience. -->
    </body>
</html>

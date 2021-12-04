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
    <body class="hold-transition skin-librio sidebar-mini {{  (filter_var(request()->cookie('sidebar', false), FILTER_VALIDATE_BOOLEAN)) ? 'sidebar-collapse' : '' }}">
        <div class="wrapper">

        @include('partials.default.header')

        @include('partials.default.sidebar')

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
                    <li><a href="{{ url("/") }}"><i class="fa fa-dashboard"></i> {{ trans('general.home') }}</a></li>
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

        @include('partials.default.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <?php /**
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                 **/ ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">{{ trans('general.activities') }}</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <!--
                            <a href="javascript:;">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                            -->
                        </li>
                    </ul>

                </div>
                <!-- /.tab-pane -->

                <?php /**
                <!-- Stats tab content -->
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Report panel usage
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Some information about this general settings option
                            </p>
                        </div>
                        <!-- /.form-group -->
                    </form>
                </div>
                <!-- /.tab-pane -->
                **/ ?>
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
        <!-- ./wrapper -->

        <script type="text/javascript" src="{{ mix("js/app.js") }}"></script>

        <script type="text/javascript" async src="{{ asset("js/custom.js") }}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#sidebar-toggle').click(function() {
                    // remove cookie
                    document.cookie = "sidebar='';-1; path=/";
                    // expire in one year
                    var date = new Date();
                    date.setTime(date.getTime() + (365*24*60*60*1000));
                    var expires = "; expires=" + date.toUTCString();
                    if ($("body").hasClass("sidebar-collapse")) {
                        document.cookie = "sidebar=false;" + expires + "; path=/";
                    } else {
                        document.cookie = "sidebar=true;" + expires + "; path=/";
                    }
                });
            });
        </script>

        @stack('scripts')

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
            Both of these plugins are recommended to enhance the
            user experience. -->
    </body>
</html>

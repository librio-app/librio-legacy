<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>LIB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Lib</b>rio</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" id="sidebar-toggle" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="{{ url('opac') }}">
                        <i class="fa fa-university"></i>
                    </a>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    @if (!empty(Auth::user()))
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <!--<img src="#" class="user-image" alt="User Image">-->
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span>
                                @if (!empty(Auth::user()->name))
                                    <span>{{ Auth::user()->name }}</span>
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ asset('images/user.jpg') }}" class="img-circle" alt="User Image">

                                <p>
                                    @if (!empty(Auth::user()->name))
                                        <span>{{ Auth::user()->name }}</span>
                                    @endif
                                    @if (!empty(Auth::user()->created_at))
                                        <small>{{ trans('header.member_time', ['time' => Auth::user()->created_at->diffForHumans() ]) }}</small>
                                    @endif
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <?php /**
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            **/ ?>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                @permission('read-admin-panel')
                                    <div class="pull-left">
                                        <a href="{{ url('auth/users') }}" class="btn btn-default btn-flat">{{ trans_choice('general.users', 2) }}</a>
                                    </div>
                                @endpermission
                                <div class="pull-right">
                                    <a href="{{ url('admin/auth/logout') }}" class="btn btn-default btn-flat">{{ trans('auth.logout') }}</a>
                                </div>
                            </li>
                        </ul>
                    @endif
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

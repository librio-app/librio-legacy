<!-- Main Header -->
<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ url('/opac') }}" class="navbar-brand">
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Lib</b>rio</span>
                </a>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>

                <div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false" style="height: 1px;">
{{--                    <ul class="nav navbar-nav">--}}
{{--                        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>--}}
{{--                        <li><a href="#">Link</a></li>--}}
{{--                        <li class="dropdown">--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
{{--                            <ul class="dropdown-menu" role="menu">--}}
{{--                                <li><a href="#">Action</a></li>--}}
{{--                                <li><a href="#">Another action</a></li>--}}
{{--                                <li><a href="#">Something else here</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">Separated link</a></li>--}}
{{--                                <li class="divider"></li>--}}
{{--                                <li><a href="#">One more separated link</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                    <form method="GET" action="{{ url('opac/search') }}" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" id="quick-search" name="search" placeholder="{{ trans('general.search_quick') }}...">
                        </div>
                    </form>
                </div>
            </div>

            <div class="navbar-custom-menu-left">
                <ul class="nav navbar-nav">
                    <li>
                        <p>{{ config('app.name', 'Librio') }}</p>
                    </li>
                </ul>
            </div>

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if (Auth()->user() instanceof App\Models\User && Auth::user()->isAdmin())
                        <li><a href="{{ url('/') }}">{{ trans('general.dashboard') }}</a></li>
                    @else
                        <li><a href="{{ url('opac/auth/logout') }}">{{ trans('auth.logout') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>

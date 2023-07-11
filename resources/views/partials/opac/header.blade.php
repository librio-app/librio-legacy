<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo" style="position: relative; z-index: 99999;">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>LIB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Lib</b>rio</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        @if (Auth()->user() instanceof App\Models\User && !Auth::user()->isAdmin())
            <!-- Sidebar toggle button-->
            <a href="#" id="sidebar-toggle" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        @endif

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if (Auth()->user() instanceof App\Models\User && Auth::user()->isAdmin())
                    <li><a href="{{ url('/') }}">{{ trans('general.dashboard') }}</a></li>
                @else
                    <li><a href="{{ route('opac') }}">{{ trans('general.dashboard') }}</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>

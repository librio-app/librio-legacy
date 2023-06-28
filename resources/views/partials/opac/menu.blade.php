<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
    <li {{ Request::routeIs('opac')  ? "class=active" : '' }}><a href="{{ route('opac') }}"><i class="fa fa-university"></i> <span>{{ trans('general.search') }}</span></a></li>
    <li {{ Request::routeIs('lended')  ? "class=active" : '' }}><a href="{{ route('lended') }}"><i class="fa fa-book"></i> <span>{{ trans('general.lended_books') }}</span></a></li>
    <li><a href="{{ route('logout') }}"><i class="fa fa-user"></i>{{ trans('auth.logout') }}</a></li>
</ul>
<!-- /.sidebar-menu -->

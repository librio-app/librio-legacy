<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
    <!-- Optionally, you can add icons to the links -->
    <?php /**
    <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
    <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
        </ul>
    </li>
    **/ ?>

    @permission('read-take-in-panel')
    <li class="treeview {{ strpos(url()->current(), 'member/') !== false ? 'active' : '' }}">
        <a href="#"><i class="fa fa-calendar"></i> <span>{{ trans('general.lend') }} / {{ trans('general.take-in') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>

        <ul class="treeview-menu">
            @permission('read-member-takein')
                <li {{ Request::is('member/take-in')  ? "class=active" : '' }}><a href="{{ url('member/take-in') }}"><i class="fa fa-share"></i> <span>{{ trans_choice('general.take-in', 2) }}</span></a></li>
            @endpermission

            @permission('read-member-lend')
                <li {{ Request::is('member/lend')  ? "class=active" : '' }}><a href="{{ url('member/lend') }}"><i class="fa fa-book"></i> <span>{{ trans_choice('general.lend', 2) }}</span></a></li>
            @endpermission

            @permission('read-member-reservations')
                <li {{ Request::is('member/reservations')  ? "tbl-reservationsclass=active" : '' }}><a href="{{ url('member/reservations') }}"><i class="fa fa-flag"></i> <span>{{ trans_choice('general.reservations', 2) }}</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-catalog-panel')
    <li class="treeview {{ strpos(url()->current(), 'catalog/') !== false ? 'active' : '' }}">
        <a href="#"><i class="fa fa-book"></i> <span>{{ trans('general.catalog') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>

        <ul class="treeview-menu">
            @permission('read-catalog-books')
                <li {{ Request::is('catalog/books')  ? "class=active" : '' }}><a href="{{ url('catalog/books') }}"><i class="fa fa-bookmark"></i> <span>{{ trans_choice('general.books', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-books')
            <li {{ Request::is('catalog/barcode/status')  ? "class=active" : '' }}><a href="{{ url('catalog/barcode/status') }}"><i class="fa fa-bell"></i> <span>{{ trans('general.change_status') }}</span></a></li>
            @endpermission

            @permission('read-catalog-authors')
                <li {{ Request::is('catalog/authors')  ? "class=active" : '' }}><a href="{{ url('catalog/authors') }}"><i class="fa fa-user"></i> <span>{{ trans_choice('general.authors', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-publishers')
                <li {{ Request::is('catalog/publishers')  ? "class=active" : '' }}><a href="{{ url('catalog/publishers') }}"><i class="fa fa-industry"></i> <span>{{ trans_choice('general.publishers', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-categories')
                <li {{ Request::is('catalog/categories')  ? "class=active" : '' }}><a href="{{ url('catalog/categories') }}"><i class="fa fa-list"></i> <span>{{ trans_choice('general.categories', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-series')
                <li {{ Request::is('catalog/series')  ? "class=active" : '' }}><a href="{{ url('catalog/series') }}"><i class="fa fa-book"></i> <span>{{ trans_choice('general.series', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-themes')
                <li {{ Request::is('catalog/themes')  ? "class=active" : '' }}><a href="{{ url('catalog/themes') }}"><i class="fa fa-eyedropper"></i> <span>{{ trans_choice('general.themes', 2) }}</span></a></li>
            @endpermission

            @permission('read-catalog-types')
                <li {{ Request::is('catalog/types')  ? "class=active" : '' }}><a href="{{ url('catalog/types') }}"><i class="fa fa-list"></i> <span>{{ trans_choice('general.types', 2) }}</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-administration-panel')
    <li class="treeview {{ strpos(url()->current(), 'administration/') !== false ? 'active' : '' }}">
        <a href="#"><i class="fa fa-users"></i> <span>{{ trans('general.administration') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>

        <ul class="treeview-menu">
            @permission('read-administration-members')
                <li {{ Request::is('administration/members')  ? "class=active" : '' }}><a href="{{ url('administration/members') }}"><i class="fa fa-user-plus"></i> <span>{{ trans_choice('general.members', 2) }}</span></a></li>
            @endpermission

            @permission('read-administration-subscriptions')
            <li {{ Request::is('administration/subscriptions')  ? "class=active" : '' }}><a href="{{ url('administration/subscriptions') }}"><i class="fa fa-money"></i> <span>{{ trans_choice('general.subscriptions', 2) }}</span></a></li>
            @endpermission
        </ul>
    </li>
    @endpermission

    @permission('read-admin-panel')
    <li class="treeview {{ strpos(url()->current(), 'auth/users') !== false ? 'active' : '' }}">
        <a href="#"><i class="fa fa-cog"></i> <span>{{ trans_choice('general.settings', 2) }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li {{ Request::is('auth/users')  ? "class=active" : '' }}><a href="{{ url('auth/users') }}"><i class="fa fa-user"></i> <span>{{ trans_choice('general.users', 2) }}</span></a></li>
        </ul>
    </li>
    @endpermission

    @permission('read-statistics-panel')
    <li class="treeview {{ strpos(url()->current(), 'statistics/') !== false ? 'active' : '' }}">
        <a href="#"><i class="fa fa-bar-chart"></i> <span>{{ trans_choice('general.statistics', 2) }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li {{ Request::is('statistics/books')  ? "class=active" : '' }}><a href="{{ url('statistics/books') }}"><i class="fa fa-book"></i> <span>{{ trans_choice('general.books', 2) }}</span></a></li>
        </ul>
    </li>
    @endpermission

    <li {{ Request::is('opac')  ? "class=active" : '' }}><a href="{{ url('opac') }}"><i class="fa fa-university"></i> <span>{{ trans('general.opac') }}</span></a></li>
</ul>
<!-- /.sidebar-menu -->

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        {{--<div class="user-panel">--}}
            {{--<div class="pull-left image">--}}
                {{--<img src="{{ asset('images/user.jpg') }}" class="img-circle" alt="User Image">--}}
            {{--</div>--}}
            {{--<div class="pull-left info">--}}
                {{--@if (!empty(Auth::user()->name))--}}
                    {{--<p>{{ Auth::user()->name }}</p>--}}
                {{--@endif--}}
                {{--<!-- Status -->--}}
                {{--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>--}}
            {{--</div>--}}
        {{--</div>--}}

        <!-- search form (Optional) -->
        <form action="{{ route('quick.search') }}" method="GET" class="sidebar-form">
            <div class="input-group">
                <input autocomplete="off" type="text" name="search" class="form-control" placeholder="{{ trans('general.search') }}...">
                <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
            </div>
        </form>
        <!-- /.search form -->

        @include('partials.default.menu')
    </section>
    <!-- /.sidebar -->
</aside>

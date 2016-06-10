<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('quickadmin/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if(Auth::user()->role_id == config('quickadmin.defaultRole'))
                <li @if(Request::path() == config('quickadmin.route')) class="active" @endif>
                    <a href="{{ url(config('quickadmin.route')) }}">
                        <i class="fa fa-tachometer"></i>
                        <span class="title">{{ trans('quickadmin::admin.partials-sidebar-dashboard') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('quickadmin.route').'/menu') class="active" @endif>
                    <a href="{{ url(config('quickadmin.route').'/menu') }}">
                        <i class="fa fa-list"></i>
                        <span class="title">{{ trans('quickadmin::admin.partials-sidebar-menu') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('quickadmin.route').'/users') class="active" @endif>
                    <a href="{{ url(config('quickadmin.route').'/users') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('quickadmin::admin.partials-sidebar-users') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('quickadmin.route').'/roles') class="active" @endif>
                    <a href="{{ url(config('quickadmin.route').'/roles') }}">
                        <i class="fa fa-gavel"></i>
                        <span class="title">{{ trans('quickadmin::admin.partials-sidebar-roles') }}</span>
                    </a>
                </li>
                <li @if(Request::path() == config('quickadmin.route').'/actions') class="active" @endif>
                    <a href="{{ url(config('quickadmin.route').'/actions') }}">
                        <i class="fa fa-users"></i>
                        <span class="title">{{ trans('quickadmin::admin.partials-sidebar-user-actions') }}</span>
                    </a>
                </li>
            @endif
            @foreach($menus as $menu)
                @if($menu->menu_type != 2 && is_null($menu->parent_id))
                    @if(Auth::user()->role->canAccessMenu($menu))
                        <li @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($menu->name)) class="active" @endif>
                            <a href="{{ route(config('quickadmin.route').'.'.strtolower($menu->name).'.index') }}">
                                <i class="fa {{ $menu->icon }}"></i>
                                <span class="title">{{ $menu->title }}</span>
                            </a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->role->canAccessMenu($menu) && !is_null($menu->children()->first()) && is_null($menu->parent_id))
                        <li>
                            <a href="#">
                                <i class="fa {{ $menu->icon }}"></i>
                                <span class="title">{{ $menu->title }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @foreach($menu['children'] as $child)
                                    @if(Auth::user()->role->canAccessMenu($child))
                                        <li
                                        @if(isset(explode('/',Request::path())[1]) && explode('/',Request::path())[1] == strtolower($child->name)) class="active active-sub" @endif>
                                            <a href="{{ route(config('quickadmin.route').'.'.strtolower($child->name).'.index') }}">
                                                <i class="fa {{ $child->icon }}"></i>
                                                <span class="title">
                                                    {{ $child->title  }}
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

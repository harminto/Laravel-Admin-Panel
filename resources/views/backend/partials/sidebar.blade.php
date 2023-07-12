<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
    <div class="pull-left image">
        <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>
            @if(Auth::check())    
                {{ Auth::user()->name }}
            @endif
        </p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @php
            $menus = DB::table('menus')->orderBy('order')->get();
            $roleMenus = Auth::user()->roles->pluck('menus')->flatten()->unique();
        @endphp

        @foreach($menus as $menu)
            @php
                $hasChildren = DB::table('menus')->where('parent_id', $menu->id)->count() > 0;
            @endphp

            @if(!$hasChildren || DB::table('menus')->whereIn('id', $roleMenus->pluck('id'))->count() > 0)
                @if($menu->parent_id === null)
                    @if(!$hasChildren)
                        <li>
                            <a href="{{ $menu->url == '#' ? $menu->url : (strpos($menu->url, 'http') === 0 ? $menu->url : route($menu->url)) }}"  data-nprogress>
                                <i class="{{ $menu->icon }}"></i>
                                <span>{{ $menu->title }}</span>
                            </a>
                        </li>
                    @else
                        <li class="treeview">
                            <a href="{{ $menu->url == '#' ? $menu->url : (strpos($menu->url, 'http') === 0 ? $menu->url : route($menu->url)) }}">
                                <i class="{{ $menu->icon }}"></i>
                                <span>{{ $menu->title }}</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach(DB::table('menus')->whereIn('id', $roleMenus->pluck('id'))->where('parent_id', $menu->id)->orderBy('order')->get() as $childMenu)
                                    <li class="{{ request()->routeIs(explode('.', $childMenu->url)[0].'.*') ? 'active' : '' }}">
                                        <a href="{{ $childMenu->url == '#' ? $childMenu->url : (strpos($childMenu->url, 'http') === 0 ? $childMenu->url : route($childMenu->url)) }}" data-nprogress>
                                            <i class="{{ $childMenu->icon }}"></i> {{ $childMenu->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif
            @endif
        @endforeach
    </ul>




    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var treeviewItems = document.querySelectorAll('.treeview');
        treeviewItems.forEach(function(item) {
            if (item.querySelector('.treeview-menu .active')) {
                item.classList.add('active');
            }
        });
    });
    </script>

</section>
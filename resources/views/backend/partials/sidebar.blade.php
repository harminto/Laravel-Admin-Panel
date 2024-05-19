<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">{{ \App\Models\AppSetting::where('setting_key', 'short_name')->value('setting_value') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <img alt="image" src="{{ asset('logo-jamf.png') }}" width="50" class="rounded-circle mr-1">
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Menu Utama</li>
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
                        <li class="dropdown">
                            <a href="{{ $menu->url == '#' ? $menu->url : (strpos($menu->url, 'http') === 0 ? $menu->url : route($menu->url)) }}" class="nav-link has-dropdown" data-toggle="dropdown">
                                <i class="{{ $menu->icon }}"></i>
                                <span>{{ $menu->title }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(DB::table('menus')->whereIn('id', $roleMenus->pluck('id'))->where('parent_id', $menu->id)->orderBy('order')->get() as $childMenu)
                                    <li class="{{ request()->routeIs(explode('.', $childMenu->url)[0].'.*') ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ $childMenu->url == '#' ? $childMenu->url : (strpos($childMenu->url, 'http') === 0 ? $childMenu->url : route($childMenu->url)) }}" data-nprogress data-menu-id="{{ $childMenu->id }}" data-nprogress>
                                            {{ $childMenu->title }}
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

    {{-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <button id="installButton" style="display: none;" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Install APP
        </button>
        <button id="uninstallButton" style="display: none;" class="btn btn-danger btn-lg btn-block btn-icon-split">
            <i class="fas fa-rocket"></i> Uninstall APP
        </button>
    </div> --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var treeviewItems = document.querySelectorAll('.dropdown');
        treeviewItems.forEach(function(item) {
            if (item.querySelector('.dropdown-menu .active')) {
                item.classList.add('active');
            }
        });
    });
    </script>
</aside>
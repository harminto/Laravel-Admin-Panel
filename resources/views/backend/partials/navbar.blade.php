<a href="{{ route('home') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{!! \App\Models\AppSetting::where('setting_key', 'system_short_name')->value('setting_value') !!}</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">{!! \App\Models\AppSetting::where('setting_key', 'system_short_name')->value('setting_value') !!}</span>
</a>
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
            <span class="hidden-xs">
                @if(Auth::check())    
                    {{ Auth::user()->name }}
                @endif
            </span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
            <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

            <p>
            @if(Auth::check())    
                {{ Auth::user()->name }}
            @endif
            @if(Auth::check())
                <small>{{ Auth::user()->roles->pluck('name')->implode(', ') }}</small>
                @endif
            </p>
            </li>
            
            <li class="user-footer">
            <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            </li>
        </ul>
        </li>
    </ul>
    </div>
</nav>
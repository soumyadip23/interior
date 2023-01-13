<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'vendor.dashboard' ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        
        <li>
            <a class="app-menu__item" href=""><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Take Measurement</span>
            </a>
        </li>

        
    </ul>
</aside>
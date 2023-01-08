<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.users']) }}"
                href="{{ route('admin.users.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Vendor Management</span>
            </a>
        </li>
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.restaurant']) }}"
                href="{{ route('admin.restaurant.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Restaurant Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.order']) }}"
                href="{{ route('admin.order.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Order Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item"
                href="{{ route('admin.order.report') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Order Report</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item"
                href="{{ route('admin.order.sales') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Sales Data</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item"
                href="{{ route('admin.order.onlinetransactions') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Online Transactions</span>
            </a>
        </li> -->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.boys']) }}"
                href="{{ route('admin.boys.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Staff Management</span>
            </a>
        </li>
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.coupon']) }}"
                href="{{ route('admin.coupon.index') }}"><i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">Coupon Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.notification.sos']) }}"
                href="{{ route('admin.notification.sos') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">SOS Notification</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.notification']) }}"
                href="{{ route('admin.notification.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Notification Management</span>
            </a>
        </li> -->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.category']) }}"
                href="{{ route('admin.category.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Category Management</span>
            </a>
        </li>
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.cousine']) }}"
                href="{{ route('admin.cousine.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Cuisine Management</span>
            </a>
        </li> -->
        {{-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.location']) }}"
                href="{{ route('admin.location.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Location Management</span>
            </a>
        </li> --}}
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.commission']) }}"
                href="{{ route('admin.commission.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Commission Management</span>
            </a>
        </li> -->
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.incentive']) }}"
                href="{{ route('admin.incentive.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Incentive Management</span>
            </a>
        </li> -->
        <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.vehicle']) }}"
                href="{{ route('admin.vehicle.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Vehicle Management</span>
            </a>
        </li> -->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.banner']) }}"
                href="{{ route('admin.banner.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Banner Management</span>
            </a>
        </li>
         <!-- <li>
            <a class="app-menu__item {{ sidebar_open(['admin.blog']) }}"
                href="{{ route('admin.blog.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Blog Management</span>
            </a>
        </li> -->
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.lead']) }}"
                href="{{ route('admin.lead.index') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Lead Management</span>
            </a>
        </li> 
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.settings']) }}"
                href="{{ route('admin.settings') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Site Settings</span>
            </a>
        </li>
        
    </ul>
</aside>
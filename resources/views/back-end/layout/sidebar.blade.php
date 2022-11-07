<!-- BEGIN: Main Menu-->
<!-- main menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow menu-bordered" data-scroll-to-active="true">
    <!-- main menu header-->
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{ request()->is('admin/dashboard*') ? ' active' : '' }}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="">Dashboard</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/categories*') ? ' active' : '' }}">
                <a href="{{route('admin.categories.index')}}">
                    <i class="feather icon-tag"></i>
                    <span class="menu-title" data-i18n="">Categories</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/attributes*') ? ' active' : '' }}">
                <a href="{{route('admin.attributes.index')}}">
                    <i class="icon-notebook"></i>
                    <span class="menu-title" data-i18n="">Product Attributes</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/products*') ? ' active' : '' }}">
                <a href="{{route('admin.products.index')}}">
                    <i class="feather icon-package"></i>
                    <span class="menu-title" data-i18n="">Products</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/coupons*') ? ' active' : '' }}">
                <a href="{{route('admin.coupons.index')}}">
                    <i class="fa fa-ticket"></i>
                    <span class="menu-title" data-i18n="">Coupons</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/orders*') ? ' active' : '' }}">
                <a href="{{route('admin.orders.index')}}">
                    <i class="feather icon-shopping-cart"></i>
                    <span class="menu-title" data-i18n="">Orders</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/contacts*') ? ' active' : '' }}">
                <a href="{{route('admin.contacts')}}">
                    <i class="feather icon-mail"></i>
                    <span class="menu-title" data-i18n="">Contacts</span>
                </a>
            </li>

            <li class=" nav-item {{ request()->is('admin/settings*') ? ' active' : '' }}">
                <a href="{{route('admin.settings')}}">
                    <i class="feather icon-settings"></i>
                    <span class="menu-title" data-i18n="">Settings</span>
                </a>
            </li>

        </ul>
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <!-- main menu footer-->
</div>
<!-- / main menu-->
<!-- END: Main Menu-->

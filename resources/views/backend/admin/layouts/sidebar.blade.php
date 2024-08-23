<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <h6>{{ config('app.name') }}</h6>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-speedometer') }}"></use>
                </svg>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.admin-user.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-user') }}"></use>
                </svg>
                Admin User
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.staff.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-group') }}"></use>
                </svg>
                Staff
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.category.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-fastfood') }}"></use>
                </svg>
                Category
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.product.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-restaurant') }}"></use>
                </svg>
                Product
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.order.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-dinner') }}"></use>
                </svg>
                Order
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.invoice.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-description') }}"></use>
                </svg>
                Invoice
            </a>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>

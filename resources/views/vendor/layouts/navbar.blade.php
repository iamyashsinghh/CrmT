@php
    $auth_user = Auth::guard('Vendor')->user();
@endphp
<nav class="main-header navbar navbar-expand navbar-dark navbar-light" style="background: var(--wb-renosand)">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link" data-widget="pushmenu" id="sidebar_collapsible_elem"
                data-collapse="1" onclick="handle_sidebar_collapse(this)"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        @yield('navbar-right-links')
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" title="logout" onclick="return confirm('Are you sure want to logout?')"
                href="{{ route('logout') }}">
                <i class="fas fa-power-off"></i>
            </a>
        </li>
    </ul>
</nav>

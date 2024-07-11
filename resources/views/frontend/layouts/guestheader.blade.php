<style>
    .logo {
        height: 50px;
        /* Adjust the height as needed */
    }
</style>
@php
    $settings = DB::table('settings')->get();
@endphp
<!-- Header -->
<header class="header shop">
    <!-- Desktop Navbar -->
    <div class="header-inner d-none d-lg-block">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <a class="navbar-brand" href="{{ route('home') }}">
                                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach"
                                        class="logo m-0" alt="logo">
                                </a>
                                <div class="collapse navbar-collapse" id="navbarNav">
                                    <div class="nav-inner d-flex justify-content-between w-100">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{ Request::path() == 'home' ? 'active' : '' }}">
                                                <a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}">
                                                <a href="{{ route('about-us') }}">About Us</a>
                                            </li>
                                            <li class="@if (Request::path() == 'product-grids' || Request::path() == 'product-lists') active @endif">
                                                <a href="{{ route('product-grids') }}">Products</a>
                                            </li>
                                            <!-- {{ Helper::getHeaderCategory() }} -->
                                        </ul>
                                        <ul class="nav navbar-nav ml-auto">
                                            <li>
                                                <a href="{{ route('login.form') }}">Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Navbar -->
    <div class="header-inner d-block d-lg-none">
        <div class="container">
            <nav class="navbar navbar-light">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" class="logo"
                        alt="logo">
                </a>
                <button class="navbar-toggler text-white" type="button" data-toggle="collapse"
                    data-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mobileNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::path() == 'home' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item {{ Request::path() == 'about-us' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li
                            class="nav-item {{ Request::path() == 'product-grids' || Request::path() == 'product-lists' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('product-grids') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login.form') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>


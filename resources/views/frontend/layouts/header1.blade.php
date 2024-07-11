<style>
    .logo {
        height: 40px;
        /* Adjust the height as needed */
    }

    .custom-nav-link i {
        color: #fff;
    }

    .custom-nav-link:hover i {
        color: #F7941D;
    }

    .custom-nav-link.active i {
        color: #F7941D;
    }

    .header.sticky .custom-nav-link i {
        color: #333;
    }

    .header.sticky .custom-nav-link:hover i {
        color: #F7941D;
    }

    .header.sticky .custom-nav-link.active i {
        color: #F7941D;
    }
</style>
@php
    $settings = DB::table('settings')->get();
@endphp
<!-- Header -->
<header class="header shop">
    <!-- Desktop Navbar -->
    <div class="header-inner d-none d-lg-block">
        <div class="container-fluid">
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
                                            <li class="@if (Request::path() == 'product-grids' || Request::path() == 'product-lists') active @endif">
                                                <a href="{{ route('product-grids') }}">Products</a>
                                                <span class="new">New</span>
                                            </li>
                                            {{ Helper::getHeaderCategory() }}
                                            <li class="{{ Request::path() == 'about-us' ? 'active' : '' }}">
                                                <a href="{{ route('about-us') }}">About Us</a>
                                            </li>
                                        </ul>
                                        <div class="d-flex">
                                            <div class="right-bar mr-4" style="float: none">
                                                <!-- Search Form -->
                                                <div class="sinlge-bar shopping">
                                                    @php
                                                        $total_prod = 0;
                                                        $total_amount = 0;
                                                    @endphp
                                                    @if (session('wishlist'))
                                                        @foreach (session('wishlist') as $wishlist_items)
                                                            @php
                                                                $total_prod += $wishlist_items['quantity'];
                                                                $total_amount += $wishlist_items['amount'];
                                                            @endphp
                                                        @endforeach
                                                    @endif
                                                    <a href="{{ route('wishlist') }}"
                                                        class="single-icon custom-nav-link {{ Request::path() == 'wishlist' ? 'active' : '' }}"><i
                                                            class="fa fa-heart-o"></i> <span
                                                            class="total-count">{{ Helper::wishlistCount() }}</span></a>
                                                    <!-- Shopping Item -->
                                                    <div class="shopping-item">
                                                        <div class="dropdown-cart-header">
                                                            <span>{{ count(Helper::getAllProductFromWishlist()) }}
                                                                Items</span>
                                                            <a href="{{ route('wishlist') }}">View Wishlist</a>
                                                        </div>
                                                        <ul class="shopping-list">
                                                            {{-- {{Helper::getAllProductFromCart()}} --}}
                                                            @foreach (Helper::getAllProductFromWishlist() as $data)
                                                                @php
                                                                    $photo = explode(',', $data->product['photo']);
                                                                @endphp
                                                                <li>
                                                                    <a href="javascript:void(0);" class="remove"
                                                                        title="Remove this item"
                                                                        onclick="confirmDelete('{{ route('wishlist-delete', $data->id) }}');">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                    <a class="cart-img" href="#"><img
                                                                            src="{{ $photo[0] }}"
                                                                            alt="{{ $photo[0] }}"></a>
                                                                    <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                                            target="_blank">{{ $data->product['title'] }}</a>
                                                                    </h4>
                                                                    <p class="quantity">{{ $data->quantity }} x - <span
                                                                            class="amount">{{ Helper::rupiahFormatter($data->price, 2) }}</span>
                                                                    </p>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="bottom">
                                                            <div class="total">
                                                                <span>Total</span>
                                                                <span
                                                                    class="total-amount">{{ Helper::rupiahFormatter(Helper::totalWishlistPrice(), 2) }}</span>
                                                            </div>
                                                            <a href="{{ route('cart') }}" class="btn animate">Cart</a>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function confirmDelete(deleteUrl) {
                                                            Swal.fire({
                                                                title: 'Are you sure?',
                                                                text: "You won't be able to revert this!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#222',
                                                                cancelButtonColor: '#ea8e1e',
                                                                confirmButtonText: 'Yes, delete it!'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    window.location.href = deleteUrl;
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                    <!--/ End Shopping Item -->
                                                </div>

                                                <div class="sinlge-bar shopping">
                                                    <a href="{{ route('cart') }}"
                                                        class="single-icon custom-nav-link {{ Request::path() == 'cart' ? 'active' : '' }}"><i
                                                            class="ti-bag"></i> <span
                                                            class="total-count">{{ Helper::cartCount() }}</span></a>
                                                    <!-- Shopping Item -->
                                                    <div class="shopping-item">
                                                        <div class="dropdown-cart-header">
                                                            <span>{{ count(Helper::getAllProductFromCart()) }}
                                                                Items</span>
                                                            <a href="{{ route('cart') }}">View Cart</a>
                                                        </div>
                                                        <ul class="shopping-list">
                                                            @foreach (Helper::getAllProductFromCart() as $data)
                                                                @php
                                                                    $photo = explode(',', $data->product['photo']);
                                                                @endphp
                                                                <li>
                                                                    <a href="javascript:void(0);" class="remove"
                                                                        title="Remove this item"
                                                                        onclick="confirmDelete('{{ route('cart-delete', $data->id) }}');">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
                                                                    <a class="cart-img" href="#"><img
                                                                            src="{{ $photo[0] }}"
                                                                            alt="{{ $photo[0] }}"></a>
                                                                    <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                                            target="_blank">{{ $data->product['title'] }}</a>
                                                                    </h4>
                                                                    <p class="quantity">{{ $data->quantity }} x - <span
                                                                            class="amount">{{ Helper::rupiahFormatter($data->price, 2) }}</span>
                                                                    </p>
                                                            @endforeach
                                                        </ul>
                                                        <div class="bottom">
                                                            <div class="total">
                                                                <span>Total</span>
                                                                <span
                                                                    class="total-amount">{{ Helper::rupiahFormatter(Helper::totalCartPrice(), 2) }}</span>
                                                            </div>
                                                            <a href="{{ route('checkout') }}"
                                                                class="btn animate">Checkout</a>
                                                        </div>
                                                    </div>
                                                    <!--/ End Shopping Item -->
                                                </div>
                                            </div>
                                            <ul class="nav navbar-nav ml-auto">
                                                <li>
                                                    <a href="{{ route('order.track') }}">Track Order</a>
                                                </li>
                                                @if (Auth::user()->role == 'admin')
                                                    <li>
                                                        <a href="{{ route('admin') }}" target="_blank">Dashboard</a>
                                                    </li>
                                                @else
                                                    @if (Auth::check() && Auth::user()->role == 'agent')
                                                        <li>
                                                            <a href="{{ route('order.return') }}">Return Order</a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="{{ route('user') }}" target="_blank">Dashboard</a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="{{ route('user.logout') }}">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
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
                <div class="d-flex align-items-center">
                    <div class="sinlge-bar shopping mr-3">
                        @php
                            $total_prod = 0;
                            $total_amount = 0;
                        @endphp
                        @if (session('wishlist'))
                            @foreach (session('wishlist') as $wishlist_items)
                                @php
                                    $total_prod += $wishlist_items['quantity'];
                                    $total_amount += $wishlist_items['amount'];
                                @endphp
                            @endforeach
                        @endif
                        <a href="{{ route('wishlist') }}" class="text-white single-icon"><i
                                class="fa fa-heart-o"></i> <span
                                class="total-count">{{ Helper::wishlistCount() }}</span></a>
                        <!-- Shopping Item -->
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>{{ count(Helper::getAllProductFromWishlist()) }}
                                    Items</span>
                                <a href="{{ route('wishlist') }}">View Wishlist</a>
                            </div>
                            <ul class="shopping-list">
                                {{-- {{Helper::getAllProductFromCart()}} --}}
                                @foreach (Helper::getAllProductFromWishlist() as $data)
                                    @php
                                        $photo = explode(',', $data->product['photo']);
                                    @endphp
                                    <li>
                                        <a href="javascript:void(0);" class="remove" title="Remove this item"
                                            onclick="confirmDelete('{{ route('wishlist-delete', $data->id) }}');">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                        <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                alt="{{ $photo[0] }}"></a>
                                        <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                target="_blank">{{ $data->product['title'] }}</a>
                                        </h4>
                                        <p class="quantity">{{ $data->quantity }} x - <span
                                                class="amount">{{ Helper::rupiahFormatter($data->price, 2) }}</span>
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span
                                        class="total-amount">{{ Helper::rupiahFormatter(Helper::totalWishlistPrice(), 2) }}</span>
                                </div>
                                <a href="{{ route('cart') }}" class="btn animate">Cart</a>
                            </div>
                        </div>
                        <script>
                            function confirmDelete(deleteUrl) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#222',
                                    cancelButtonColor: '#ea8e1e',
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = deleteUrl;
                                    }
                                });
                            }
                        </script>
                        <!--/ End Shopping Item -->
                    </div>

                    <div class="sinlge-bar shopping mr-3">
                        <a href="{{ route('cart') }}" class="single-icon text-white"><i class="ti-bag"></i>
                            <span class="total-count">{{ Helper::cartCount() }}</span></a>
                        <!-- Shopping Item -->
                        <div class="shopping-item">
                            <div class="dropdown-cart-header">
                                <span>{{ count(Helper::getAllProductFromCart()) }}
                                    Items</span>
                                <a href="{{ route('cart') }}">View Cart</a>
                            </div>
                            <ul class="shopping-list">
                                @foreach (Helper::getAllProductFromCart() as $data)
                                    @php
                                        $photo = explode(',', $data->product['photo']);
                                    @endphp
                                    <li>
                                        <a href="javascript:void(0);" class="remove" title="Remove this item"
                                            onclick="confirmDelete('{{ route('cart-delete', $data->id) }}');">
                                            <i class="fa fa-remove"></i>
                                        </a>
                                        <a class="cart-img" href="#"><img src="{{ $photo[0] }}"
                                                alt="{{ $photo[0] }}"></a>
                                        <h4><a href="{{ route('product-detail', $data->product['slug']) }}"
                                                target="_blank">{{ $data->product['title'] }}</a>
                                        </h4>
                                        <p class="quantity">{{ $data->quantity }} x - <span
                                                class="amount">{{ Helper::rupiahFormatter($data->price, 2) }}</span>
                                        </p>
                                @endforeach
                            </ul>
                            <div class="bottom">
                                <div class="total">
                                    <span>Total</span>
                                    <span
                                        class="total-amount">{{ Helper::rupiahFormatter(Helper::totalCartPrice(), 2) }}</span>
                                </div>
                                <a href="{{ route('checkout') }}" class="btn animate">Checkout</a>
                            </div>
                        </div>
                        <!--/ End Shopping Item -->
                    </div>
                    <button class="navbar-toggler text-white" type="button" data-toggle="collapse"
                        data-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="mobileNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item {{ Request::path() == 'home' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                        </li>
                        <li
                            class="nav-item {{ Request::path() == 'product-grids' || Request::path() == 'product-lists' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('product-grids') }}">Products</a>
                        </li>
                        <li class="nav-item {{ Request::path() == 'about-us' ? 'active' : '' }}">
                            <a class="nav-link text-white" href="{{ route('about-us') }}">About Us</a>
                        </li>
                        <li>
                            <a class="nav-link text-white" href="{{ route('order.track') }}">Track Order</a>
                        </li>
                        @if (Auth::user()->role == 'admin')
                            <li>
                                <a class="nav-link text-white" href="{{ route('admin') }}"
                                    target="_blank">Dashboard</a>
                            </li>
                        @else
                            @if (Auth::check() && Auth::user()->role == 'agent')
                                <li>
                                    <a class="nav-link text-white" href="{{ route('order.return') }}">Return
                                        Order</a>
                                </li>
                            @endif

                            <li>
                                <a class="nav-link text-white" href="{{ route('user') }}"
                                    target="_blank">Dashboard</a>
                            </li>
                        @endif
                        <li>
                            <a class="nav-link text-white" href="{{ route('user.logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>


</header>

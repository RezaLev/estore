<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('frontend.layouts.head')
</head>

<body class="js">

    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    @include('frontend.layouts.notification')
    <!-- Header -->
    @auth
        @include('frontend.layouts.header1')
    @endauth
    @guest
        @include('frontend.layouts.guestheader')
    @endguest
    <!--/ End Header -->
    @yield('main-content')

    @include('frontend.layouts.footer')

</body>

</html>

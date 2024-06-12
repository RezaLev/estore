@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Make Your Checkout Here</h2>
                            <p>Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="first_name" placeholder=""
                                            value="{{ old('first_name') }}" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{ old('lat_name') }}">
                                        @error('last_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Email Address<span>*</span></label>
                                        <input type="email" name="email" placeholder="" value="{{ old('email') }}">
                                        @error('email')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" required
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Country<span>*</span></label>
                                        <select name="country" id="country">
                                            <option value="ID" selected>Indonesia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 1<span>*</span></label>
                                        <input type="text" name="address1" placeholder="" value="{{ old('address1') }}">
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address2" placeholder="" value="{{ old('address2') }}">
                                        @error('address2')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input class="form-control" name="post_code" id="post_code" type="text">
                                        <div class="position-absolute invisible" style="z-index: 1000"
                                            id="post_code_complete"></div>
                                        {{-- <input type="text" name="post_code" id="post_code" onchange="checkPostCode()"> --}}
                                        <button type="button" class="btn w-100 mt-2"
                                            onclick="checkPostCode()">Check</button>
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>CART TOTALS</h2>
                                <div class="content">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Cart
                                            Subtotal<span>{{ Helper::rupiahFormatter(Helper::totalCartPrice(), 2) }}</span>
                                        </li>
                                        <li class="shipping">
                                            Shipping Cost
                                            @if (Helper::cartCount() > 0)
                                                <select name="shipping" class="nice-select">
                                                    <option value="">Select your address</option>
                                                </select>
                                            @else
                                                <span>Free</span>
                                            @endif
                                        </li>

                                        @if (session('coupon'))
                                            <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You
                                                Save<span>{{ Helper::rupiahFormatter(session('coupon')['value'], 2) }}</span>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session('coupon')) {
                                                $total_amount = $total_amount - session('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session('coupon'))
                                            <li class="last" id="order_total_price">
                                                Total<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget d-none">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                        <form-group>
                                            <input name="payment_method" type="radio" value="cod"> <label> Cash On
                                                Delivery</label><br>
                                        </form-group>

                                    </div>
                                </div>
                            </div>
                            <!--/ End Order Widget -->

                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn">proceed to checkout</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shipping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->
@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        function showMe(box) {
            var checkbox = document.getElementById('shipping').style.display;
            // alert(checkbox);
            var vis = 'none';
            if (checkbox == "none") {
                vis = 'block';
            }
            if (checkbox == "block") {
                vis = "none";
            }
            document.getElementById(box).style.display = vis;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(subtotal + cost - coupon));
            });



            checkPostCode = () => {
                let code = $('#post_code').val()
                if (typeof postCodeMap[code] != 'undefined') requestPostCode(code[0]);
            }

            requestPostCode = (code) => {

                $('.preloader').fadeIn('slow');

                $.ajax({
                    url: "{{ route('order.getCourier') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: code
                    },
                    success: function(response) {
                        $('[name="shipping"]').html('<option value="">Select your address</option>')
                        if (response.success) {
                            response.data.map((data) => {
                                $('[name="shipping"]').append(
                                    `<option value="${data.id}" class="shippingOption" data-price="${data.cost}">${data.name}</option>`
                                )
                            })
                        }

                        $('[name="shipping"]').next('.nice-select').remove();
                        $('[name="shipping"]').niceSelect();
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.error(xhr.responseText);
                    }
                });
                $('.preloader').delay(2000).fadeOut('slow');
            }

            const postCodeMap = {
                "23681 - Kabupaten Aceh Barat": 1,
                "24454 - Kabupaten Aceh Timur": 10,
                "97351 - Kabupaten Buru Selatan": 100,
                "93754 - Kabupaten Buton": 101,
                "93745 - Kabupaten Buton Utara": 102,
                "46211 - Kabupaten Ciamis": 103,
                "43217 - Kabupaten Cianjur": 104,
                "53211 - Kabupaten Cilacap": 105,
                "42417 - Kota Cilegon": 106,
                "40512 - Kota Cimahi": 107,
                "45611 - Kabupaten Cirebon": 108,
                "45116 - Kota Cirebon": 109,
                "24382 - Kabupaten Aceh Utara": 11,
                "22211 - Kabupaten Dairi": 110,
                "98784 - Kabupaten Deiyai (Deliyai)": 111,
                "20511 - Kabupaten Deli Serdang": 112,
                "59519 - Kabupaten Demak": 113,
                "80227 - Kota Denpasar": 114,
                "16416 - Kota Depok": 115,
                "27612 - Kabupaten Dharmasraya": 116,
                "98866 - Kabupaten Dogiyai": 117,
                "84217 - Kabupaten Dompu": 118,
                "94341 - Kabupaten Donggala": 119,
                "26411 - Kabupaten Agam": 12,
                "28811 - Kota Dumai": 120,
                "31811 - Kabupaten Empat Lawang": 121,
                "86351 - Kabupaten Ende": 122,
                "91719 - Kabupaten Enrekang": 123,
                "98651 - Kabupaten Fakfak": 124,
                "86213 - Kabupaten Flores Timur": 125,
                "44126 - Kabupaten Garut": 126,
                "24653 - Kabupaten Gayo Lues": 127,
                "80519 - Kabupaten Gianyar": 128,
                "96218 - Kabupaten Gorontalo": 129,
                "85811 - Kabupaten Alor": 13,
                "96115 - Kota Gorontalo": 130,
                "96611 - Kabupaten Gorontalo Utara": 131,
                "92111 - Kabupaten Gowa": 132,
                "61115 - Kabupaten Gresik": 133,
                "58111 - Kabupaten Grobogan": 134,
                "55812 - Kabupaten Gunung Kidul": 135,
                "74511 - Kabupaten Gunung Mas": 136,
                "22813 - Kota Gunungsitoli": 137,
                "97757 - Kabupaten Halmahera Barat": 138,
                "97911 - Kabupaten Halmahera Selatan": 139,
                "97222 - Kota Ambon": 14,
                "97853 - Kabupaten Halmahera Tengah": 140,
                "97862 - Kabupaten Halmahera Timur": 141,
                "97762 - Kabupaten Halmahera Utara": 142,
                "71212 - Kabupaten Hulu Sungai Selatan": 143,
                "71313 - Kabupaten Hulu Sungai Tengah": 144,
                "71419 - Kabupaten Hulu Sungai Utara": 145,
                "22457 - Kabupaten Humbang Hasundutan": 146,
                "29212 - Kabupaten Indragiri Hilir": 147,
                "29319 - Kabupaten Indragiri Hulu": 148,
                "45214 - Kabupaten Indramayu": 149,
                "21214 - Kabupaten Asahan": 15,
                "98771 - Kabupaten Intan Jaya": 150,
                "11220 - Kota Jakarta Barat": 151,
                "10540 - Kota Jakarta Pusat": 152,
                "12230 - Kota Jakarta Selatan": 153,
                "13330 - Kota Jakarta Timur": 154,
                "14140 - Kota Jakarta Utara": 155,
                "36111 - Kota Jambi": 156,
                "99352 - Kabupaten Jayapura": 157,
                "99114 - Kota Jayapura": 158,
                "99511 - Kabupaten Jayawijaya": 159,
                "99777 - Kabupaten Asmat": 16,
                "68113 - Kabupaten Jember": 160,
                "82251 - Kabupaten Jembrana": 161,
                "92319 - Kabupaten Jeneponto": 162,
                "59419 - Kabupaten Jepara": 163,
                "61415 - Kabupaten Jombang": 164,
                "98671 - Kabupaten Kaimana": 165,
                "28411 - Kabupaten Kampar": 166,
                "73583 - Kabupaten Kapuas": 167,
                "78719 - Kabupaten Kapuas Hulu": 168,
                "57718 - Kabupaten Karanganyar": 169,
                "80351 - Kabupaten Badung": 17,
                "80819 - Kabupaten Karangasem": 170,
                "41311 - Kabupaten Karawang": 171,
                "29611 - Kabupaten Karimun": 172,
                "22119 - Kabupaten Karo": 173,
                "74411 - Kabupaten Katingan": 174,
                "38911 - Kabupaten Kaur": 175,
                "78852 - Kabupaten Kayong Utara": 176,
                "54319 - Kabupaten Kebumen": 177,
                "64184 - Kabupaten Kediri": 178,
                "64125 - Kota Kediri": 179,
                "71611 - Kabupaten Balangan": 18,
                "99461 - Kabupaten Keerom": 180,
                "51314 - Kabupaten Kendal": 181,
                "93126 - Kota Kendari": 182,
                "39319 - Kabupaten Kepahiang": 183,
                "29991 - Kabupaten Kepulauan Anambas": 184,
                "97681 - Kabupaten Kepulauan Aru": 185,
                "25771 - Kabupaten Kepulauan Mentawai": 186,
                "28791 - Kabupaten Kepulauan Meranti": 187,
                "95819 - Kabupaten Kepulauan Sangihe": 188,
                "14550 - Kabupaten Kepulauan Seribu": 189,
                "76111 - Kota Balikpapan": 19,
                "95862 - Kabupaten Kepulauan Siau Tagulandang Biaro (Sitaro)": 190,
                "97995 - Kabupaten Kepulauan Sula": 191,
                "95885 - Kabupaten Kepulauan Talaud": 192,
                "98211 - Kabupaten Kepulauan Yapen (Yapen Waropen)": 193,
                "37167 - Kabupaten Kerinci": 194,
                "78874 - Kabupaten Ketapang": 195,
                "57411 - Kabupaten Klaten": 196,
                "80719 - Kabupaten Klungkung": 197,
                "93511 - Kabupaten Kolaka": 198,
                "93911 - Kabupaten Kolaka Utara": 199,
                "23764 - Kabupaten Aceh Barat Daya": 2,
                "23238 - Kota Banda Aceh": 20,
                "93411 - Kabupaten Konawe": 200,
                "93811 - Kabupaten Konawe Selatan": 201,
                "93311 - Kabupaten Konawe Utara": 202,
                "72119 - Kabupaten Kotabaru": 203,
                "95711 - Kota Kotamobagu": 204,
                "74119 - Kabupaten Kotawaringin Barat": 205,
                "74364 - Kabupaten Kotawaringin Timur": 206,
                "29519 - Kabupaten Kuantan Singingi": 207,
                "78311 - Kabupaten Kubu Raya": 208,
                "59311 - Kabupaten Kudus": 209,
                "35139 - Kota Bandar Lampung": 21,
                "55611 - Kabupaten Kulon Progo": 210,
                "45511 - Kabupaten Kuningan": 211,
                "85362 - Kabupaten Kupang": 212,
                "85119 - Kota Kupang": 213,
                "75711 - Kabupaten Kutai Barat": 214,
                "75511 - Kabupaten Kutai Kartanegara": 215,
                "75611 - Kabupaten Kutai Timur": 216,
                "21412 - Kabupaten Labuhan Batu": 217,
                "21511 - Kabupaten Labuhan Batu Selatan": 218,
                "21711 - Kabupaten Labuhan Batu Utara": 219,
                "40311 - Kabupaten Bandung": 22,
                "31419 - Kabupaten Lahat": 220,
                "74611 - Kabupaten Lamandau": 221,
                "62218 - Kabupaten Lamongan": 222,
                "34814 - Kabupaten Lampung Barat": 223,
                "35511 - Kabupaten Lampung Selatan": 224,
                "34212 - Kabupaten Lampung Tengah": 225,
                "34319 - Kabupaten Lampung Timur": 226,
                "34516 - Kabupaten Lampung Utara": 227,
                "78319 - Kabupaten Landak": 228,
                "20811 - Kabupaten Langkat": 229,
                "40111 - Kota Bandung": 23,
                "24412 - Kota Langsa": 230,
                "99531 - Kabupaten Lanny Jaya": 231,
                "42319 - Kabupaten Lebak": 232,
                "39264 - Kabupaten Lebong": 233,
                "86611 - Kabupaten Lembata": 234,
                "24352 - Kota Lhokseumawe": 235,
                "26671 - Kabupaten Lima Puluh Koto/Kota": 236,
                "29811 - Kabupaten Lingga": 237,
                "83311 - Kabupaten Lombok Barat": 238,
                "83511 - Kabupaten Lombok Tengah": 239,
                "40721 - Kabupaten Bandung Barat": 24,
                "83612 - Kabupaten Lombok Timur": 240,
                "83711 - Kabupaten Lombok Utara": 241,
                "31614 - Kota Lubuk Linggau": 242,
                "67319 - Kabupaten Lumajang": 243,
                "91994 - Kabupaten Luwu": 244,
                "92981 - Kabupaten Luwu Timur": 245,
                "92911 - Kabupaten Luwu Utara": 246,
                "63153 - Kabupaten Madiun": 247,
                "63122 - Kota Madiun": 248,
                "56519 - Kabupaten Magelang": 249,
                "94711 - Kabupaten Banggai": 25,
                "56133 - Kota Magelang": 250,
                "63314 - Kabupaten Magetan": 251,
                "45412 - Kabupaten Majalengka": 252,
                "91411 - Kabupaten Majene": 253,
                "90111 - Kota Makassar": 254,
                "65163 - Kabupaten Malang": 255,
                "65112 - Kota Malang": 256,
                "77511 - Kabupaten Malinau": 257,
                "97451 - Kabupaten Maluku Barat Daya": 258,
                "97513 - Kabupaten Maluku Tengah": 259,
                "94881 - Kabupaten Banggai Kepulauan": 26,
                "97651 - Kabupaten Maluku Tenggara": 260,
                "97465 - Kabupaten Maluku Tenggara Barat": 261,
                "91362 - Kabupaten Mamasa": 262,
                "99381 - Kabupaten Mamberamo Raya": 263,
                "99553 - Kabupaten Mamberamo Tengah": 264,
                "91519 - Kabupaten Mamuju": 265,
                "91571 - Kabupaten Mamuju Utara": 266,
                "95247 - Kota Manado": 267,
                "22916 - Kabupaten Mandailing Natal": 268,
                "86551 - Kabupaten Manggarai": 269,
                "33212 - Kabupaten Bangka": 27,
                "86711 - Kabupaten Manggarai Barat": 270,
                "86811 - Kabupaten Manggarai Timur": 271,
                "98311 - Kabupaten Manokwari": 272,
                "98355 - Kabupaten Manokwari Selatan": 273,
                "99853 - Kabupaten Mappi": 274,
                "90511 - Kabupaten Maros": 275,
                "83131 - Kota Mataram": 276,
                "98051 - Kabupaten Maybrat": 277,
                "20228 - Kota Medan": 278,
                "79672 - Kabupaten Melawi": 279,
                "33315 - Kabupaten Bangka Barat": 28,
                "37319 - Kabupaten Merangin": 280,
                "99613 - Kabupaten Merauke": 281,
                "34911 - Kabupaten Mesuji": 282,
                "34111 - Kota Metro": 283,
                "99962 - Kabupaten Mimika": 284,
                "95614 - Kabupaten Minahasa": 285,
                "95914 - Kabupaten Minahasa Selatan": 286,
                "95995 - Kabupaten Minahasa Tenggara": 287,
                "95316 - Kabupaten Minahasa Utara": 288,
                "61382 - Kabupaten Mojokerto": 289,
                "33719 - Kabupaten Bangka Selatan": 29,
                "61316 - Kota Mojokerto": 290,
                "94911 - Kabupaten Morowali": 291,
                "31315 - Kabupaten Muara Enim": 292,
                "36311 - Kabupaten Muaro Jambi": 293,
                "38715 - Kabupaten Muko Muko": 294,
                "93611 - Kabupaten Muna": 295,
                "73911 - Kabupaten Murung Raya": 296,
                "30719 - Kabupaten Musi Banyuasin": 297,
                "31661 - Kabupaten Musi Rawas": 298,
                "98816 - Kabupaten Nabire": 299,
                "23951 - Kabupaten Aceh Besar": 3,
                "33613 - Kabupaten Bangka Tengah": 30,
                "23674 - Kabupaten Nagan Raya": 300,
                "86911 - Kabupaten Nagekeo": 301,
                "29711 - Kabupaten Natuna": 302,
                "99541 - Kabupaten Nduga": 303,
                "86413 - Kabupaten Ngada": 304,
                "64414 - Kabupaten Nganjuk": 305,
                "63219 - Kabupaten Ngawi": 306,
                "22876 - Kabupaten Nias": 307,
                "22895 - Kabupaten Nias Barat": 308,
                "22865 - Kabupaten Nias Selatan": 309,
                "69118 - Kabupaten Bangkalan": 31,
                "22856 - Kabupaten Nias Utara": 310,
                "77421 - Kabupaten Nunukan": 311,
                "30811 - Kabupaten Ogan Ilir": 312,
                "30618 - Kabupaten Ogan Komering Ilir": 313,
                "32112 - Kabupaten Ogan Komering Ulu": 314,
                "32211 - Kabupaten Ogan Komering Ulu Selatan": 315,
                "32312 - Kabupaten Ogan Komering Ulu Timur": 316,
                "63512 - Kabupaten Pacitan": 317,
                "25112 - Kota Padang": 318,
                "22763 - Kabupaten Padang Lawas": 319,
                "80619 - Kabupaten Bangli": 32,
                "22753 - Kabupaten Padang Lawas Utara": 320,
                "27122 - Kota Padang Panjang": 321,
                "25583 - Kabupaten Padang Pariaman": 322,
                "22727 - Kota Padang Sidempuan": 323,
                "31512 - Kota Pagar Alam": 324,
                "22272 - Kabupaten Pakpak Bharat": 325,
                "73112 - Kota Palangka Raya": 326,
                "30111 - Kota Palembang": 327,
                "91911 - Kota Palopo": 328,
                "94111 - Kota Palu": 329,
                "70619 - Kabupaten Banjar": 33,
                "69319 - Kabupaten Pamekasan": 330,
                "42212 - Kabupaten Pandeglang": 331,
                "46511 - Kabupaten Pangandaran": 332,
                "90611 - Kabupaten Pangkajene Kepulauan": 333,
                "33115 - Kota Pangkal Pinang": 334,
                "98765 - Kabupaten Paniai": 335,
                "91123 - Kota Parepare": 336,
                "25511 - Kota Pariaman": 337,
                "94411 - Kabupaten Parigi Moutong": 338,
                "26318 - Kabupaten Pasaman": 339,
                "46311 - Kota Banjar": 34,
                "26511 - Kabupaten Pasaman Barat": 340,
                "76211 - Kabupaten Paser": 341,
                "67153 - Kabupaten Pasuruan": 342,
                "67118 - Kota Pasuruan": 343,
                "59114 - Kabupaten Pati": 344,
                "26213 - Kota Payakumbuh": 345,
                "98354 - Kabupaten Pegunungan Arfak": 346,
                "99573 - Kabupaten Pegunungan Bintang": 347,
                "51161 - Kabupaten Pekalongan": 348,
                "51122 - Kota Pekalongan": 349,
                "70712 - Kota Banjarbaru": 35,
                "28112 - Kota Pekanbaru": 350,
                "28311 - Kabupaten Pelalawan": 351,
                "52319 - Kabupaten Pemalang": 352,
                "21126 - Kota Pematang Siantar": 353,
                "76311 - Kabupaten Penajam Paser Utara": 354,
                "35312 - Kabupaten Pesawaran": 355,
                "35974 - Kabupaten Pesisir Barat": 356,
                "25611 - Kabupaten Pesisir Selatan": 357,
                "24116 - Kabupaten Pidie": 358,
                "24186 - Kabupaten Pidie Jaya": 359,
                "70117 - Kota Banjarmasin": 36,
                "91251 - Kabupaten Pinrang": 360,
                "96419 - Kabupaten Pohuwato": 361,
                "91311 - Kabupaten Polewali Mandar": 362,
                "63411 - Kabupaten Ponorogo": 363,
                "78971 - Kabupaten Pontianak": 364,
                "78112 - Kota Pontianak": 365,
                "94615 - Kabupaten Poso": 366,
                "31121 - Kota Prabumulih": 367,
                "35719 - Kabupaten Pringsewu": 368,
                "67282 - Kabupaten Probolinggo": 369,
                "53419 - Kabupaten Banjarnegara": 37,
                "67215 - Kota Probolinggo": 370,
                "74811 - Kabupaten Pulang Pisau": 371,
                "97771 - Kabupaten Pulau Morotai": 372,
                "98981 - Kabupaten Puncak": 373,
                "98979 - Kabupaten Puncak Jaya": 374,
                "53312 - Kabupaten Purbalingga": 375,
                "41119 - Kabupaten Purwakarta": 376,
                "54111 - Kabupaten Purworejo": 377,
                "98489 - Kabupaten Raja Ampat": 378,
                "39112 - Kabupaten Rejang Lebong": 379,
                "92411 - Kabupaten Bantaeng": 38,
                "59219 - Kabupaten Rembang": 380,
                "28992 - Kabupaten Rokan Hilir": 381,
                "28511 - Kabupaten Rokan Hulu": 382,
                "85982 - Kabupaten Rote Ndao": 383,
                "23512 - Kota Sabang": 384,
                "85391 - Kabupaten Sabu Raijua": 385,
                "50711 - Kota Salatiga": 386,
                "75133 - Kota Samarinda": 387,
                "79453 - Kabupaten Sambas": 388,
                "22392 - Kabupaten Samosir": 389,
                "55715 - Kabupaten Bantul": 39,
                "69219 - Kabupaten Sampang": 390,
                "78557 - Kabupaten Sanggau": 391,
                "99373 - Kabupaten Sarmi": 392,
                "37419 - Kabupaten Sarolangun": 393,
                "27416 - Kota Sawah Lunto": 394,
                "79583 - Kabupaten Sekadau": 395,
                "92812 - Kabupaten Selayar (Kepulauan Selayar)": 396,
                "38811 - Kabupaten Seluma": 397,
                "50511 - Kabupaten Semarang": 398,
                "50135 - Kota Semarang": 399,
                "23654 - Kabupaten Aceh Jaya": 4,
                "30911 - Kabupaten Banyuasin": 40,
                "97561 - Kabupaten Seram Bagian Barat": 400,
                "97581 - Kabupaten Seram Bagian Timur": 401,
                "42182 - Kabupaten Serang": 402,
                "42111 - Kota Serang": 403,
                "20915 - Kabupaten Serdang Bedagai": 404,
                "74211 - Kabupaten Seruyan": 405,
                "28623 - Kabupaten Siak": 406,
                "22522 - Kota Sibolga": 407,
                "91613 - Kabupaten Sidenreng Rappang/Rapang": 408,
                "61219 - Kabupaten Sidoarjo": 409,
                "53114 - Kabupaten Banyumas": 41,
                "94364 - Kabupaten Sigi": 410,
                "27511 - Kabupaten Sijunjung (Sawah Lunto Sijunjung)": 411,
                "86121 - Kabupaten Sikka": 412,
                "21162 - Kabupaten Simalungun": 413,
                "23891 - Kabupaten Simeulue": 414,
                "79117 - Kota Singkawang": 415,
                "92615 - Kabupaten Sinjai": 416,
                "78619 - Kabupaten Sintang": 417,
                "68316 - Kabupaten Situbondo": 418,
                "55513 - Kabupaten Sleman": 419,
                "68416 - Kabupaten Banyuwangi": 42,
                "27365 - Kabupaten Solok": 420,
                "27315 - Kota Solok": 421,
                "27779 - Kabupaten Solok Selatan": 422,
                "90812 - Kabupaten Soppeng": 423,
                "98431 - Kabupaten Sorong": 424,
                "98411 - Kota Sorong": 425,
                "98454 - Kabupaten Sorong Selatan": 426,
                "57211 - Kabupaten Sragen": 427,
                "41215 - Kabupaten Subang": 428,
                "24882 - Kota Subulussalam": 429,
                "70511 - Kabupaten Barito Kuala": 43,
                "43311 - Kabupaten Sukabumi": 430,
                "43114 - Kota Sukabumi": 431,
                "74712 - Kabupaten Sukamara": 432,
                "57514 - Kabupaten Sukoharjo": 433,
                "87219 - Kabupaten Sumba Barat": 434,
                "87453 - Kabupaten Sumba Barat Daya": 435,
                "87358 - Kabupaten Sumba Tengah": 436,
                "87112 - Kabupaten Sumba Timur": 437,
                "84315 - Kabupaten Sumbawa": 438,
                "84419 - Kabupaten Sumbawa Barat": 439,
                "73711 - Kabupaten Barito Selatan": 44,
                "45326 - Kabupaten Sumedang": 440,
                "69413 - Kabupaten Sumenep": 441,
                "37113 - Kota Sungaipenuh": 442,
                "98164 - Kabupaten Supiori": 443,
                "60119 - Kota Surabaya": 444,
                "57113 - Kota Surakarta (Solo)": 445,
                "71513 - Kabupaten Tabalong": 446,
                "82119 - Kabupaten Tabanan": 447,
                "92212 - Kabupaten Takalar": 448,
                "98475 - Kabupaten Tambrauw": 449,
                "73671 - Kabupaten Barito Timur": 45,
                "77611 - Kabupaten Tana Tidung": 450,
                "91819 - Kabupaten Tana Toraja": 451,
                "72211 - Kabupaten Tanah Bumbu": 452,
                "27211 - Kabupaten Tanah Datar": 453,
                "70811 - Kabupaten Tanah Laut": 454,
                "15914 - Kabupaten Tangerang": 455,
                "15111 - Kota Tangerang": 456,
                "15435 - Kota Tangerang Selatan": 457,
                "35619 - Kabupaten Tanggamus": 458,
                "21321 - Kota Tanjung Balai": 459,
                "73881 - Kabupaten Barito Utara": 46,
                "36513 - Kabupaten Tanjung Jabung Barat": 460,
                "36719 - Kabupaten Tanjung Jabung Timur": 461,
                "29111 - Kota Tanjung Pinang": 462,
                "22742 - Kabupaten Tapanuli Selatan": 463,
                "22611 - Kabupaten Tapanuli Tengah": 464,
                "22414 - Kabupaten Tapanuli Utara": 465,
                "71119 - Kabupaten Tapin": 466,
                "77114 - Kota Tarakan": 467,
                "46411 - Kabupaten Tasikmalaya": 468,
                "46116 - Kota Tasikmalaya": 469,
                "90719 - Kabupaten Barru": 47,
                "20632 - Kota Tebing Tinggi": 470,
                "37519 - Kabupaten Tebo": 471,
                "52419 - Kabupaten Tegal": 472,
                "52114 - Kota Tegal": 473,
                "98551 - Kabupaten Teluk Bintuni": 474,
                "98591 - Kabupaten Teluk Wondama": 475,
                "56212 - Kabupaten Temanggung": 476,
                "97714 - Kota Ternate": 477,
                "97815 - Kota Tidore Kepulauan": 478,
                "85562 - Kabupaten Timor Tengah Selatan": 479,
                "29413 - Kota Batam": 48,
                "85612 - Kabupaten Timor Tengah Utara": 480,
                "22316 - Kabupaten Toba Samosir": 481,
                "94683 - Kabupaten Tojo Una-Una": 482,
                "94542 - Kabupaten Toli-Toli": 483,
                "99411 - Kabupaten Tolikara": 484,
                "95416 - Kota Tomohon": 485,
                "91831 - Kabupaten Toraja Utara": 486,
                "66312 - Kabupaten Trenggalek": 487,
                "97612 - Kota Tual": 488,
                "62319 - Kabupaten Tuban": 489,
                "51211 - Kabupaten Batang": 49,
                "34613 - Kabupaten Tulang Bawang": 490,
                "34419 - Kabupaten Tulang Bawang Barat": 491,
                "66212 - Kabupaten Tulungagung": 492,
                "90911 - Kabupaten Wajo": 493,
                "93791 - Kabupaten Wakatobi": 494,
                "98269 - Kabupaten Waropen": 495,
                "34711 - Kabupaten Way Kanan": 496,
                "57619 - Kabupaten Wonogiri": 497,
                "56311 - Kabupaten Wonosobo": 498,
                "99041 - Kabupaten Yahukimo": 499,
                "23719 - Kabupaten Aceh Selatan": 5,
                "36613 - Kabupaten Batang Hari": 50,
                "99481 - Kabupaten Yalimo": 500,
                "55111 - Kota Yogyakarta": 501,
                "65311 - Kota Batu": 51,
                "21655 - Kabupaten Batu Bara": 52,
                "93719 - Kota Bau-Bau": 53,
                "17837 - Kabupaten Bekasi": 54,
                "17121 - Kota Bekasi": 55,
                "33419 - Kabupaten Belitung": 56,
                "33519 - Kabupaten Belitung Timur": 57,
                "85711 - Kabupaten Belu": 58,
                "24581 - Kabupaten Bener Meriah": 59,
                "24785 - Kabupaten Aceh Singkil": 6,
                "28719 - Kabupaten Bengkalis": 60,
                "79213 - Kabupaten Bengkayang": 61,
                "38229 - Kota Bengkulu": 62,
                "38519 - Kabupaten Bengkulu Selatan": 63,
                "38319 - Kabupaten Bengkulu Tengah": 64,
                "38619 - Kabupaten Bengkulu Utara": 65,
                "77311 - Kabupaten Berau": 66,
                "98119 - Kabupaten Biak Numfor": 67,
                "84171 - Kabupaten Bima": 68,
                "84139 - Kota Bima": 69,
                "24476 - Kabupaten Aceh Tamiang": 7,
                "20712 - Kota Binjai": 70,
                "29135 - Kabupaten Bintan": 71,
                "24219 - Kabupaten Bireuen": 72,
                "95512 - Kota Bitung": 73,
                "66171 - Kabupaten Blitar": 74,
                "66124 - Kota Blitar": 75,
                "58219 - Kabupaten Blora": 76,
                "96319 - Kabupaten Boalemo": 77,
                "16911 - Kabupaten Bogor": 78,
                "16119 - Kota Bogor": 79,
                "24511 - Kabupaten Aceh Tengah": 8,
                "62119 - Kabupaten Bojonegoro": 80,
                "95755 - Kabupaten Bolaang Mongondow (Bolmong)": 81,
                "95774 - Kabupaten Bolaang Mongondow Selatan": 82,
                "95783 - Kabupaten Bolaang Mongondow Timur": 83,
                "95765 - Kabupaten Bolaang Mongondow Utara": 84,
                "93771 - Kabupaten Bombana": 85,
                "68219 - Kabupaten Bondowoso": 86,
                "92713 - Kabupaten Bone": 87,
                "96511 - Kabupaten Bone Bolango": 88,
                "75313 - Kota Bontang": 89,
                "24611 - Kabupaten Aceh Tenggara": 9,
                "99662 - Kabupaten Boven Digoel": 90,
                "57312 - Kabupaten Boyolali": 91,
                "52212 - Kabupaten Brebes": 92,
                "26115 - Kota Bukittinggi": 93,
                "81111 - Kabupaten Buleleng": 94,
                "92511 - Kabupaten Bulukumba": 95,
                "77211 - Kabupaten Bulungan (Bulongan)": 96,
                "37216 - Kabupaten Bungo": 97,
                "94564 - Kabupaten Buol": 98,
                "97371 - Kabupaten Bur": 99,
            }

            const autocomplete_example2 = [
                "23681 - Kabupaten Aceh Barat",
                "24454 - Kabupaten Aceh Timur",
                "97351 - Kabupaten Buru Selatan",
                "93754 - Kabupaten Buton",
                "93745 - Kabupaten Buton Utara",
                "46211 - Kabupaten Ciamis",
                "43217 - Kabupaten Cianjur",
                "53211 - Kabupaten Cilacap",
                "42417 - Kota Cilegon",
                "40512 - Kota Cimahi",
                "45611 - Kabupaten Cirebon",
                "45116 - Kota Cirebon",
                "24382 - Kabupaten Aceh Utara",
                "22211 - Kabupaten Dairi",
                "98784 - Kabupaten Deiyai (Deliyai)",
                "20511 - Kabupaten Deli Serdang",
                "59519 - Kabupaten Demak",
                "80227 - Kota Denpasar",
                "16416 - Kota Depok",
                "27612 - Kabupaten Dharmasraya",
                "98866 - Kabupaten Dogiyai",
                "84217 - Kabupaten Dompu",
                "94341 - Kabupaten Donggala",
                "26411 - Kabupaten Agam",
                "28811 - Kota Dumai",
                "31811 - Kabupaten Empat Lawang",
                "86351 - Kabupaten Ende",
                "91719 - Kabupaten Enrekang",
                "98651 - Kabupaten Fakfak",
                "86213 - Kabupaten Flores Timur",
                "44126 - Kabupaten Garut",
                "24653 - Kabupaten Gayo Lues",
                "80519 - Kabupaten Gianyar",
                "96218 - Kabupaten Gorontalo",
                "85811 - Kabupaten Alor",
                "96115 - Kota Gorontalo",
                "96611 - Kabupaten Gorontalo Utara",
                "92111 - Kabupaten Gowa",
                "61115 - Kabupaten Gresik",
                "58111 - Kabupaten Grobogan",
                "55812 - Kabupaten Gunung Kidul",
                "74511 - Kabupaten Gunung Mas",
                "22813 - Kota Gunungsitoli",
                "97757 - Kabupaten Halmahera Barat",
                "97911 - Kabupaten Halmahera Selatan",
                "97222 - Kota Ambon",
                "97853 - Kabupaten Halmahera Tengah",
                "97862 - Kabupaten Halmahera Timur",
                "97762 - Kabupaten Halmahera Utara",
                "71212 - Kabupaten Hulu Sungai Selatan",
                "71313 - Kabupaten Hulu Sungai Tengah",
                "71419 - Kabupaten Hulu Sungai Utara",
                "22457 - Kabupaten Humbang Hasundutan",
                "29212 - Kabupaten Indragiri Hilir",
                "29319 - Kabupaten Indragiri Hulu",
                "45214 - Kabupaten Indramayu",
                "21214 - Kabupaten Asahan",
                "98771 - Kabupaten Intan Jaya",
                "11220 - Kota Jakarta Barat",
                "10540 - Kota Jakarta Pusat",
                "12230 - Kota Jakarta Selatan",
                "13330 - Kota Jakarta Timur",
                "14140 - Kota Jakarta Utara",
                "36111 - Kota Jambi",
                "99352 - Kabupaten Jayapura",
                "99114 - Kota Jayapura",
                "99511 - Kabupaten Jayawijaya",
                "99777 - Kabupaten Asmat",
                "68113 - Kabupaten Jember",
                "82251 - Kabupaten Jembrana",
                "92319 - Kabupaten Jeneponto",
                "59419 - Kabupaten Jepara",
                "61415 - Kabupaten Jombang",
                "98671 - Kabupaten Kaimana",
                "28411 - Kabupaten Kampar",
                "73583 - Kabupaten Kapuas",
                "78719 - Kabupaten Kapuas Hulu",
                "57718 - Kabupaten Karanganyar",
                "80351 - Kabupaten Badung",
                "80819 - Kabupaten Karangasem",
                "41311 - Kabupaten Karawang",
                "29611 - Kabupaten Karimun",
                "22119 - Kabupaten Karo",
                "74411 - Kabupaten Katingan",
                "38911 - Kabupaten Kaur",
                "78852 - Kabupaten Kayong Utara",
                "54319 - Kabupaten Kebumen",
                "64184 - Kabupaten Kediri",
                "64125 - Kota Kediri",
                "71611 - Kabupaten Balangan",
                "99461 - Kabupaten Keerom",
                "51314 - Kabupaten Kendal",
                "93126 - Kota Kendari",
                "39319 - Kabupaten Kepahiang",
                "29991 - Kabupaten Kepulauan Anambas",
                "97681 - Kabupaten Kepulauan Aru",
                "25771 - Kabupaten Kepulauan Mentawai",
                "28791 - Kabupaten Kepulauan Meranti",
                "95819 - Kabupaten Kepulauan Sangihe",
                "14550 - Kabupaten Kepulauan Seribu",
                "76111 - Kota Balikpapan",
                "95862 - Kabupaten Kepulauan Siau Tagulandan",
                "97995 - Kabupaten Kepulauan Sula",
                "95885 - Kabupaten Kepulauan Talaud",
                "98211 - Kabupaten Kepulauan Yapen (Yape",
                "37167 - Kabupaten Kerinci",
                "78874 - Kabupaten Ketapang",
                "57411 - Kabupaten Klaten",
                "80719 - Kabupaten Klungkung",
                "93511 - Kabupaten Kolaka",
                "93911 - Kabupaten Kolaka Utara",
                "23764 - Kabupaten Aceh Barat Daya",
                "23238 - Kota Banda Aceh",
                "93411 - Kabupaten Konawe",
                "93811 - Kabupaten Konawe Selatan",
                "93311 - Kabupaten Konawe Utara",
                "72119 - Kabupaten Kotabaru",
                "95711 - Kota Kotamobagu",
                "74119 - Kabupaten Kotawaringin Barat",
                "74364 - Kabupaten Kotawaringin Timur",
                "29519 - Kabupaten Kuantan Singingi",
                "78311 - Kabupaten Kubu Raya",
                "59311 - Kabupaten Kudus",
                "35139 - Kota Bandar Lampung",
                "55611 - Kabupaten Kulon Progo",
                "45511 - Kabupaten Kuningan",
                "85362 - Kabupaten Kupang",
                "85119 - Kota Kupang",
                "75711 - Kabupaten Kutai Barat",
                "75511 - Kabupaten Kutai Kartanegara",
                "75611 - Kabupaten Kutai Timur",
                "21412 - Kabupaten Labuhan Batu",
                "21511 - Kabupaten Labuhan Batu Selatan",
                "21711 - Kabupaten Labuhan Batu Utara",
                "40311 - Kabupaten Bandung",
                "31419 - Kabupaten Lahat",
                "74611 - Kabupaten Lamandau",
                "62218 - Kabupaten Lamongan",
                "34814 - Kabupaten Lampung Barat",
                "35511 - Kabupaten Lampung Selatan",
                "34212 - Kabupaten Lampung Tengah",
                "34319 - Kabupaten Lampung Timur",
                "34516 - Kabupaten Lampung Utara",
                "78319 - Kabupaten Landak",
                "20811 - Kabupaten Langkat",
                "40111 - Kota Bandung",
                "24412 - Kota Langsa",
                "99531 - Kabupaten Lanny Jaya",
                "42319 - Kabupaten Lebak",
                "39264 - Kabupaten Lebong",
                "86611 - Kabupaten Lembata",
                "24352 - Kota Lhokseumawe",
                "26671 - Kabupaten Lima Puluh Koto/Kota",
                "29811 - Kabupaten Lingga",
                "83311 - Kabupaten Lombok Barat",
                "83511 - Kabupaten Lombok Tengah",
                "40721 - Kabupaten Bandung Barat",
                "83612 - Kabupaten Lombok Timur",
                "83711 - Kabupaten Lombok Utara",
                "31614 - Kota Lubuk Linggau",
                "67319 - Kabupaten Lumajang",
                "91994 - Kabupaten Luwu",
                "92981 - Kabupaten Luwu Timur",
                "92911 - Kabupaten Luwu Utara",
                "63153 - Kabupaten Madiun",
                "63122 - Kota Madiun",
                "56519 - Kabupaten Magelang",
                "94711 - Kabupaten Banggai",
                "56133 - Kota Magelang",
                "63314 - Kabupaten Magetan",
                "45412 - Kabupaten Majalengka",
                "91411 - Kabupaten Majene",
                "90111 - Kota Makassar",
                "65163 - Kabupaten Malang",
                "65112 - Kota Malang",
                "77511 - Kabupaten Malinau",
                "97451 - Kabupaten Maluku Barat Daya",
                "97513 - Kabupaten Maluku Tengah",
                "94881 - Kabupaten Banggai Kepulauan",
                "97651 - Kabupaten Maluku Tenggara",
                "97465 - Kabupaten Maluku Tenggara Barat",
                "91362 - Kabupaten Mamasa",
                "99381 - Kabupaten Mamberamo Raya",
                "99553 - Kabupaten Mamberamo Tengah",
                "91519 - Kabupaten Mamuju",
                "91571 - Kabupaten Mamuju Utara",
                "95247 - Kota Manado",
                "22916 - Kabupaten Mandailing Natal",
                "86551 - Kabupaten Manggarai",
                "33212 - Kabupaten Bangka",
                "86711 - Kabupaten Manggarai Barat",
                "86811 - Kabupaten Manggarai Timur",
                "98311 - Kabupaten Manokwari",
                "98355 - Kabupaten Manokwari Selatan",
                "99853 - Kabupaten Mappi",
                "90511 - Kabupaten Maros",
                "83131 - Kota Mataram",
                "98051 - Kabupaten Maybrat",
                "20228 - Kota Medan",
                "79672 - Kabupaten Melawi",
                "33315 - Kabupaten Bangka Barat",
                "37319 - Kabupaten Merangin",
                "99613 - Kabupaten Merauke",
                "34911 - Kabupaten Mesuji",
                "34111 - Kota Metro",
                "99962 - Kabupaten Mimika",
                "95614 - Kabupaten Minahasa",
                "95914 - Kabupaten Minahasa Selatan",
                "95995 - Kabupaten Minahasa Tenggara",
                "95316 - Kabupaten Minahasa Utara",
                "61382 - Kabupaten Mojokerto",
                "33719 - Kabupaten Bangka Selatan",
                "61316 - Kota Mojokerto",
                "94911 - Kabupaten Morowali",
                "31315 - Kabupaten Muara Enim",
                "36311 - Kabupaten Muaro Jambi",
                "38715 - Kabupaten Muko Muko",
                "93611 - Kabupaten Muna",
                "73911 - Kabupaten Murung Raya",
                "30719 - Kabupaten Musi Banyuasin",
                "31661 - Kabupaten Musi Rawas",
                "98816 - Kabupaten Nabire",
                "23951 - Kabupaten Aceh Besar",
                "33613 - Kabupaten Bangka Tengah",
                "23674 - Kabupaten Nagan Raya",
                "86911 - Kabupaten Nagekeo",
                "29711 - Kabupaten Natuna",
                "99541 - Kabupaten Nduga",
                "86413 - Kabupaten Ngada",
                "64414 - Kabupaten Nganjuk",
                "63219 - Kabupaten Ngawi",
                "22876 - Kabupaten Nias",
                "22895 - Kabupaten Nias Barat",
                "22865 - Kabupaten Nias Selatan",
                "69118 - Kabupaten Bangkalan",
                "22856 - Kabupaten Nias Utara",
                "77421 - Kabupaten Nunukan",
                "30811 - Kabupaten Ogan Ilir",
                "30618 - Kabupaten Ogan Komering Ilir",
                "32112 - Kabupaten Ogan Komering Ulu",
                "32211 - Kabupaten Ogan Komering Ulu Selatan",
                "32312 - Kabupaten Ogan Komering Ulu Timur",
                "63512 - Kabupaten Pacitan",
                "25112 - Kota Padang",
                "22763 - Kabupaten Padang Lawas",
                "80619 - Kabupaten Bangli",
                "22753 - Kabupaten Padang Lawas Utara",
                "27122 - Kota Padang Panjang",
                "25583 - Kabupaten Padang Pariaman",
                "22727 - Kota Padang Sidempuan",
                "31512 - Kota Pagar Alam",
                "22272 - Kabupaten Pakpak Bharat",
                "73112 - Kota Palangka Raya",
                "30111 - Kota Palembang",
                "91911 - Kota Palopo",
                "94111 - Kota Palu",
                "70619 - Kabupaten Banjar",
                "69319 - Kabupaten Pamekasan",
                "42212 - Kabupaten Pandeglang",
                "46511 - Kabupaten Pangandaran",
                "90611 - Kabupaten Pangkajene Kepulauan",
                "33115 - Kota Pangkal Pinang",
                "98765 - Kabupaten Paniai",
                "91123 - Kota Parepare",
                "25511 - Kota Pariaman",
                "94411 - Kabupaten Parigi Moutong",
                "26318 - Kabupaten Pasaman",
                "46311 - Kota Banjar",
                "26511 - Kabupaten Pasaman Barat",
                "76211 - Kabupaten Paser",
                "67153 - Kabupaten Pasuruan",
                "67118 - Kota Pasuruan",
                "59114 - Kabupaten Pati",
                "26213 - Kota Payakumbuh",
                "98354 - Kabupaten Pegunungan Arfak",
                "99573 - Kabupaten Pegunungan Bintang",
                "51161 - Kabupaten Pekalongan",
                "51122 - Kota Pekalongan",
                "70712 - Kota Banjarbaru",
                "28112 - Kota Pekanbaru",
                "28311 - Kabupaten Pelalawan",
                "52319 - Kabupaten Pemalang",
                "21126 - Kota Pematang Siantar",
                "76311 - Kabupaten Penajam Paser Utara",
                "35312 - Kabupaten Pesawaran",
                "35974 - Kabupaten Pesisir Barat",
                "25611 - Kabupaten Pesisir Selatan",
                "24116 - Kabupaten Pidie",
                "24186 - Kabupaten Pidie Jaya",
                "70117 - Kota Banjarmasin",
                "91251 - Kabupaten Pinrang",
                "96419 - Kabupaten Pohuwato",
                "91311 - Kabupaten Polewali Mandar",
                "63411 - Kabupaten Ponorogo",
                "78971 - Kabupaten Pontianak",
                "78112 - Kota Pontianak",
                "94615 - Kabupaten Poso",
                "31121 - Kota Prabumulih",
                "35719 - Kabupaten Pringsewu",
                "67282 - Kabupaten Probolinggo",
                "53419 - Kabupaten Banjarnegara",
                "67215 - Kota Probolinggo",
                "74811 - Kabupaten Pulang Pisau",
                "97771 - Kabupaten Pulau Morotai",
                "98981 - Kabupaten Puncak",
                "98979 - Kabupaten Puncak Jaya",
                "53312 - Kabupaten Purbalingga",
                "41119 - Kabupaten Purwakarta",
                "54111 - Kabupaten Purworejo",
                "98489 - Kabupaten Raja Ampat",
                "39112 - Kabupaten Rejang Lebong",
                "92411 - Kabupaten Bantaeng",
                "59219 - Kabupaten Rembang",
                "28992 - Kabupaten Rokan Hilir",
                "28511 - Kabupaten Rokan Hulu",
                "85982 - Kabupaten Rote Ndao",
                "23512 - Kota Sabang",
                "85391 - Kabupaten Sabu Raijua",
                "50711 - Kota Salatiga",
                "75133 - Kota Samarinda",
                "79453 - Kabupaten Sambas",
                "22392 - Kabupaten Samosir",
                "55715 - Kabupaten Bantul",
                "69219 - Kabupaten Sampang",
                "78557 - Kabupaten Sanggau",
                "99373 - Kabupaten Sarmi",
                "37419 - Kabupaten Sarolangun",
                "27416 - Kota Sawah Lunto",
                "79583 - Kabupaten Sekadau",
                "92812 - Kabupaten Selayar (Kepulauan Selayar)",
                "38811 - Kabupaten Seluma",
                "50511 - Kabupaten Semarang",
                "50135 - Kota Semarang",
                "23654 - Kabupaten Aceh Jaya",
                "30911 - Kabupaten Banyuasin",
                "97561 - Kabupaten Seram Bagian Barat",
                "97581 - Kabupaten Seram Bagian Timur",
                "42182 - Kabupaten Serang",
                "42111 - Kota Serang",
                "20915 - Kabupaten Serdang Bedagai",
                "74211 - Kabupaten Seruyan",
                "28623 - Kabupaten Siak",
                "22522 - Kota Sibolga",
                "91613 - Kabupaten Sidenreng Rappang/Rapang",
                "61219 - Kabupaten Sidoarjo",
                "53114 - Kabupaten Banyumas",
                "94364 - Kabupaten Sigi",
                "27511 - Kabupaten Sijunjung (Sawah Lunt",
                "86121 - Kabupaten Sikka",
                "21162 - Kabupaten Simalungun",
                "23891 - Kabupaten Simeulue",
                "79117 - Kota Singkawang",
                "92615 - Kabupaten Sinjai",
                "78619 - Kabupaten Sintang",
                "68316 - Kabupaten Situbondo",
                "55513 - Kabupaten Sleman",
                "68416 - Kabupaten Banyuwangi",
                "27365 - Kabupaten Solok",
                "27315 - Kota Solok",
                "27779 - Kabupaten Solok Selatan",
                "90812 - Kabupaten Soppeng",
                "98431 - Kabupaten Sorong",
                "98411 - Kota Sorong",
                "98454 - Kabupaten Sorong Selatan",
                "57211 - Kabupaten Sragen",
                "41215 - Kabupaten Subang",
                "24882 - Kota Subulussalam",
                "70511 - Kabupaten Barito Kuala",
                "43311 - Kabupaten Sukabumi",
                "43114 - Kota Sukabumi",
                "74712 - Kabupaten Sukamara",
                "57514 - Kabupaten Sukoharjo",
                "87219 - Kabupaten Sumba Barat",
                "87453 - Kabupaten Sumba Barat Daya",
                "87358 - Kabupaten Sumba Tengah",
                "87112 - Kabupaten Sumba Timur",
                "84315 - Kabupaten Sumbawa",
                "84419 - Kabupaten Sumbawa Barat",
                "73711 - Kabupaten Barito Selatan",
                "45326 - Kabupaten Sumedang",
                "69413 - Kabupaten Sumenep",
                "37113 - Kota Sungaipenuh",
                "98164 - Kabupaten Supiori",
                "60119 - Kota Surabaya",
                "57113 - Kota Surakarta (Solo)",
                "71513 - Kabupaten Tabalong",
                "82119 - Kabupaten Tabanan",
                "92212 - Kabupaten Takalar",
                "98475 - Kabupaten Tambrauw",
                "73671 - Kabupaten Barito Timur",
                "77611 - Kabupaten Tana Tidung",
                "91819 - Kabupaten Tana Toraja",
                "72211 - Kabupaten Tanah Bumbu",
                "27211 - Kabupaten Tanah Datar",
                "70811 - Kabupaten Tanah Laut",
                "15914 - Kabupaten Tangerang",
                "15111 - Kota Tangerang",
                "15435 - Kota Tangerang Selatan",
                "35619 - Kabupaten Tanggamus",
                "21321 - Kota Tanjung Balai",
                "73881 - Kabupaten Barito Utara",
                "36513 - Kabupaten Tanjung Jabung Barat",
                "36719 - Kabupaten Tanjung Jabung Timur",
                "29111 - Kota Tanjung Pinang",
                "22742 - Kabupaten Tapanuli Selatan",
                "22611 - Kabupaten Tapanuli Tengah",
                "22414 - Kabupaten Tapanuli Utara",
                "71119 - Kabupaten Tapin",
                "77114 - Kota Tarakan",
                "46411 - Kabupaten Tasikmalaya",
                "46116 - Kota Tasikmalaya",
                "90719 - Kabupaten Barru",
                "20632 - Kota Tebing Tinggi",
                "37519 - Kabupaten Tebo",
                "52419 - Kabupaten Tegal",
                "52114 - Kota Tegal",
                "98551 - Kabupaten Teluk Bintuni",
                "98591 - Kabupaten Teluk Wondama",
                "56212 - Kabupaten Temanggung",
                "97714 - Kota Ternate",
                "97815 - Kota Tidore Kepulauan",
                "85562 - Kabupaten Timor Tengah Selatan",
                "29413 - Kota Batam",
                "85612 - Kabupaten Timor Tengah Utara",
                "22316 - Kabupaten Toba Samosir",
                "94683 - Kabupaten Tojo Una-Una",
                "94542 - Kabupaten Toli-Toli",
                "99411 - Kabupaten Tolikara",
                "95416 - Kota Tomohon",
                "91831 - Kabupaten Toraja Utara",
                "66312 - Kabupaten Trenggalek",
                "97612 - Kota Tual",
                "62319 - Kabupaten Tuban",
                "51211 - Kabupaten Batang",
                "34613 - Kabupaten Tulang Bawang",
                "34419 - Kabupaten Tulang Bawang Barat",
                "66212 - Kabupaten Tulungagung",
                "90911 - Kabupaten Wajo",
                "93791 - Kabupaten Wakatobi",
                "98269 - Kabupaten Waropen",
                "34711 - Kabupaten Way Kanan",
                "57619 - Kabupaten Wonogiri",
                "56311 - Kabupaten Wonosobo",
                "99041 - Kabupaten Yahukimo",
                "23719 - Kabupaten Aceh Selatan",
                "36613 - Kabupaten Batang Hari",
                "99481 - Kabupaten Yalimo",
                "55111 - Kota Yogyakarta",
                "65311 - Kota Batu",
                "21655 - Kabupaten Batu Bara",
                "93719 - Kota Bau-Bau",
                "17837 - Kabupaten Bekasi",
                "17121 - Kota Bekasi",
                "33419 - Kabupaten Belitung",
                "33519 - Kabupaten Belitung Timur",
                "85711 - Kabupaten Belu",
                "24581 - Kabupaten Bener Meriah",
                "24785 - Kabupaten Aceh Singkil",
                "28719 - Kabupaten Bengkalis",
                "79213 - Kabupaten Bengkayang",
                "38229 - Kota Bengkulu",
                "38519 - Kabupaten Bengkulu Selatan",
                "38319 - Kabupaten Bengkulu Tengah",
                "38619 - Kabupaten Bengkulu Utara",
                "77311 - Kabupaten Berau",
                "98119 - Kabupaten Biak Numfor",
                "84171 - Kabupaten Bima",
                "84139 - Kota Bima",
                "24476 - Kabupaten Aceh Tamiang",
                "20712 - Kota Binjai",
                "29135 - Kabupaten Bintan",
                "24219 - Kabupaten Bireuen",
                "95512 - Kota Bitung",
                "66171 - Kabupaten Blitar",
                "66124 - Kota Blitar",
                "58219 - Kabupaten Blora",
                "96319 - Kabupaten Boalemo",
                "16911 - Kabupaten Bogor",
                "16119 - Kota Bogor",
                "24511 - Kabupaten Aceh Tengah",
                "62119 - Kabupaten Bojonegoro",
                "95755 - Kabupaten Bolaang Mongondow (Bolmong)",
                "95774 - Kabupaten Bolaang Mongondow Selatan",
                "95783 - Kabupaten Bolaang Mongondow Timur",
                "95765 - Kabupaten Bolaang Mongondow Utara",
                "93771 - Kabupaten Bombana",
                "68219 - Kabupaten Bondowoso",
                "92713 - Kabupaten Bone",
                "96511 - Kabupaten Bone Bolango",
                "75313 - Kota Bontang",
                "24611 - Kabupaten Aceh Tenggara",
                "99662 - Kabupaten Boven Digoel",
                "57312 - Kabupaten Boyolali",
                "52212 - Kabupaten Brebes",
                "26115 - Kota Bukittinggi",
                "81111 - Kabupaten Buleleng",
                "92511 - Kabupaten Bulukumba",
                "77211 - Kabupaten Bulungan (Bulongan)",
                "37216 - Kabupaten Bungo",
                "94564 - Kabupaten Buol",
                "97371 - Kabupaten Bur",
            ];
            set_autocomplete('post_code', 'post_code_complete',
                autocomplete_example2,
                start_at_letters = 1,
                count_results = 3
            );

        });
    </script>
@endpush

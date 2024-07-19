@extends('frontend.layouts.master')
@section('title', 'Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ 'home' }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summery -->
                    <table class="table shopping-summery">
                        <thead>
                            <tr class="main-hading">
                                <th>PRODUCT</th>
                                <th>NAME</th>
                                <th class="text-center">UNIT PRICE</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                            </tr>
                        </thead>
                        <tbody id="cart_item_list">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                @if (Helper::getAllProductFromCart())
                                    @foreach (Helper::getAllProductFromCart() as $key => $cart)
                                        <tr>
                                            @php
                                                $photo = explode(',', $cart->product['photo']);
                                            @endphp
                                            <td class="image" data-title="No"><img src="{{ $photo[0] }}"
                                                    alt="{{ $photo[0] }}"></td>
                                            <td class="product-des" data-title="Description">
                                                <p class="product-name"><a
                                                        href="{{ route('product-detail', $cart->product['slug']) }}"
                                                        target="_blank">{{ $cart->product['title'] }}
                                                        @if (auth()->check() && auth()->user()->role == 'agent')
                                                            <span class="badge badge-info"
                                                                id="preorderLabel{{ $cart->product->id }}"
                                                                @if ($cart->product->stock >= 10) style="display:none" @endif>Pre
                                                                -
                                                                Order 7Hari</span>
                                                        @endif

                                                    </a></p>
                                                <p class="product-des">{!! $cart['summary'] !!}</p>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <span>{{ Helper::rupiahFormatter($cart['price'], 2) }}</span>
                                            </td>
                                            <td class="qty" data-title="Qty"><!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            disabled="disabled" data-type="minus"
                                                            data-field="quant[{{ $key }}]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" name="quant[{{ $key }}]"
                                                        class="input-number" data-min="1" data-max="1000"
                                                        id="quantity{{ $cart->product->id }}"
                                                        value="{{ $cart->quantity }}" oninput="updateCustomPrices(); updateTotalPrice();"
                                                        @if (auth()->check() && auth()->user()->role == 'agent') onchange="checkQuantity('{{ $cart->product->stock }}', '{{ $cart->product->id }}')" @endif>
                                                    <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                            data-type="plus" data-field="quant[{{ $key }}]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </td>
                                            <td class="total-amount cart_single_price" data-title="Total"><span
                                                    class="money">{{ Helper::rupiahFormatter($cart['amount']) }}</span>
                                            </td>

                                            <td class="action" data-title="Remove">
                                                <a href="javascript:void(0);" class="remove" title="Remove this item"
                                                    onclick="confirmDelete('{{ route('cart-delete', $cart->id) }}');">
                                                    <i class="ti-trash remove-icon"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <track>
                                    <td colspan="5">
                                        <div class="d-flex justify-content-between my-2">
                                            <div class="d-flex m-0">
                                                <input type="checkbox" name="has_custom_name" id="has_custom_name"
                                                    class="form-check mr-2" onclick="toggleCustom()">
                                                <label for="has_custom_name" class="text-nowrap">Kustom Nama (+
                                                    Rp.25.000)</label>
                                                <input type="hidden" name="custom_name_price" id="custom_name_price"
                                                    value="25000" disabled>
                                            </div>
                                            <input type="text" name="custom_name" id="custom_name"
                                                class="form-control ml-2 w-75" disabled
                                                oninput="localStorage.setItem('custom_name', this.value)">
                                        </div>
                                        <div class="d-flex justify-content-between my-2">
                                            <div class="d-flex m-0">
                                                <input type="checkbox" name="has_custom_tag" id="has_custom_tag"
                                                    class="form-check mr-2" onclick="toggleCustom()">
                                                <label for="has_custom_tag" class="text-nowrap">Kustom Tag (+
                                                    Rp.15.000)</label>
                                                <input type="hidden" name="custom_tag_price" id="custom_tag_price"
                                                    value="15000" disabled>
                                            </div>
                                            <input type="text" name="custom_tag" id="custom_tag"
                                                class="form-control ml-2 w-75" disabled
                                                oninput="localStorage.setItem('custom_tag', this.value)">
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var has_custom_name = localStorage.getItem('has_custom_name');
                                                var custom_name_price = localStorage.getItem('custom_name_price');
                                                var custom_name = localStorage.getItem('custom_name');

                                                var additional = 0
                                                if (has_custom_name == 'true') {
                                                    $('#custom_name_cart_container').show();
                                                    document.getElementById('has_custom_name').checked = true;
                                                    document.getElementById('custom_name_price').value = custom_name_price;
                                                    document.getElementById('custom_name').value = custom_name;
                                                    document.getElementById('custom_name').disabled = false;
                                                    document.getElementById('custom_name_price').disabled = false;
                                                    additional = additional + parseInt(custom_name_price);
                                                }

                                                var has_custom_tag = localStorage.getItem('has_custom_tag');
                                                var custom_tag_price = localStorage.getItem('custom_tag_price');
                                                var custom_tag = localStorage.getItem('custom_tag');
                                                if (has_custom_tag == 'true') {
                                                    $('#custom_tag_cart_container').show();
                                                    document.getElementById('has_custom_tag').checked = true;
                                                    document.getElementById('custom_tag_price').value = custom_tag_price;
                                                    document.getElementById('custom_tag').value = custom_tag;
                                                    document.getElementById('custom_tag').disabled = false;
                                                    document.getElementById('custom_tag_price').disabled = false;
                                                    additional = additional + parseInt(custom_tag_price);
                                                }

                                                let cost = parseFloat($('[name=shipping]').find('option:selected').data('price')) || 0;
                                                let subtotal = parseFloat($('.order_subtotal').data('price'));
                                                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                                                // alert(coupon);
                                                $('#order_total_price span').text(rupiahFormat(subtotal + cost - coupon + additional));
                                            })

                                            function toggleCustom() {
                                                var custom_name = document.getElementById('has_custom_name');
                                                var custom_name_price = document.getElementById('custom_name_price');
                                                var custom_name_input = document.getElementById('custom_name');
                                                var additional = 0
                                                var quantity = parseInt(document.getElementById('quantity{{ $cart->product->id }}').value);
                                                if (custom_name.checked) {
                                                    if (quantity >= 50) {
                                                        custom_name_price.value = 23000;
                                                    } else {
                                                        custom_name_price.value = 25000;
                                                    }
                                                     
                                                    // Tambahkan kondisi untuk biaya kustom per produk jika jumlah pembelian kurang dari 10
                                                    if (quantity < 10) {
                                                        custom_name_price.value = quantity * 1500;
                                                    }
                                                    additional = additional + parseInt(custom_name_price.value);
                                                    custom_name_price.disabled = false;
                                                    custom_name_input.disabled = false;
                                                    localStorage.setItem('has_custom_name', custom_name.checked);
                                                    localStorage.setItem('custom_name_price', custom_name_price.value);
                                                    $('#custom_name_cart_container').show();
                                                } else {
                                                    $('#custom_name_cart_container').hide();
                                                    custom_name_price.disabled = true;
                                                    custom_name_input.disabled = true;
                                                    localStorage.removeItem('has_custom_name');
                                                    localStorage.removeItem('custom_name_price');
                                                    localStorage.removeItem('custom_name');
                                                    custom_name_input.value = '';
                                                }
                                                var custom_tag = document.getElementById('has_custom_tag');
                                                var custom_tag_price = document.getElementById('custom_tag_price');
                                                var custom_tag_input = document.getElementById('custom_tag');
                                                if (custom_tag.checked) {
                                                    if (quantity >= 50) {
                                                        custom_tag_price.value = 13000;
                                                    } else {
                                                        custom_tag_price.value = 15000;
                                                    }
                                                    // Tambahkan kondisi untuk biaya kustom per produk jika jumlah pembelian kurang dari 10
                                                    if (quantity < 10) {
                                                        custom_tag_price.value = quantity * 1000;
                                                    }
                                                    additional = additional + parseInt(custom_tag_price.value);
                                                    custom_tag_price.disabled = false;
                                                    custom_tag_input.disabled = false;
                                                    localStorage.setItem('has_custom_tag', custom_tag.checked);
                                                    localStorage.setItem('custom_tag_price', custom_tag_price.value);
                                                    $('#custom_tag_cart_container').show();
                                                } else {
                                                    $('#custom_tag_cart_container').hide();
                                                    custom_tag_price.disabled = true;
                                                    custom_tag_input.disabled = true;
                                                    localStorage.removeItem('has_custom_tag');
                                                    localStorage.removeItem('custom_tag_price');
                                                    localStorage.removeItem('custom_tag');
                                                    custom_tag_input.value = '';
                                                }
                                                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                                                let subtotal = parseFloat($('.order_subtotal').data('price'));
                                                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                                                // alert(coupon);
                                                $('#order_total_price span').text(rupiahFormat(subtotal + cost - coupon + additional));
                                            }
                                        </script>

                                    </td>
                                    <td class="float-right">
                                        <button class="btn float-right" type="submit">Update</button>
                                    </td>
                                    </track>
                                @else
                                    <tr>
                                        <td class="text-center">
                                            There are no any carts available. <a href="{{ route('product-grids') }}"
                                                style="color:blue;">Continue shopping</a>

                                        </td>
                                    </tr>
                                @endif

                            </form>
                        </tbody>
                    </table>
                    <!--/ End Shopping Summery -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupon-store') }}" method="POST">
                                            @csrf
                                            <input name="code" placeholder="Enter Your Coupon">
                                            <button class="btn">Apply</button>
                                        </form>
                                    </div>
                                    {{-- <div class="checkbox">`
										@php
											$shipping=DB::table('shippings')->where('status','active')->limit(1)->get();
										@endphp
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" onchange="showMe('shipping');"> Shipping</label>
									</div> --}}
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                            Cart Subtotal
                                            <span>{{ Helper::rupiahFormatter(Helper::totalCartPrice(), 2) }}</span>
                                        </li>
                                        <li id="custom_name_cart_container" style="display:none">
                                            Kustom Nama
                                            <span id="custom_name_price_display">Rp. 25.000</span>
                                        </li>
                                        <li id="custom_tag_cart_container" style="display:none">
                                            Kustom Tag
                                            <span id="custom_tag_price_display">Rp. 15.000</span>
                                        </li>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var custom_name_price = localStorage.getItem('custom_name_price');
                                                var custom_tag_price = localStorage.getItem('custom_tag_price');
                                                var quantity = parseInt(localStorage.getItem('quantity'));
                                                // Ubah harga kustom nama
                                                if (custom_name_price !== null && custom_name_price !== undefined) {
                                                    if (quantity >= 50) {
                                                        custom_name_price = 23000; // Harga jika lebih dari atau sama dengan 50
                                                    } else if (quantity < 10) {
                                                        custom_name_price = quantity * 1500; // Harga per produk jika kurang dari 10
                                                    } else {
                                                        custom_name_price = 25000; // Harga jika antara 10 dan kurang dari 50
                                                    }
                                                    // Update elemen span dengan harga kustom nama yang baru
                                                    document.getElementById("custom_name_price_display").textContent = 'Rp. ' + custom_name_price.toLocaleString('id-ID');
                                                } else {
                                                    console.error('Nilai custom_name_price tidak ditemukan atau tidak valid.');
                                                }
                                                // Ubah harga kustom tag
                                                if (custom_tag_price !== null && custom_tag_price !== undefined) {
                                                    if (quantity >= 50) {
                                                        custom_tag_price = 13000; // Harga jika lebih dari atau sama dengan 50
                                                    } else if (quantity < 10) {
                                                        custom_tag_price = quantity * 1000; // Harga per produk jika kurang dari 10
                                                    } else {
                                                        custom_tag_price = 15000; // Harga jika antara 10 dan kurang dari 50
                                                    }
                                                    // Update elemen span dengan harga kustom tag yang baru
                                                    document.getElementById('custom_tag_price_display').textContent = 'Rp. ' + custom_tag_price;
                                                } else {
                                                    console.error('Nilai custom_tag_price tidak ditemukan atau tidak valid.');
                                                }
                                            });
                                        </script>
                                        @if (session()->has('coupon'))
                                            <li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">
                                                You
                                                Save<span>{{ Helper::rupiahFormatter(Session::get('coupon')['value'], 2) }}</span>
                                            </li>
                                        @endif
                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session()->has('coupon')) {
                                                $total_amount = $total_amount - Session::get('coupon')['value'];
                                            }
                                        @endphp
                                        @if (session()->has('coupon'))
                                            <li class="last" id="order_total_price">You
                                                Pay<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">You
                                                Pay<span>{{ Helper::rupiahFormatter($total_amount, 2) }}</span></li>
                                        @endif
                                    </ul>
                                    <div class="button5">
                                        <a href="{{ route('checkout') }}" class="btn">Checkout</a>
                                        <a href="{{ route('product-grids') }}" class="btn">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section">
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
    <!-- End Shop Newsletter -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
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
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text(rupiahFormat(subtotal + cost - coupon));
            });

        });
    </script>
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

        rupiahFormat = (rupiah) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0
            }).format(rupiah);
        }
        

    </script>

    @if (auth()->check() && auth()->user()->role == 'agent')
        <script>
            checkQuantity = (max, id) => {
                let quantity = $('#quantity' + id).val();
                if (quantity > max) {
                    $('#preorderLabel' + id).show();
                } else {
                    $('#preorderLabel' + id).hide();
                }
            }
        </script>
    @endif
@endpush

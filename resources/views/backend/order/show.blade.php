@php
    use Carbon\Carbon;
@endphp
@extends('backend.layouts.master')
@section('title', 'Order Detail')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Order
        </h5>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order No</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Charge</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ Helper::rupiahFormatter($order->courier_charge) }}</td>
                            <td>{{ Helper::rupiahFormatter($order->total_amount, 2) }}</td>
                            <td>
                                @if ($order->status == 'received')
                                    <span class="badge badge-primary">{{ $order->status }}</span>
                                @elseif($order->status == 'process')
                                    <span class="badge badge-warning">{{ $order->status }}</span>
                                @elseif($order->status == 'delivered' || $order->status == 'completed')
                                    <span class="badge badge-success">{{ $order->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td>
                                @if (
                                    $order->status == 'received' ||
                                        $order->status == 'process' ||
                                        $order->status == 'delivered' ||
                                        $order->status == 'return_request')
                                    <a href="{{ route('order.edit', $order->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('order.destroy', [$order->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">ORDER INFORMATION</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Order Number</td>
                                            <td> : {{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Date</td>
                                            <td> :{{ Carbon::parse($order->created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Quantity</td>
                                            <td> : {{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Status</td>
                                            <td> : {{ $order->status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Charge</td>
                                            <td> : {{ Helper::rupiahFormatter($order->courier_charge) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Coupon</td>
                                            <td> : {{ Helper::rupiahFormatter($order->coupon, 2) }}</td>
                                        </tr>

                                        @if ($order->has_custom_name == 1)
                                            <tr>
                                                <td>Kustom Nama</td>
                                                <td> : {{ $order->custom_name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Biaya Kustom Nama</td>
                                                <td> : {{ Helper::rupiahFormatter($order->custom_name_price, 2) }}</td>
                                            </tr>
                                        @endif

                                        @if ($order->has_custom_tag == 1)
                                            <tr>
                                                <td>Kustom tag</td>
                                                <td> : {{ $order->custom_tag ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Biaya Kustom Tag</td>
                                                <td> : {{ Helper::rupiahFormatter($order->custom_tag_price, 2) }}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>Total Amount</td>
                                            <td> : {{ Helper::rupiahFormatter($order->total_amount, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Full Name</td>
                                            <td> : {{ $order->first_name }} {{ $order->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td> : {{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone No.</td>
                                            <td> : {{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td> : {{ $order->address1 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td> : {{ $order->country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Post Code</td>
                                            <td> : {{ $order->post_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Name</td>
                                            <td> : {{ $order->courier_name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-12 col-lx-8 mt-4">
                                <div class="ordered-products-info">
                                    <h4 class="text-center pb-4">ORDERED PRODUCTS</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderedProducts as $key => $product)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $product->product->title }}</td>
                                                    <td>{{ Helper::rupiahFormatter($product->price, 2) }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>{{ Helper::rupiahFormatter($product->amount, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info,
        .shipping-info,
        .ordered-products-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4,
        .ordered-products-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush

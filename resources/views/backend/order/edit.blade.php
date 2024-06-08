@extends('backend.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Order Edit</h5>
        <div class="card-body">
            <form action="{{ route('order.update', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="status">Status :</label>
                    <select name="status" id="" class="form-control">
                        <option value="new"
                            {{ $order->status == 'delivered' || $order->status == 'process' || $order->status == 'cancel' || $order->status == 'return_request' || $order->status == 'return_accepted' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'new' ? 'selected' : '' }}>New</option>
                        <option value="process"
                            {{ $order->status == 'delivered' || $order->status == 'cancel' || $order->status == 'return_request' || $order->status == 'return_accepted' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'process' ? 'selected' : '' }}>process</option>
                        <option value="delivered"
                            {{ $order->status == 'cancel' || $order->status == 'return_request' || $order->status == 'return_accepted' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancel"
                            {{ $order->status == 'delivered' || $order->status == 'return_request' || $order->status == 'return_accepted' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'cancel' ? 'selected' : '' }}>Cancel</option>

                        <option value="return_request"
                            {{ $order->status == 'new' || $order->status == 'process' || $order->status == 'cancel' || $order->status == 'cancel' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'return_request' ? 'selected' : '' }}>Return Requested</option>
                        <option value="return_accepted"
                            {{ $order->status == 'new' || $order->status == 'process' || $order->status == 'cancel' || $order->status == 'cancel' || $order->status == 'return_rejected' ? 'disabled' : '' }}
                            {{ $order->status == 'return_accepted' ? 'selected' : '' }}>Return Accepted</option>
                        <option value="return_accepted"
                            {{ $order->status == 'new' || $order->status == 'process' || $order->status == 'cancel' || $order->status == 'cancel' || $order->status == 'return_accepted' ? 'disabled' : '' }}
                            {{ $order->status == 'return_accepted' ? 'selected' : '' }}>Return Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush

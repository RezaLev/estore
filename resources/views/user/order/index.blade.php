@extends('user.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('user.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($orders) > 0)
                    <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Quantity</th>
                                <th>Charge</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ Helper::rupiahFormatter($order->courier_charge) }}</td>
                                <td>{{ Helper::rupiahFormatter($order->total_amount, 2) }}</td>
                                <td>
                                    @switch($order->approved_status)
                                        @case('0')
                                            <span class="badge badge-warning">waiting approval</span>
                                        @break

                                        @case(null)
                                        @case('1')
                                            @if ($order->status == 'received')
                                                <span class="badge badge-primary">{{ $order->status }}</span>
                                            @elseif($order->status == 'process')
                                                <span class="badge badge-warning">{{ $order->status }}</span>
                                            @elseif($order->status == 'delivered' || $order->status == 'completed')
                                                <span class="badge badge-success">{{ $order->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $order->status }}</span>
                                            @endif
                                        @break

                                        @case('2')
                                            <span class="badge badge-danger">reject</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('user.order.show', $order->id) }}"
                                        class="btn btn-warning btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    @if ($order->status == 'delivered')
                                        <form method="POST" action="{{ route('user.order.complete', [$order->id]) }}">
                                            @csrf
                                            <button class="btn btn-primary btn-sm" data-id={{ $order->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Complete"><i
                                                    class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    @if ($order->status == 'received' || $order->status == 'process')
                                        <form method="POST" action="{{ route('user.order.delete', [$order->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $orders->links() }}</span>
                @else
                    <h6 class="text-center">No orders found!!! Please order some products</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->

    <script>
        $('#order-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [8]
            }]
        });

        // Sweet alert
        function deleteData(id) {
        }
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush

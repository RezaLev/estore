@php
    use Carbon\Carbon;
@endphp
@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
            <div class="d-flex ">
            <form class="form-inline" id="searchForm" onsubmit="event.preventDefault(); searchOrders();">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchQuery">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="searchOrders()">Search</button>
            </form> &nbsp;
            <form id="filter-form" method="GET" action="{{ route('order.index') }}">
                    <select name="order" id="order" class="form-control" onchange="this.form.submit()">
                        <option value="all">All Status</option>
                        @foreach ($status as $stat)
                            <option value="{{ $stat->status }}"
                                {{ request('order') == $stat->status ? 'selected' : '' }}>{{ $stat->status }}
                            </option>
                        @endforeach
                    </select>
            </form>&nbsp;
                <form id="filter-form" class="form-inline" method="GET" action="{{ route('order.index') }}">
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">&nbsp;
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </form>&nbsp;
                <a href="/export-pdf" target="_blank" class="btn btn-primary btn-sm d-flex align-items-center"
                    style="text-wrap:nowrap">Export Pdf</a>
            </div>
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
                                <th>Address</th>
                                <th>Total Amount</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                    <td>{{ $order->address1 }}</td>
                                    <td>{{ Helper::rupiahFormatter($order->total_amount, 2) }}</td>
                                    <td>{{ Carbon::parse($order->created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>
                                        @switch($order->approved_status)
                                            @case('0')
                                                <span class="badge badge-warning">Menunggu Persetujuan</span>
                                            @break

                                            @case(null)
                                            @case('1')
                                                @if ($order->status == 'new')
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
                                                <span class="badge badge-danger">Ditolak</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-warning btn-sm mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                                        @switch($order->approved_status)
                                            @case('0')
                                                <form method="POST" action="{{ route('order.approved', [$order->id]) }}">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm mr-1" data-id={{ $order->id }}
                                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                        data-placement="bottom" title="Complete"><i
                                                            class="fas fa-check"></i></button>
                                                </form>
                                                <form method="POST" action="{{ route('order.rejected', [$order->id]) }}">
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm mr-1" data-id={{ $order->id }}
                                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                        data-placement="bottom" title="Complete"><i
                                                            class="fas fa-times"></i></button>
                                                </form>
                                            @break

                                            @case('1')
                                                @if (
                                                    $order->status == 'new' ||
                                                        $order->status == 'process' ||
                                                        $order->status == 'delivered' ||
                                                        $order->status == 'return_request')
                                                    <a href="{{ route('order.edit', $order->id) }}"
                                                        class="btn btn-primary btn-sm mr-1"
                                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                        title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                @endif
                                            @break
                                        @endswitch

                                        <form method="POST" action="{{ route('order.destroy', [$order->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $order->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>


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
        function searchOrders() {
        var query = $('#searchQuery').val().toLowerCase();

        $('#order-dataTable tbody tr').filter(function() {
            var rowName = $(this).find('td:nth-child(3)').text().toLowerCase();
            var rowAddress = $(this).find('td:nth-child(4)').text().toLowerCase();

            if (rowName.includes(query) || rowAddress.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        }
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

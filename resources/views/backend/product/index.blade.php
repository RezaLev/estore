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
            <h6 class="m-0 font-weight-bold text-primary">Product Lists</h6>
            <div class="d-flex">
                <form id="filter-form" method="GET" action="{{ route('product.index') }}">
                    <div class="form-group mr-3 mb-0">
                        <select name="category" id="category" class="form-control" onchange="this.form.submit()">
                            <option value="all">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <a href="{{ route('product.create') }}"
                    class="btn btn-primary btn-sm d-flex justify-content-center align-items-center" data-toggle="tooltip"
                    data-placement="bottom" title="Add User"><i class="fas fa-plus mb-1 mr-2"></i> Add Product</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($products) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Condition</th>
                                <th>Stock</th>
                                <th>Photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($products as $product)
                                @php
                                    $sub_cat_info = DB::table('categories')
                                        ->select('title')
                                        ->where('id', $product->child_cat_id)
                                        ->get();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->cat_info['title'] }}
                                        <sub>
                                            {{ $product->sub_cat_info->title ?? '' }}
                                        </sub>
                                    </td>
                                    <td>Rp. {{ $product->price }} /-</td>
                                    <td> {{ $product->discount }}% OFF</td>
                                    <td>{{ $product->condition }}</td>
                                    <td>
                                        @if ($product->stock > 0)
                                            <span class="badge badge-primary">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $product->stock }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->photo)
                                            @php
                                                $photo = explode(',', $product->photo);
                                            @endphp
                                            <img src="{{ $photo[0] }}" class="img-fluid zoom" style="max-width:80px"
                                                alt="{{ $product->photo }}">
                                        @else
                                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                                style="max-width:80px" alt="avatar.png">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->status == 'active')
                                            <span class="badge badge-success">{{ $product->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $product->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('product.destroy', [$product->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $product->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $products->links()}}</span>
                @else
                    <h6 class="text-center">No Products found!!! Please create Product</h6>
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
        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->

    <script>
        $('#product-dataTable').DataTable({
            "columnDefs": [{
                "orderable": true,
                "targets": [7, 8, 9]
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

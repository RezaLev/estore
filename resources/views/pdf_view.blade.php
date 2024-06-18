<!DOCTYPE html>
<html>

<head>
    <title>PDF Export</title>
    <style>
        /* Add some styling if needed */
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <table border="1" width="100%" cellspacing="0" style="font-size: 10px">
        <thead>
            <tr>
                <th>No</th>
                <th>Order No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Total Amount</th>
                <th>Created At</th>
                <th>Status</th>
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
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->address1 }} {{ $order->address2 }}</td>
                    <td>{{ Helper::rupiahFormatter($order->total_amount, 2) }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        @if ($order->status == 'new')
                            <span class="badge badge-primary">{{ $order->status }}</span>
                        @elseif($order->status == 'process')
                            <span class="badge badge-warning">{{ $order->status }}</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge badge-success">{{ $order->status }}</span>
                        @else
                            <span class="badge badge-danger">{{ $order->status }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    @include('home.css')
</head>

<body>
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <!-- end hero area -->

    <div class="container">
        <h1 class="mt-4">My Orders</h1>
        <div class="orders mt-4">
            @if ($orders->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Price</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pengiriman</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->rec_address }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                                <td>{{ $order->status_pembayaran }}</td>
                                <td>{{ $order->status_pengiriman }}</td>
                                <td>
                                    @if ($order->status_pembayaran == 'Belum Bayar')
                                        <a href="{{ route('pay', $order->id) }}" class="btn btn-primary">Bayar</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-warning">No orders found.</p>
            @endif
        </div>
    </div>

    <!-- info section -->
    @include('home.footer')

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-beta3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .custom-table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .custom-table tbody tr {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .custom-table th, .custom-table td {
            padding: 15px;
            text-align: left;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    @include('admin.header')
    {{-- End Header --}}
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Product Title</th>
                            <th>Price</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pengiriman</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->rec_address }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->product->title }}</td>
                            <td>Rp{{ number_format($order->price, 0, ',', '.') }}</td>
                            <td>{{ $order->status_pembayaran }}</td>
                            <td>{{ $order->status_pengiriman }}</td>
                            <td>
                                <img width="150" src="products/{{ $order->product->image }}" alt="">
                            </td>
                            <td>
                                @if ($order->status_pengiriman != 'Sudah Dikirim')
                                <form action="{{ route('orders.updateShipment', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Delivered</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
</body>
</html>

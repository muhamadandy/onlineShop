<!DOCTYPE html>
<html>

<head>
@include('home.css')

<style>
 .div_deg {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items to the top */
            margin: 60px;
            flex-wrap: wrap; /* Allow items to wrap */
            gap: 40px; /* Add gap between form and table */
        }
    table{
        border: 2px solid black;
        text-align: center;
        width: 800px
    }
    th{
        border: 2px solid black;
        text-align: center;
        color: white;
        font-size: 20px;
        font-weight: bold;
        background-color: black
    }
    td{
        border: 1px solid skyblue;
    }
    .order_deg {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
            max-width: 400px; /* Set max-width for the form */
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in the width */
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

</style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

  </div>
    <!-- end hero area -->
    <div class="div_deg">
        <div class="order_deg">
            <form action="{{url('confirm_order')}}" method="POST">
                @csrf
                <div class="div_gap">
                    <label for="name">Receiver Name</label>
                    <input type="text" id="name" name="name" value="{{Auth::user()->name}}">
                </div>
                <div class="div_gap">
                    <label for="address">Receiver Address</label>
                    <textarea id="address" name="address">{{Auth::user()->address}}</textarea>
                </div>
                <div class="div_gap">
                    <label for="phone">Receiver Phone</label>
                    <input type="text" id="phone" name="phone" value="{{Auth::user()->phone}}">
                </div>
                <div class="div_gap">
                    @if ($cart->isNotEmpty())
                        <input class="btn btn-primary" type="submit" value="Place Order">
                    @endif
                </div>
            </form>
        </div>



        <table>
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalPrice = 0; // Inisialisasi total harga
                @endphp

                @foreach ($cart as $cartItem)
                <tr>
                    <td>{{$cartItem->product->title}}</td>
                    <td>Rp{{ number_format($cartItem->product->price, 0, ',', '.') }}</td>
                    <td>
                        <img width="150px" src="/products/{{$cartItem->product->image}}" alt="">
                    </td>
                    <td>
                        <form action="{{url('remove_cart',$cartItem->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Remove</button>
                        </form>
                    </td>
                </tr>

                @php
                // Tambahkan harga produk ke total harga
                $totalPrice += $cartItem->product->price;
                @endphp

                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>Total Price:</strong></td>
                    <td><strong>Rp{{ number_format($totalPrice, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- info section -->
    @include('home.footer')

</body>

</html>

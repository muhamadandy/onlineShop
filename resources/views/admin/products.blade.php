<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
    <style>
        .div_deg{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px
        }
        .table_deg{
            width: 100%;
            border: 2px solid greenyellow;
        }
        th{
            background-color: skyblue;
            color: white;
            font-size: 19px;
            font-weight: bold;
            padding: 15px
        }
        td{
            border: 1px solid skyblue;
            text-align: center;
            color: white;
        }
        input[type='search']{
            width: 500px;
            height: 40px;
            margin-left: 50px
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

            <form action="{{url('product_search')}}" method="GET">
                @csrf
                <input type="search" name="search" >
                <input type="submit" class="btn btn-secondary" value="Search">
            </form>

            <div class="div_deg">
                <table class="table_deg">
                    <thead>
                        <th>Product Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{$product->title}}</td>
                            <td>{!!Str::limit($product->description,50)!!}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>
                                <img height="120" width="120" src="/products/{{$product->image}}" alt="">
                                </td>
                                <td>
                                    <a class="btn btn-success" href="{{url('update_product',$product->id)}}">Edit</a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="{{url('delete_product',$product->id)}}" onclick="confirmation(event)">Delete</a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="div_deg">
                {{$products->onEachSide(1)->links()}}
            </div>
          </div>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
    @include('admin.js')
  </body>
</html>

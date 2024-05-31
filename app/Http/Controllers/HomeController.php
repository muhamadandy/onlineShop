<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function home(){
        $count = '';

        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $count = Cart::where('user_id', $userId)->count();
        }

        return view('home.index', [
            'products' => Product::all(),
            'cartCount' => $count
        ]);
    }


    public function login_home(){
        $count = '';

        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $count = Cart::where('user_id', $userId)->count();
        }
        return view('home.index', [
            'products' => Product::all(),
            'cartCount' => $count
        ]);
    }


    public function product_details($id){
        $data = Product::find($id);
        $cartCount = '';

        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;
            $cartCount = Cart::where('user_id', $userId)->count();
        }

        return view('home.product_details',compact('data','cartCount'));
    }

    public function add_cart($id){
        $product_id = $id;

        $user = Auth::user();

        $user_id = $user->id;

        $data = new Cart;

        $data->user_id = $user_id;
        $data->product_id = $product_id;

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Add Product to Cart Successfully');

        return redirect()->back();

    }

    public function mycart(){
        if (Auth::id()) {
            $user = Auth::user();
            $userId = $user->id;
            $cartCount = Cart::where('user_id',$userId)->count();
            $cart = Cart::where('user_id',$userId)->get();
        }
        return view('home.mycart',compact('cartCount','cart'));
    }

    public function removeCart($id){
        $cartItem = Cart::find($id);

        $cartItem->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Item removed from cart successfully');

        return redirect()->back();

    }

    public function confirm_order(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        // Retrieve the user ID
        $userId = Auth::user()->id;

        // Retrieve the cart items for the user
        $carts = Cart::where('user_id', $userId)->get();

        // Process each cart item
        foreach ($carts as $cart) {
            // Ambil harga produk dari tabel products
            $product = Product::find($cart->product_id);
            $productPrice = $product->price;

            // Simpan order ke dalam database
            $order = new Order;
            $order->name = $request->name;
            $order->rec_address = $request->address;
            $order->phone = $request->phone;
            $order->user_id = $userId;
            $order->product_id = $cart->product_id;
            $order->price = $productPrice; // Simpan total harga pesanan

            $order->save();

            // Hapus item keranjang
            $cart->delete();
        }

        toastr()->timeOut(10000)->closeButton()->addSuccess('Order added successfully');
        return redirect('my_order');
    }


    public function my_order()
    {
        $orders = [];

        // Dapatkan ID pengguna yang sedang login
        $userId = Auth::id();

        // Jika ada pengguna yang terautentikasi
        if ($userId) {
            // Ambil jumlah item di keranjang untuk pengguna yang sedang login
            $cartCount = Cart::where('user_id', $userId)->count();

            // Ambil pesanan yang terkait dengan pengguna yang sedang login
            $orders = Order::where('user_id', $userId)->get();
        } else {
            $cartCount = 0;
        }

        // Kirim data pesanan dan jumlah item di keranjang ke tampilan
        return view('home.my_orders', ['orders' => $orders, 'cartCount' => $cartCount]);
    }


}
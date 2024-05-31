<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function add_product(){
        return view('admin.add_product');
    }

    public function upload_product(Request $request){
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;

        $image = $request->image;
        if ($image) {
           $imagename = time().'.'.$image->getClientOriginalExtension();
           $request->image->move('products',$imagename);
           $data->image = $imagename;
        }

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product Added Successfully');

        return redirect()->back();
    }

    public function view_products(){

        return view('admin.products',[
            "products" => Product::paginate(1)
        ]);
    }

    public function update_product($id){
        $data = Product::find($id);


        return view('admin.update_page',compact('data'));
    }

    public function edit_product(Request $request, $id){
        $data = Product::find($id);

        if (!$data) {
            // Handle if product not found
            toastr()->timeOut(10000)->closeButton()->addDanger('Product not found');
            return redirect('/view_products');
        }

        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;

        $image = $request->image;
        if ($image) {
            // Handle image upload only if new image is provided
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('products'), $imageName);
            $data->image = $imageName;
        }

        $data->save();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Product updated Successfully');
        return redirect('/view_products');
    }


    public function delete_product($id){
        $data = Product::find($id);

        $image_path = public_path('products/'.$data->image);

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $data->delete();

        toastr()->timeOut(10000)->closeButton()->addSuccess('Delete product Successfully');

        return redirect()->back();
    }

    public function product_search(Request $request){
        $search = $request->search;

        $products = Product::where('title','LIKE','%'.$search.'%')
        ->paginate(3);

        return view('admin.products',compact('products'));
    }

    public function view_orders(){
        return view('admin.orders',[
            'orders' => Order::all()
        ]);
    }
}
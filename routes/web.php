<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

Route::get('/',[HomeController::class,'home']);
Route::get('product_details/{id}',[HomeController::class,'product_details']);
Route::get('add_cart/{id}',[HomeController::class,'add_cart'])
->middleware(['auth','verified']);
Route::get('mycart',[HomeController::class,'mycart'])
->middleware(['auth','verified']);
Route::delete('remove_cart/{id}',[HomeController::class,'removeCart'])
->middleware(['auth','verified']);

Route::get('/dashboard',[HomeController::class,'login_home'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::get('my_order',[HomeController::class,'my_order'])
->middleware(['auth', 'verified']);

Route::post('confirm_order',[HomeController::class,'confirm_order'])
->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/admin/dashboard',[HomeController::class,'index'])->middleware(['auth','admin']);

Route::get('add_product',[AdminController::class,'add_product'])->middleware(['auth','admin']);
Route::post('upload_product',[AdminController::class,'upload_product'])->middleware(['auth','admin']);
Route::get('view_products',[AdminController::class,'view_products'])->middleware(['auth','admin']);
Route::get('update_product/{id}',[AdminController::class,'update_product'])->middleware(['auth','admin']);
Route::post('edit_product/{id}',[AdminController::class,'edit_product'])->middleware(['auth','admin']);
Route::get('delete_product/{id}',[AdminController::class,'delete_product'])->middleware(['auth','admin']);
Route::get('product_search',[AdminController::class,'product_search'])->middleware(['auth','admin']);
Route::get('view_orders',[AdminController::class,'view_orders'])->middleware(['auth','admin']);


Route::get('pay/{id}', [PaymentController::class, 'createTransaction'])->name('pay')->middleware(['auth','verified']);
Route::put('/orders/{id}/update-payment', [PaymentController::class, 'updatePayment'])->name('orders.updatePayment')->middleware(['auth','verified']);
Route::put('/orders/{id}/update-shipment', [PaymentController::class, 'updateShipment'])->name('orders.updateShipment');
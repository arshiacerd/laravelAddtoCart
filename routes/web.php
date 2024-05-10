<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/add', [App\Http\Controllers\HomeController::class, 'addprod']);
Route::get('/show', [App\Http\Controllers\ProductController::class, 'show']);
Route::post('/aaaa', [App\Http\Controllers\ProductController::class, 'aa']);
Route::get('proood/{id}', [App\Http\Controllers\ProductController::class, 'stat']);
Route::get('products/{id}/delete', [App\Http\Controllers\ProductController::class, 'destroy']);
Route::get('products/{id}/cart', [App\Http\Controllers\ProductController::class, 'store']);
Route::get('products/display', [App\Http\Controllers\ProductController::class, 'displayProducts']);
Route::get('products/checkout', [App\Http\Controllers\ProductController::class, 'checkout']);
Route::get('products/{id}/delete', [App\Http\Controllers\ProductController::class, 'deleteFromSession']);
Route::post('/update-session', function (\Illuminate\Http\Request $request) {
    $productId = $request->input('productId');
    $quantity = $request->input('quantity');
    $prodPrice = $request->input('prodPrice');
    $totalPrice = $quantity * $prodPrice;
    // Store the quantity in the session
    session()->put("quantity_" . $productId, $quantity);
    session()->put("price_" . $productId, $totalPrice);


    return response()->json(session()->get("price_" . $productId));
});
Route::post('/update-totalPrice', function (\Illuminate\Http\Request $request) {
    $totalPrice = $request->input('totalPrice');

    session()->put("totalPrice", $totalPrice);


    return response()->json(session()->get("totalPrice"));
});
// Route::post('/shh', [App\Http\Controllers\ProductController::class, 'show']);
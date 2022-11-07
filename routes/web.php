<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();

Route::get('/', \App\Http\Livewire\Front\LandingPage::class)->name('landing-page');
Route::get('/shop', \App\Http\Livewire\Front\Shop::class)->name('shop.index');
Route::get('/shop/product/{slug}', \App\Http\Livewire\Front\SingleProduct::class)->name('product.show');
Route::get('/shopping-cart', \App\Http\Livewire\Front\ShoppingCart::class)->name('cart.index');
Route::get('/contact-us', \App\Http\Livewire\Front\Contact::class)->name('contact');

Route::middleware(['auth:web'])->group(function (){
    Route::get('/checkout', \App\Http\Livewire\Front\Checkout::class)->name('checkout');
    Route::get('/thankyou', \App\Http\Livewire\Front\ThankYou::class)->name('thankyou');
    //Orders
    Route::get('/user-orders', \App\Http\Livewire\Front\UserOrders::class)->name('user_orders.index');
    Route::get('/user-orders/{order_id}', \App\Http\Livewire\Front\UserOrderDetails::class)->name('user_order.details');
    //Reviews
    Route::get('/user-review/{order_item_id}', \App\Http\Livewire\Front\UserReview::class)->name('user_review');
    //Change Password
    Route::get('/user-password', \App\Http\Livewire\Front\UserChangePassword::class)->name('user_change_password');
    //User Profile
    Route::get('/user-profile', \App\Http\Livewire\Front\UserProfile::class)->name('user_profile');
    Route::get('/edit-user-profile', \App\Http\Livewire\Front\EditUserProfile::class)->name('edit_user_profile');

});


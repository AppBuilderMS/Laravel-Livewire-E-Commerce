<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function (){
    Route::middleware(['guest:admin'])->group(function (){
        Route::view('/login', 'back-end.login')->name('login');
        Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'store']);
    });

    Route::middleware(['auth:admin'])->group(function (){
        Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'destroy'])->name('logout');
        Route::get('/dashboard', \App\Http\Livewire\Back\Dashboard::class)->name('dashboard');
        //Categories
        Route::get('/categories', \App\Http\Livewire\Back\Categories\CategoriesIndex::class)->name('categories.index');
        //Attributes
        Route::get('/attributes', \App\Http\Livewire\Back\Attributes\ProductAttributesIndex::class)->name('attributes.index');
        //Products
        Route::get('/products', \App\Http\Livewire\Back\Products\ProductsIndex::class)->name('products.index');
        Route::get('/products/create', \App\Http\Livewire\Back\Products\CreateProduct::class)->name('product.create');
        Route::get('/products/edit/{product_slug}', \App\Http\Livewire\Back\Products\EditProduct::class)->name('product.edit');
        //Coupons
        Route::get('/coupons', \App\Http\Livewire\Back\Coupons\CouponsIndex::class)->name('coupons.index');
        //Orders
        Route::get('/orders', \App\Http\Livewire\Back\Orders\OrdersIndex::class)->name('orders.index');
        Route::get('/orders/{order_id}', \App\Http\Livewire\Back\Orders\OrderDetails::class)->name('order.details');
        //Contact
        Route::get('/contacts', \App\Http\Livewire\Back\Contacts\ContactsIndex::class)->name('contacts');
        //Settings
        Route::get('/settings', \App\Http\Livewire\Back\Settings::class)->name('settings');
        //Change Password Email
        Route::get('/change-password-email', \App\Http\Livewire\Back\ChangeAdminAuthEmailPassword::class)->name('change-password-email');

    });
});

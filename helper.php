<?php

use App\Models\Product;
use App\Models\Setting;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

function admin() {
    return Auth::guard('admin')->user();
}

function presentPrice(int $price)
{
    return '$' . number_format($price /100 , 2, '.', '');
}

function currency() {
    $settings = Setting::find(1);
    if($settings){
        return $settings->currency;
    }else{
        return '';
    }
}

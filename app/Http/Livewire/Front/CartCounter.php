<?php

namespace App\Http\Livewire\Front;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = ['cart_updated' => 'render'];

    public function render()
    {
        $cart_count = Cart::instance('default')->count();
        return view('livewire.front.cart-counter', compact('cart_count'));
    }
}

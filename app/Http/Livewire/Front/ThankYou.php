<?php

namespace App\Http\Livewire\Front;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ThankYou extends Component
{
    public function verifyCheckoutDone()
    {
        if(! session()->get('checkoutDone')){
            return redirect()->route('shop.index');
        }
    }
    public function render()
    {
        $this->verifyCheckoutDone();
        session()->forget('checkoutDone');
        return view('livewire.front.thank-you')->layout('front-end.layout.app', ['title' => 'Thank You | E-Commerce']);
    }
}

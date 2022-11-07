<?php

namespace App\Http\Livewire\Front;

use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $selectedProduct;
    public array $quantity = [];
    public $haveCoupon;
    public $couponCode;
    public $discount;
    public $subtotalAfterDiscount;
    public $taxAfterDiscount;
    public $totalAfterDiscount;
    public $dAttribute = [];

    public function mount()
    {
        $cartContent = Cart::instance('default')->content();
        foreach ($cartContent as $index => $item){
            $this->quantity[$index] = $item->qty != '1' ? $item->qty : '1';
        }

    }

    public function selectProduct($productID)
    {
        $this->selectedProduct = Product::find($productID);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) {
            return $cartItem->id === $this->selectedProduct->id;
        });

        if($this->selectedProduct->sale_price > 0){
            $price = $this->selectedProduct->sale_price;
        }else{
            $price = $this->selectedProduct->regular_price;
        }

        $attributesNames = [];
        $attributesValues = [];
        foreach($this->selectedProduct->attributeValues as $attr){
            array_push($attributesNames, $attr->productAttribute->name);
            array_push($attributesValues, $attr->value);
        };
        $this->dAttribute = array_combine($attributesNames, $attributesValues);

        if ($duplicates->isNotEmpty()) {
            $this->dispatchBrowserEvent("MsgWarning", [
                'title' => 'Item is already in your cart!',
            ]);
        } else {
            Cart::instance('default')->add($this->selectedProduct->id, $this->selectedProduct->name, 1, $price, $this->dAttribute)->associate('App\Models\Product');
            $this->emit('cart_updated');

            $this->dispatchBrowserEvent("MsgSuccess", [
                'title' => 'Item has been added to your cart Successfully!',
            ]);
        }
    }

    public function destroy($productId)
    {
        foreach (Cart::instance('default')->content() as $cartItem){
            if($productId === $cartItem->id){
                Cart::instance('default')->remove($cartItem->rowId);
                $this->dispatchBrowserEvent("MsgSuccess", [
                    'title' => 'Item has been removed from your cart Successfully!'
                ]);
                $this->emit('cart_updated');
            }
        }
    }

    public function clearAllCart()
    {
        Cart::instance('default')->destroy();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'All cart items has been removed Successfully!'
        ]);
        $this->emit('cart_updated');
    }

    public function destroyCartItem($rowId)
    {
        Cart::instance('default')->remove($rowId);
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Item has been removed from your cart Successfully!'
        ]);
        $this->emit('cart_updated');
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('default')->get($id);
        Cart::instance('default')->remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function($cartItem, $rowId) use ($id){
            return $rowId === $id;
        });

        if($duplicates->isNotEmpty()){
            $this->dispatchBrowserEvent("MsgWarning", [
                'title' => 'Item is already saved for later!',
            ]);
        }else{
            Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
            $this->dispatchBrowserEvent("MsgSuccess", [
                'title' => 'Item has been saved for later!',
            ]);
        }

        $this->emit('cart_updated');
    }

    public function destroyItemSavedForLater($rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Item has been removed from your saved for later list Successfully!'
        ]);
        $this->emit('cart_updated');
    }

    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);

        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use ($id){
            return $rowId === $id;
        });

        if($duplicates->isNotEmpty()){
            $this->dispatchBrowserEvent("MsgWarning", [
                'title' => 'Item is already in your cart!',
            ]);
        }else{
            Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');

            $cartContent = Cart::instance('default')->content();
            foreach ($cartContent as $index => $item){
                $this->quantity[$index] = $item->qty != '1' ? $item->qty : '1';
            }

            $this->dispatchBrowserEvent("MsgSuccess", [
                'title' => 'Item has been moved to your cart successfully!',
            ]);
        }

        $this->emit('cart_updated');
    }

    public function updatedQuantity()
    {
        $rowIds = array_keys($this->quantity);
        foreach ($rowIds as $rowID){
            Cart::instance('default')->update($rowID, $this->quantity[$rowID]);
        }
        $this->emit('cart_updated');
    }

    public function applyCouponCode()
    {
        $coupon = Coupon::where('code', $this->couponCode)->where('expiry_date','>=', Carbon::today())->where('cart_value' , '<=', Cart::instance('default')->subtotal())->first();
        if(!$coupon)
        {
            session()->flash('coupon_message', 'Coupon Code Is Invalid!');
            return;
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);

        if(session()->get('coupon')['type'] == 'fixed')
        {
            $this->discount = session()->get('coupon')['value'];
        }else{
            $this->discount = (Cart::instance('default')->subtotal()*session()->get('coupon')['value'])/100;
        }
        $this->subtotalAfterDiscount = Cart::instance('default')->subtotal() - $this->discount;
        $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax'))/100;
        $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
    }

    public function calculateDiscount()
    {
        if(session()->get('coupon')['type'] == 'fixed')
        {
            $this->discount = session()->get('coupon')['value'];
        }else{
            $this->discount = (Cart::instance('default')->subtotal()*session()->get('coupon')['value'])/100;
        }
        $this->subtotalAfterDiscount = Cart::instance('default')->subtotal() - $this->discount;
        $this->taxAfterDiscount = ($this->subtotalAfterDiscount * config('cart.tax'))/100;
        $this->totalAfterDiscount = $this->subtotalAfterDiscount + $this->taxAfterDiscount;
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
    }

    public function checkout()
    {
        if(\Auth::check())
        {
            return redirect()->route('checkout');
        }else{
            return redirect()->route('login');
        }
    }

    public function setAmountForCheckout()
    {
        if(!Cart::instance('default')->count() > 0)
        {
            session()->forget('checkout');
            return;
        }

        if(session()->has('coupon'))
        {
            session()->put('checkout', [
                'discount' => $this->discount,
                'subtotal' => $this->subtotalAfterDiscount,
                'tax' => $this->taxAfterDiscount,
                'total' => $this->totalAfterDiscount
            ]);
        }else{
            session()->put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('default')->subtotal(),
                'tax' => Cart::instance('default')->tax(),
                'total' => Cart::instance('default')->total()
            ]);
        }
    }

    public function render()
    {
        if(\Auth::check())
        {
            Cart::instance('default')->store(\Auth::user()->email);
            Cart::instance('saveForLater')->store(\Auth::user()->email);
        }

        $cartProductsNames = array_keys(Cart::instance('default')->content()->groupBy('name')->toArray());
        $mightAlsoLike = Product::whereNotIn('name' , $cartProductsNames)->mightAlsoLike()->get();  //global scope in product model

        if(session()->has('coupon'))
        {
            if(Cart::instance('default')->subtotal() < session()->get('coupon')['cart_value'])
            {
                session()->forget('coupon');
            }else{
                $this->calculateDiscount();
            }
        }

        $this->setAmountForCheckout();

        return view('livewire.front.shopping-cart')->with([
            'mightAlsoLike' => $mightAlsoLike
        ])->layout('front-end.layout.app', ['title' => 'Shopping Cart | E-Commerce']);
    }
}

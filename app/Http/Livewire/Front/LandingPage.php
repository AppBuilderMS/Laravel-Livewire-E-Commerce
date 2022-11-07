<?php

namespace App\Http\Livewire\Front;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class LandingPage extends Component
{
    public $selectedProduct;

    public $filteredProducts;
    public $activeLatest = '';
    public $activeFeatured = '';
    public $activeOnSale = '';
    public $dAttribute = [];

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

    public function latest()
    {
        $this->filteredProducts = Product::orderBy('created_at', 'DESC')->limit(9)->get();
        $this->activeLatest = 'active';
        $this->activeFeatured = '';
        $this->activeOnSale = '';
    }

    public function featured()
    {
        $this->filteredProducts = Product::where('featured', 1)->orderBy('created_at', 'DESC')->limit(9)->get();
        $this->activeLatest = '';
        $this->activeFeatured = 'active';
        $this->activeOnSale = '';
    }

    public function onSale()
    {
        $this->filteredProducts = Product::where('sale_price', '>' , 0)->orderBy('created_at', 'DESC')->limit(9)->get();
        $this->activeLatest = '';
        $this->activeFeatured = '';
        $this->activeOnSale = 'active';
    }

    public function render()
    {
        if(\Auth::check())
        {
            Cart::instance('default')->restore(\Auth::user()->email);
            Cart::instance('saveForLater')->restore(\Auth::user()->email);
        }
        $randomProducts = Product::inRandomOrder()->limit(9)->get();

        return view('livewire.front.landing-page')->with([
            'products' => $this->filteredProducts ?? $randomProducts
        ])->layout('front-end.layout.app', ['title' => 'E-Commerce']);
    }
}

<?php

namespace App\Http\Livewire\Front;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use function PHPUnit\Framework\isEmpty;

class SingleProduct extends Component
{
    public $product;
    public $mightAlsoLike;
    public $popularProducts;
    public $selectedProduct;
    public $sAttribute = [];
    public $dAttribute = [];

    public $p_attributes;
    public $attribute_arr = [];
    public $attribute_values = [];

    public function mount($slug)
    {
        $cartProductsNames = array_keys(Cart::instance('default')->content()->groupBy('name')->toArray());
        $this->product = Product::where('slug', $slug)->firstOrFail();
        $this->mightAlsoLike = Product::where('slug', '!=', $slug)
            ->whereNotIn('name' , $cartProductsNames)
            ->mightAlsoLike()
            ->where('category_id', $this->product->category_id)
            ->get();
        $this->popularProducts = Product::inRandomOrder()->limit(4)->get();

        $this->p_attributes = ProductAttribute::all();
        $this->attribute_arr = array_unique($this->product->attributeValues()->where('product_id', $this->product->id)->pluck('product_attribute_id')->toArray());
        foreach ($this->attribute_arr as $a_rr)
        {
            $allAttributeValue = AttributeValue::where('product_id', $this->product->id)->where('product_attribute_id', $a_rr)->get()->pluck('value');
            $valueString = '';
            foreach ($allAttributeValue as $value)
            {
                $valueString = $valueString . $value . ',';
            }
            $this->attribute_values[$a_rr] = rtrim($valueString, ',');
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
            Cart::instance('default')->add($this->selectedProduct->id, $this->selectedProduct->name, 1, $price, $this->sAttribute ? $this->sAttribute : $this->dAttribute)->associate('App\Models\Product');
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

    public function render()
    {
        if(\Auth::check())
        {
            Cart::instance('default')->store(\Auth::user()->email);
            Cart::instance('saveForLater')->store(\Auth::user()->email);
        }
        return view('livewire.front.single-product')->layout('front-end.layout.app', ['title' => $this->product->slug.' | E-Commerce']);
    }
}

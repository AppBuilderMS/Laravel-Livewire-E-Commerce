<?php

namespace App\Http\Livewire\Front;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class Shop extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $selectedProduct;
    public $sorting;
    public $perPage;
    public $categories;
    public $selectedCategoryName;
    public $selectedCategory;
    public $selectedSubCategory;
    public $allProducts;
    public $search;
    public $min_price;
    public $max_price;
    public $dAttribute = [];

    protected $listeners = ['set-search-price' => 'setPriceSearch'];

    public function mount()
    {
        $this->sorting = 'default';
        $this->perPage = 12;
        $this->categories =Category::all();
        $this->allProducts = 'All Products';

        $this->search = '';

        $this->min_price = 1;
        $max_price = Product::max('regular_price');
        $this->max_price = $max_price;
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

    public function allProducts()
    {
        $this->selectedCategory = null;
        $this->selectedSubCategory = null;
        $this->selectedCategoryName =null;
        $this->allProducts = 'All Products';
    }

    public function byCategoryFilter($categoryId)
    {
        $this->selectedSubCategory = "";
        $this->selectedCategory = Category::where('id', $categoryId)->first();
        $this->selectedCategoryName = $this->selectedCategory->name;
        $this->resetPage();
    }

    public function bySubCategoryFilter($subcategoryId)
    {
        $this->selectedCategory = "";
        $this->selectedSubCategory = Subcategory::where('id', $subcategoryId)->first();
        $this->selectedCategoryName = $this->selectedSubCategory->name;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setPriceSearch($value)
    {
        $this->min_price = $value[0];
        $this->max_price = $value[1];
        $this->resetPage();
    }

    public function render()
    {
        if(\Auth::check())
        {
            Cart::instance('default')->store(\Auth::user()->email);
            Cart::instance('saveForLater')->store(\Auth::user()->email);
        }

        if($this->sorting == 'date'){
            if($this->selectedCategory) {
                $products = Product::with('category','subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('category_id', $this->selectedCategory->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($this->perPage);
            }elseif($this->selectedSubCategory){
                $products = Product::with('category','subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('subcategory_id', $this->selectedSubCategory->id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($this->perPage);
            }else{
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->orderBy('created_at', 'DESC')
                    ->paginate($this->perPage);
            }
        }elseif ($this->sorting == 'price'){
            if($this->selectedCategory){
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('category_id', $this->selectedCategory->id)
                    ->orderBy('regular_price', 'ASC')
                    ->paginate($this->perPage);
            }elseif($this->selectedSubCategory) {
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('subcategory_id', $this->selectedSubCategory->id)
                    ->orderBy('regular_price', 'ASC')
                    ->paginate($this->perPage);
            }else{
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->orderBy('regular_price', 'ASC')
                    ->paginate($this->perPage);
            }
        }elseif ($this->sorting == 'price-desc'){
            if($this->selectedCategory){
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('category_id', $this->selectedCategory->id)
                    ->orderBy('regular_price', 'DESC')
                    ->paginate($this->perPage);
            }elseif($this->selectedSubCategory) {
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('subcategory_id', $this->selectedSubCategory->id)
                    ->orderBy('regular_price', 'DESC')
                    ->paginate($this->perPage);
            }else{
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->orderBy('regular_price', 'DESC')
                    ->paginate($this->perPage);
            }
        }else{
            if($this->selectedCategory){
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('category_id', $this->selectedCategory->id)
                    ->paginate($this->perPage);
            }elseif($this->selectedSubCategory) {
                $products = Product::with('category', 'subcategory')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->where('subcategory_id', $this->selectedSubCategory->id)
                    ->paginate($this->perPage);
            }else{
                $products = Product::with('category')
                    ->whereBetween('regular_price', [$this->min_price, $this->max_price])
                    ->search(trim($this->search))
                    ->paginate($this->perPage);
            }
        }

        return view('livewire.front.shop')->with([
            'products' => $products,
        ])->layout('front-end.layout.app',['title' => 'Shop | E-Commerce']);
    }
}

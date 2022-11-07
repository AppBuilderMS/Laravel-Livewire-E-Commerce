<?php

namespace App\Http\Livewire\Back\Products;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $description;
    public $details;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $images;
    public $category_id;
    public $categories;
    public $subcategories;
    public $subcategory_id;

    public $p_attributes;
    public $attr;
    public $attr_inputs = [];
    public $attribute_arr = [];
    public $attribute_values;

    protected $rules = [
        'name' => 'required|unique:products,name',
        'slug' => 'required|unique:products,slug',
        'description' => 'required',
        'details' => 'required',
        'regular_price' => 'required|numeric',
//        'sale_price' => 'numeric',
        'SKU' => 'required',
        'stock_status' => 'required',
        'featured' => 'required',
        'quantity' => 'required|numeric',
        'image' => 'required|image',
        'category_id' => 'required',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:products,name',
            'slug' => 'required|unique:products,slug',
            'description' => 'required',
            'details' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => $this->sale_price ?'numeric': '',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|image',
            'category_id' => 'required',
        ]);
    }

    public function mount()
    {
        $this->categories = Category::with('products')->get();
        $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
        $this->p_attributes = ProductAttribute::all();
    }

    public function updatedCategoryId()
    {
        $this->subcategories = Subcategory::where('category_id', $this->category_id)->get();
    }

    public function add()
    {
        if (!in_array($this->attr, $this->attribute_arr))
        {
            array_push($this->attr_inputs, $this->attr);
            array_push($this->attribute_arr, $this->attr);
        }
    }

    public function remove($attr)
    {
        unset($this->attr_inputs[$attr]);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function store()
    {
        $this->validate();

        Image::make($this->image)->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/products/'.$this->image->hashName()));

        $product =Product::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'details' => $this->details,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'SKU' => $this->SKU,
            'stock_status' => $this->stock_status,
            'featured' => $this->featured,
            'quantity' => $this->quantity,
            'image' => $this->image->hashName(),
            'category_id' => $this->category_id,
        ]);

        if($this->images){
            $imagesNames = '';
            foreach ($this->images as $key => $image){
                $imgName = $key.$image->hashName();

                Image::make($image)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/products/'.$imgName));

                $imagesNames = $imagesNames . ',' . $imgName;
            }

            $product->update([
                'images' => $imagesNames
            ]);
        }

        if($this->subcategory_id){
            $product->update([
               'subcategory_id' => $this->subcategory_id
            ]);
        }

        foreach ($this->attribute_values as $key => $attribute_value)
        {
            $a_values = explode(",", $attribute_value);
            foreach ($a_values as $a_value){
                $attr_value = new AttributeValue();
                $attr_value->product_attribute_id = $key;
                $attr_value->value = $a_value;
                $attr_value->product_id = $product->id;
                $attr_value->save();
            }
        }

        return redirect(route('admin.products.index'))->with('success', 'Product has been added successfully!');
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Products', 'link' => route('admin.products.index')],
            ['name' => 'create new product'],
        ];
        return view('livewire.back.products.create-product')->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

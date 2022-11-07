<?php

namespace App\Http\Livewire\Back\Products;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
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
    public $category_id;
    public $categories;
    public $subcategories;
    public $subcategory_id;

    public $oldImage;
    public $newImage;

    public $oldImages;
    public $newImages;

    public $product_id;

    public $p_attributes;
    public $attr;
    public $attr_inputs = [];
    public $attribute_arr = [];
    public $attribute_values = [];

    protected $listeners = ['setDetails'];

    public function mount($product_slug)
    {
        $this->categories = Category::with('products')->get();


        $product = Product::where('slug',$product_slug)->first();
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->details = $product->details;
        $this->regular_price = $product->regular_price;
        $this->sale_price = $product->sale_price;
        $this->SKU = $product->SKU;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->oldImage = $product->image;
        $this->oldImages = $product->images;
        $this->category_id = $product->category_id;
        $this->subcategory_id = $product->subcategory_id;
        $this->subcategories = $product->category->subcategories;
        $this->product_id = $product->id;


        $this->p_attributes = ProductAttribute::all();
        $this->attr_inputs = array_unique($product->attributeValues()->where('product_id', $product->id)->pluck('product_attribute_id')->toArray());
        $this->attribute_arr = array_unique($product->attributeValues()->where('product_id', $product->id)->pluck('product_attribute_id')->toArray());
        foreach ($this->attribute_arr as $a_rr)
        {
            $allAttributeValue = AttributeValue::where('product_id', $product->id)->where('product_attribute_id', $a_rr)->get()->pluck('value');
            $valueString = '';
            foreach ($allAttributeValue as $value)
            {
                $valueString = $valueString . $value . ',';
            }
            $this->attribute_values[$a_rr] = rtrim($valueString, ',');
        }
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

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => ['required', Rule::unique('products','name')->ignore($this->product_id)],
            'slug' => ['required', Rule::unique('products','slug')->ignore($this->product_id)],
            'description' => 'required',
            'details' => 'required|min:20',
            'regular_price' => 'required|numeric',
            'sale_price' => $this->sale_price ?'numeric': '',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|numeric',
            'newImage' => $this->newImage ? 'required|image' : '',
            'newImages' => $this->newImages ? 'required' : '',
            'category_id' => 'required',
        ]);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function setDetails($value)
    {
        $this->details = $value;
    }

    public function update()
    {

        $validatedData = $this->validate([
            'name' => ['required', Rule::unique('products','name')->ignore($this->product_id)],
            'slug' => ['required', Rule::unique('products','slug')->ignore($this->product_id)],
            'description' => 'required',
            'details' => 'required|min:20',
            'regular_price' => 'required|numeric',
            'sale_price' => $this->sale_price ?'numeric': '',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required|numeric',
            'newImage' => $this->newImage ? 'required|image' : '',
            'newImages' => $this->newImages ? 'required' : '',
            'category_id' => 'required',
        ]);

        if($this->newImage){
            //delete old image
            if($this->newImage != 'default.png'){
                Storage::disk('public_uploads')->delete('/products/'.$this->oldImage);
            }
            //create new image
            Image::make($this->newImage)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products/'.$this->newImage->hashName()));
        }

        $product = Product::findOrFail($this->product_id);
        if($this->newImages){

            if($product->images){
                $images = explode(",", $product->images);
                foreach ($images as $image){
                    if($image){
                        Storage::disk('public_uploads')->delete('/products/'.$image);
                    }
                }
            }

            $imagesNames = '';
            foreach ($this->newImages as $key => $image){
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

        $product->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'details' =>$this->details,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'SKU' => $this->SKU,
            'stock_status' => $this->stock_status,
            'featured' => $this->featured,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id ? $this->subcategory_id : null,
            'image' => $this->newImage ? $this->newImage->hashName() : $this->oldImage
        ]);

        AttributeValue::where('product_id', $product->id)->delete();
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

        return redirect(route('admin.products.index'))->with('success', 'Product has been updated successfully!');
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Products', 'link' => route('admin.products.index')],
            ['name' => 'Update Product'],
        ];
        return view('livewire.back.products.edit-product')->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

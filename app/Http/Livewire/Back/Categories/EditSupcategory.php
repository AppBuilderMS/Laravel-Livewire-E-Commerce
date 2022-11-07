<?php

namespace App\Http\Livewire\Back\Categories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditSupcategory extends Component
{
    public $name;
    public $slug;
    public $category_id;
    public $subCategory_id;

    protected $listeners = [
        'forceCloseModal',
        'sendSubCategoryId'
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => ['required', Rule::unique('categories','name')->ignore($this->category_id)],
            'slug' => ['required', Rule::unique('categories','slug')->ignore($this->category_id)]
        ]);
    }

    public function sendSubCategoryId($value)
    {
        $this->subCategory_id = $value;
        $subCategory = Subcategory::findOrFail($this->subCategory_id);
        $this->name = $subCategory->name;
        $this->slug = $subCategory->slug;
        $this->category_id = $subCategory->category_id;

    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => ['required', Rule::unique('subcategories','name')->ignore($this->subCategory_id)],
            'slug' => ['required', Rule::unique('subcategories','slug')->ignore($this->subCategory_id)],
            'category_id' => ''
        ]);
        $subCategory = Subcategory::findOrFail($this->subCategory_id);

        if ($this->category_id){
            $subCategory->update($validatedData);
        }else{
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
            $subCategory->delete();
        }

        $this->emit('refreshParent');
        $this->formReset();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'SubCategory has been updated successfully!',
        ]);
    }

    public function forceCloseModal()
    {
        $this->name = '';
        $this->slug = '';
        $this->category_id = '';
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function formReset()
    {
        $this->name = '';
        $this->slug = '';
        $this->category_id = '';
        $this->dispatchBrowserEvent('closeModal');
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.back.categories.edit-supcategory', ['categories' => $categories]);
    }
}

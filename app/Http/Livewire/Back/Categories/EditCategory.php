<?php

namespace App\Http\Livewire\Back\Categories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditCategory extends Component
{
    public $name;
    public $slug;
    public $category_id;
    public $parent_category_id = null;

    protected $listeners = [
        'forceCloseModal',
        'sendCategoryId'
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => ['required', Rule::unique('categories','name')->ignore($this->category_id)],
            'slug' => ['required', Rule::unique('categories','slug')->ignore($this->category_id)]
        ]);
    }

    public function sendCategoryId($value)
    {
        $this->category_id = $value;
        $category = Category::findOrFail($this->category_id);
        $this->name = $category->name;
        $this->slug = $category->slug;

    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => ['required', Rule::unique('categories','name')->ignore($this->category_id)],
            'slug' => ['required', Rule::unique('categories','slug')->ignore($this->category_id)]
        ]);
        $category = Category::findOrFail($this->category_id);

        if($this->parent_category_id){
            if(! $category->subcategories){
                $category->delete();
                Subcategory::create([
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'category_id' => $this->parent_category_id
                ]);
                $this->emit('refreshParent');
                $this->formReset();
                $this->dispatchBrowserEvent("MsgSuccess", [
                    'title' => 'Category has been updated to be Subcategory successfully!',
                ]);
            }else{
                $this->dispatchBrowserEvent("MsgWarning", [
                    'title' => "This category have subcategories and can't be Subcategory",
                ]);
            }
        }else{
            $category->update($validatedData);
            $this->emit('refreshParent');
            $this->formReset();
            $this->dispatchBrowserEvent("MsgSuccess", [
                'title' => 'Category has been updated successfully!',
            ]);
        }

    }

    public function forceCloseModal()
    {
        $this->name = '';
        $this->slug = '';
        $this->parent_category_id = '';
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function formReset()
    {
        $this->name = '';
        $this->slug = '';
        $this->parent_category_id = '';
        $this->dispatchBrowserEvent('closeModal');
    }
    public function render()
    {
        $categories = Category::all();
        return view('livewire.back.categories.edit-category', ['categories' => $categories]);
    }
}

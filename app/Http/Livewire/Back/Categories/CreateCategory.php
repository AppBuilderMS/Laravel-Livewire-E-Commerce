<?php

namespace App\Http\Livewire\Back\Categories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateCategory extends Component
{
    public $name;
    public $slug;
    public $category_id;

    protected $listeners = [
        'forceCloseModal',
    ];

    protected $rules = [
        'name' => 'required|unique:categories,name',
        'slug' => 'required|unique:categories,slug',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
        ]);
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function forceCloseModal()
    {
        $this->name = '';
        $this->slug = '';
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function formReset()
    {
        $this->name = '';
        $this->slug = '';
        $this->dispatchBrowserEvent('closeModal');
    }

    public function store()
    {
        $this->validate();

        if($this->category_id) {
            Subcategory::create([
               'name' => $this->name,
               'slug' => $this->slug,
               'category_id' => $this->category_id
            ]);
        }else{
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug
            ]);
        }
        $this->formReset();
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Category has been added successfully!',
        ]);
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.back.categories.create-category', ['categories' => $categories]);
    }
}

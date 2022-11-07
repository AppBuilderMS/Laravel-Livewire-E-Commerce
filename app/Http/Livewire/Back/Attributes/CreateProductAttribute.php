<?php

namespace App\Http\Livewire\Back\Attributes;

use App\Models\ProductAttribute;
use Livewire\Component;

class CreateProductAttribute extends Component
{
    public $name;

    protected $listeners = [
        'forceCloseModal',
    ];

    protected $rules = [
        'name' => 'required|unique:product_attributes,name',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|unique:product_attributes,name',
        ]);
    }

    public function forceCloseModal()
    {
        $this->restInputs();
        //they clear the error bag.
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function formReset()
    {
        $this->restInputs();
        $this->dispatchBrowserEvent('closeModal');
    }

    public function restInputs()
    {
        $this->name = '';
    }

    public function store()
    {
        $this->validate();
        ProductAttribute::create([
            'name' => $this->name,
        ]);
        $this->formReset();
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Attribute has been added successfully!',
        ]);
    }
    public function render()
    {
        return view('livewire.back.attributes.create-product-attribute');
    }
}

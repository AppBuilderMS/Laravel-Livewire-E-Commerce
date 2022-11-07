<?php

namespace App\Http\Livewire\Back\Attributes;

use App\Models\Coupon;
use App\Models\ProductAttribute;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditProductAttribute extends Component
{
    public $name;

    public $attribute_id;

    protected $listeners = [
        'forceCloseModal',
        'sendAttributeId'
    ];

    public function sendAttributeId($value)
    {
        $this->attribute_id = $value;
        $attribute = ProductAttribute::findOrFail($this->attribute_id);
        $this->name = $attribute->name;
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => ['required', Rule::unique('product_attributes','name')->ignore($this->attribute_id)],
        ]);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => ['required', Rule::unique('product_attributes','name')->ignore($this->attribute_id)],
        ]);
        $attribute = ProductAttribute::findOrFail($this->attribute_id);
        $attribute->update($validatedData);
        $this->emit('refreshParent');
        $this->formReset();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Attribute has been updated successfully!',
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

    public function render()
    {
        return view('livewire.back.attributes.edit-product-attribute');
    }
}

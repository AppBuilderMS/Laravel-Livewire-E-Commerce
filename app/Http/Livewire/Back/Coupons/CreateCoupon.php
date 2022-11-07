<?php

namespace App\Http\Livewire\Back\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class CreateCoupon extends Component
{
    public $code;
    public $type;
    public $value;
    public $cart_value;
    public $expiry_date;

    protected $listeners = [
        'forceCloseModal',
    ];

    protected $rules = [
        'code' => 'required|unique:coupons,code',
        'type' => 'required',
        'value' => 'required|numeric',
        'cart_value' => 'required|numeric',
        'expiry_date' => 'required|date',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
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
        $this->code = '';
        $this->type = '';
        $this->value = '';
        $this->cart_value = '';
        $this->expiry_date = '';
    }

    public function store()
    {
        $this->validate();
        Coupon::create([
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'cart_value' => $this->cart_value,
            'expiry_date' => $this->expiry_date
        ]);
        $this->formReset();
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Coupon has been added successfully!',
        ]);
    }

    public function render()
    {
        return view('livewire.back.coupons.create-coupon');
    }
}

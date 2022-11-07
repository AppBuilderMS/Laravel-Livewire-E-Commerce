<?php

namespace App\Http\Livewire\Back\Coupons;

use App\Models\Coupon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditCoupon extends Component
{
    public $code;
    public $type;
    public $value;
    public $cart_value;
    public $expiry_date;

    public $coupon_id;

    protected $listeners = [
        'forceCloseModal',
        'sendCouponId'
    ];

    public function sendCouponId($value)
    {
        $this->coupon_id = $value;
        $coupon = Coupon::findOrFail($this->coupon_id);
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->cart_value = $coupon->cart_value;
        $this->expiry_date = $coupon->expiry_date;

    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'code' => ['required', Rule::unique('coupons','code')->ignore($this->coupon_id)],
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);
    }

    public function update()
    {
        $validatedData = $this->validate([
            'code' => ['required', Rule::unique('coupons','code')->ignore($this->coupon_id)],
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);
        $coupon = Coupon::findOrFail($this->coupon_id);
        $coupon->update($validatedData);
        $this->emit('refreshParent');
        $this->formReset();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Coupon has been updated successfully!',
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

    public function render()
    {
        return view('livewire.back.coupons.edit-coupon');
    }
}

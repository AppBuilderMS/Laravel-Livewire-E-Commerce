<?php

namespace App\Http\Livewire\Front;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserOrderDetails extends Component
{
    public $order_id;
    public function mount($order_id)
    {
        $this->order_id = $order_id;

    }

    public function cancelOrder()
    {
        $order = Order::findOrFail($this->order_id);
        $order->status = 'canceled';
        $order->canceled_date = DB::raw('CURRENT_DATE');
        $order->save();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Order status has been canceled successfully!',
        ]);
    }
    public function render()
    {
        $order = Order::findOrFail($this->order_id);
        return view('livewire.front.user-order-details',[
            'order' => $order
        ])->layout('front-end.layout.app', ['title' => 'Order # '.$order->id.' | E-Commerce']);
    }
}

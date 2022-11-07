<?php

namespace App\Http\Livewire\Back\Orders;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public $order_id;
    public function mount($order_id)
    {
        $this->order_id = $order_id;

    }
    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Orders', 'link' => route('admin.orders.index')],
            ['name' => 'Order # '.$this->order_id ],
        ];
        $order = Order::findOrFail($this->order_id);
        return view('livewire.back.orders.order-details',[
            'order' => $order
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

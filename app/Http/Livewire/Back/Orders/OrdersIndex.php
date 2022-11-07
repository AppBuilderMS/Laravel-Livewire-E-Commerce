<?php

namespace App\Http\Livewire\Back\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $search;

    public function mount()
    {
        $this->perPage = 10;
        $this->search = '';
    }

    public function sortBy($columnName)
    {
        if($this->sortColumnName === $columnName){
            $this->sortDirection = $this->swapSortDirection();
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function updateOrderStatus($order_id, $status)
    {
        $order = Order::findOrFail($order_id);
        $order->status = $status;
        if($status == 'delivered'){
            $order->delivered_date = DB::raw('CURRENT_DATE');
        }elseif ($status == 'canceled'){
            $order->canceled_date = DB::raw('CURRENT_DATE');
        }
        $order->save();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Order status has been updated successfully!',
        ]);
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Orders'],
        ];
        $orders = Order::search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.back.orders.orders-index')->with([
            'orders' => $orders,
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

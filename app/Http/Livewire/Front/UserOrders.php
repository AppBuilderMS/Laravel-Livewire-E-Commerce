<?php

namespace App\Http\Livewire\Front;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class UserOrders extends Component
{  use WithPagination;

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

    public function render()
    {
        $orders = Order::search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.front.user-orders',[
            'orders' => $orders
        ])->layout('front-end.layout.app', ['title' => 'My Orders | E-Commerce']);
    }
}

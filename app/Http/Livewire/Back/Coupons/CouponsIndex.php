<?php

namespace App\Http\Livewire\Back\Coupons;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class CouponsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $search;

    protected $listeners = [
        'confirmAction' => 'deleteCoupon',
        'CancelAction' => 'cancelDeleteCoupon',
        'refreshParent' => '$refresh'
    ];

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

    public function addNew()
    {
        $this->dispatchBrowserEvent('showCreateModal');
    }

    public function editItem($couponID)
    {
        $this->dispatchBrowserEvent('showEditModal');
        $this->emit('sendCouponId', $couponID);
    }

    public function confirmDelete($coupon_id, $coupon_code)
    {
        $this->dispatchBrowserEvent('MsgConfirmation', [
            'title' => "<span>Are you sure about delete coupon<span class='text-danger text-bold-600'>"." (".$coupon_code.") ?"."</span></span>",
            'id'    => $coupon_id
        ]);
    }

    public function deleteCoupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Coupon has been deleted successfully!',
        ]);
    }

    public function cancelDeleteCoupon($coupon_id)
    {
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgWarning", [
            'title' => "Coupon hasn't been deleted!",
        ]);
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Coupons'],
        ];
        $coupons = Coupon::search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.back.coupons.coupons-index')->with([
            'coupons' => $coupons
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

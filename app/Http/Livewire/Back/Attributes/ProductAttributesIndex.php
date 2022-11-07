<?php

namespace App\Http\Livewire\Back\Attributes;

use App\Models\ProductAttribute;
use Livewire\Component;
use Livewire\WithPagination;

class ProductAttributesIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $search;

    protected $listeners = [
        'confirmAction' => 'deleteAttribute',
        'CancelAction' => 'cancelDeleteAttribute',
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

    public function editItem($attributeID)
    {
        $this->dispatchBrowserEvent('showEditModal');
        $this->emit('sendAttributeId', $attributeID);
    }

    public function confirmDelete($attribute_id, $attribute_name)
    {
        $this->dispatchBrowserEvent('MsgConfirmation', [
            'title' => "<span>Are you sure about delete attribute<span class='text-danger text-bold-600'>"." (".$attribute_name.") ?"."</span></span>",
            'id'    => $attribute_id
        ]);
    }

    public function deleteAttribute($attribute_id)
    {
        $attribute = ProductAttribute::find($attribute_id);
        $attribute->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Attribute has been deleted successfully!',
        ]);
    }

    public function cancelDeleteAttribute($attribute_id)
    {
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgWarning", [
            'title' => "Attribute hasn't been deleted!",
        ]);
    }
    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Product Attributes'],
        ];
        $attributes = ProductAttribute::search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.back.attributes.product-attributes-index',[
            'attributes' => $attributes
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

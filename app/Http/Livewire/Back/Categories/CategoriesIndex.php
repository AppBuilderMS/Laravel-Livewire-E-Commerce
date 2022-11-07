<?php

namespace App\Http\Livewire\Back\Categories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $search;

    protected $listeners = [
        'confirmAction' => 'deleteCategory',
        'CancelAction' => 'cancelDeleteCategory',
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

    public function editItem($categoryID)
    {
        $this->dispatchBrowserEvent('showEditModal');
        $this->emit('sendCategoryId', $categoryID);
    }

    public function editSubCat($subcategoryID)
    {
        $this->dispatchBrowserEvent('showEditSubCatModal');
        $this->emit('sendSubCategoryId', $subcategoryID);
    }

    public function confirmDelete($category_id, $category_name)
    {
        $this->dispatchBrowserEvent('MsgConfirmation', [
            'title' => "<span>Are you sure about delete category<span class='text-danger text-bold-600'>"." (".$category_name.") ?"."</span></span>",
            'id'    => $category_id
        ]);
    }

    public function deleteCategory($category_id)
    {
        $category = Category::find($category_id);
        $category->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Category has been deleted successfully!',
        ]);
    }

    public function cancelDeleteCategory($category_id)
    {
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgWarning", [
            'title' => "Category hasn't been deleted!",
        ]);
    }

    public function deleteSubcategory($subcategoryID)
    {
        $subcategory = Subcategory::find($subcategoryID);
        $subcategory->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Subcategory has been deleted successfully!',
        ]);
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Categories'],
        ];

        $categories = Category::with('products', 'subcategories')
            ->search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.back.categories.categories-index')->with([
            'categories' => $categories,
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

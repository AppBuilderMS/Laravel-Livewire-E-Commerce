<?php

namespace App\Http\Livewire\Back\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $search;

    protected $listeners = [
        'confirmAction' => 'deleteProduct',
        'CancelAction' => 'cancelDeleteProduct',
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

    protected function cleanupOldUploads()
    {
        $storage = Storage::disk('public_uploads');
        foreach ($storage->allFiles('livewire-temp') as $filePathname) {
            $yesterdaysStamp = now()->subSeconds(4)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }

    public function confirmDelete($product_id, $product_name)
    {
        $this->dispatchBrowserEvent('MsgConfirmation', [
            'title' => "<span>Are you sure about delete product<span class='text-danger text-bold-600'>"." (".$product_name.") ?"."</span></span>",
            'id'    => $product_id
        ]);
    }

    public function deleteProduct($product_id)
    {
        $product = Product::find($product_id);
        if($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/products/'.$product->image);
        }
        if($product->images){
            $images = explode(",", $product->images);
            foreach ($images as $image){
                if($image){
                    Storage::disk('public_uploads')->delete('/products/'.$image);
                }
            }
        }
        $product->delete();
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgSuccess", [
            'title' => 'Product has been deleted successfully!',
        ]);
    }

    public function cancelDeleteProduct()
    {
        $this->resetPage();
        $this->dispatchBrowserEvent("MsgWarning", [
            'title' => "Product hasn't been deleted!",
        ]);
    }

    public function render()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'link' => route('admin.dashboard')],
            ['name' => 'Products'],
        ];
        $products = Product::with('category')
            ->search(trim($this->search))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.back.products.products-index')->with([
            'products' => $products,
        ])->layout('back-end.layout.app', ['breadcrumbs' => $breadcrumbs]);
    }
}

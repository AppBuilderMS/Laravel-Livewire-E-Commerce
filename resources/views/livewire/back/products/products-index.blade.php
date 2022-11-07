@push('styles')
    <style>
        .bb-solid{
            border-bottom: 1px solid #959595 !important
        }
        .table-bordered th.bt-solid {
            border-top: 1.02px solid #959595 !important
        }
        .text-muted{
            color: #979797 !important;
        }
        .sort-column i{
            font-weight: bold;
        }
    </style>
@endpush
<div>
    <h3 class="content-header-title mb-2">Products</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('admin.product.create')}}" class="btn btn-primary"><i class="feather icon-plus-circle mr-50"></i>Add Product</a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard table-responsive">
                        <!--Filters-->
                        <div class="d-flex justify-content-between">
                            <label for="" class="d-flex justify-content-start align-items-center">
                                <span class="mr-25">show</span>
                                <select name="" id="" class="custom-select custom-select-sm form-control form-control-sm" wire:model="perPage">
                                    <option value="{{10}}">10</option>
                                    <option value="{{25}}">25</option>
                                    <option value="{{50}}">50</option>
                                    <option value="{{100}}">100</option>
                                </select>
                                <span class="ml-25">entries</span>
                            </label>
                            <label class="d-flex justify-content-start align-items-center">
                                <span class="mr-25">Search:</span>
                                <input type="search" class="form-control form-control-sm" placeholder="" wire:model="search">
                            </label>
                        </div>

                        <!--Table-->
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr class="sort-column">
                                <th scope="col" class="bb-solid text-center">#</th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Id</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('id')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'id' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="">Image</span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Name</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('name')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                            </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Slug</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('slug')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'slug' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'slug' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Stock</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('stock_status')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'stock_status' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'stock_status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Price</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('regular_price')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'regular_price' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'regular_price' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Category</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('category_id')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'category_id' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'category_id' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Created At</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('created_at')">
                                                <i class="feather icon-arrow-up {{$sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                <i class="feather icon-arrow-down {{$sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($products->count() > 0)
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                    <td>{{$product->id}}</td>
                                    <td class="text-center"><img src="{{asset('uploads/products')}}/{{$product->image}}" width="60" class="img-thumbnail" alt="{{$product->name}}"></td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->slug}}</td>
                                    <td>
                                        @if($product->stock_status === 'instock')
                                            <span class="badge badge-success">{{$product->stock_status}}</span>
                                        @else
                                            <span class="badge badge-danger">{{$product->stock_status}}</span>
                                        @endif
                                    </td>
                                    <td>{{$product->presentPrice()}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{date_format($product->created_at ,'Y-m-d')}}</td>
                                    <td>
                                        <a href="{{route('admin.product.edit', $product->slug)}}"><i class="feather icon-edit-1"></i></a>
                                        <a href="#" wire:click.prevent="confirmDelete('{{$product->id}}', '{{$product->name}}')" class="mr-50 ml-50"><i class="feather icon-trash-2"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-warning text-center mb-0" role="alert">
                                            <strong>Warning!</strong> No data recorded yet.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="bt-solid text-center">#</th>
                                <th class="bt-solid">Id</th>
                                <th class="bt-solid">Image</th>
                                <th class="bt-solid">Name</th>
                                <th class="bt-solid">Slug</th>
                                <th class="bt-solid">Stock</th>
                                <th class="bt-solid">Price</th>
                                <th class="bt-solid">Category</th>
                                <th class="bt-solid">Created At</th>
                                <th class="bt-solid">Actions</th>
                            </tr>
                            </tfoot>
                        </table>

                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('showModal', event => {
            $('#addNewItem').modal('show');
        });

        //hide modal after save
        window.addEventListener("closeModal", event => {
            $('.closeModal').modal('hide');
        });
    </script>

    <script>
        @if (session()->has('success'))
            iziToast.success({
                title: 'OK',
                message: '{{ session('success') }}',
                position: 'topLeft',
            });
        @endif
    </script>
@endpush





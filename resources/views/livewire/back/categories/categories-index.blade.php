@push('styles')
    <style>
        .bb-solid{
            border-bottom: 1px solid #959595 !important
        }
        /*        .bt-solid{
                    border-top: 1.02px solid #959595 !important
                }*/
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
    <h3 class="content-header-title mb-2">Categories</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" wire:click.prevent="addNew"><i class="feather icon-plus-circle mr-50"></i>Add Category</a>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard  table-responsive">
                        <!--Filters-->
                        <div class="d-flex justify-content-between">
                            <label for="" class="d-flex justify-content-start align-items-center">
                                <span class="mr-25">show</span>
                                <select name="" id="" class="custom-select custom-select-sm form-control form-control-sm" wire:model="perPage">
                                    <option value="{{5}}">10</option>
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
                                <th scope="col" class="bb-solid text-center" width="5%">#</th>
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
                                        <span class="">Subcategories</span>
                                        <span class="cursor-pointer">
                                            <i class="feather icon-arrow-up text-muted"></i>
                                            <i class="feather icon-arrow-down text-muted"></i>
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="bb-solid">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($categories->count() > 0)
                                @foreach($categories as $category)
                                    <tr>
                                        <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->slug}}</td>
                                        <td>
                                            @if($category->subcategories->count() > 0)
                                                @foreach($category->subcategories as $subcategory)
                                                    <div class="btn-group mr-50">
                                                        <div class="badge badge-primary">
                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">{{$subcategory->name}}</a>
                                                            <div class="dropdown-menu">
                                                                <a href="#" wire:click.prevent="editSubCat('{{$subcategory->id}}')" class="dropdown-item"><i class="feather icon-edit primary"></i> Edit</a>
                                                                <a href="#" wire:click.prevent="deleteSubcategory('{{$subcategory->id}}')" onclick="confirm('Are you sure you want to delete subcategory ({{$subcategory->name}})') || event.stopImmediatePropagation()" class="dropdown-item">
                                                                    <i class="feather icon-delete primary"></i> Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="badge badge-warning">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" wire:click.prevent="editItem('{{$category->id}}')"><i class="feather icon-edit-1"></i></a>
                                            <a href="#" wire:click.prevent="confirmDelete('{{$category->id}}', '{{$category->name}}')" class="mr-50 ml-50"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
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
                                <th class="bt-solid">Category Name</th>
                                <th class="bt-solid">Slug</th>
                                <th class="bt-solid">Subcategories</th>
                                <th class="bt-solid">Actions</th>
                            </tr>
                            </tfoot>
                        </table>

                        {{$categories->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modals-->
    <!--Create Modal-->
    <div class="modal fade text-left closeModal" id="addNewItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Add New Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.categories.create-category')

            </div>
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade text-left closeModal" id="editItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Edit Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.categories.edit-category')

            </div>
        </div>
    </div>

    <!--Edit SubCat Modal-->
    <div class="modal fade text-left closeModal" id="editSubCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Edit SubCategory</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.categories.edit-supcategory')

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('showCreateModal', event => {
            $('#addNewItem').modal('show');
        });

        window.addEventListener('showEditModal', event => {
            $('#editItem').modal('show');
        });

        window.addEventListener('showEditSubCatModal', event => {
            $('#editSubCat').modal('show');
        });
    </script>
@endpush


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
    <h3 class="content-header-title mb-2">Product Attributes</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="#" class="btn btn-primary" wire:click.prevent="addNew"><i class="feather icon-plus-circle mr-50"></i>Add Attribute</a>
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
                            @if($attributes->count() > 0)
                                @foreach($attributes as $attribute)
                                    <tr>
                                        <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                        <td>{{$attribute->id}}</td>
                                        <td>{{$attribute->name}}</td>
                                        <td>{{$attribute->created_at}}</td>
                                        <td>
                                            <a href="#" wire:click.prevent="editItem('{{$attribute->id}}')"><i class="feather icon-edit-1"></i></a>
                                            <a href="#" wire:click.prevent="confirmDelete('{{$attribute->id}}', '{{$attribute->name}}')" class="mr-50 ml-50"><i class="feather icon-trash-2"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">
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
                                <th class="bt-solid">Name</th>
                                <th class="bt-solid">Created At</th>
                                <th class="bt-solid">Actions</th>
                            </tr>
                            </tfoot>

                        </table>

                        {{$attributes->links()}}
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
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Add New Attribute</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.attributes.create-product-attribute')

            </div>
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade text-left closeModal" id="editItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Edit Attribute</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.attributes.edit-product-attribute')

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
    </script>
@endpush




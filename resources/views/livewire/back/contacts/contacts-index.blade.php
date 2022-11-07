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
    <h3 class="content-header-title mb-2">Contacts</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

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
                        <table class="table table-striped table-bordered table-hover ">

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
                                        <span class="">Email</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('email')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'email' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'email' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Phone</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('phone')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'phone' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'phone' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Contact Date</span>
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
                            @if($contacts->count() > 0)
                                @foreach($contacts as $contact)
                                    <tr>
                                        <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                        <td>{{$contact->id}}</td>
                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->phone}}</td>
                                        <td>{{$contact->created_at->format('Y-m-d')}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="#" wire:click.prevent="showDetails('{{$contact->id}}')"><i class="feather icon-eye"></i> Details</a>
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
                                <th class="bt-solid">Name</th>
                                <th class="bt-solid">Email</th>
                                <th class="bt-solid">Phone</th>
                                <th class="bt-solid">Contact Date</th>
                                <th class="bt-solid">Actions</th>
                            </tr>
                            </tfoot>

                        </table>

                        {{$contacts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Modals-->
    <div class="modal fade text-left closeModal" id="messageDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success white">
                    <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-tree"></i> Message Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @livewire('back.contacts.contact-details')

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('showDetailsModal', event => {
            $('#messageDetails').modal('show');
        });
    </script>
@endpush



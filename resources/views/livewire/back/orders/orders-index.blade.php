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
    <h3 class="content-header-title mb-2">Orders</h3>
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
                                        <span class="">Total</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('total')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'total' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'total' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">First Name</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('first_name')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'first_name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'first_name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Last Name</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('last_name')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'last_name' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'last_name' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                        <span class="">Email</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('email')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'email' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'email' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Status</span>
                                        <span class="cursor-pointer" wire:click.prevent="sortBy('status')">
                                            <i class="feather icon-arrow-up {{$sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                            <i class="feather icon-arrow-down {{$sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="bb-solid">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="">Order Date</span>
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
                            @if($orders->count() > 0)
                                @foreach($orders as $order)
                                    <tr>
                                        <th scope="row" class="text-center">{{$loop->iteration}}</th>
                                        <td>{{$order->id}}</td>
                                        <td>$ {{$order->total}}</td>
                                        <td>{{$order->first_name}}</td>
                                        <td>{{$order->last_name}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>{{$order->email}}</td>
                                        @if($order->status == 'ordered')
                                            <td><span class="badge badge-warning">{{$order->status}}</span></td>
                                        @elseif($order->status == 'delivered')
                                            <td><span class="badge badge-success">{{$order->status}}</span></td>
                                        @elseif($order->status == 'canceled')
                                          <td><span class="badge badge-danger">{{$order->status}}</span></td>
                                        @endif
                                        <td>{{$order->created_at->format('Y-m-d')}}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{route('admin.order.details', $order->id)}}"><i class="feather icon-eye"></i> Details</a>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-toggle-on"></i> Status</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#" wire:click.prevent="updateOrderStatus({{$order->id}}, 'delivered')">Delivered</a>
                                                    <a class="dropdown-item" href="#" wire:click.prevent="updateOrderStatus({{$order->id}}, 'canceled')">Canceled</a>
                                                </div>
                                            </div>
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
                                <th class="bt-solid">total</th>
                                <th class="bt-solid">First Name</th>
                                <th class="bt-solid">Last Name</th>
                                <th class="bt-solid">Phone</th>
                                <th class="bt-solid">Email</th>
                                <th class="bt-solid">Status</th>
                                <th class="bt-solid">Order Date</th>
                                <th class="bt-solid">Actions</th>
                            </tr>
                            </tfoot>

                        </table>

                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
<div class="content-body">
    <!-- Stats -->
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-primary bg-darken-2">
                            <i class="icon-basket-loaded font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-primary white media-body">
                            <h5>Today Orders</h5>
                            <h5 class="text-bold-400 mb-0">{{$todaySales}} {{Str::plural('Order', $todaySales)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-danger bg-darken-2">
                            <i class="icon-wallet font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-danger white media-body">
                            <h5>Today Revenues</h5>
                            <h5 class="text-bold-400 mb-0">{{currency()}} {{$todayRevenue}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-warning bg-darken-2">
                            <i class="icon-basket-loaded font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-warning white media-body">
                            <h5>Total Orders</h5>
                            <h5 class="text-bold-400 mb-0">{{$totalSales}} {{Str::plural('Order', $totalSales)}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-success bg-darken-2">
                            <i class="icon-wallet font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-success white media-body">
                            <h5>Total Revenues</h5>
                            <h5 class="text-bold-400 mb-0">{{currency()}} {{$totalRevenue}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Stats -->


    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-blue-grey bg-lighten-3">
                        <h4 class="content-header-title mb-0">Latest Orders</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard table-responsive">

                            <!--Table-->
                            <table class="table table-striped table-bordered table-hover ">
                                <thead>
                                <tr class="sort-column">
                                    <th scope="col" class="bb-solid text-center">#</th>
                                    <th scope="col" class="bb-solid">
                                        Id
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Total
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        First Name
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Last Name
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Phone
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Email
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Status
                                    </th>
                                    <th scope="col" class="bb-solid">
                                        Order Date
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>

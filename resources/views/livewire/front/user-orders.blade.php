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
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">My Orders</h1>
                    <p class="lead-2 opacity-90 mt-6">Here your requested orders list</p>
                </div>
            </div>
        </div>
    </header><!-- /.header -->

    <!-- Breadcrumb -->
    <section class="d-lg-flex">
        <div class="container small-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0 pr-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="main-content">
        <div class="section bg-gray pt-7" style="min-height: 47vh">
            <div class="container">
                <div class="row ">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <!--Filters-->
                                <div class="d-flex justify-content-between">
                                    <label for="" class="d-flex justify-content-start align-items-center">
                                        <span class="mr-2">show</span>
                                        <select name="" id="" class="custom-select custom-select-sm form-control form-control-sm" wire:model="perPage">
                                            <option value="{{10}}">10</option>
                                            <option value="{{25}}">25</option>
                                            <option value="{{50}}">50</option>
                                            <option value="{{100}}">100</option>
                                        </select>
                                        <span class="ml-2">entries</span>
                                    </label>
                                    <label class="d-flex justify-content-start align-items-center">
                                        <span class="mr-2">Search:</span>
                                        <input type="search" class="form-control form-control-sm" placeholder="" wire:model="search">
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--Table-->
                                <table class="table table-striped table-bordered table-hover table-responsive-sm">

                                    <thead>
                                    <tr class="sort-column">
                                        <th scope="col" class="bb-solid text-center">#</th>
                                        <th scope="col" class="bb-solid">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="">Total</span>
                                                <span class="cursor-pointer" wire:click.prevent="sortBy('total')" style="font-size: 10px">
                                                    <i class="ti-arrow-up {{$sortColumnName === 'total' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                    <i class="ti-arrow-down {{$sortColumnName === 'total' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </div>
                                        </th>
                                        <th scope="col" class="bb-solid">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="">Status</span>
                                                <span class="cursor-pointer" wire:click.prevent="sortBy('status')" style="font-size: 10px">
                                                    <i class="ti-arrow-up {{$sortColumnName === 'status' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                    <i class="ti-arrow-down {{$sortColumnName === 'status' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
                                                </span>
                                            </div>
                                        </th>
                                        <th scope="col" class="bb-solid">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="">Order Date</span>
                                                <span class="cursor-pointer" wire:click.prevent="sortBy('created_at')" style="font-size: 10px">
                                                    <i class="ti-arrow-up {{$sortColumnName === 'created_at' && $sortDirection === 'asc' ? '' : 'text-muted'}}"></i>
                                                    <i class="ti-arrow-down {{$sortColumnName === 'created_at' && $sortDirection === 'desc' ? '' : 'text-muted'}}"></i>
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
                                                <td>$ {{$order->total}}</td>
                                                @if($order->status == 'ordered')
                                                    <td><span class="badge badge-warning">{{$order->status}}</span></td>
                                                @elseif($order->status == 'delivered')
                                                    <td><span class="badge badge-success">{{$order->status}}</span></td>
                                                @elseif($order->status == 'canceled')
                                                    <td><span class="badge badge-danger">{{$order->status}}</span></td>
                                                @endif
                                                <td>{{$order->created_at->format('Y-m-d')}}</td>
                                                <td>
                                                    <a class="btn-link" href="{{route('user_order.details', $order->id)}}"><i class="ti-eye"></i> Details</a>
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
                                        <th class="bt-solid">total</th>
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
    </main>
</div>

@push('scripts')
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

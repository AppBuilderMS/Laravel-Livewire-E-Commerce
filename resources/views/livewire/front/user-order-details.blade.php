@push('styles')
    <style>
        .v-middle{
            vertical-align: middle !important;
        }
    </style>
@endpush
<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">Order ID # {{$order->id}}</h1>
                    <p class="lead-2 opacity-90 mt-6">Here your order ID # {{$order->id}} details</p>
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
                    <li class="breadcrumb-item"><a href="{{route('user_orders.index')}}">My Orders</a></li>
                    <li class="breadcrumb-item">Order ID # {{$order->id}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="main-content">
        <div class="section bg-gray pt-7">
            <div class="container">

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-white mb-0">Order Details</h4>
                                @if($order->status == 'ordered')
                                    <a href="#" class="btn btn-warning" wire:click.prevent="cancelOrder">Cancel Order</a>
                                @endif
                            </div>

                            <div class="card-body">
                                <table class="table table-striped table-bordered table-hover table-responsive-sm">
                                    <tr>
                                        <th>Order ID</th>
                                        <td>{{$order->id}}</td>
                                        <th>Order Date</th>
                                        <td>{{$order->created_at}}</td>
                                        <th>Order Status</th>
                                        <td>{{$order->status}}</td>
                                        @if($order->status == 'delivered')
                                            <th>Delivery Date</th>
                                            <td>{{$order->delivered_date}}</td>
                                        @elseif($order->status == 'canceled')
                                            <th>Cancellation Date</th>
                                            <td>{{$order->canceled_date}}</td>
                                        @endif
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white mb-0">Ordered Items</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-12">
                                        <table class="table table-striped table-bordered table-hover table-responsive-sm">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Options</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                                <th>Review</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->orderItems as $item)
                                                <tr>
                                                    <th scope="row" class="text-center v-middle">{{$loop->iteration}}</th>
                                                    <td class="v-middle">
                                                        <img width="60" class="img-thumbnail" src="{{asset('uploads/products/')}}/{{$item->product->image}}" alt="{{$item->product->name}}">
                                                    </td>
                                                    <td class="v-middle" width="20%"><a href="{{route('product.show', $item->product->slug)}}" class="btn-link">{{$item->product->name}}</a></td>
                                                    <td class="v-middle">
                                                        @if($item->options)
                                                            @foreach(unserialize($item->options) as $key => $value)
                                                                <div>
                                                                    <label>{{$key}}</label>: <p style="display: inline">{{$value}}</p>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <span>None</span>
                                                        @endif
                                                    </td>
                                                    <td class="v-middle">{{$item->quantity}}</td>
                                                    <td class="v-middle">$ {{$item->price}}</td>
                                                    <td class="v-middle">$ {{$item->price * $item->quantity}}</td>
                                                    @if($order->status == 'delivered' && $item->rstatus == false)
                                                        <td class="v-middle">
                                                            <a href="{{route('user_review', $item->id)}}">Write Review</a>
                                                        </td>
                                                    @else
                                                        <td class="v-middle">
                                                            <a aria-disabled="true" role="link" style="text-decoration: line-through">Write Review</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-xl-3 col-lg-12">
                                        <div class="d-flex justify-content-between p-1">
                                            <div>
                                                <h6 class="mb-2 font-weight-bold">Subtotal</h6>
                                                <h6 class="mb-2 font-weight-bold">Discount</h6>
                                                <h6 class="mb-2 font-weight-bold">Tax</h6>
                                                <h6 class="font-weight-bold">Shipping</h6>
                                            </div>
                                            <div class="text-right">
                                                <h6 class="mb-2 font-weight-bold">{{currency()}} {{$order->subtotal}}</h6>
                                                <h6 class="mb-2 font-weight-bold">{{currency()}} {{$order->discount}}</h6>
                                                <h6 class="mb-2 font-weight-bold">{{currency()}} {{$order->tax}}</h6>
                                                <h6 class="font-weight-bold">Free</h6>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between bg-secondary p-1 align-items-center">
                                            <h5 class="font-weight-bold mb-0">Total</h5>
                                            <h5 class="font-weight-bold mb-0">{{currency()}} {{$order->total}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white mb-0">Billing Details</h4>
                            </div>

                            <div class="card-body">
                                    <table class="table table-striped table-bordered table-hover table-responsive-sm">
                                        <tr>
                                            <th>First Name</th>
                                            <td>{{$order->first_name}}</td>
                                            <th>Last Name</th>
                                            <td>{{$order->last_name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{$order->email}}</td>
                                            <th>Phone</th>
                                            <td>{{$order->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Line 1</th>
                                            <td>{{$order->line1}}</td>
                                            <th>Line 2</th>
                                            <td>{{$order->line2}}</td>
                                        </tr>
                                        <tr>
                                            <th>City</th>
                                            <td>{{$order->city}}</td>
                                            <th>Province</th>
                                            <td>{{$order->province}}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{$order->country}}</td>
                                            <th>Zipcode</th>
                                            <td>{{$order->zipcode}}</td>
                                        </tr>
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>

                @if($order->is_shipping_different)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white mb-0">Shipping Details</h4>
                                </div>

                                <div class="card-body">
                                        <table class="table table-striped table-bordered table-hover table-responsive-sm">
                                            <tr>
                                                <th>First Name</th>
                                                <td>{{$order->shipping->first_name}}</td>
                                                <th>Last Name</th>
                                                <td>{{$order->shipping->last_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{$order->shipping->email}}</td>
                                                <th>Phone</th>
                                                <td>{{$order->shipping->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>Line 1</th>
                                                <td>{{$order->shipping->line1}}</td>
                                                <th>Line 2</th>
                                                <td>{{$order->shipping->line2}}</td>
                                            </tr>
                                            <tr>
                                                <th>City</th>
                                                <td>{{$order->shipping->city}}</td>
                                                <th>Province</th>
                                                <td>{{$order->shipping->province}}</td>
                                            </tr>
                                            <tr>
                                                <th>Country</th>
                                                <td>{{$order->shipping->country}}</td>
                                                <th>Zipcode</th>
                                                <td>{{$order->shipping->zipcode}}</td>
                                            </tr>
                                        </table>
                                    </div>

                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white mb-0">Transaction Details</h4>
                            </div>

                            <div class="card-body">
                                    <table class="table table-striped table-bordered table-hover table-responsive-sm">
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{$order->transaction->payment_method}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{$order->transaction->status}}</td>
                                        </tr>
                                        <tr>
                                            <th>Transaction Date</th>
                                            <td>{{$order->transaction->created_at}}</td>
                                        </tr>
                                    </table>
                                </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</div>

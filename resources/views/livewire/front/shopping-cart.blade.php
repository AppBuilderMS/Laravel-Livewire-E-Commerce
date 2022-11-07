@push('styles')
    <style>
        .hidden{
            display: none !important;
        }
    </style>
@endpush
<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <h1 class="display-4">Cart Overview</h1>
                    <p class="lead-2 opacity-90 mt-6">Take a look inside your cart. Make sure you have everything you needed.</p>

                </div>
            </div>
        </div>
    </header><!-- /.header -->

    <!-- Breadcrumb -->
    <section class="d-lg-flex bg-gray">
        <div class="container small-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0 pr-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">

        <section class="section">
            <div class="container">
                @include('front-end.partials._messages')

                <!--Items Selected-->
                @if(\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->count() > 0)

                    <h3>{{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->count()}} {{\Illuminate\Support\Str::plural('item', \Gloudemans\Shoppingcart\Facades\Cart::instance('default')->count())}} in Shopping Cart</h3>
                    <div class="row gap-y">
                        <div class="col-lg-8">
                            <table class="table table-cart">
                                <tbody valign="middle">
                                <!--start of cart-items-->
                                @foreach(\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->content() as $item)
                                    <tr>
                                        <td width="5%">
                                            <a class="item-remove" href="#" title="Remove" wire:click.prevent="destroyCartItem('{{$item->rowId}}')"><i class="ti-close"></i></a>

                                            <a class="item-save d-block" href="#" title="Save for later" wire:click.prevent="switchToSaveForLater('{{$item->rowId}}')"><i class="ti-save"></i></a>
                                        </td>

                                        <td width="15%">
                                            <a href="{{route('product.show', $item->model->slug)}}">
                                                <img class="rounded" src="{{'uploads/products/'.$item->model->image}}" alt="...">
                                            </a>
                                        </td>

                                        <td width="25%">
                                            <a href="{{route('product.show', $item->model->slug)}}">
                                                <h5>{{$item->model->name}}</h5>
                                                <p>{{Str::words($item->model->description, 3)}}</p>
                                            </a>
                                        </td>

                                        <td width="20%">
                                            @foreach($item->options as $key => $value)
                                                <div>
                                                    <label>{{$key}}</label>: <p style="display: inline">{{$value}}</p>
                                                </div>
                                            @endforeach
                                                <label for=""><a href="{{route('product.show', $item->model->slug)}}">Change</a></label>
                                        </td>

                                        <td width="10%">
                                            <label>Quantity</label>
                                            <input wire:model="quantity.{{$item->rowId}}" class="form-control form-control-sm" type="number">
                                        </td>

                                        <td>
                                            <h4 class="price">{{currency()}} {{$item->subtotal()}}</h4>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!--Coupon-->
                            <div class="d-flex justify-content-between align-items-center">
                                @if(!Session::has('coupon'))
                                    <label>
                                        <span>Do You Have Coupon Code?</span>
                                        <input class="ml-1" type="checkbox" value="1" wire:model="haveCoupon">
                                        <span>Yes</span>
                                    </label>
                                @endif
                                <a href="#" class="text-danger btn-link" wire:click.prevent="clearAllCart">Clear All</a>
                            </div>
                            @if(!Session::has('coupon') && $haveCoupon == 1)
                                @if(Session::has('coupon_message'))
                                    <div class="alert alert-danger" role="alert">{{Session::get('coupon_message')}}</div>
                                @endif
                                <form class="d-flex justify-content-start" wire:submit.prevent="applyCouponCode">
                                    <div class="form-group">
                                        <input type="text" class="form-control w-250 mb-2 mr-sm-2" placeholder="Enter Your Coupon Code Here..." wire:model="couponCode">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary mb-2">Apply <i class="ti-angle-right fs-9"></i></button>
                                    </div>
                                </form>
                            @endif
                        </div>


                        <!--Cart Totals-->
                        <div class="col-lg-4">

                            @if(Session::has('coupon'))
                            <div class="cart-price">
                                <div class="flexbox">
                                    <div>
                                        <p><strong>Subtotal:</strong></p>
                                        <p><strong>Discount ({{Session::get('coupon')['code']}}):</strong> <i class="fa fa-times text-danger cursor-pointer" wire:click="removeCoupon"></i></p>
                                        <p><strong>Subtotal after discount:</strong></p>
                                        <p><strong>Tax ({{config('cart.tax')}}%) :</strong>
                                        <p><strong>Shipping :</strong></p>
                                    </div>

                                    <div>
                                        <p class="text-right">{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::subtotal()}}</p>
                                        <p class="text-right">{{currency()}} {{number_format($discount,2,'.','')}}</p>
                                        <p class="text-right">{{currency()}} {{number_format($subtotalAfterDiscount,2,'.','')}}</p>
                                        <p class="text-right">{{currency()}} {{number_format($taxAfterDiscount,2,'.','')}}</p>
                                        <p class="text-right">Free Shipping</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="flexbox">
                                    <div>
                                        <p><strong>Total:</strong></p>
                                    </div>

                                    <div>
                                        <p class="fw-600 text-right">{{currency()}} {{number_format($totalAfterDiscount,2,'.','')}}</p>
                                    </div>
                                </div>

                            </div>
                            @else
                            <div class="cart-price">
                                <div class="flexbox">
                                    <div>
                                        <p><strong>Subtotal:</strong></p>
                                        <p><strong>Tax ({{config('cart.tax')}}%) :</strong></p>
                                        <p><strong>Shipping :</strong></p>
                                    </div>

                                    <div>
                                        <p class="text-right">{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->subtotal()}}</p>
                                        <p class="text-right">{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->tax()}}</p>
                                        <p class="text-right">Free Shipping</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="flexbox">
                                    <div>
                                        <p><strong>Total:</strong></p>
                                    </div>

                                    <div>
                                        <p class="fw-600 text-right">{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->total()}}</p>
                                    </div>
                                </div>

                            </div>
                            @endif

                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-block btn-secondary" href="{{route('shop.index')}}">Shop more</a>
                                </div>

                                <div class="col-6">
                                    <a class="btn btn-block btn-primary" href="#" wire:click.prevent="checkout">Checkout <i class="ti-angle-right fs-9"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>

                @else
                    <h5 class="alert alert-warning">No items in your cart!</h5>
                    <a href="{{route('shop.index')}}" class="btn btn-outline-dark">Continue Shopping</a>
                @endif

                <hr>

                <!--Items Saved for later-->
                @if(\Gloudemans\Shoppingcart\Facades\Cart::instance('saveForLater')->count() > 0)
                    <div class="row gap-y">
                        <div class="col-lg-8">
                            <h3>{{\Gloudemans\Shoppingcart\Facades\Cart::instance('saveForLater')->count()}} {{\Illuminate\Support\Str::plural('item', \Gloudemans\Shoppingcart\Facades\Cart::instance('saveForLater')->count())}} saved for later</h3>
                            <table class="table table-cart">
                                <tbody valign="middle">
                                @foreach(\Gloudemans\Shoppingcart\Facades\Cart::instance('saveForLater')->content() as $item)
                                    <tr>
                                        <td>
                                            <a class="item-remove" href="#" title="Remove" wire:click.prevent="destroyItemSavedForLater('{{$item->rowId}}')">
                                                <i class="ti-close"></i>
                                            </a>

                                            <a class="item-save d-block" href="#" title="Move to cart" wire:click.prevent="switchToCart('{{$item->rowId}}')">
                                                <i class="ti-shopping-cart"></i>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{route('product.show', $item->model->slug)}}">
                                                <img class="rounded" src="{{'uploads/products/'.$item->model->image}}" alt="...">
                                            </a>
                                        </td>

                                        <td>
                                            <a href="{{route('product.show', $item->model->slug)}}">
                                                <h5>{{$item->model->name}}</h5>
                                                <p>{{Str::words($item->model->description, 5)}}</p>
                                            </a>
                                        </td>

                                        <td>
                                            <h4 class="price">{{currency()}} {{$item->subtotal()}}</h4>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <h5 class="alert alert-warning">You have no items saved for later</h5>
                @endif

            </div>
        </section>

        @include('front-end.partials._might-also-like')

    </main>
</div>

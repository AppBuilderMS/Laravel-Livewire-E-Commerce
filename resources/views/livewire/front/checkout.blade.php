@push('styles')
    <style>
        .form-control {
            border: 1px solid #b1b1b1 !important;
        }
    </style>
@endpush

<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <h1 class="display-4">Checkout</h1>
                    <p class="lead-2 opacity-90 mt-6">Seems you're done! Let us know where should we send your order.</p>

                </div>
            </div>
        </div>
    </header><!-- /.header -->

    <!-- Main Content -->
    <main class="main-content">

        <section class="section">
            <div class="container">

                <div class="row gap-y">
                    <div class="col-lg-8">
                        <!--Cart Items-->
                        <table class="table table-cart">
                            <tbody valign="middle">
                                @foreach(\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->content() as $item)
                                    <tr>
                                        <td width="25%">
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

                                        <td width="15%">
                                            @foreach($item->options as $key => $value)
                                                <div>
                                                    <label>{{$key}}</label>: <p style="display: inline">{{$value}}</p>
                                                </div>
                                            @endforeach
                                        </td>

                                        <td width="10%">
                                            <h4 class="quantity">{{$item->qty}}</h4>
                                        </td>

                                        <td>
                                            <h4 class="price">{{currency()}} {{$item->subtotal()}}</h4>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!--Cart Totals-->
                    <div class="col-lg-4">
                        <div class="cart-price">
                            <div class="flexbox">
                                <div>
                                    <p><strong>Subtotal:</strong></p>
                                    @if(Session::get('checkout')['discount'] > 0)
                                        <p><strong>Discount:</strong></p>
                                        <p><strong>Subtotal after discount:</strong></p>
                                        <p><strong>Tax:</strong></p>
                                        <p><strong>Shipping:</strong></p>
                                    @else
                                        <p><strong>Tax:</strong></p>
                                        <p><strong>Shipping:</strong></p>
                                    @endif
                                </div>

                                <div class="text-right">
                                    <p>{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->subtotal()}}</p>
                                    @if(Session::get('checkout')['discount'] > 0)
                                        <p>{{currency()}} {{Session::get('checkout')['discount']}}</p>
                                        <p>{{currency()}} {{Session::get('checkout')['subtotal']}}</p>
                                        <p>{{currency()}} {{Session::get('checkout')['tax']}}</p>
                                        <p>{{currency()}} 0.00</p>
                                    @else
                                        <p>{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->tax()}}</p>
                                        <p>{{currency()}} 0.00</p>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="flexbox">
                                <div>
                                    <p><strong>Total:</strong></p>
                                </div>

                                <div>
                                    @if(Session::get('checkout')['discount'] > 0)
                                        <p class="fw-600">{{currency()}} {{Session::get('checkout')['total']}}</p>
                                    @else
                                        <p>{{currency()}} {{\Gloudemans\Shoppingcart\Facades\Cart::instance('default')->total()}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-block btn-secondary" href="{{route('cart.index')}}">Revise Cart</a>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-8">


                <form wire:submit.prevent="proceed" onsubmit="$('#processing').show()">
                    <div class="row gap-y">
                        <div class="col-lg-8">
                            <!--Billing Details-->
                            <h5 class="mb-6">Billing details</h5>
                            <div class="form-row mb-6">
                                <div class="col-6 form-group mb-0">
                                    <label for="" class="require">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Your Name" wire:model="first_name">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-6 form-group mb-0">
                                    <label for="" class="require">Last Name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name"  placeholder="Last Name" wire:model="last_name">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <label for="" class="require">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Your Email Address" wire:model="email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group mb-0">
                                    <label for="" class="require">Line 1</label>
                                    <input class="form-control @error('line1') is-invalid @enderror" type="text" name="line1" placeholder="Your street and apartment number" wire:model="line1">
                                    @error('line1')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group mb-0">
                                    <label for="" >Line 2</label>
                                    <input class="form-control @error('line2') is-invalid @enderror" type="text" name="line2" placeholder="Your street and apartment number" wire:model="line2">
                                    @error('line2')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-0">
                                    <label for="" class="require">Country</label>
                                    <input class="form-control @error('country') is-invalid @enderror" type="text" name="country" placeholder="Your Country" wire:model="country">
                                    @error('country')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-0">
                                    <label for="" class="require">Town / City</label>
                                    <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" placeholder="Your City" wire:model="city">
                                    @error('city')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-0">
                                    <label for="" class="require">Province</label>
                                    <input class="form-control @error('province') is-invalid @enderror" type="text" name="province" placeholder="Your Province" wire:model="province">
                                    @error('province')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-0">
                                    <label for="" class="require">Postcode / ZIP</label>
                                    <input class="form-control @error('zipcode') is-invalid @enderror" type="text" name="zipcode"  placeholder="Your Postal Code/ Zipcode" wire:model="zipcode">
                                    @error('zipcode')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 form-group mb-0">
                                    <label for="" class="require">Phone Number</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" placeholder="Phone Number" wire:model="phone">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>


                            </div>

                            <label for="" class="mb-6">
                                <input type="checkbox" value="1" wire:model="ship_to_different">
                                <span>Ship to a different address</span>
                            </label>

                        @if($ship_to_different == 1)
                            <!--Another Shipping Addrerss-->
                                <h5 class="mb-6">Shipping to different address</h5>
                                <div class="form-row mb-6">
                                    <div class="col-6 form-group mb-0">
                                        <label for="" class="require">First Name</label>
                                        <input type="text" class="form-control @error('s_first_name') is-invalid @enderror" name="s_first_name" placeholder="Your Name" wire:model="s_first_name">
                                        @error('s_first_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-6 form-group mb-0">
                                        <label for="" class="require">Last Name</label>
                                        <input type="text" class="form-control @error('s_last_name') is-invalid @enderror" name="s_last_name"  placeholder="Last Name" wire:model="s_last_name">
                                        @error('s_last_name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-12 form-group mb-0">
                                        <label for="" class="require">Email</label>
                                        <input type="email" class="form-control @error('s_email') is-invalid @enderror" name="s_email" placeholder="Your Email Address" wire:model="s_email">
                                        @error('s_email')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-0">
                                        <label for="" class="require">Line 1</label>
                                        <input class="form-control @error('s_line1') is-invalid @enderror" type="text" name="s_line1" placeholder="Your street and apartment number" wire:model="s_line1">
                                        @error('s_line1')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-0">
                                        <label for="" >Line 2</label>
                                        <input class="form-control @error('s_line2') is-invalid @enderror" type="text" name="s_line2" placeholder="Your street and apartment number" wire:model="s_line2">
                                        @error('s_line2')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-0">
                                        <label for="" class="require">Country</label>
                                        <input class="form-control @error('s_country') is-invalid @enderror" type="text" name="s_country" placeholder="Your Country" wire:model="s_country">
                                        @error('s_country')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-0">
                                        <label for="" class="require">Town / City</label>
                                        <input class="form-control @error('s_city') is-invalid @enderror" type="text" name="s_city" placeholder="Your City" wire:model="s_city">
                                        @error('s_city')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-0">
                                        <label for="" class="require">Province</label>
                                        <input class="form-control @error('s_province') is-invalid @enderror" type="text" name="s_province" placeholder="Your Province" wire:model="s_province">
                                        @error('s_province')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-0">
                                        <label for="" class="require">Postcode / ZIP</label>
                                        <input class="form-control @error('s_zipcode') is-invalid @enderror" type="text" name="s_zipcode"  placeholder="Your Postal Code/ Zipcode" wire:model="s_zipcode">
                                        @error('s_zipcode')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-0">
                                        <label for="" class="require">Phone Number</label>
                                        <input class="form-control @error('s_phone') is-invalid @enderror" type="text" name="s_phone" placeholder="Phone Number" wire:model="s_phone">
                                        @error('s_phone')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="col-lg-4">
                            <div class="cart-price">
                                <div class="flex-box">
                                    <div class="mb-5">
                                        <h5 class="border-bottom">Shipping Method</h5>
                                        <div>Flat Rate</div>
                                        <div>Fixed {{currency()}}0</div>
                                    </div>

                                    <div class="mb-5">
                                        <h5 class="border-bottom">Payment Method</h5>
                                        <div class="mb-5">
                                            <div>
                                                <input type="radio" name="payment_method" value="cash" wire:model="payment_method">
                                                <label >Cash On Delivery</label>
                                            </div>

                                            <div>
                                                <input type="radio" name="payment_method" value="card" wire:model="payment_method">
                                                <label >Debit / Credit Card</label>

                                                @if($payment_method === 'card')
                                                    <div class="row">
                                                         @if(Session::has('stripe_error'))
                                                             <div class="alert alert-danger" role="alert">
                                                                 {{Session::get('stripe_error')}}
                                                             </div>
                                                         @endif
                                                        <div class="col-md-12 form-group">
                                                            <input class="form-control @error('card_number') is-invalid @enderror" type="text" name="card_number" placeholder="Card Number" wire:model="card_number">
                                                            @error('card_number')
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <input class="form-control @error('expiry_month') is-invalid @enderror" type="text" name="expiry_month" placeholder="Expiry Month (MM)" wire:model="expiry_month">
                                                            @error('expiry_month')
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <input class="form-control @error('expiry_year') is-invalid @enderror" type="text" name="expiry_year" placeholder="Expiry Year (YYYY)" wire:model="expiry_year">
                                                            @error('expiry_year')
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <input class="form-control @error('cvc') is-invalid @enderror" type="password" name="CVC" placeholder="CVC" wire:model="cvc">
                                                            @error('cvc')
                                                            <div class="invalid-feedback">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                            <div>
                                                <input type="radio" name="payment_method" value="paypal" wire:model="payment_method">
                                                <label >Paypal</label>
                                            </div>

                                            @error('payment_method')
                                                <small class="text-danger"><strong>{{ $message }}</strong></small>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    @if(Session::has('checkout'))
                                        <div class="flexbox">
                                            <div>
                                                <h4><strong>Grand Total:</strong></h4>
                                            </div>

                                            <div>
                                                <h4><strong>{{currency()}} {{Session::get('checkout')['total']}}</strong></h4>
                                            </div>
                                        </div>
                                    @endif

                                    <!--Spinner-->
                                    @if($errors->isEmpty())
                                        <div wire:ignore id="processing" style="font-size: 22px; margin-bottom: 20px; padding-left: 37px; color: green; display: none;" class="text-center">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                                            <span>Processing...</span>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-block btn-primary">Proceed  <i class="ti-angle-right fs-9"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </section>

    </main>
</div>

@push('styles')
    <style>
        .img-thumbnail {
            padding: 0.25rem;
            border-color: #dddddd !important;
            border-radius: 3px;
        }
        .img-thumbnail:hover{
            border-color: #00b5b8 !important;
        }
        .popular-desc{
            color: #333333 !important;
        }
        a.popular-desc:hover{
            color: #00b5b8 !important;
        }

        .form-control {
            border: 1px solid #b1b1b1 !important;
        }

        .c-badge{
            padding-top: 3px;
            padding-bottom: 4px;
            font-size: 11px;
        }
    </style>

@endpush
<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <h1 class="display-4">{{$product->name}}</h1>
                    <p class="lead-2 opacity-90 mt-6">{{$product->description}}</p>

                    @php
                        $avg_rating = 0;
                    @endphp
                    @foreach($product->orderItems->where('rstatus', 1) as $orderItem)
                        @php
                            $avg_rating = $avg_rating + $orderItem->review->rating
                        @endphp
                    @endforeach
                    @for($i=1;$i<=5;$i++)
                        <div class="rating rating-lg">
                        @if($i<=$avg_rating)
                                <label class="fa fa-star"></label>
                        @else
                                <label class="fa fa-star empty"></label>
                        @endif
                        </div>
                    @endfor

                    <span class="font-italic">({{$product->orderItems->where('rstatus', 1)->count()}} Reviews)</span>


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
                    <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Detail
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <section class="section">
            <div class="container">

                <div class="row">
                    <div class="col-md-6 ml-auto order-md-last mb-7 mb-md-0" wire:ignore>
                        <div data-provide="slider" data-arrows="true" style="text-align: center">
                            <div><img src="{{asset('uploads/products/'.$product->image)}}"></div>
                            @php
                                $images = explode(',', $product->images);
                            @endphp
                            @foreach($images as $image)
                                @if($image)
                                    <div><img src="{{asset('uploads/products/'.$image)}}" alt="{{$product->name}}"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>

{{--                    <div class="col-md-6 ml-auto order-md-last mb-7 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center w-100 h-100" style="border: 1px solid #D9D9D9; border-radius: 5px">
                            <img style="width: 80%; height: 80%;" src="{{asset('uploads/products/'.$product->image)}}" alt="product">
                        </div>
                    </div>--}}

                    <div class="col-11 mx-auto col-md-5 mx-md-0">
                        <!--Details-->
                        {!! $product->details !!}

                        <!--Availability-->
                        <label>Availability: </label>
                        @if($product->stock_status == 'instock')
                            <b class="text-success"> In Stock</b>
                        @else
                            <b class="text-danger"> Out Of Stock</b>
                        @endif

                        <!--Attributes-->
                        @if(!array_key_exists($product->id, \Gloudemans\Shoppingcart\Facades\Cart::instance('default')->content()->groupBy('id')->toArray()))
                            @foreach($product->attributeValues->unique('product_attribute_id') as $av)
                                <div class="form-group">
                                    <label for="product-quantity">{{$av->productAttribute->name}}:</label>
                                    <select class="form-control" wire:model="sAttribute.{{$av->productAttribute->name}}">
                                        <option value="#">Select {{$av->productAttribute->name}}</option>
                                        @foreach($av->productAttribute->attributeValues->where('product_id', $product->id) as $pav)
                                            <option value="{{$pav->value}}">{{$pav->value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        @else
                            <p class="bold" style="color: orangered"><strong>Remove from cart if you want change options</strong></p>
                        @endif

                        <!--Add to cart button-->
                        <div class="row gap-y align-items-center text-center bg-light rounded p-4 mt-5 ml-auto">
                            <div class="col-md-auto ml-auto order-md-last">
                                @if($product->sale_price > 0)
                                    <h4 class="lead-5 mb-0 lh-1 fw-500">{{currency()}}{{$product->sale_price}}</h4>
                                @else
                                    <h4 class="lead-5 mb-0 lh-1 fw-500">{{currency()}}{{$product->regular_price}}</h4>
                                @endif
                                <small class="text-lighter">Free</small>
                            </div>

                            <div class="col-md-auto">
                                @if(!array_key_exists($product->id, \Gloudemans\Shoppingcart\Facades\Cart::instance('default')->content()->groupBy('id')->toArray()))
                                    <a class="btn btn-lg btn-primary text-white" wire:click.prevent="selectProduct({{$product->id}})">Add to cart</a>
                                @else
                                    <a class="btn btn-lg btn-danger text-white" wire:click.prevent="destroy({{$product->id}})">Remove from cart</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="">

                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab-home-1">Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-profile-1">Additional Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-contact-1">Reviews</a>
                            </li>
                        </ul>

                        <div class="tab-content p-4">
                            <div class="tab-pane fade show active" id="tab-home-1">
                                    {!! $product->details !!}
                            </div>

                            <div class="tab-pane fade" id="tab-profile-1">
                                <table class="table table-bordered">
                                    <tbody>
                                    @foreach($attribute_arr as $key => $value)
                                        <tr>
                                            <td><strong>{{$p_attributes->where('id', $attribute_arr[$key])->first()->name}}</strong></td>
                                            <td >{{$attribute_values[$value]}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fad" id="tab-contact-1">

                                <span style="font-size: 15px; font-weight: bold">({{$product->orderItems->where('rstatus', 1)->count()}}) Reviews for </span><h5 class="d-inline font-italic">{{' '.$product->name}}</h5>

                                @foreach($product->orderItems->where('rstatus', 1) as $orderItem)
                                    <div class="media mt-2">
                                        <div class="mr-5" style="width: 80px; height: 80px">
                                            <img class="w-100 h-100" src="{{asset('uploads/profile/')}}/{{$orderItem->order->user->profile->image}}" alt="{{$orderItem->order->user->name}}">
                                        </div>
                                        <div class="media-body">

                                            <div class="star-rating">
                                                <span class="width-{{$orderItem->review->rating * 20}}-percent">Rated <strong class="rating">{{$orderItem->review->rating}}</strong> out of 5</span>
                                            </div>

                                            <h6 class="d-inline">{{$orderItem->order->user->name}}</h6><span> - {{\Carbon\Carbon::parse($orderItem->review->created_at)->format('d F Y g:i A')}}</span>
                                            <p>{{$orderItem->review->comment}}</p>
                                        </div>
                                    </div>
                                @endforeach()

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div class="row">
                            <div class="col-12">
                                <h6 style="border-bottom: 1px solid #e6e6e6;padding-bottom: 10px;margin-bottom: 18px;margin-top: 12px">POPULAR PRODUCTS</h6>
                                @foreach($popularProducts as $popular)
                                    <div class="media mb-2">
                                        <div class="mr-5 w-25">
                                            <a href="{{route('product.show', $popular->slug)}}">
                                                <img class="img-thumbnail" src="{{asset('uploads/products/'.$popular->image)}}" alt="product">
                                            </a>
                                        </div>

                                        <div class="media-body">
                                            <a class="text-dark popular-desc " href="{{route('product.show', $popular->slug)}}">
                                                <span><strong>{{$popular->name}}</strong>{{' - '.Str::words($popular->description, 3)}}</span>
                                            </a>

                                            @if($popular->sale_price > 0)
                                                <div class="d-flex justify-content-start align-items-end">
                                                    <h6 class="text-muted line-through mb-0">{{currency()}}{{$popular->regular_price}}</h6>
                                                    <h6 class="ml-2 text-dark mb-0">{{currency()}}{{$popular->sale_price}}</h6>
                                                    @if($product->sale_price > 0)
                                                        <div class="ml-2">
                                                            <span class="badge badge-pill badge-success c-badge">
                                                                -{{round(((($product->regular_price - $product->sale_price)/$product->regular_price)*100))}}%
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <h6 class="text-dark">{{currency()}}{{$popular->regular_price}}</h6>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </section>


        @include('front-end.partials._might-also-like')

    </main>
</div>

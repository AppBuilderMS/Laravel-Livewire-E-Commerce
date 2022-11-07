<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Similar products
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
@push('styles')
    <style>
        .line-through{
            text-decoration: line-through;
        }
        .c-badge-right{
            position: absolute;
            padding-top: 3px;
            padding-bottom: 4px;
            font-size: 11px;
            top: 7px;
            right: 7px;
            z-index: 1;
        }
    </style>
@endpush
<section class="section bg-gray bt-1">
    <div class="container">

        <h4 class="mb-7">You might also like...</h4>

        <div class="row gap-y">

            @foreach($mightAlsoLike as $product)
                <div class="col-md-6 col-xl-3">
                    <div>
                        @if($product->sale_price > 0)
                            <span class="badge badge-pill badge-success c-badge-right">
                                -{{round(((($product->regular_price - $product->sale_price)/$product->regular_price)*100))}}%
                            </span>
                        @endif
                        <div class="product-3 mb-3 card overflow-hidden">
                            <a class="product-media" href="{{route('product.show', $product->slug)}}">
                                <img  src="{{asset('uploads/products/'.$product->image)}}" alt="product">
                            </a>
                            <div class="product-detail">
                                <h6><a href="{{route('product.show', $product->slug)}}">{{$product->name}}</a></h6>
                                @if($product->sale_price > 0)
                                    <span class="text-muted line-through">{{currency()}}{{$product->regular_price}}</span>
                                    <span class="ml-2 text-dark">{{currency()}}{{$product->sale_price}}</span>
                                @else
                                    <span class="text-dark">{{currency()}}{{$product->regular_price}}</span>
                                @endif
                            </div>
                            <div class="card-hover text-white" data-animation="slide-up">
                                <div class="overlay bg-dark opacity-70"></div>
                                <div class="card-body">
                                    <div class="row h-100">
                                        <div class="col-12 pb-2">
                                            <h5>{{$product->name}}</h5>
                                            <p>{{Str::words($product->description,15)}}</p>
                                        </div>
                                        <div class="col-12 align-self-end">
                                            @if(!array_key_exists($product->id, \Gloudemans\Shoppingcart\Facades\Cart::instance('default')->content()->groupBy('id')->toArray()))
                                                <a class="btn btn-success btn-sm d-block mb-1" wire:click.prevent="selectProduct({{$product->id}})">Add to cart</a>
                                            @else
                                                <a class="btn btn-danger btn-sm d-block mb-1" wire:click.prevent="destroy({{$product->id}})">Remove from cart</a>
                                            @endif
                                            <a class="btn btn-primary btn-sm d-block" href="{{route('product.show', $product->slug)}}">Show Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
</section>

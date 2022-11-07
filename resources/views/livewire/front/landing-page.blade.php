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
<div>
    <!-- header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">

            <div class="row align-items-center h-100">

                <div class="col-lg-5">
                    <h1 class="display-4"><strong>TheSaaS</strong>;<br>Where Work happens</h1>
                    <p class="lead mt-5">Whatever work means for you, TheSaaS brings all the pieces and people you need together so you can actually get things done.</p>

                    <hr class="w-10 ml-0 my-7">

                    <p class="gap-xy">
                        <a class="btn btn-lg btn-round btn-success mw-200" href="#section-pricing">Blog Post</a>
                        <a class="btn btn-lg btn-round btn-outline-success mw-200" href="#section-features">GitHup</a>
                    </p>
                </div>


                <div class="col-lg-6 ml-auto mt-8 mt-lg-0 video-wrapper ratio-16x9">
                    <div class="poster d-flex justify-content-center">
                        <img class="h-100" src="{{asset('')}}../assets/img/preview/laptop-1.png" alt="">
                    </div>
                </div>


            </div>

        </div>
    </header><!-- /.header -->

    <!-- Main Content -->
    <main class="main-content">

        <section class="section bg-gray">
            <div class="container">

                <header class="section-header">
                    <h2>Shop Now</h2>
                    <p class="lead">Won't said night above you're she'd behold moveth said one fowl. Beast forth. Man creepeth. She'd above bring blessed.</p>
                    <div class="mt-7">
                        <a href="#" class="btn btn-secondary {{$activeLatest}}" wire:click.prevent="latest">Latest</a>
                        <a href="#" class="btn btn-secondary {{$activeFeatured}}" wire:click.prevent="featured">Featured</a>
                        <a href="#" class="btn btn-secondary {{$activeOnSale}}" wire:click.prevent="onSale">On Sale</a>
                    </div>
                </header>

                <div class="row gap-y">
                    @if($products->count() > 0)
                        @foreach ($products as $product)
                            <div class="col-md-6 col-xl-4">
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
                    @else
                        <div class="alert alert-warning w-100 text-center"><h3>No Products Added Yet</h3></div>
                    @endif
                </div>

                <div class="d-flex justify-content-center mt-7">
                    <a href="{{route('shop.index')}}" class="btn btn-outline-dark">View more products</a>
                </div>

            </div>
        </section>


        <section class="section bg-secondary">
            <div class="container">
                <header class="section-header">
                    <h2>Latest From Our Blog</h2>
                    <p>Read and get updated on how we progress</p>
                </header>

                <div class="row gap-y">

                    <div class="col-md-6 col-lg-4">
                        <div class="card d-block border hover-shadow-6 mb-6">
                            <a href="#"><img class="card-img-top" src="{{asset('')}}../assets/img/thumb/1.jpg" alt="Card image cap"></a>
                            <div class="p-6 text-center">
                                <p><a class="small-5 text-lighter text-uppercase ls-2 fw-400" href="#">News</a></p>
                                <h5 class="mb-0"><a class="text-dark" href="#">We relocated our office to a new designed garage</a></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card d-block border hover-shadow-6 mb-6">
                            <a href="#"><img class="card-img-top" src="{{asset('')}}../assets/img/thumb/6.jpg" alt="Card image cap"></a>
                            <div class="p-6 text-center">
                                <p><a class="small-5 text-lighter text-uppercase ls-2 fw-400" href="#">Marketing</a></p>
                                <h5 class="mb-0"><a class="text-dark" href="#">Top 5 brilliant content marketing strategies</a></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card d-block border hover-shadow-6 mb-6">
                            <a href="#"><img class="card-img-top" src="{{asset('')}}../assets/img/thumb/3.jpg" alt="Card image cap"></a>
                            <div class="p-6 text-center">
                                <p><a class="small-5 text-lighter text-uppercase ls-2 fw-400" href="#">Design</a></p>
                                <h5 class="mb-0"><a class="text-dark" href="#">Best practices for minimalist design with example</a></h5>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>
</div>

@push('styles')
    <link rel="stylesheet" href="{{asset('/assets/noUiSlider/nouislider.min.css')}}">
    <style>
        #slider{
            height: 8px;
        }

        #slider .noUi-connect {
            background: #00b5b8;
        }

        #slider .noUi-handle {
            height: 18px;
            width: 18px;
            top: -6px;
            right: -9px; /* half the width */
            border-radius: 9px;
        }
        #slider .noUi-handle::before, #slider .noUi-handle::after{
            display: none;
        }
        .form-control {
            border: 1px solid #b1b1b1 !important;
        }
        .input-group-addon{
            border: 1px solid #b1b1b1 !important;
        }

        .sidebar .form-control {
            border: 1px solid #b1b1b1 !important;
            border-right: none !important;
        }

        .sidebar .input-group-addon{
            border: 1px solid #b1b1b1 !important;
            border-left: none !important;
        }

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

        .accordion .btn{
            font-size: 13px;
            padding: 8px 26px 6px;
            letter-spacing: 1px;
            text-transform: none;
            border-radius: 2px;
            outline: none;
            -webkit-transition: 0.15s linear;
            transition: 0.15s linear;
        }
        .accordion .card .card-header:hover{
            background: #EEEEEE;
        }
        .accordion .card .card-body li:hover{
            background: #EEEEEE;
        }
        .accordion .card .card-body li a:hover{
            color: #333333;
        }
        .accordion .active-link{
            background: #e7e7e7;
        }
        .accordion .active-link .btn{
            color: #333333;
        }

    </style>
@endpush
<div>
    <!-- Header -->
    <header class="header text-center text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h1 class="display-4">The Store</h1>
                    <p class="lead-2 opacity-90 mt-6">You can find a list of our product in this page. We'll deliver your order in less than two days. Try it yourself!</p>
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
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="section bg-gray">
            <div class="container">
                <div class="row">

                    <!--Sidebar-->
                    <div class="col-md-4 col-xl-3" style="background: #f1f2f3">
                        <nav class="sidebar py-0">

                            <div class="mb-7">
                                <h6 class="sidebar-title pt-3">Search</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" wire:model.debounce.500ms="search">
                                    <div class="input-group-addon">
                                        <span class="input-group-text"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <h6 class="sidebar-title"><a href="#" wire:click="allProducts">{{$allProducts}}</a></h6>

                                <h6 class="sidebar-title">By Category</h6>

                                <div class="accordion" id="accordionExample">
                                    @foreach($categories as $category)
                                        <div class="card mb-0 {{$selectedCategoryName == $category->name ? 'active-link' : ''}}">
                                            @if(count($category->subcategories) > 0)
                                                <div class="card-header" id="heading{{$category->id}}">
                                                    <span class="mb-0">
                                                        <button class="btn btn-block text-left pl-0 pr-0 d-flex justify-content-between align-items-center" type="button" data-toggle="collapse" data-target="#collapse{{$category->id}}" aria-expanded="true" aria-controls="collapse{{$category->id}}">
                                                            <span>{{$category->name}}</span>
                                                            <i class="ti-angle-down fs-9"></i>
                                                        </button>
                                                    </span>
                                                </div>

                                                <div id="collapse{{$category->id}}" class="collapse {{in_array($selectedCategoryName, $category->subcategories->pluck('name')->toArray()) ? 'show' : ''}}" aria-labelledby="heading{{$category->id}}" data-parent="#accordionExample">
                                                    <div class="card-body pl-0 pr-0 pb-0">
                                                        <ul style="list-style: none" class="pl-0">
                                                            @foreach($category->subcategories as $subcategory)
                                                                <li class="nav-item sub-cat-link {{$selectedCategoryName == $subcategory->name ? 'active-link' : ''}}">
                                                                    <span wire:click="bySubCategoryFilter({{$subcategory->id}})" class="nav-link pl-6 cursor-pointer fs-13">
                                                                        <i class="ti-angle-right fs-9"></i>
                                                                        {{$subcategory->name}}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                            @else
                                                <div class="card-header" id="heading{{$category->id}}">
                                                    <span class="mb-0">
                                                        <button wire:click="byCategoryFilter({{$category->id}})" class="btn btn-block text-left pl-0 pr-0" type="button" data-toggle="collapse" data-target="#collapse{{$category->id}}" aria-expanded="true" aria-controls="collapse{{$category->id}}">
                                                            {{$category->name}}
                                                        </button>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>


                            <h6 class="sidebar-title">By Price</h6>
                            <div style="width: 240px" id="slider" wire:ignore></div>
                            <span style="margin-top: 60px; font-size: 14px">Price: <span class="text-info">{{currency()}}{{$min_price}} - {{currency()}}{{$max_price}}</span></span>

                        </nav>
                    </div>

                    <!--Products List-->
                    <div class="col-md-8 col-xl-9">

                        <!--Products Sorting & Per Page-->
                        <div class="d-flex justify-content-between align-items-center mb-7 p-3" style="background-color: #f1f2f3">
                            <div class="heading">
                                <span class="top-line"></span>
                                <h3 class="font-weight-bold">{{$selectedCategoryName ? $selectedCategoryName : $allProducts}}</h3>
                                <span class="under-line"></span>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <div class="form-group mr-2 mt-4">
                                    <select name="orderby" class="form-control form-control-sm" wire:model="sorting">
                                        <option value="default" selected="selected">Default sorting</option>
                                        <option value="date">Sort by newness</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                </div>

                                <div class="form-group mt-4">
                                    <select name="post-per-page" class="form-control form-control-sm" wire:model="perPage">
                                        <option value="{{12}}" selected="selected">12 per page</option>
                                        <option value="{{16}}">16 per page</option>
                                        <option value="{{18}}">18 per page</option>
                                        <option value="{{21}}">21 per page</option>
                                        <option value="{{24}}">24 per page</option>
                                        <option value="{{30}}">30 per page</option>
                                        <option value="{{32}}">32 per page</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!--List-->
                        <div class="row gap-y">
                            @if($products->count() > 0)
                                @foreach ($products as $product)
                                    <div class="col-md-6 col-xl-4">
                                        <div>
                                            @if($product->sale_price > 0)
                                                <span class="badge badge-pill badge-success c-badge-right">
                                                -{{ round(((($product->regular_price - $product->sale_price)/$product->regular_price)*100)) }}%
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
                                <div class="alert alert-warning w-100 text-center ml-4 mr-4"><h3>No Products Added Yet</h3></div>
                            @endif
                        </div>

                        <!--Pagination-->
                        <div class="mt-2">
                            {{$products->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
    <script src="{{asset('/assets/noUiSlider/nouislider.min.js')}}"></script>
    <script>
        var slider = document.getElementById('slider');
        noUiSlider.create(slider, {
            start : [1, {{$max_price}}],
            connect:true,
            range :{
                'min' : 1,
                'max' : {{$max_price}}
            },
            pips:{
                mode: 'steps',
                stepped:true,
                density:4
            }
        })

        slider.noUiSlider.on('update', function (value) {
            Livewire.emit('set-search-price', value)
        })
    </script>
@endpush

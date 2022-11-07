@push('styles')
    <style>
        .form-control {
            border: 1px solid #b1b1b1 !important;
        }
        .comment-form-rating p.stars {
            display: inline-block;
            margin-bottom: -6px !important;
        }
    </style>
@endpush
<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">User Review</h1>
                    <p class="lead-2 opacity-90 mt-6">Here you can review our products</p>
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
                    <li class="breadcrumb-item">User Review</li>
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
                                <h5 >Add Reviews For... </h5>
                            </div>
                            <div class="card-body">
                                <div class="media mt-2">
                                    <div class="mr-5" style="width: 60px; height: 60px">
                                        <img class="w-100 h-100" src="{{asset('uploads/products/')}}/{{$orderItem->product->image}}" alt="...">
                                    </div>
                                    <div class="media-body">
                                        <h6 class="d-inline">{{$orderItem->product->name}}</h6>
                                        <p>{{$orderItem->product->description}}</p>
                                    </div>
                                </div>

                                <form wire:submit.prevent="addReview" class="col-12 mx-auto p-6 bg-gray rounded">

                                    <div class="comment-form-rating">
                                        <div class="d-flex align-items-center">
                                            <span class="pr-2 font-weight-bold">Your rating</span>
                                            <p class="stars">
                                                <label for="rated-1"></label>
                                                <input type="radio" id="rated-1" name="rating" value="1" wire:model="rating">
                                                <label for="rated-2"></label>
                                                <input type="radio" id="rated-2" name="rating" value="2" wire:model="rating">
                                                <label for="rated-3"></label>
                                                <input type="radio" id="rated-3" name="rating" value="3" wire:model="rating">
                                                <label for="rated-4"></label>
                                                <input type="radio" id="rated-4" name="rating" value="4" wire:model="rating">
                                                <label for="rated-5"></label>
                                                <input type="radio" id="rated-5" name="rating" value="5" checked="checked" wire:model="rating">
                                            </p>
                                        </div>
                                        @error('rating')
                                        <small><strong class="d-block text-danger">{{ $message }}</strong></small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control form-control-lg" rows="4" placeholder="Your Comment" name="comment" wire:model="comment"></textarea>
                                        @error('comment')
                                            <small><strong class="text-danger">{{ $message }}</strong></small>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-lg btn-primary" type="submit">Submit Review</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

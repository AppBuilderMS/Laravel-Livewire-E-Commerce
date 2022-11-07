<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">Edit User Profile</h1>
                    <p class="lead-2 opacity-90 mt-6">Here you can Update your profile</p>
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
                    <li class="breadcrumb-item">Edit User Profile</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="main-content">
        <div class="section bg-gray pt-7" style="min-height: 47vh">
            <div class="container">
                <div class="row ">
                    <div class="col-12">
                        <form wire:submit.prevent="updateUserProfile">
                            <div class="card">
                                <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                                    <h5 >Edit User Profile</h5>
                                    <button class="btn btn-success" type="submit"><i class="ti-save"></i> Save Profile</button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-1">
                                            @if($newImage)
                                                <div>
                                                    <img src="{{$newImage->temporaryUrl()}}" width="100%" alt="">
                                                </div>
                                            @elseif($image)
                                                <div>
                                                    <img src="{{asset('uploads/profile')}}/{{$image}}" width="100%" alt="">
                                                </div>
                                            @else
                                                <div >
                                                    <img class="img-thumbnail bg-secondary shadow-1 rounded" src="{{asset('uploads/profile/default.png')}}" width="100%" alt="">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" wire:model="newImage">
                                        </div>
                                        <div class="col-md-8">
                                            <p><b>Name:</b> <input type="text" class="form-control" wire:model="name"></p>
                                            <p><b>Email:</b> {{$user->email}}</p>
                                            <p><b>Phone:</b> <input type="text" class="form-control" wire:model="phone"></p>
                                            <hr>
                                            <p><b>Line1:</b> <input type="text" class="form-control" wire:model="line1"></p>
                                            <p><b>Line2:</b> <input type="text" class="form-control" wire:model="line2"></p>
                                            <p><b>City:</b> <input type="text" class="form-control" wire:model="city"></p>
                                            <p><b>Province:</b> <input type="text" class="form-control" wire:model="province"></p>
                                            <p><b>Country:</b> <input type="text" class="form-control" wire:model="country"></p>
                                            <p><b>Zipcode:</b> <input type="text" class="form-control" wire:model="zipcode"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

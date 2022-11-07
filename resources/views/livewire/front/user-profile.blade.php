<div>
    <!-- Header -->
    <header class="header text-white bg-gradient-slate">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="display-4">User Profile</h1>
                    <p class="lead-2 opacity-90 mt-6">Here you can preview your profile</p>
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
                    <li class="breadcrumb-item">User Profile</li>
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
                            <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                                <h5 >User Profile Details</h5>
                                <a class="btn btn-info" href="{{route('edit_user_profile')}}"><i class="ti-pencil"></i> Edit Profile</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        @if($user->profile->image)
                                            <div>
                                                <img src="{{asset('uploads/profile')}}/{{$user->profile->image}}" width="100%" alt="">
                                            </div>
                                        @else
                                            <div >
                                                <img class="img-thumbnail bg-secondary shadow-1 rounded" src="{{asset('uploads/profile/default.png')}}" width="100%" alt="">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <p><b>Name:</b> {{$user->name}}</p>
                                        <p><b>Email:</b> {{$user->email}}</p>
                                        <p><b>Phone:</b> {{$user->phone}}</p>
                                        <hr>
                                        <p><b>Line1:</b> {{$user->profile->line1}}</p>
                                        <p><b>Line2:</b> {{$user->profile->line2}}</p>
                                        <p><b>City:</b> {{$user->profile->city}}</p>
                                        <p><b>Province:</b> {{$user->profile->province}}</p>
                                        <p><b>Country:</b> {{$user->profile->country}}</p>
                                        <p><b>Zipcode:</b> {{$user->profile->zipcode}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

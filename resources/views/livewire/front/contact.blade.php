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
                    <h1 class="display-4">Let's Get In Touch</h1>
                    <p class="lead-2 opacity-90 mt-6">Here are the ways you can contact us with any questions you have</p>
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
                    <li class="breadcrumb-item">Contact Us</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="main-content">
        <div class="section bg-gray pt-7" style="min-height: 47vh">
            <div class="container">
                <div class="row">
                    <form class="col-lg-6 rounded bg-secondary p-6 mb-5 " wire:submit.prevent="sendMessage">

                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Done! </strong> {{Session::get('message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif


                        <div class="form-group">
                            <label for="" class="require">Name</label>
                            <input class="form-control form-control-lg @error('name') is-invalid @enderror" type="text" name="name" placeholder="Your Name" wire:model="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="" class="require">Email</label>
                            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" placeholder="Your Email Address" wire:model="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="" class="require">Phone Number</label>
                            <input class="form-control form-control-lg @error('phone') is-invalid @enderror" type="text" name="phone" placeholder="Your Phone" wire:model="phone">
                            @error('phone')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="" class="require">Your Message</label>
                            <textarea class="form-control form-control-lg @error('comment') is-invalid @enderror" rows="7" placeholder="Your Message" name="comment" wire:model="comment"></textarea>
                            @error('comment')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <button class="btn btn-lg btn-primary" type="submit">Submit Inquiry</button>
                        </div>
                    </form>

                    <div class="col-lg-6 text-center text-lg-left">
                        <div class="h-400 rounded bg-secondary p-7">
                            <img class="w-100 h-100" src="{{asset('/assets/img/contact-us.svg')}}" alt="contact us">
                        </div>
                        <div class="text-center mt-5">
                            <hr class="d-lg-none">
                            <h3>Find Us</h3>
                            @if($settings)
                                <p>{{$settings->address}}</p>
                                <p class="mb-0">{{$settings->phone}}</p>
                                <p>{{$settings->phone2}}</p>
                                <p>{{$settings->email}}</p>
                                <div class="fw-400">Follow Us</div>
                                <div class="social social-sm social-inline">
                                    @foreach($socials as $index =>$social)
                                        @if($social != '#')
                                            <a class="social-{{$index}}" href="{{'https://www.'.$social}}"><i class="fa fa-{{$index}}"></i></a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">Adjust Settings To Display Contact Details</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

</div>

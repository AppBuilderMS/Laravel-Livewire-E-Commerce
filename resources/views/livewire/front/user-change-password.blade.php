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
                    <h1 class="display-4">Change User Password</h1>
                    <p class="lead-2 opacity-90 mt-6">Here you can change your password</p>
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
                    <li class="breadcrumb-item">Change Password</li>
                </ol>
            </nav>
        </div>
    </section>

    <main class="main-content">
        <div class="section bg-gray pt-7" style="min-height: 47vh">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <h5 >Change Password</h5>
                            </div>
                            <div class="card-body">

                                @if(Session::has('password_success'))
                                    <div class="alert alert-success" role="alert">{{Session::get('password_success')}}</div>
                                @endif

                                @if(Session::has('password_error'))
                                    <div class="alert alert-danger" role="alert">{{Session::get('password_error')}}</div>
                                @endif

                                <form wire:submit.prevent="changePassword">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="form-row mb-6">
                                                <div class="col-12 form-group mb-0">
                                                    <label for="" class="require">Current Password</label>
                                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" placeholder="Current Password" wire:model="current_password">
                                                    @error('current_password')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-6">
                                                <div class="col-12 form-group mb-0">
                                                    <label for="" class="require">New Password</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password" wire:model="password">
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-row mb-6">
                                                <div class="col-12 form-group mb-0">
                                                    <label for="" class="require">Confirm Password</label>
                                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Password Confirmation" wire:model="password_confirmation">
                                                    @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div>
                                                <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
                                            </div>
                                        </div>
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

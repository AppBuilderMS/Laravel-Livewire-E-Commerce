<div>

    <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header bg-light-primary">
                            <h5 >Edit Admin Profile</h5>
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

                                        <div class="form-row mb-2">
                                            <div class="col-12 form-group mb-0">
                                                <label for="" class="require">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Email" wire:model="name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-2">
                                            <div class="col-12 form-group mb-0">
                                                <label for="" class="require">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" wire:model="email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-row mb-2">
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

                                        <div class="form-row mb-2">
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

                                        <div class="form-row mb-2">
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
                                            <button class="btn btn-primary" type="submit">Save Changes</button>
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

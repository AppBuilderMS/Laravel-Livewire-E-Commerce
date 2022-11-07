<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-success bg-lighten-5">
                        <h3 class="content-header-title">Settings</h3>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="saveSettings" autocomplete="off">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Business Name: </label>
                                    <input type="text" placeholder="Business name" class="form-control  @error('business_name') is-invalid @enderror" wire:model="business_name">
                                    @error('business_name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" placeholder="Email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Phone: </label>
                                    <input type="text" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror" wire:model="phone">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Phone2: </label>
                                    <input type="text" placeholder="Phone2" class="form-control @error('phone2') is-invalid @enderror" wire:model="phone2">
                                    @error('phone2')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Address: </label>
                                    <input type="text" placeholder="Address" class="form-control @error('address') is-invalid @enderror" wire:model="address">
                                    @error('address')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Twitter: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('twitter') is-invalid @enderror" placeholder="Twitter address OR # if you don't have one"  wire:model="twitter">
                                        @error('twitter')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Facebook: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('facebook') is-invalid @enderror" placeholder="Facebook address OR # if you don't have one"  wire:model="facebook">
                                        @error('facebook')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Youtube: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('youtube') is-invalid @enderror" placeholder="Youtube address OR # if you don't have one"  wire:model="youtube">
                                        @error('youtube')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Instagram: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('instagram') is-invalid @enderror" placeholder="Instagram address OR # if you don't have one"  wire:model="instagram">
                                        @error('instagram')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Pinterest: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('pinterest') is-invalid @enderror" placeholder="pinterest address OR # if you don't have one"  wire:model="pinterest">
                                        @error('pinterest')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Dribbble: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">https://www.</span>
                                        </div>
                                        <input type="text" class="form-control  @error('dribbble') is-invalid @enderror" placeholder="Dribbble address OR # if you don't have one"  wire:model="dribbble">
                                        @error('dribbble')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Currency: </label>
                                    <input type="text" placeholder="Used currency symbol" class="form-control @error('currency') is-invalid @enderror" wire:model="currency">
                                    @error('currency')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Logo 1: </label>
                                        <div class="custom-file">
                                            <input type="file" placeholder="Logo Image" class="custom-file-input @error('newLogo1') is-invalid @enderror" wire:model="newLogo1">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            @error('newLogo1')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            @if($newLogo1)
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{$newLogo1->temporaryUrl()}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @elseif($oldLogo1)
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{asset('uploads/')}}/{{$oldLogo1}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @else
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{asset('uploads/defaultLogo1.png')}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Logo 2: </label>
                                        <div class="custom-file">
                                            <input type="file" placeholder="Logo Image" class="custom-file-input @error('newLogo2') is-invalid @enderror" wire:model="newLogo2">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            @error('newLogo2')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            @if($newLogo2)
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{$newLogo2->temporaryUrl()}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @elseif($oldLogo2)
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{asset('uploads/')}}/{{$oldLogo2}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @else
                                                <div style="width: 70px" class="mt-1 mb-1">
                                                    <img src="{{asset('uploads/defaultLogo2.png')}}" class="img-thumbnail w-100" alt="">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <a href="{{route('admin.products.index')}}" class="btn grey btn-outline-secondary">Back</a>
                                <button id="createSubmit" type="submit" class="btn btn-outline-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

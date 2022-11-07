@push('styles')
    <link rel="stylesheet" href="{{asset('app-assets/summernote/summernote-lite.min.css')}}">
    <style>
        .note-editor .note-toolbar .note-color-all .note-dropdown-menu, .note-popover .popover-content .note-color-all .note-dropdown-menu {
            min-width: 350px !important;
        }
    </style>
@endpush
<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-info bg-lighten-5">
                        <h3 class="content-header-title">Update Product</h3>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="update" autocomplete="off">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name: </label>
                                    <input type="text" placeholder="Product name" class="form-control  @error('name') is-invalid @enderror" wire:model="name" wire:keyup="generateSlug">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Slug: </label>
                                    <input type="text" placeholder="Product slug" class="form-control @error('slug') is-invalid @enderror" wire:model="slug" readonly>
                                    @error('slug')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Description: </label>
                                    <textarea placeholder="Short description for the product" class="editor form-control @error('description') is-invalid @enderror" wire:model="description"></textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-0" wire:ignore>
                                    <label>Details: </label>
                                    <textarea id="edit-editor-details" placeholder="Product details" class="form-control @error('details') is-invalid @enderror">{{$details}}</textarea>
                                </div>
                                @error('details')
                                <div style="width: 100%;margin-top: 0.25rem;font-size: 80%;color: #ff7588;">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror

                                <div class="form-group mt-2">
                                    <label>Regular Price: </label>
                                    <input type="text" placeholder="Regular Price" class="form-control @error('regular_price') is-invalid @enderror" wire:model="regular_price">
                                    @error('regular_price')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Sale Price: </label>
                                    <input type="text" placeholder="Sale Price" class="form-control @error('sale_price') is-invalid @enderror" wire:model="sale_price">
                                    @error('sale_price')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>SKU: </label>
                                    <input type="text" placeholder="SKU" class="form-control @error('SKU') is-invalid @enderror" wire:model="SKU">
                                    @error('SKU')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Stock: </label>
                                    <select class="custom-select form-control @error('stock_status') is-invalid @enderror" wire:model="stock_status">
                                        <option value="" selected>==Select Stock Status==</option>
                                        <option value="instock">In stock</option>
                                        <option value="outofstock">Out of stock</option>
                                    </select>
                                    @error('stock_status')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Featured: </label>
                                    <select class="custom-select form-control @error('featured') is-invalid @enderror" wire:model="featured">
                                        <option value="" selected>==Select Featured==</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('featured')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Quantity: </label>
                                    <input type="text" placeholder="Quantity" class="form-control @error('quantity') is-invalid @enderror" wire:model="quantity">
                                    @error('quantity')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Category: </label>
                                    <select class="custom-select form-control @error('category_id') is-invalid @enderror" wire:model="category_id">
                                        <option value="" selected>==Select Product Category==</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>SubCategory: </label>
                                    <select class="custom-select form-control @error('subcategory_id') is-invalid @enderror" wire:model="subcategory_id">
                                        <option value="" selected>==Select Product SubCategory==</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-row align-items-end">
                                        <div class="col-10">
                                            <label>Attributes: </label>
                                            <select class="custom-select form-control" wire:model="attr">
                                                <option value="" selected>==Select Product Attribute==</option>
                                                @foreach($p_attributes as $p_attribute)
                                                    <option value="{{$p_attribute->id}}">{{$p_attribute->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-2">
                                            <button type="button" class="btn btn-info w-100"  wire:click.prevent="add"><i class="feather icon-plus"></i> Add</button>
                                        </div>
                                    </div>
                                </div>

                                @foreach($attr_inputs as $key => $value)
                                    <div class="form-group">
                                        <div class="form-row align-items-end">
                                            <div class="col-10">
                                                <label>{{$p_attributes->where('id', $attribute_arr[$key])->first()->name}}: <small class="text-italic text-muted">For more than one value use ( , )</small></label>
                                                <input type="text" placeholder="{{$p_attributes->where('id', $attribute_arr[$key])->first()->name}}"
                                                       class="form-control" wire:model="attribute_values.{{$value}}">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-danger w-100"  wire:click.prevent="remove({{$key}})"><i class="feather icon-delete"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group">
                                    <label>Image: </label>
                                    <div class="custom-file">
                                        <input type="file" placeholder="Product Image" class="custom-file-input @error('newImage') is-invalid @enderror" wire:model="newImage">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        @error('newImage')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @if($newImage)
                                            <div style="width: 70px" class="mt-1">
                                                <img src="{{$newImage->temporaryUrl()}}" class="img-thumbnail w-100 mb-3" alt="">
                                            </div>
                                        @elseif($oldImage)
                                            <div style="width: 70px" class="mt-1">
                                                <img src="{{asset('uploads/products/')}}/{{$oldImage}}" class="img-thumbnail w-100 mb-3" alt="">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Product Gallery: </label>
                                    <div class="custom-file">
                                        <input type="file" multiple placeholder="Product Images" class="custom-file-input @error('newImages') is-invalid @enderror" wire:model="newImages">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        @error('newImages')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                        @if($newImages)
                                            <div class="mt-1">
                                                <div class="d-flex justify-content-start">
                                                    @foreach($newImages as $nImage)
                                                        @if($nImage)
                                                            <div style="width: 70px" class="mr-50">
                                                                <img src="{{$nImage->temporaryUrl()}}" class="img-thumbnail w-100" alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif($oldImages)
                                            <div class="mt-1">
                                                <div class="d-flex justify-content-start">
                                                    @php
                                                        $oImages = explode(",", $oldImages)
                                                    @endphp
                                                    @foreach($oImages as $oImage)
                                                        @if($oImage)
                                                            <div style="width: 70px" class="mr-50">
                                                                <img src="{{asset('uploads/products/')}}/{{$oImage}}" class="img-thumbnail w-100" alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer mt-2">
                                <a href="{{route('admin.products.index')}}" class="btn grey btn-outline-secondary">Back</a>
                                <button type="submit" class="btn btn-outline-info">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <!--Summernote-->
    <script src="{{asset('app-assets/summernote/summernote-lite.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#edit-editor-details').summernote({
                minHeight: 200,
                tabSize: 2,
                callbacks: {
                    onChange: function(contents, $editable) {
                        @this.set('details', contents)
                    }
                }
            });
        });
    </script>
@endpush

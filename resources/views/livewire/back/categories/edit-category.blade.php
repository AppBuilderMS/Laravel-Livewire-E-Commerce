<div>
    <form wire:submit.prevent="update" autocomplete="off">
        <div class="modal-body">
            <div class="form-group">
                <label>Name: </label>
                <input type="text" placeholder="Category Name" class="form-control  @error('name') is-invalid @enderror" wire:model="name" wire:keyup="generateSlug">
                @error('name')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Slug: </label>
                <input type="text" placeholder="Category Slug" class="form-control @error('slug') is-invalid @enderror" wire:model="slug" readonly>
                @error('slug')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Parent Category: <small class="text-danger font-italic">(If none this category will be parent category)</small></label>
                <select class="custom-select form-control " wire:model="parent_category_id">
                    <option value="" selected="">==None==</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-info">Save</button>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        //hide modal after save
        window.addEventListener("closeModal", event => {
            $('.closeModal').modal('hide');
        });

        $(document).ready(function() {
            //this event is triggered when the modal is hidden
            $('.closeModal').on('hidden.bs.modal', function () {
                livewire.emit('forceCloseModal');
            })
        });
    </script>
@endpush

<div>
    <form wire:submit.prevent="update" autocomplete="off">
        <div class="modal-body">
            <div class="form-group">
                <div class="form-group">
                    <label>Name: </label>
                    <input type="text" placeholder="Attribute Name" class="form-control  @error('name') is-invalid @enderror" wire:model="name">
                    @error('name')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline-success">Save</button>
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



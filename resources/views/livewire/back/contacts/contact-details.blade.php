<div>
    <div class="modal-body">
        <div class="form-group">
            <label>Name: </label>
            <input type="text" placeholder="Name" class="form-control" wire:model="name" readonly>
        </div>

        <div class="form-group">
            <label>Email: </label>
            <input type="text" placeholder="Email" class="form-control" wire:model="email" readonly>
        </div>

        <div class="form-group">
            <label>Phone: </label>
            <input type="text" placeholder="Phone" class="form-control" wire:model="phone" readonly>
        </div>

        <div class="form-group">
            <label>Comment: </label>
            <textarea placeholder="Comment" rows="7" class="form-control" wire:model="comment" readonly></textarea>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
    </div>
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

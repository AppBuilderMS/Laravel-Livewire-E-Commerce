@push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('')}}../../../app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
@endpush
<div>
    <form wire:submit.prevent="store" autocomplete="off">
        <div class="modal-body">
            <div class="form-group">
                <label>Code: </label>
                <input type="text" placeholder="Coupon Code" class="form-control  @error('code') is-invalid @enderror" wire:model="code">
                @error('code')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Type: </label>
                <select class="custom-select form-control @error('type') is-invalid @enderror" wire:model="type">
                    <option value="" selected>==Select Coupon Type==</option>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
                @error('type')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Value: </label>
                <input type="text" placeholder="Coupon Value" class="form-control  @error('value') is-invalid @enderror" wire:model="value">
                @error('value')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Cart Value: </label>
                <input type="text" placeholder="Coupon Value" class="form-control  @error('cart_value') is-invalid @enderror" wire:model="cart_value">
                @error('cart_value')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
            </div>

            <div class="form-group" wire:ignore>
                <label>Expiry Date: </label>
                <input type="text" id="expiry_date" placeholder="Expiry Date" class="form-control  @error('expiry_date') is-invalid @enderror" wire:model="expiry_date">
                @error('expiry_date')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
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
    <script src="{{asset('')}}../../../app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
    <script src="{{asset('')}}../../../app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(function (){
            $('#expiry_date').datetimepicker({
                format: 'YY-MM-DD'
            }).on('dp.change', function (event){
                let data = $('#expiry_date').val();
                @this.set('expiry_date', data);
            })
        });
    </script>
@endpush

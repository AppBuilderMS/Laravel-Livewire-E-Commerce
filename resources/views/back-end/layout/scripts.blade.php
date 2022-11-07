<!-- BEGIN: Vendor JS-->
<script src="{{asset('')}}./app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('')}}./app-assets/js/core/app-menu.min.js"></script>
<script src="{{asset('')}}./app-assets/js/core/app.min.js"></script>
<script src="{{asset('')}}./app-assets/js/scripts/customizer.min.js"></script>
<script src="{{asset('assets/iziToast/js/iziToast.min.js')}}"></script>
<script src="{{asset('assets/js/customLivewire.js')}}"></script>
<!-- END: Theme JS-->
@livewireScripts
@stack('scripts')

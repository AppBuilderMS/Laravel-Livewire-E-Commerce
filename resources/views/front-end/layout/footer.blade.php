@livewire('front.footer')

<!-- Scripts -->
<script src="{{asset('/assets/js/page.min.js')}}"></script>
<script src="{{asset('/assets/js/script.js')}}"></script>
<script src="{{asset('assets/iziToast/js/iziToast.min.js')}}"></script>
<script src="{{asset('assets/js/customLivewire.js')}}"></script>
@livewireScripts
@stack('scripts')
</body>
</html>

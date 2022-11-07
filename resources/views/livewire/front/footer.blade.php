<div>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row gap-y align-items-center justify-content-between">

                @if($settings)
                    <div class="col-6 col-lg-3">
                        <a href="/">
                            @if($settings->newLogo1)
                                <img style="width: 50px; height: 50px;" class="logo-dark" src="{{asset('uploads/')}}/{{$settings->newLogo1}}" alt="logo">
                            @else
                                <img style="width: 50px; height: 50px;" class="logo-dark" src="{{asset('uploads/defaultLogo1.png')}}" alt="logo">
                            @endif
                        </a>
                    </div>
                @else
                    <div class="col-6 col-lg-3">
                        <a href="/"><img style="width: 50px !important; height: 50px;" src="{{asset('/uploads/defaultLogo1.png')}}" alt="logo"></a>
                    </div>
                @endif

                <div class="col-6 col-lg-3 text-right order-lg-last">
                    <div class="social">
                        @foreach($socials as $index =>$social)
                            @if($social != '#')
                                <a class="social-{{$index}}" href="{{'https://www.'.$social}}"><i class="fa fa-{{$index}}"></i></a>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </footer><!-- /.footer -->
</div>

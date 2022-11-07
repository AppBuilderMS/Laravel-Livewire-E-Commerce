<div class="container">

    <div class="navbar-left">
        @if(\Illuminate\Support\Facades\Request::route()->getName() != 'checkout')
            <button class="navbar-toggler" type="button">☰</button>
        @endif
        @if($settings)
            <a class="navbar-brand" href="/">
                @if($settings->newLogo1)
                    <img style="width: 50px; height: 50px;" class="logo-dark" src="{{asset('uploads/')}}/{{$settings->newLogo1}}" alt="logo">
                @else
                    <img style="width: 50px; height: 50px;" class="logo-dark" src="{{asset('uploads/defaultLogo1.png')}}" alt="logo">
                @endif

                @if($settings->newLogo2)
                    <img style="width: 50px; height: 50px;" class="logo-light" src="{{asset('uploads/')}}/{{$settings->newLogo2}}" alt="logo">
                @else
                    <img style="width: 50px; height: 50px;" class="logo-light" src="{{asset('uploads/defaultLogo2.png')}}" alt="logo">
                @endif
            </a>
        @else
            <a class="navbar-brand" href="/">
                <img style="width: 50px; height: 50px;" class="logo-dark" src="{{asset('uploads/defaultLogo1.png')}}" alt="logo">
                <img style="width: 50px; height: 50px;" class="logo-light" src="{{asset('uploads/defaultLogo2.png')}}" alt="logo">
            </a>
        @endif
    </div>

    @if(\Illuminate\Support\Facades\Request::route()->getName() != 'checkout')
        <section class="navbar-mobile">
            <span class="navbar-divider d-mobile-none"></span>
            <ul class="nav nav-navbar mr-auto">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->routeIs('shop*') ? ' active' : '' }}" href="{{route('shop.index')}}">Shop</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/about*') ? ' active' : '' }}" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/blog*') ? ' active' : '' }}" href="#">Blog</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? ' active' : '' }}" href="{{route('contact')}}">Contact Us</a>
                </li>
            </ul>

            @if (Route::has('login'))
                <ul class="nav nav-navbar ml-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{auth()->user()->name}} <span class="arrow"></span></a>
                            <nav class="nav">
                                <a class="nav-link" href="{{route('user_orders.index')}}">My Orders</a>
                                <a class="nav-link" href="{{route('user_profile')}}">Profile</a>
                                <a class="nav-link" href="{{route('user_change_password')}}">Change Password</a>
                                <div class="nav-divider"></div>
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </nav>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            </li>
                        @endif
                    @endauth

                    <li class="nav-item">
                        <a class="nav-link badge badge-pale pr-2 {{ request()->routeIs('cart*') ? ' active' : '' }}" href="{{route('cart.index')}}">
                            Cart
                        </a>
                        @livewire('front.cart-counter')
                    </li>
                </ul>
            @endif


        </section>
    @endif

</div>

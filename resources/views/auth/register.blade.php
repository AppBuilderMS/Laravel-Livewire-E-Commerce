<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>TheSaaS — Register</title>

    <!-- Styles -->
    <link href="{{asset('')}}../assets/css/page.min.css" rel="stylesheet">
    <link href="{{asset('')}}../assets/css/style.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('')}}../assets/img/apple-touch-icon.png">
    <link rel="icon" href="{{asset('')}}../assets/img/favicon.png">
</head>

<body class="layout-centered bg-img bg-gradient-g-slate" >

<!-- Main Content -->
<main class="main-content">
    <div>
        <div class="mb-5">
            <h2 class="text-white text-center">Register Now</h2>
            <p class="text-white text-center opacity-70 lead">Start to explore our products.</p>
        </div>
        <div class="bg-gradient-g-slate rounded w-400 mw-100 p-6" style="box-shadow: 10px 55px 100px rgb(0 0 0 / 60%);">
            <h5 class="mb-7 text-white text-bold-700">Create an account</h5>

            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf
                <div class="form-group">
                    <div class="input-group @error('name') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user-o fa-fw"></i></span>
                        </div>

                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required  autofocus placeholder="Your Name">
                    </div>
                    @error('name')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group @error('email') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope-o fa-fw"></i></span>
                        </div>

                        <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="E-mail Address">
                    </div>
                    @error('email')
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group @error('email') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                        </div>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password">
                    </div>
                    @error('password')
                    <div class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                        </div>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                </div>


                <div class="form-group">
                    <button class="btn btn-block bg-gradient-primary text-white" type="submit">{{ __('Register') }}</button>
                </div>
            </form>

            <hr class="w-30" style="background-color: #888888">

            <p class="text-center text-white-50 small-2">Already a member? <a class="font-weight-bolder" href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>
</main><!-- /.main-content -->


<!-- Scripts -->
<script src="{{asset('')}}../assets/js/page.min.js"></script>
<script src="{{asset('')}}../assets/js/script.js"></script>

</body>
</html>



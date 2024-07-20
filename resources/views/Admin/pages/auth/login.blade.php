<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ trans('admin.auth.admin') . ' | ' . trans('admin.auth.login') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assetsAdmin/logo/Primary.svg') }}" />
    <link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet"
        type="text/css" />
    <script src="{{ asset('assetsAdmin/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('assetsAdmin/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assetsAdmin/src/assets/css/light/authentication/auth-boxed.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assetsAdmin/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assetsAdmin/src/assets/css/dark/authentication/auth-boxed.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('assetsAdmin/src/assets/css/dark/auth/log.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <section>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span>
        <div class="signin">
            <div class="content">
                <img src="{{ asset('assetsAdmin/logo/Icon-Black.svg') }}" alt="User Image">
                <h2>{{ trans('admin.auth.sign_in') }}</h2>
                {{-- <p class="text-light">{{ trans('admin.auth.enter_your_email_and_password') }}</p> --}}

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <form class="w-100" action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="form">
                        <div class="inputBox">
                            <label class="form-label">{{ trans('admin.auth.email') }}<code>*</code></label>
                            <input type="email" name="email" @if(isset($_COOKIE['email'])) value="{{ $_COOKIE['email'] }}" @endif required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="inputBox">
                            <label class="form-label">{{ trans('admin.auth.password') }}<code>*</code></label>
                            <input type="password" name="password" @if(isset($_COOKIE['password'])) value="{{ $_COOKIE['password'] }}" @endifrequired>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check form-check-primary form-check-inline">
                            <input class="form-check-input me-3" type="checkbox" id="form-check-default" name="remember"
                                value="1" @if (old('remember')) checked @endif>
                            <label class="form-check-label" for="form-check-default">
                                {{ trans('admin.auth.remember_me') }}
                            </label>
                        </div>
                        <div class="inputBox text-light">
                            <input type="submit" value="{{ trans('admin.auth.sign_in') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assetsAdmin/ar/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

</html>

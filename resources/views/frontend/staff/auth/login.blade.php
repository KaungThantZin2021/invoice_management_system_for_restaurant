<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">

    <title>{{ config('app.name') }} (Staff Panel)</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('theme/src/assets/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('theme/src/assets/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('theme/src/assets/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('theme/src/assets/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('theme/src/assets/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('theme/src/assets/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('theme/src/assets/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('theme/src/assets/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('theme/src/assets/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('theme/src/assets/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('theme/src/assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('theme/src/assets/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('theme/src/assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('theme/src/assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <script src="{{ asset('theme/src/js/color-modes.js') }}"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>Login</h1>
                                <p class="text-body-secondary">Sign In to your account</p>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-envelope-closed') }}">
                                                </use>
                                            </svg>
                                        </span>
                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <svg class="icon">
                                                <use
                                                    xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-lock-locked') }}">
                                                </use>
                                            </svg>
                                        </span>
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Staff Panel</h2>
                                    <h5>{{ config('app.name') }}</h5>
                                </div>
                                <hr>
                                <div>
                                    <a href="{{ route('admin.login') }}" class="btn btn-lg btn-outline-light mt-3">
                                        Go to Admin Panel
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('coreui_icons/sprites/free.svg#cil-arrow-right') }}">
                                            </use>
                                        </svg></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script></script>
</body>

</html>

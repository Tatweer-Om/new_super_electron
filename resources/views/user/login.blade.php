<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/css/register/all_register.min.css') }}">
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{ asset('css/register/style.css') }}">


</head>

<body class="account-page">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper login-new">
                <div class="container">
                    <div class="login-content user-login">
                        <div class="login-logo">
                            <img src="{{asset('img/logo.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="80" width="250">
                            <a href="index.html" class="login-logo logo-white">
                                <img src="assets/img/logo-white.png" alt>
                            </a>
                        </div>
                        <form action="{{ url('login') }}" method="POST" id="login"  >
                            @csrf
                            <div class="login-userset">
                                <div class="login-userheading">
                                    <h3>Sign In</h3>
                                    <h4 >Access the Proton Electronics using UserName and Passcode.</h4>
                                </div>
                                <div class="form-login">
                                    <label class="form-label">User Name</label>
                                    <div class="form-addons">
                                        <input type="text" class="form-control" name= "username" >

                                    </div>
                                </div>
                                <div class="form-login">
                                    <label>Password</label>
                                    <div class="pass-group">
                                        <input type="password" class="pass-input" name= "password">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                                <div class="form-login authentication-check">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                {{-- <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>Remember me
                                                </label> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-6 text-end">
                                            <a class="forgot-link" href="forgot-password-3.html">Forgot Password?</a>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="form-login">
                                    <button class="btn btn-login" type="submit">Sign In</button>
                                </div>

                                <div class="form-setlogin or-text">

                                </div>
                                <div class="form-sociallink">
                                    <ul class="d-flex">

                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                        {{-- <p>Copyright &copy; 2023 DreamsPOS. All rights reserved</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="customizer-links" id="setdata">
        <ul class="sticky-sidebar">
            <li class="sidebar-icons">
                <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-original-title="Theme">
                    <i data-feather="settings" class="feather-five"></i>
                </a>
            </li>
        </ul>
    </div>


    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('js/feather.min.js') }}"></script>


    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="assets/js/theme-script.js" type="7c727fd214671afd349a01f2-text/javascript"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/theme-script.js') }}"></script>
    <script src="{{ asset('js/rocket.min.js') }}"></script>
    <script src="{{  asset('plugins/toastr/toastr.min.js')}}"></script>
		<script src="{{  asset('plugins/toastr/toastr.js')}}"></script>


    @include('custom_js.custom_js');
    @include('custom_js.login_js');

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="bootstrap default admin template">
    <meta name="viewport" content="width=device-width">
    <title>Login | Admin Template</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="../../../assets/favicon/favicon.ico" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="../../../assets/favicon/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="57x57" href="../../../assets/favicon/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="../../../assets/favicon/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/favicon/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="../../../assets/favicon/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="../../../assets/favicon/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="../../../assets/favicon/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="../../../assets/favicon/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="../../../assets/favicon/apple-touch-icon-180x180.png"/>

    <!-- START GLOBAL CSS -->
    <link rel="stylesheet" href="../../../assets/global/plugins/Waves/dist/waves.min.css"/>
    <link rel="stylesheet" href="../../../assets/global/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../../../assets/icons_fonts/elegant_font/elegant.min.css"/>


    <link rel="stylesheet" href="../../../assets/pages/global/css/global.css"/>
    <!-- END GLOBAL CSS -->

    <!-- START TEMPLATE GLOBAL CSS -->
    <link rel="stylesheet" href="../../../assets/global/css/components-rounded.css"/>
    <!-- END TEMPLATE GLOBAL CSS -->

    <!-- START LAYOUT CSS -->
    <link rel="stylesheet" href="../../../assets/layouts/layout-material-menu/css/layout.min.css"/>
    <link rel="stylesheet" href="../../../assets/pages/login/login-v2/css/login_v2.css"/>
    <!-- END LAYOUT CSS -->
</head>
<body class="rounded-admin">
<!-- START CONTENT -->
<div class="login_v2">
    <div class="login_v2_main">
        <div class="login_v2_contain">
            <div class="login_v2_form text-xs-center">
                <i class="login_v2_profile_icon icon icon_lock"></i>
                <h5>Sign into your account</h5>
                <form action="#" id="form-validation" method="post" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="login_v2_text_field circle-input">
                        <input type="text" id='email' name='email' placeholder="Enter email">
                        <i class="icon icon_mail"></i>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <div class="login_v2_text_field circle-input">
                        <input type="password" id='password' name='password' placeholder="Password">
                        <i class="icon icon_key"></i>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div class="checkbox-login login_v2_check">
                        <div class="checkbox-squared">
                            <input value="None" id="checkbox-squared1" name="check" type="checkbox">
                            <label for="checkbox-squared1"></label>
                            <span>Remember me</span>
                        </div>
                    </div>
                    <div class="login_v2_forget_text">
                        <a href="forgot_password_v2.html">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn flat-buttons btn-primary btn-block text-xs-center">Sign in</button>
                    <div class="login_v2_sign_link">
                        <i class="arrow_back"></i>
                        Create A New Account? Go to <a href="register_v2.html">register.</a>
                    </div>
                </form>
            </div>
            <div class="login_v2_reserved_text text-xs-center bold-fonts">
                <p>© 2017. all right reserved.</p>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->


<!-- START CORE JAVASCRIPT -->
<script type="text/javascript" src="../../../assets/global/plugins/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="../../../assets/global/plugins/tether/dist/js/tether.min.js"></script>
<script type="text/javascript" src="../../../assets/global/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../../assets/global/plugins/Waves/dist/waves.min.js"></script>
<script src="../../../assets/global/plugins/classie/classie.js"></script>
<script type="text/javascript" src="../../../assets/pages/global/js/global.min.js"></script>
<!-- END CORE JAVASCRIPT -->
<!-- START PAGE PLUGINS -->
<script type="text/javascript"
        src="../../../assets/global/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- END PAGE PLUGINS -->
<!-- START PAGE JAVASCRIPT -->
<script type="text/javascript" src="../../../assets/global/js/global/global_validation.js"></script>
<!-- END PAGE JAVASCRIPT -->
</body>
</html>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

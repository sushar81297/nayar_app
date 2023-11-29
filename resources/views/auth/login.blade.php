@extends('layout')

@section('content')
<<<<<<< HEAD

<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">
  
                      <form action="{{ route('login.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="remember"> Remember Me
                                      </label>
                                  </div>
                              </div>
                          </div>
  
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Login
                              </button>
                              <div class="flex items-center justify-end mt-4">
                                <a class="ml-1 btn btn-primary" href="{{ url('auth/facebook') }}" style="margin-top: 0px !important;background: blue;color: #ffffff;padding: 5px;border-radius:7px;" id="btn-fblogin">
                                    <i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook
                                </a>
=======
    <section id="wrapper">
        <div class="login-register" style="padding:2% 0">
            <!-- background-image: url('assets/img/background.png');background-position: center;background-repeat: no-repeat; -->

            <div class="card login-box">
                <div class="card-body" style="text-align: center">
                    <form class="form" action="{{ route('login.post') }}" method="POST" aria-label="{{ __('Login') }}"
                        style=" width:50%;margin:0 auto">
                        @csrf
                        <a href="javascript:void(0)" class="text-center db">
                            <img src="{{ asset('assets/img/nayar_logo.png') }}"
                                style="width:50px;object-fit:cover;border-radius:10px" alt="Home" />
                            <span style="color:#c7126f;font-weight:bold">Nayar</span><br />
                        </a>
                        <div class="form-group" style="margin-top:10px">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <img src="{{ asset('assets/img/user_name_icon.png') }}"
                                            style="width:1.5rem;height:1.5rem" />
                                    </span>
                                </div>
                                <input id="username" type="text" placeholder="username"
                                    class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} custom-inputs"
                                    name="username" required>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
>>>>>>> 957f1213d10cd153ad805aa24b2d0ba34ae410d3
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <img src="{{ asset('assets/img/password_icon.png') }}"
                                            style="width:1.5rem;height:1.5rem" />
                                    </span>
                                </div>
                                <input id="password" type="password" placeholder="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} custom-inputs"
                                    name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                <div class="input-group-append">
                                    <span class="input-group-text " id="basic-addon2">
                                        <span id="eye" class="mdi mdi-eye-off"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-sm  text-uppercase "
                                style="margin-top:25px;margin-bottom:15px;width:100px;border-radius:20px;height:35px;background: #c7126f;border: 1px solid #c7126f;"
                                type="submit">Log In</button>
                        </div>
                        
                        <div class="social-auth-links text-center">
                            <a href="{{ url('auth/facebook') }}">
                                <img src="{{ asset('assets/img/facebook.png') }}" alt="Facebook login button png" width="170px"/>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <style type="text/css">
        .signup-email {
            background: url(assets/img/icon/mail.svg) left center no-repeat;
            width: 100%;
            border-bottom: solid 1px #e3e3e3 !important;
            /* padding: 15px 3px 0px 0px; */
        }

        .login-box {
            border-radius: 2rem;
            box-shadow: 0px 0px 6px 0px #cdcdcd;
            width: 36rem;
            /*height:21rem;*/
            background-image: url('assets/img/nayar_bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            margin: 0 auto;
            /* Added */
            float: none;
            /* Added */
            margin-top: 10%;

        }

        .custom-inputs {
            /*background:#e9ecef;*/
            background: #ECF1F6;
            border-left: none;
            border-right: none;
            border-radius: 5rem;
            border: none;

        }

        ::-webkit-input-placeholder {
            /* WebKit browsers */

            opacity: 0.5 !important;
            font-size: 0.8rem;
        }

        .input-group-text {
            border-radius: 5rem;
            background: #ECF1F6;
            border: none;
        }

        #eye {
            opacity: 0.5;
        }



        .form-control:focus {
            border: inherit;
            /*-webkit-box-shadow: none;*/
            /*box-shadow: none;*/
            /*border:none;*/
            background: #ECF1F6;
        }

        .btn-facebook:hover {
            color: #c6ccd9;
        }

        .signup-lock {
            background: url(assets/img/icon/lock.svg) left center no-repeat;
            width: 100%;
            border-bottom: solid 1px #e3e3e3 !important;
            /* padding: 15px 3px 0px 0px; */
        }

        .signup-input {
            width: 100%;
            border: none !important;
            margin: 0 0 15px 35px;
            font-size: 15px;
        }
    </style>
@endsection

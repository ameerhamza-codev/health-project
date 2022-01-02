<<<<<<< HEAD
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In & Sign Up Form</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/1788c719dd.js" crossorigin="anonymous"></script>

  <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="container">
    <div class="container__forms">
      <div class="form">
        <form class="form__sign-in" action="{{ route('login_auth') }}" method="POST">
          @csrf
          @if(session('error'))
          <div class="alert alert-danger" role="alert">
            {{ session('error') }}
          </div>
          @endif
          <h2 class="form__title">Sign In</h2>
          <div class="form__input-field">
            <i class="fas fa-user"></i>
            <input name="username" type="text" placeholder="Email/Phone" required />
          </div>
          <div class="form__input-field">
            <i class="fas fa-lock"></i>
            <input  name="password" type="password" placeholder="Password" required />
          </div>
          <input class="form__submit" type="submit" value="Login" />

        </form>

      </div>
    </div>
    <div class="container__panels">
      <div class="panel panel__left">
        <div class="panel__content">

        </div>
        <img class="panel__image" src="{{ asset('assets/images/doctor.png') }}" alt="" />
      </div>
      <div class="panel panel__right">
        <div class="panel__content">


        </div>
      </div>
    </div>
  </div>

</body>
<script>
  const signInBtn = document.querySelector("#sign-in-btn");
  const signUpBtn = document.querySelector("#sign-up-btn");
  const container = document.querySelector(".container");

  signUpBtn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
  });

  signInBtn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
  });
</script>
=======
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <!-- Fevicon 
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">-->
    <!-- Start CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- End CSS -->
</head>

<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                    @endif
                                    <form action="{{ route('login_auth') }}" method="POST">
                                        @csrf
                                        <h4 class="text-black my-4 ">Welcome Back</h4>
                                        <div class="form-group shadow-sm">
                                            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Email or Phone Number" required>
                                        </div>
                                        <div class="form-group shadow-sm">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password here" required>
                                        </div>
                                        <div class="form-row mb-3">
                                            <div class="col-sm-6">
                                                <div class="custom-control custom-checkbox text-left">
                                                    <input type="checkbox" class="custom-control-input" id="rememberme">
                                                    <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="forgot-psw">
                                                    <a id="forgot-psw" href="{{url('/user-forgotpsw')}}" class="font-14">Forgot Password?</a>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block font-18">Log in</button>
                                </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    <!-- Start JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <!-- End js -->
</body>

</html>
>>>>>>> 8af0d82634b5047c85b7c8400e1e6bb58be786ba

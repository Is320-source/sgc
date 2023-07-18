<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login - SGC</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="../login/css/login.css">
</head>
<body>
  <main>
    <div class="container-fluid">
      <div class="row">
         <!-- <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="../images/login.jpg" alt="login image" class="login-img">
        </div> -->
        <div class="col-sm-6 login-section-wrapper">
          <!-- <div class="brand-wrapper">
            <img src="{{ asset('../images/logo.png') }}" alt="logo" style="height: 100px; text-align:center;" class="logo">
          </div>-->
          <!-- <h1 class="login-title" style="margin-bottom: 0px !important;">Benfica Boulevard</h1> -->
          <div class="login-wrapper my-auto" style="margin-top: 0px !important;">
            <h3 class="login-title" style="margin-bottom: 10px !important;">Login</h3>
            <form class="form-horizontal new-lg-form" method="post" action="{{ route('login') }}">
            @csrf
              <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group mb-4">
                <input type="password" name="password" id="password" class="form-control" placeholder="Sua Senha">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <input name="login" id="login" class="btn btn-block login-btn"  type="submit" value="INICIAR">
            </form>
            <!-- <a href="#!" class="forgot-password-link">Forgot password?</a> -->
            <!-- <p class="login-wrapper-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p> -->
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>










<!doctype html>
<html lang="en">
  <head>
    <style>
        .hidden {
            display: none;
        }
    </style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('assets/loginAssets/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/loginAssets/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/loginAssets/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets/loginAssets/css/style.css')}}">

    <title>Login</title>
  </head>
  <body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img style="" src="{{asset('assets/loginAssets/images/Design sans titre.gif')}}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In</h3>
              <p class="mb-4"></p>
            </div>
            <form action="{{route('login')}}" method="post">
            @csrf
            <div class="form-group first">
                <label for="username" id="usernameLabel">Username</label>
                <input type="text" class="form-control" id="username" name="email" onblur="showLabel('usernameLabel')" onclick="hideLabel('usernameLabel')">
            </div>

              <div class="text-danger">
                @error('email')
                    {{$message}}
                @enderror
            </div>
            <div class="form-group last mb-4">
                <label for="password" id="passwordLabel">Password</label>
                <input type="password" class="form-control" id="password" name="password" onblur="showLabel('passwordLabel')" onclick="hideLabel('passwordLabel')">
            </div>

              <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{route('showRegister')}}" class="text-muted">Don't have an account? Sign Up</a>
                <span class="mx-2">&nbsp;</span> <!-- Space between links -->
                <a href="" class="text-muted">Forgot Password?</a>
            </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="{{asset('assets/loginAssets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/loginAssets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/loginAssets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/loginAssets/js/main.js')}}"></script>
  </body>
</html>
<script>
    function hideLabel(labelId) {
        var label = document.getElementById(labelId);
        if (label) {
            label.style.display = 'none';
        }
    }

    function showLabel(labelId) {
        var input = document.getElementById(labelId.replace('Label', ''));
        var label = document.getElementById(labelId);
        if (!input.value) {
            label.style.display = 'block';
        }
    }
</script>


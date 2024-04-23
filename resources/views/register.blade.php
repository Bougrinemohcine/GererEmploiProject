<!doctype html>
<html lang="en">
  <head>
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

    <title>Register</title>
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
              <h3>Sign Up</h3>
              <p class="mb-4"></p>
            </div>
            <form action="{{route('createUser')}}" method="post">
                @csrf
                <div class="form-group first mb-2">
                    <label for="username" class="label">Username</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="text-danger">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
                <div class="form-group first mb-2">
                    <label for="email" class="label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="text-danger">
                    @error('email')
                        {{$message}}
                    @enderror
                </div>
                <div class="form-group last mb-2">
                    <label for="password" class="label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="text-danger">
                    @error('password')
                        {{$message}}
                    @enderror
                </div>
                <div class="form-group last mb-4">
                    <label for="password" class="label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <input type="submit" value="Sign Up" class="btn btn-block btn-primary">
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
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(function(input) {
            input.addEventListener('focus', function() {
                const label = this.previousElementSibling;
                label.style.display = 'none';
            });
            input.addEventListener('blur', function() {
                const label = this.previousElementSibling;
                if (this.value === '') {
                    label.style.display = 'block';
                }
            });
        });
    });
</script>

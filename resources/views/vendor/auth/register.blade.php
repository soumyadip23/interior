<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    <title>Register - {{ config('app.name') }}</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="login-box">
        <form class="login-form" action="{{ route('admin.register.post') }}" method="POST" role="form">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            @csrf
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
           
            <div class="form-group">
                <label for="first_name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="" autocomplete="off">
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">E-Mail Address</label>
                <input type="email" class="form-control" value="">
            </div>
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="contact_no">Contact No</label>
                    <input class="form-control" type="text" name="contact_no" id="contact_no" value="{{ old('contact_no') }}"/>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="tile-body">
                <div class="form-group">
                    <label class="control-label" for="address">Address</label>
                    <input class="form-control" type="text" name="address" id="searchTextField" value="{{ old('address') }}"/>
                        <input type="hidden" id="lat" name="lat" />
                         <input type="hidden" id="long" name="long" />
                </div>
            </div>
          
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block"> Sign Up </button>
            </div>
            <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>
        </form>
    <!-- <div class="border-top card-body text-center">Have an account? <a href="{{ route('admin.login') }}">Log In</a></div> -->
        </form>
    </div>
</section>
<script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('backend/js/popper.min.js') }}"></script>
<script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/js/main.js') }}"></script>
<script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
</body>
</html>
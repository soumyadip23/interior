<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Interior Staff Login</title>

    <link rel="stylesheet" href="{{ asset('staff/styles/styles.css') }}"/>
    <link rel="stylesheet" href="{{ asset('staff/styles/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('staff/styles/bootstrap.min.css') }}" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
    />
  </head>
  <body>

    <section class="login-create-account-sec login-sec">
        <div class="content">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-md-12 col-lg-5 order-lg-2 mb-md-4 mb-4" data-aos="fade-down" data-aos-duration="2000">
                <img src="images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
              </div>
              <div class="col-md-12 col-lg-7 contents" data-aos="fade-down" data-aos-duration="2000">
                <div class="row">
                  <div class="col-md-8">
                    <div class="mb-4 login-create-account-heading">
                      <h3>Login</h3>
                      <p class="mb-4"></p>
                    </div>
                    <form class="login-form" action="{{ route('staff.login.post') }}" method="POST" role="form">
                        @if(session()->has('verified'))
                            <div class="alert alert-success">
                                Verified successfully
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="email">Email/Mobile</label>
                            <input class="form-control" type="text" id="email" name="email" placeholder="Email address" autofocus value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <div class="utility">
                                <div class="animated-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"><span class="label-text">Remember me</span>
                                    </label>
                                </div>
                            </div>
                            <a class="" href="">Forgot Your Password?</a>
                        </div>
                        <div class="form-group btn-container">
                            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
                        </div>
                    </form>
                   
    
                    <div class="create-account mt-4">
                      
                    </div>
                  </div>
                </div>
    
              </div>
    
            </div>
          </div>
        </div>
      </section>


    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
      integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
      integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>
    <script src="{{ asset('staff/js/app.js') }}"></script>
  </body>
</html>

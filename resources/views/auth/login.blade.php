@extends('layout.app.app', ['class' => 'bg-default'])

@section('content')
    @include('layout.headers.guest')

   
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ url('/') }}/vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>

    

  </head>
                <!-- <body class="login-img3-body" style="background-color: linen!important;"> -->
      <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">  
                <div class="card-header bg-transparent pb-5">
                        <div class="text-muted text-center mt-2 mb-3"><small>{{ __('Sign in with') }}</small></div>
                        <div class="btn-wrapper text-center">
                            <a href="#" class="btn btn-neutral btn-icon mr-4">
                                <span class="btn-inner--icon"><img src="{{ asset('assets/img/icons/common/github.svg')}}"></span>
                                <span class="btn-inner--text">{{ __('Github') }}</span>
                            </a>
                            <a href="#" class="btn btn-neutral btn-icon">
                                <span class="btn-inner--icon"><img src="{{ asset('assets/img/icons/common/google.svg')}}"></span>
                                <span class="btn-inner--text">{{ __('Google') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>
                                <a href="{{ route('register') }}">{{ __('Create new account') }}</a> {{ __('OR Sign in with these credentials:') }}
                            </small>
                            <br>
                            
                        </div>
             <form class="form" autocomplete="off" id="loginForm" role="form" 
             method="POST" action="{{ route('login') }}">
        
          {{ csrf_field() }}
             
          @if ($errors->has('email'))
              <span class="help-block text-left">
                  <strong>{{ $errors->first('email') }}</strong>
              </span>
          @endif
          @if ($errors->has('password'))
              <span class="help-block text-left">
                  <strong>
                  {{ $errors->first('password') }}                      
                  </strong>
              </span>
          @endif
        
                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Email" id="email" type="text" name="email"  required autofocus>
                                </div>
                                
                                </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" autocomplete="off" required>
                                </div>
                                
                            </div>
       
        
        <button class="btn btn-primary btn-lg btn-block" type="submit" id="loginFormBtn" >Login</button>
     
     
    </form>
  </div>
</div>
<div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light">
                                <small>{{ __('Forgot password?') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('register') }}" class="text-light">
                            <small>{{ __('Create new account') }}</small>
                        </a>
                    </div>
                </div>
</div>
</div>
</div>
        <script>
        var IV = '1234567890123412';
        var KEY = '201707eggplant99';
        function encrypt(str) {
            key = CryptoJS.enc.Utf8.parse(KEY);// Secret key
            var iv= CryptoJS.enc.Utf8.parse(IV);//Vector iv
            var encrypted = CryptoJS.AES.encrypt(str, key, { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7});
            return encrypted.toString();
        }

        jQuery(document).ready(function(){
          jQuery("#loginFormBtn").click(function(){                   
              var email = jQuery('#email').val();                            
              encryptedEmail = encrypt(email);              
              var password = jQuery('#password').val();                            
              encryptedPassword = encrypt(password);    

              jQuery('#email').val(encryptedEmail);
              jQuery('#password').val(encryptedPassword);
              jQuery("#loginForm").submit(); // Submit the form
            });
        });


        
        /**
        * encryption
        */
        
</script>
        
  <!-- </body> -->
</html>
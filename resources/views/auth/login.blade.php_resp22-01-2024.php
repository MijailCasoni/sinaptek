@extends('layouts.app')

@section('content')
<style type="text/css">
body {
    background-image: url("{{ URL::asset('dist/img/fondo1.jpg')}}");
    background-size: cover;
}
.loginalt {
            display: flex;
            justify-content: flex-end;
            height: 100vh;
            padding: 0px;
        }

</style>



    <div class="row justify-content-left">

            <div class="card justify-content-center col-md-4 loginalt" style="opacity: 0.9;background-color: #d4d5d9;">
                <div class="card-header">
                    <img src="{{ URL::asset('dist/img/AdminLTELogo.png')}}" class="img-circle img-size-32 mr-2" style="opacity: .8; height:55px;width: 60px;">
                    {{ __('SEGMA LOGIN') }}
                    
                </div>            
                <div class="card-body" style="padding-top: 50px;">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="container">
                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-end">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-11 offset-md-1">
                                <button type="submit" class="btn btn-primary" style="background-color: #537eb9;border-color: #767676;padding-top: 7px;padding-bottom: 7px;padding-left: 50px;padding-right: 50px;">
                                    {{ __('Ingresar') }}
                                </button>

                                @if (Route::has('password.request'))
                                <button class="btn btn-primary" style="background-color: #537eb9;border-color: #767676;" onclick="">
                                    <a class="btn btn-link" style="color:white;padding-top: 0px;padding-bottom: 0px;" href="{{ route('password.request') }}">
                                        {{ __('Olvidaste el password?') }}
                                    </a>
                                    </button>
                                @endif

                                <!-- <button type="submit" class="btn btn-primary" style="background-color: #537eb9;border-color: #767676;padding-top: 7px;padding-bottom: 7px;padding-left: 50px;padding-right: 50px;"><a class="btn btn-link" style="color:white;padding-top: 0px;padding-bottom: 0px;" href="{{ route('register') }}">
                                        {{ __('Registrar') }}
                                    </a>
                                    
                                </button> -->
                                </div>
                            </div>    
                        </div>

                        

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

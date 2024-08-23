<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <style type="text/css">
        html, body{
            min-height: 100%;
        }


        body{
            background-image: url("AdminLTE/dist/img/fondo4.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            padding-left: 0px;
            margin: 0px;
        }

        .container-login{
            background-color: #fffefe;
            position:absolute;
            height: 100%;
            width: 500px;
            align-items: center;
        }

        .login-logo{
            display: flex;
            width: 50px;
            height: 50px;
            padding-top: 20%;
            margin-left: 10%;
        }

        h1{
            font-family: "Century Gothic", sans-serif;
            font-size: 20px;
            color: #080887;
        }

        .login-box{
            display:block;
            position:relative;
            align-items: center;
            text-decoration: none;
        }

        .form-login{
            position: center;
            margin-top: 10%;
            padding-left: 20%;
            justify-content: center;
            align-items: center;
        }

        input{
            margin: 10px;
            padding: 10px
        }
        .input-group input[type="email"][type="password"]{
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.2s ease-in-out;

        }

        .button{
            display: flexbox;
            position: relative;
            padding-left: 20%;
            width: 80px;
        }
        button {
            background-color: #4740e7;
            width: 100px;
            height: 40px;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            /*box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);*/
            display: relative;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
            
        }

        .forget-pass{
            float: left;
            margin-top: 15px;
            text-decoration: none;
            color: #08054d;
        }
    </style>
    <body>
        <div class="container-login">
            <div class="login-logo">
                <img src="AdminLTE/dist/img/AdminLTELogo.png" alt="logo segma">
                <!-- <h1>SEGMA</h1> -->
            </div>
            
            <div class="form-login">    
                        <form method="POST" action="{{ route('login') }}" class="form-cont">
                            @csrf
                            <div class="input-mail">
                                <span class="fa fa-envelope-o" aria-hidden="true"></span>
                                <input id="email" type="email" placeholder="Correo" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input">
                                <span class="fa fa-key" aria-hidden="true"></span>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <div class="button">
                                <button type="submit">{{ __('Ingresar') }}</button>
                            </div>
                             @if (Route::has('password.request'))
                            <a class="forget-pass" id="forget-pass" href="{{ route('password.request') }}">{{ __('Olvidó su contraseña?') }}</a>
                             @endif
                        </form>
            </div>
        </div>                   
    </body>
</html>

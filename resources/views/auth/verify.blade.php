@extends('layouts.app')

@section('content')
<style type="text/css">
body {
    background-image: url("{{ URL::asset('dist/img/fondo1.jpg')}}");
    background-size: cover;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card justify-content-center" style="margin-top: 50px;opacity: 0.9;background-color: #d4d5d9;">
                <div class="card-header"><img src="{{ URL::asset('dist/img/AdminLTELogo.png')}}" class="img-circle img-size-32 mr-2" style="opacity: .8; height:55px;width: 60px;">{{ __('Verifica tu Email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un link de verificación se ha enviado a tu email.') }}
                        </div>
                    @endif

                    {{ __('Antes, por favor chequea tu email donde enviaremos el link.') }}
                    {{ __('Si no reciviste el email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Click aqui para otra operación') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

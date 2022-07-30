@extends('layouts.app')

@section('content')
    @php
        // use App\Language;
        //
        // $lang =
        // preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];
        //
        // $languages = Language::all();
        //
        // $set_lang = false;
        //
        // foreach ($languages as $language) {
        //     if($language->lang == $lang){
        //         app()->setLocale($lang);
        //         $set_lang = true;
        //         $language_id = $language->id;
        //     }
        // }
        //
        // if(!$set_lang){
        //     app()->setLocale('it');
        //     $language_id = 2;
        // }
        app()->setLocale('it');
        $language_id = 2;
    @endphp
<script type="text/javascript">
    login = true;
</script>
<div class="bg-blue" id="login" style="background-image: url({{asset("storage/images/bg-contact.svg") }}); background-position: left 0px bottom -17px; background-repeat: no-repeat; background-size: 700px 500px;">
  <div class="container">
    <div class="item-cont p-2 pb-5">
        <div class="item-style">
            <div class="row d-flex justify-content-center">
                <div class="bg-dark custom-card col-sm-12 col-md-12 col-lg-8 col-xl-6 p-5">
                    <div  class="switch-button-container pt-1 pb-5">
                        <label class="pt-2 mr-4 font-weight-bold text-right" for="" style="width: 70px;">Login</label>
                        <button class="button r switch-button d-inline-block">
                            <input type="checkbox" class="checkbox" @click="login=!login" id="switch-checkbox" :checked="!login">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </button>
                        <label class="pt-2 ml-4 font-weight-bold" for="" style="width: 70px;">Registrati</label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-7 p-0">
                            <a href="{{ url('auth/google') }}" style="margin-top: 20px;" class="btn btn-lg button-color-white btn-block">
                                <img src="{{asset("storage/images/icon-google.svg") }}" alt="">
                                <strong class="text-dark ml-2">Entra con Google</strong>
                            </a>
                        </div>
                    </div>
                    <div class="or-container">
                        <div class="line-separator"></div>
                        <div class="or-label">oppure</div>
                        <div class="line-separator"></div>
                    </div>
                    <form v-show="login" method="POST" action="{{ route('login') }}" id="loginForm" v-cloak>
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                {{ __('E-Mail Address') }}
                            </label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    @if($message=='These credentials do not match our records.')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{__( $message) }}</strong>
                                        </span>
                                        <script type="application/javascript">
                                            login = true;
                                        </script>
                                    @endif
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <div class="placeholder-icon">
                                    <input id="password" :type="show_password?'text':'password'" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <i :class="show_password?'fas fa-eye':'fas fa-eye-slash'" @click="show_password=!show_password"></i>
                                    @error('password')
                                        @if($message!='The password confirmation does not match.'  && $message!="The password format is invalid.")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__( $message) }}</strong>
                                            </span>
                                            <script type="application/javascript">
                                                login = true;
                                            </script>
                                            {{-- <span>Login</span> --}}
                                        @endif
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" id="button-submit-login" class="invisible">
                                </button>
                                <button type="button" :class="login_btn?'button-style button-color':'button-style button-color button-deactivate'" @click="submitLogin()" v-cloak>
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{-- <a href="{{ url('auth/google') }}" style="margin-top: 20px;" class="btn btn-lg btn-success btn-block">
                            <strong>Login With Google</strong>
                        </a> --}}
                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <span>Non sei ancora registrato?
                                    <a class="" href="{{ route('home') }}">Registrati</a>
                                </span>
                            </div>
                        </div> --}}
                    </form>
                    <form v-show="!login" method="POST" action="{{ route('register') }}" id="registerForm" v-cloak>
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required maxlength="15" autocomplete="first-name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">Cognome</label>
                            <div class="col-md-6">
                                <input id="surname" type="surname" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required maxlength="20" autocomplete="family-name">
                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Data di nascita
                                <div class="info">
                                    <button aria-label="La data di nascita è utile a verificare che tu sia maggiorenne, non sarà visibile agli altri utenti." data-microtip-position="top" data-microtip-size="medium" type="button" role="tooltip">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </label>
                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="bday" min="1900-01-01" :max="maxbirthdate()">

                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{__( $message) }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    @if($message!='These credentials do not match our records.')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{__( $message) }}</strong>
                                        </span>
                                        <script type="application/javascript">
                                            login = false;
                                        </script>
                                    @endif
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="language_id" value="{{$language_id}}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                {{ __('Password') }}
                                <div class="info">
                                    <button aria-label="Almeno 8 caratteri,
                                                        carattere minuscolo,
                                                        carattere maiuscolo,
                                                        numero,
                                                        simbolo(@$!%*#?&_-)"
                                    data-microtip-position="top" data-microtip-size="medium" type="button" role="tooltip">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </label>
                            <div class="col-md-6">
                                <div class="placeholder-icon">
                                    <input :type="show_password?'text':'password'" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <i :class="show_password?'fas fa-eye':'fas fa-eye-slash'" @click="show_password=!show_password"></i>
                                    @error('password')
                                        @if($message=='The password confirmation does not match.' || $message=="The password format is invalid.")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{__($message)}}</strong>
                                            </span>
                                            <script type="application/javascript">
                                                login = false;
                                            </script>
                                        @endif
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Conferma password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" :type="show_password?'text':'password'" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="" id="tc" required>
                                    <label class="form-check-label " for="tc">
                                        <small>
                                            {{ __('I accept these') }}
                                        <a href="{{ route('termsAndConditions') }}">
                                            {{ __('Terms & Conditions') }}
                                        </a>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="" id="pp"
                                    required>
                                    <label class="form-check-label" for="pp" >
                                        <small>
                                            {{ __('I have read the information on the processing of personal data.') }}
                                        <a href="{{ route('privacyPolicy') }}">Privacy Policy</a>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="button-submit-register" class="invisible">
                                </button>
                                <button type="button" :class="register_btn?'button-style button-color':'button-style button-color button-deactivate'" @click="submitRegister()" v-cloak>
                                    Registrati
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

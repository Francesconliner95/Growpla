@extends('layouts.app')

@section('content')
    @php
        use App\Language;

        $lang =
        preg_split('/,|;/',request()->server('HTTP_ACCEPT_LANGUAGE'))[1];

        $languages = Language::all();

        $set_lang = false;

        foreach ($languages as $language) {
            if($language->lang == $lang){
                app()->setLocale($lang);
                $set_lang = true;
                $language_id = $language->id;
            }
        }

        if(!$set_lang){
            // app()->setLocale('en');
            // $language_id = 1;
            app()->setLocale('it');
            $language_id = 2;
        }
    @endphp
<div class="container not-log-main-hg">
    <div class="item-cont">
        <div class="item-style">
            <h6>Registrazione</h6>
            <div class="text-center pb-4">
                <img src="{{ asset("storage/images/logo-fullsize.svg") }}" alt="" class="col-sm-12 col-md-12 col-lg-6 col-xl-6 h-auto">
            </div>
            <div class="card-body" id="register">
                {{-- <div v-if="!code_verified" class="" v-cloak>
                    <h5 for="email" class="text-center m-4">{{ __('Access to the platform is currently reserved exclusively for those who have the invitation code. If you are among the first 100 users who received it, enter it in the appropriate section') }}</h5>
                    <div class="form-group d-flex justify-content-center">
                        <div class="mr-2">
                            <input type="text" class="form-control"  placeholder="Inserisci codice qui" v-model="code" autofocus required>
                        </div>
                        <button type="button" class="button-style button-color" @click="sendCode()">
                            {{ __('Verify') }}
                        </button>
                    </div>
                    <span v-if="error" class="input-error">
                        <strong>{{ __('Invalid code') }}</strong>
                    </span>
                </div> --}}
                <form  {{--v-else--}} method="POST" action="{{ route('register') }}" v-cloak>
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
                    <div class="form-group row">
                        <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Data di nascita
                            <div class="info">
                                <button aria-label="La data di nascita è utile a verificare che tu sia maggiorenne, non sarà visibile agli altri utenti." data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </label>
                        <div class="col-md-6">
                            <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="bday" min="1900-01-01" :max="maxbirthdate()">

                            @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="language_id" value="{{$language_id}}">

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Conferma password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
                            <button type="submit" class="button-style button-color">
                                Registrati
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

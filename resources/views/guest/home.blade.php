@extends('layouts.app')

@section('content')
    <script type="text/javascript">
        accounts = "{{$accounts}}";
        cooperations = "{{$cooperations}}";
        chats = "{{$chats}}";
    </script>
    <div class="background not-log-main-hg" id="guest-home">
        <div class="container">
            <div class="logo-cont mt-5 mb-3 position-relative">
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <img src="{{ asset("storage/images/logo-fullsize.svg") }}" alt="" class="logo ">
                    <span class="beta">BETA</span>
                </div>
            </div>
            <h3 class="pt-3 text-center">
                {{__('The platform that allows direct interaction between incubators, investors, companies, organizations, professionals and Startups following your growth step by step.')}}
            </h3>
            <div class="preview row">
                <div class="intro col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if($language_id==2)
                        <img v-if="" src="{{ asset('storage/images/home_it.svg') }}" alt="" class="home-img">
                    @else
                        <img v-if="" src="{{ asset('storage/images/home_en.svg') }}" alt="" class="home-img">
                    @endif
                    <h3 class="pt-4">{{__("Register and create one of these")}}
                        <a href="#accounts" class="txt-green">
                            {{__("accounts")}}</a>!
                    </h3>
                </div>
                <div v-if="!code_verified" class="code-ver col-sm-12 col-md-6 col-lg-6 col-xl-6" v-cloak>
                    {{-- <h4 for="email" class="text-center">{{ __('Access to the platform is currently reserved exclusively for those who have received the invitation code. If you have one, enter it in the appropriate section') }}</h4>
                    <div class="form-group">
                        <div class="">
                            <input type="text" class="form-control"  placeholder="{{ __('Enter code here') }}" v-model="code" autofocus required>
                        </div>
                        <button type="button" class="button-style button-color" @click="sendCode()">
                            {{ __('Send') }}
                        </button>
                    </div>
                    <span v-if="error" class="input-error">
                        <strong>{{ __('Invalid code') }}</strong>
                    </span>--}}
                    <h4 for="email" class="text-center">{{ __('Enter Growpla! Enter your email to access the registration form and be among the first 100 users to test the platform') }}</h4>

                    <div class="form-group">
                        <input type="email" class="form-control mr-2"  placeholder="{{ __('Enter email here') }}" v-model="email" autofocus autocomplete="email" required>
                        <button type="submit" class="button-style button-color" @click="sendEmail()">
                            {{ __('Send') }}
                        </button>
                    </div>
                    <span v-if="error" class="input-error" v-cloak>
                        <strong>{{ __('Invalid email') }}</strong>
                    </span>
                    <div class="">
                        <span>Sei gia registrato? Vai al
                            <a class="txt-green" href="{{ route('login') }}">Login</a>
                        </span>
                    </div>
                </div>
                <div v-else class="code-ver col-sm-12 col-md-6 col-lg-6 col-xl-6 text-center" v-cloak>
                    <i class="fas fa-check-circle txt-green mb-4"></i>
                    <h4 for="email" class="text-center">{{ __('Mail sent successfully, you will receive a reply shortly') }}</h4>
                </div>
                {{-- <div v-else-if="!im_log" class="login-register-cont col-sm-12 col-md-6 col-lg-6 col-xl-6" v-cloak>
                    <div class="switch">
                        <button @click="log_reg_switch(true)" type="button" name="button" :class="show_login?'selected':''">
                            {{ __('Login') }}
                        </button>
                        <button @click="log_reg_switch(false)" type="button" name="button" :class="!show_login?'selected':''">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <div v-if="show_login" class="log-reg">
                        <form method="POST" action="{{ route('login') }}" name="formLogName">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" v-model="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-8 password">
                                    <input id="password" :type="show_password?'text':'password'" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" v-model="psw">
                                    <button type="button" name="button" @click="show_password=!show_password">
                                        <i :class="show_password?'fas fa-eye':'fas fa-eye-slash'"></i>
                                    </button>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="remember_me">

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button v-if="!press_reg" class="button-style button-color" @click="loading(1)">
                                        {{ __('Login') }}
                                    </button>
                                    <div v-else class="anim-load-cont">
                                        <span v-for="item in 5" class="anim-item anim-green"></span>
                                    </div>
                                    <button type="submit" id="login-button" class="invisible">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div v-else class="log-reg">
                        <form method="POST" action="{{ route('register') }}" name="formRegName">
                            @csrf

                            {{-- <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                                <div class="col-md-8">
                                    <input id="email_r" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-8 password">
                                    <input id="password_r" :type="show_password?'text':'password'" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <button type="button" name="button" @click="show_password=!show_password">
                                        <i :class="show_password?'fas fa-eye':'fas fa-eye-slash'"></i>
                                    </button>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __($message) }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right password">
                                    {{ __('Confirm Password') }}
                                </label>

                                <div class="col-md-8 password">
                                    <input id="password-confirm" :type="show_password?'text':'password'" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <input type="hidden" name="language_id" value="{{$language_id}}">

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
                                    <button v-if="!press_reg" class="button-style button-color" @click="loading(2)">
                                        {{ __('Register') }}
                                    </button>
                                    <div v-else class="anim-load-cont">
                                        <span v-for="item in 5" class="anim-item anim-green"></span>
                                    </div>
                                    <button type="submit" id="register-button" class="invisible">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <h3>Hai già una sessione attiva</h3>
                    <a class="button-style button-color pt-3 pb-3 pl-5 pr-5" href="{{ route('admin.accounts.index') }}">
                        Entra
                    </a>
                    <a class="button-style button-color-red pt-3 pb-3 pl-5 pr-5" href="{{ url('/logout') }}">Logout </a>
                </div> --}}
            </div>
        </div>
        <div class="stats">
            <div class="container">
                {{-- <h3 class="section-title">
                    <b></b>
                    <span>RELAZIONI</span>
                    <b></b>
                </h3> --}}
                <div class="row justify-content-center">
                    <div class="text-center col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <h2 class="count-anim" id="profiles">0</h2>
                        <p class="font-weight-bold">{{__("Profiles")}}</p>
                    </div>
                    <div class="text-center col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <h2 class="count-anim" id="cooperations">0</h2>
                        <p class="font-weight-bold">{{__("Collaborations born")}}</p>
                    </div>
                    <div class="text-center col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <h2 class="count-anim" id="chats">0</h2>
                        <p class="font-weight-bold">{{__("Conversations started")}}</p>
                    </div>

                </div>
            </div>
        </div>
        <div class="landing" id="accounts">
            <div class="container pb-4">
                <h3 class="section-title">
                    <b></b>
                    <span class="text-uppercase">{{__('our accounts')}}</span>
                    <b></b>
                </h3>
            </div>
            <div class="container pb-5">
                <div class="row justify-content-center">
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-startup.svg" alt="" class="w-100"> --}}
                            <div class="card-info">
                                <h2>{{__('Company')}}</h2>
                                <p>{{__('Do you have a business idea? Growpla helps you understand the Startup ecosystem by indicating what you need based on the stage of the life cycle you are going through and allowing you to find and get in touch with those who could help you. If your business has passed the Startup stage you can use this type of account to get in touch with other companies that can offer you the services you need')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-cofounder.svg" alt="" class="w-100"> --}}
                            <div class="card-info">
                                <h2>{{__('Aspiring Co-founder')}}</h2>
                                <p>{{__('Collaborate in the realization of interesting business ideas by making your skills available. We can grow together!')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-incubatore.svg" alt="" class="w-100"> --}}
                            <div class="card-info">
                                <h2>{{__('Incubator/Accelerator')}}</h2>
                                <p>{{__('It supports the birth and growth of the Startups present on the platform')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-investitori.svg" alt="" class="w-100"> --}}
                            <div class="card-info" >
                                <h2>Business Angel, Venture Capital, Private Equity</h2>
                                <p>{{__('Scout and invest in Startups that are part of our network')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-servizi.svg" alt="" class="w-100"> --}}
                            <div class="card-info">
                                <h2>{{__('Company Services')}}</h2>
                                <p>{{__('The account dedicated to freelancers, companies and their employees who offer Startups coaching, mentoring, advisoring, software development and nocode, marketing, legal, crowdfunding, pitch and business plan creation, subsidized finance, product development, prototyping, plant engineering and much more. Including the services offered to companies that have passed the Startup phase')}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-up">
                        <div class="item-style p-0">
                            {{-- <img src="/storage/images/account-agenzia.svg" alt="" class="w-100"> --}}
                            <div class="card-info">
                                <h2>{{__('Regional/National Agency')}}</h2>
                                <p>{{__('Create an account on the platform in order to inform the Startups present about opportunities, calls and incentives aimed at encouraging their development')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container pb-2">
            <h3 class="section-title">
                <b></b>
                <span class="text-uppercase">{{__('partners')}}</span>
                <b></b>
            </h3>
            <div class="partner row justify-content-center">
                {{-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                    <a href="https://www.knowledge-hub.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/khub-logo.png" alt="">
                    </a>
                </div> --}}
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                    <a href="https://www.lum.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/lum-logo.png" alt="">
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                    <a href="https://www.goheroes.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/heroes-logo.png" alt="">
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                    <a href="https://www.viscontilegal.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/visconti-logo.png" alt="">
                    </a>
                </div>
            </div>
        </div>
        <div v-if="showConsenScreen" class="cookie-consent" v-cloak>
            <p class="position-relative">
                <a href="#" @click="closeConsentScreen()" class="txt-blue edit-top-right">
                    <i class="fas fa-times"></i>
                </a>
            </p>
            <div class="container">
                <p>{{__('Growpla and third-party use technical cookies and similar technologies (“tracking tools”) to operate and improve the platform. For full details on how we use cookies please see the full')}} <a href="{{ route('cookiePolicy') }}" class="txt-green">cookie policy</a>.
                </p>
                <div v-if="cookieSettings" class="cookie-list pb-3">
                    <div  class="switch-button-container pt-1 pb-2">
                        <label class="pt-2 mr-4" for="">{{__('Technical Cookies')}}</label>
                        <span>{{__('Always Enabled')}}</span>
                    </div>
                    <div  class="switch-button-container pt-1 pb-2">
                        <label class="pt-2 mr-4" for="">{{__('Analytical Cookies')}}</label>
                        <div class="button r switch-button d-inline-block">
                            <input type="checkbox" class="checkbox" v-model="analyticsCookie">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                    <a href="#" class="txt-blue" @click="acceptSelected()">{{__('Accept selected')}}</a>
                </div>
                <p>
                    <a href="#" class="txt-blue" @click="cookieSettings=!cookieSettings">
                        <span v-if="cookieSettings">{{__('Close customize')}}</span>
                        <span v-else>{{__('Customize')}}</span>
                    </a>
                    <a href="#" class="ml-5 txt-green" @click="acceptAll()">{{__('Accept all')}}</a>
                </p>
            </div>
        </div>
    </div>
@endsection

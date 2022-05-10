<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset("storage/images/logo.svg") }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js?14') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css?14') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JQ65YBYMPD"></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
    <script type="text/javascript">
        window.csrf_token = "{{ csrf_token() }}";
    </script>
    <!-- Google Analytics -->
    <script>
        function getCookie(name){
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };
        //console.log(this.getCookie("analyticsCookie"));
        //Controllo se accettato google analytics
        if(this.getCookie("analyticsCookie")=='accept'){
            //console.log('abilitato');
            // abilito GOOLGE Analytics
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-JQ65YBYMPD');
        }else{
            //console.log('disabilitato');
            // disabilito GOOLGE Analytics
            window['ga-disable-G-EX66GGGB3E'] = true;
        }
    </script>
    <div id="app">
        @guest
        {{-- SE NON LOGGATO NON COMPARE LA NAVBAR --}}

        @else
            @if(!Auth::user()->tutorial)
            <nav id="nav-bar">
                <div id="container-nb" class="container-nb">
                    <div class="row">
                        <div class="nav-left d-inline-block col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-center mobile-hide">

                            <a href="{{ route('home') }}" class="position-relative">

                            <a href="{{ route('admin.search') }}" class="position-relative">
                                <img src="{{ asset("storage/images/logo-fullsize.svg") }}" alt="" id="logo-fullsize" class="logo" style="width:300px;">
                                {{-- <span class="beta">BETA</span> --}}
                            </a>
                        </div>
                        <div class="nav-right d-inline-block col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-center">
                            <a href="{{ route('admin.search') }}" class="mobile-show position-relative">
                                <img src="{{ asset("storage/images/logo.svg") }}" alt="" class="mini-logo" id="logo">
                                {{-- <span class="beta">BETA</span> --}}
                            </a>
                            {{-- <div class="d-inline-block">
                                <a class="icon scale" href="{{route('admin.search')}}">
                                    <i class="fas fa-search"></i>
                                </a>
                            </div> --}}
                            <div class="dropdown show notification not-navbar">
                                <a href="#" role="button" id="notDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon tiny-img scale" @click="readNotifications()">
                                    <div class="img-cont micro-img no-br">
                                        <img src="{{ asset("storage/images/icon-not.svg") }}" alt="" id="not-img" class="rounded-0">
                                        <span v-show="notifications.length" v-cloak>
                                            @{{notifications.length}}
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu show-notf-preview bg-dark" aria-labelledby="notDropdown">
                                    <div v-if="notifications.length>0"  class="notf">
                                        <a v-for="notification in notifications"
                                        :href="notification.notification_type.url + notification.parameter">
                                            <div class="">
                                              <strong>@{{notification.name}}</strong>
                                              <span>@{{notification.notification_type.message_it}}</span>
                                              <strong>@{{notification.end_name}}</strong>
                                              <strong>@{{notification.name_type}}</strong>
                                            </div>
                                        </a>
                                    </div>
                                    <div v-else class="notf">
                                        <span>{{__('No new notifications')}}</span>
                                    </div>
                                    <div class="v-notf">
                                        <a class="mini-txt txt-green" :href="'/admin/notifications/'">
                                            <span>{{__('See all notifications')}}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat d-inline-block" v-cloak>
                                <a class="not-navbar icon tiny-img scale" href="{{route('admin.chats.index')}}">
                                    <div class="img-cont micro-img no-br">
                                        <img src="{{ asset("storage/images/icon-chat.svg") }}" alt="" id="chat-img" class="rounded-0">
                                        <span v-if="message_not_read_qty" v-cloak>
                                            @{{message_not_read_qty}}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            {{-- <div class="chat d-inline-block">
                                <a class="not-navbar icon" href="#" @click="switchAccounts()">
                                      <i class="fas fa-exchange-alt"></i>
                                </a>
                            </div> --}}
                            <div class="account-menu d-inline-block d-flex align-items-center" v-cloak>
                                <div class="user-image-cont">
                                    <a href="{{route('admin.users.show',Auth::user()->id)}}" class="scale ">
                                        <div class="img-cont tiny-img">
                                            @if(Auth::user()->image)
                                            <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="">
                                            @endif
                                        </div>
                                    </a>
                                    {{-- <a v-if="page_selected"
                                    :href="'/admin/pages/'+ page_selected.id" class="micro-item">
                                        <div class="img-cont micro-img">
                                            <img v-if="page_selected.image" :src="'/storage/'+ page_selected.image" alt="">
                                        </div>
                                    </a> --}}
                                </div>
                                <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{-- <div class="drop-menu mobile-hide"> --}}
                                        {{-- @{{user.name}} @{{user.surname}} --}}
                                    {{-- </div> --}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{route('admin.users.show',Auth::user()->id)}}" class="dropdown-item">
                                        <i class="fas fa-user"></i>
                                        Il mio profilo
                                    </a>
                                    {{-- <a @click="switchAccounts()" type="button" name="button" class="dropdown-item">
                                        <i class="fas fa-exchange-alt"></i>
                                        Cambia account
                                    </a> --}}
                                    <a class="dropdown-item"
                                    href="{{route('admin.users.settings',Auth::user()->id)}}">
                                        <i class="fas fa-cog"></i>
                                        Impostazioni
                                    </a>
                                    <a class="dropdown-item"
                                    href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </nav>
            <div class="nav-bar-space">

            </div>
            @endif
        @endguest
        {{-- class="py-4" --}}
        <main id="main">
            @yield('content')
        </main>
        @if(!Auth::user()->tutorial)
        <footer id="footer">
            <div class="container ">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="row d-flex justify-content-center">
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                <div class="legal mini-txt">
                                    <div class="">
                                        <a href="{{ route('termsAndConditions') }}">
                                            {{__('Terms & Conditions')}}
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('privacyPolicy') }}">
                                            {{__('Privacy Disclaimer')}}
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('cookiePolicy') }}">
                                            Cookie Policy
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                <div class="contacts mini-txt">
                                    <div class="">
                                        <a href="{{ route('admin.supports.switch') }}">
                                            {{__("Contact us")}}
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="mailto:info@growpla.com" >info@growpla.com</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center">
                        <div class="social">
                            <div class="">
                                {{-- <a href="" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a> --}}
                                <a href="https://www.instagram.com/growpla/" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://www.linkedin.com/company/78734323" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="bottom-footer">
                    <span class="mini-txt">All copyrighted reserved to  Growpla © {{date("Y")}}</span>
                </div>
            </div>
        </footer>
        @endif
    </div>
</body>
</html>

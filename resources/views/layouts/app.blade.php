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
    <script src="{{ asset('js/app.js?28') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css?28') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JQ65YBYMPD"></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            console.log('disabilitato');
            // disabilito GOOLGE Analytics
            window['ga-disable-G-EX66GGGB3E'] = true;
        }
    </script>
</script>
    <div id="app">
        @guest
        {{-- SE NON LOGGATO NON COMPARE LA NAVBAR --}}

        @else
        <nav id="nav-bar" class="navbar-light">
            <div class="container">
                <div class="row">
                    <div class="nav-left d-inline-block col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-center mobile-hide">

                        <a href="{{ route('home') }}" class="position-relative">

                        <a href="{{ route('admin.search') }}" class="position-relative">
                            <img src="{{ asset("storage/images/logo-fullsize.svg") }}" alt="" class="logo">
                            <span class="beta">BETA</span>
                        </a>
                    </div>
                    <div class="nav-right d-inline-block col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex align-items-center">
                        <a href="{{ route('admin.search') }}" class="mobile-show position-relative">

                            <img src="{{ asset("storage/images/logo.svg") }}" alt="" class="mini-logo">
                            <span class="beta">BETA</span>
                        </a>
                        {{-- <a class="" href="{{route('admin.topics.create')}}">
                            Forum
                        </a> --}}
                        <div class="dropdown show notification not-navbar">
                            <a href="#" role="button" id="notDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="icon" @click="readNotifications()">
                                <i class="fas fa-bell">
                                    <span v-show="notifications.length" v-cloak>
                                        @{{notifications.length}}
                                    </span>
                                </i>
                            </a>
                            <div class="dropdown-menu show-notf-preview" aria-labelledby="notDropdown">
                                <div v-if="notifications.length>0"  class="notf">
                                    <a v-for="notification in notifications"
                                    :href="notification.ref_user_id?'/admin/users/'+ notification.ref_user_id : '/admin/pages/'+ notification.ref_page_id">
                                        <strong>@{{notification.name}}</strong>
                                        <span>@{{notification.notification_type.message_it}}</span>
                                    </a>
                                </div>
                                <div v-else class="notf">
                                    <span>{{__('No new notifications')}}</span>
                                </div>
                                <div class="v-notf">
                                    <a class="mini-txt" :href="'/admin/notifications/'">
                                        <span>{{__('See all notifications')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="chat d-inline-block" v-cloak>
                            <a class="not-navbar icon" href="{{route('admin.chats.index')}}">
                                <i class="fas fa-comment-alt">
                                    <span v-if="message_not_read">
                                        @{{message_not_read}}
                                    </span>
                                </i>
                            </a>
                        </div>
                        <div class="account-menu d-inline-block" v-cloak>
                            <a href="{{route('admin.users.show',Auth::user()->id)}}">
                                @if(Auth::user()->image)
                                <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="">
                                @endif
                            </a>
                            <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <div class="drop-menu mobile-hide"> --}}
                                    {{-- @{{user.name}} @{{user.surname}} --}}
                                {{-- </div> --}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="{{route('admin.users.show',Auth::user()->id)}}" class="dropdown-item">
                                    {{__('My account')}}
                                </a>
                                <a class="dropdown-item"
                                href="{{route('admin.users.settings',Auth::user()->id)}}">
                                    {{__('Settings')}}
                                </a>
                                <a class="dropdown-item"
                                href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
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
        @endguest
        {{-- class="py-4" --}}
        <main>
            @yield('content')
        </main>

        <footer id="footer">
            <div class="container ">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="legal">
                            <h5 class="text-uppercase">{{__('Legal')}}</h5>
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
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="contacts">
                            <h5 class="text-uppercase">{{__('Contacts')}}</h5>
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
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="social">
                            <h5 class="text-uppercase">{{__('Social')}}</h5>
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
                    <span>© {{date("Y")}} Growpla {{-- · All Rights Reserved--}}</span>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

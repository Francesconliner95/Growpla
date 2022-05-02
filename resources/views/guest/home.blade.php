@extends('layouts.app')

@section('content')
<script type="text/javascript">
</script>
<div id="guest-home" class="pt-0">
    <section class="pt-5 mb-5" style="background: url({{asset("storage/images/bg-razzo.svg") }}) right -250px top 200px,url({{asset("storage/images/bg-cerchio.svg") }}) right -270px top -150px; background-repeat: no-repeat; background-size: 800px 800px,1000px 1000px;">
        <div class="header mb-5 pb-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mobile-hide">
                        <img src="{{ asset("storage/images/logo-fullsize-white.svg") }}" alt="" class="logo" style="width:300px; height:80px; object-fit:contain;">
                    </div>
                    <div class="mobile-show">
                        <img src="{{ asset("storage/images/logo-white.svg") }}" alt="" class="logo" style="width:80px; height:80px; object-fit:contain;">
                    </div>
                    <div class="text-right">
                        <span class="font-weight-bold text-white d-inline-block m-2">Sei già iscritto?</span>
                        <a href="{{route('login')}}" class="button-style-radius button-color-transparent">LOGIN</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <h1 class="col-sm-12 col-md-8 col-lg-5 col-xl-5 pb-3">Fai decollare il tuo business.</h1>
                <h4 class="col-sm-12 col-md-12 col-lg-10 col-xl-10 pt-3 pb-3">Crea la tua Startup, sviluppa la tua <strong> idea di business</strong>, forma il tuo team, incontra persone e stringi relazioni.</h4>
                <h4 class="col-sm-12 col-md-12 col-lg-10 col-xl-10 pt-3 pb-3">Entra a far parte della <strong>prima piattaforma</strong> italiana che genera ecosistemi unendo gli attori principali della <strong>community degli innovatori</strong>.</h4>
            </div>
            <div class="pt-5 pb-5 row justify-content-start">
                <a href="{{route('login')}}" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
                <a href="{{route('login')}}"  class="button-color-transparent iscriviti-ora m-2">login</a>
            </div>
        </div>
    </section>
    <section class="mb-5 pt-5">
        <div class="container">
            <div class="row pt-3">
                <h1 class="col-sm-12 col-md-10 col-lg-10 col-xl-7 pb-3">A chi ci rivolgiamo?</h1>
            </div>
            <div class="row justify-content-center pt-5 pb-5">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">STARTUP</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-cofounder.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">CO-FOUNDER</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center  scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-incubatore.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">INCUBATORI ED ACCELERATORI</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-business-angel.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">INVESTITORI</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-associazione.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">ENTI ED ASSOCIAZIONI</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-studente.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">STUDENTI</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-azienda.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">AZIENDE</h5>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center scale-nocursor">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-freelancer.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">LIBERI PROFESSIONISTI</h5>
                    </div>
                </div>
            </div>
            <h4 class="pt-3 pb-3">Prendi parte al cambiamento, scorri e scopri di più su  <strong>Growpla</strong>!</h4>
        </div>
    </section>
    <section class="mb-5 pt-5"  style="background: url({{asset("storage/images/bg-cerchio.svg") }}) right -270px top 0px; background-repeat: no-repeat; background-size: 1000px 1000px;">
        <div class="container">
            <div class="row pt-5 pb-5">
                <h1 class="col-sm-12 col-md-10 col-lg-7 col-xl-7 pb-5">Pochi semplici step!</h1>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-10 col-lg-7 col-xl-7 pb-3">
                    <div class="step-cont">
                        <div class="step">
                            <div class="step-circle">

                            </div>
                            <div class="step-line">

                            </div>
                        </div>
                        <div class="step-text">
                            <h5>Step 1</h5>
                            <p>Crea il tuo profilo con tutte le informazioni utili</p>
                        </div>
                    </div>
                    <div class="step-cont">
                        <div class="step">
                            <div class="step-circle">

                            </div>
                            <div class="step-line">

                            </div>
                        </div>
                        <div class="step-text">
                            <h5>Step 2</h5>
                            <p>Cerca i ruoli, i servizi o le competenze di cui hai bisogno</p>
                        </div>
                    </div>
                    <div class="step-cont">
                        <div class="step">
                            <div class="step-circle">

                            </div>
                            <div class="step-line">

                            </div>
                        </div>
                        <div class="step-text">
                            <h5>Step 3</h5>
                            <p>Trova il profilo perfetto per le tue necessità</p>
                        </div>
                    </div>
                    <div class="step-cont">
                        <div class="step">
                            <div class="step-circle">

                            </div>
                            <div class="step-line">

                            </div>
                        </div>
                        <div class="step-text">
                            <h5>Step 4</h5>
                            <p>Contatta persone e crea un network di interazioni</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-5 pb-5 d-flex justify-content-center">
                <a href="{{route('login')}}" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
            </div>
        </div>
    </section>
    <section class="screenshot pt-5 pb-5">
            <div class="row pb-5">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 order-1 order-sm-1 order-md-0">
                    <div class="text-container">
                        <h1 class="pb-5">Fai crescere la tua startup</h1>
                        <p>Growpla ti guida nel <strong>processo di crescita</strong> indicandotile figure che fanno al caso tuo in base alla fase del <strong>ciclo di vita</strong> che attraversi con l’<strong>obiettivo</strong> di passare alla successiva!</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 order-0 order-sm-0 order-md-1">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-1.svg") }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-2.svg") }}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <div class="text-container">
                        <h1 class="pb-5">Scopri i futuri talenti</h1>
                        <p>Imposta i parametri che preferisci e fai <strong>scouting delle Startup</strong>facenti parte nel nostro network</p>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 order-1 order-sm-1 order-md-0">
                    <div class="text-container">
                        <h1 class="pb-5">Offri e cerca servizi</h1>
                        <p>Ottieni recensioni positive ed <strong>amplia la tua cerchia di clienti</strong>, comunica novità, sconti e promozioni</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 order-0 order-sm-0 order-md-1">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-3.svg") }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-4.svg") }}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <div class="text-container">
                        <h1 class="pb-5">Insieme si va più lontano</h1>
                        <p>Vuoi diventare uno startupper ma non hai idee su cui puntare?</p>
                        <p><strong>Il progetto che fa per te potrebbe già esistere, cercalo!</strong></p>
                        <p>Collabora alla realizzazione di idee di business interessanti mettendo a disposizione le tue capacità.</p>
                    </div>
                </div>
            </div>
            <div class=" pb-5 d-flex justify-content-center">
                <a href="{{route('login')}}" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
            </div>
    </section>
    <section class="partner pt-5 pb-5 mb-5">
        <div class="container">
            <div class="pt-3 pb-5">
                <h5 class="pb-4"><strong>Growpla</strong> è una dimensione emergente ma già solida, che gode del supporto di importanti <strong>realtà affermate</strong>.</h5>
                <h5 class="pb-4">Ecco alcuni dei nostri <strong>partner</strong> e sostenitori:</h5>
            </div>
        </div>
        <div class="partner-cont pt-5 pb-5">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 text-center fade-anim fade-right">
                    <a href="https://www.lum.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/partner-lum-logo.png" alt="">
                    </a>
               </div>
               <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 text-center fade-anim fade-right">
                    <a href="https://www.ic406.com/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/partner-ic406-logo.png" alt="">
                    </a>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 text-center fade-anim fade-right">
                    <a href="https://www.goheroes.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/partner-heroes-logo.png" alt="">
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 text-center fade-anim fade-right">
                    <a href="https://www.viscontilegal.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/partner-visconti-logo.png" alt="">
                    </a>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2 text-center fade-anim fade-right">
                    <a href="https://www.knowledge-hub.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/partner-khub-logo.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-5 pt-1"  style="background: url({{asset("storage/images/bg-aereo.svg") }}) left -150px top 0px; background-repeat: no-repeat; background-size: contain">
        <div class="container">
            <div class="row pt-5 pb-5">
                <h1 class="col-sm-12 col-md-10 col-lg-7 col-xl-7 pb-5">Roadmap</h1>
            </div>
            <div class="d-flex justify-content-center">
                <div class="d-inline-block">
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-1.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #00C5C5">LUGLIO 2021</h5>
                                <span style="background-color: #00C5C5"></span>
                            </div>
                            <div class="">
                                <p>il team avvia il progetto Growpla</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-2.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #4033C5">MAGGIO 2022</h5>
                                <span style="background-color:#4033C5"></span>
                            </div>
                            <div class="">
                                <p>lancio della versione 1.0 della piattaforma</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-3.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #7620BB">GIUGNO 2022</h5>
                                <span style="background-color: #7620BB"></span>
                            </div>
                            <div class="">
                                <p>inserimento della sezione news</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-4.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #C5337E">OTTOBRE 2022</h5>
                                <span style="background-color: #C5337E"></span>
                            </div>
                            <div class="">
                                <p>introduzione della possibilità di effettuare transazioni in piattaforma e lasciare recensioni sui servizi ottenuti dagli altri utenti</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-5.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #BC7100">GENNAIO 2023</h5>
                                <span style="background-color: #BC7100"></span>
                            </div>
                            <div class="">
                                <p>introduzione di nuove funzionalità di discussione ed interazione</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-6.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #2D8329">APRILE 2023</h5>
                                <span style="background-color: #2D8329"></span>
                            </div>
                            <div class="">
                                <p>rilascio mobile app</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-6.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #2D8329">IN EVOLUZIONE</h5>
                                <span style="background-color: #2D8329"></span>
                            </div>
                            <div class="">
                                <p>in divenire</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="reviews pt-5 pb-5">
        <div class="container">
            <h1 class="col-sm-12 col-md-10 col-lg-10 col-xl-7 pb-3">Cosa dicono di noi i nostri utenti</h1>
        </div>
        <div class="card-slider-review pt-3 pb-5">
            <div class="container">
	            <div class="row">
	                <div class="MultiCarousel" data-items="1,2,2,2" data-slide="1" id="MultiCarousel"  data-interval="1000">
                        <div class="MultiCarousel-inner">
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Avevo un sogno:</p>
                                                <p>creare il mio business e far emegere la mia startup.</p>
                                                <p>Ma è difficile trovare le giuste persone e la guida necessaria..</p>
                                                <p>Con Growpla ho trovato tutto in un’unica piattaforma!</p>
                                            </div>
                                            <p class="text-white">Lucia C.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Avevo un sogno:</p>
                                                <p>creare il mio business e far emegere la mia startup.</p>
                                            </div>
                                            <p class="text-white">Lucia C.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Avevo un sogno:</p>
                                                <p>creare il mio business e far emegere la mia startup.</p>
                                                <p>Ma è difficile trovare le giuste persone e la guida necessaria..</p>
                                                <p>Con Growpla ho trovato tutto in un’unica piattaforma!</p>
                                            </div>
                                            <p class="text-white">Lucia C.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Avevo un sogno:</p>
                                                <p>creare il mio business e far emegere la mia startup.</p>
                                                <p>Ma è difficile trovare le giuste persone e la guida necessaria..</p>
                                                <p>Con Growpla ho trovato tutto in un’unica piattaforma!</p>
                                            </div>
                                            <p class="text-white">Lucia C.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn leftLst">
                        </button>
                        <button class="btn rightLst">
                        </button>
                    </div>
	            </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pb-5">
        <div class="container">
            <h1 class="pb-5">Non perdere l’occasione di crescere con professionisti del settore e far decollare il tuo business.</h1>
        </div>
        <div class="pb-5 d-flex justify-content-center">
            <a href="{{route('login')}}" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
        </div>
    </section>
    <div v-if="showConsenScreen" class="cookie-consent" v-cloak>
        <p class="position-relative">
            <a href="#" @click="closeConsentScreen()" class="txt-blue edit-top-right scale">
                <i class="fas fa-times"></i>
            </a>
        </p>
        <div class="container">
            <p class="font-weight-bold">{{__('Growpla and third-party use technical cookies and similar technologies (“tracking tools”) to operate and improve the platform. For full details on how we use cookies please see the full')}} <a href="{{ route('cookiePolicy') }}" class="txt-green">cookie policy</a>.
            </p>
            <div v-if="cookieSettings" class="cookie-list pb-3">
                <div  class="switch-button-on-off pt-1 pb-2">
                    <label class="pt-2 mr-4" for="">
                        {{__('Technical Cookies')}}
                        <span class="d-block txt-green font-weight-bold">"Sempre abilitati"</span>
                    </label>
                    <div class="button r switch-button d-inline-block">
                        <input type="checkbox" class="checkbox" onclick="return false;" readonly>
                        <div class="knobs"></div>
                        <div class="layer"></div>
                    </div>
                </div>
                <div  class="switch-button-on-off pt-1 pb-2">
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

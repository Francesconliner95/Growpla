@extends('layouts.app')

@section('content')
<div id="guest-home" class="pt-0">
    {{-- <div class="">
        <h1 data-aos="fade-down-left"
        class="text-dark dark-text">A chi ci rivolgiamo?</h1>
    </div>
    <section class="splide" aria-label="Splide Basic HTML Example">
        <div class="splide__track">
		    <ul class="splide__list">
			    <li class="splide__slide">Slide 01</li>
			    <li class="splide__slide">Slide 02</li>
			    <li class="splide__slide">Slide 03</li>
		    </ul>
        </div>
    </section> --}}
    <section class="pt-5 mb-5"
    style="background: url({{asset("storage/images/bg-cerchio.svg") }}) right -270px top -150px; background-repeat: no-repeat; background-size: 1000px 1000px;" v-cloak>
        <img src="{{asset("storage/images/bg-razzo.svg") }}" alt="" class="rocket-animation mobile-hide">
        <div class="pb-5">

        </div>
        {{-- <a href="{{route('home2')}}">Home2</a> --}}
        <div class="container mt-5 pt-5">
            <div class="row">
                <h1 class="col-sm-12 col-md-8 col-lg-5 col-xl-5 pb-3">Fai decollare il tuo business.</h1>
                <h4 class="col-sm-12 col-md-12 col-lg-10 col-xl-10 pt-3 pb-3">Crea la tua Startup, sviluppa la tua <strong> idea di business</strong>, forma il tuo team, incontra persone e stringi relazioni.</h4>
                <h4 class="col-sm-12 col-md-12 col-lg-10 col-xl-10 pt-3 pb-3">Entra a far parte della <strong>piattaforma</strong> italiana che genera ecosistemi unendo gli attori principali della <strong>community degli innovatori</strong>.</h4>
            </div>
            <div class="pt-5 pb-5 row justify-content-start">
                <a href="login#register" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
                <a href="{{route('login')}}"  class="button-color-transparent iscriviti-ora m-2">login</a>
            </div>
        </div>
    </section>
    <section class="mb-5 pt-5">
        <div class="container">
            <div class="row pt-3">
                <h1 class="col-sm-12 col-md-10 col-lg-10 col-xl-7 pb-3">A chi ci rivolgiamo?</h1>
            </div>
            <div class="row">
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-startup.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">STARTUP</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-cofounder.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">ASPIRANTI
                            <span class="d-block">CO-FOUNDER</span>
                        </h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center ">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-incubatore.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">INCUBATORI ED ACCELERATORI</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-business-angel.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">INVESTITORI</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-ente.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">ENTI ED ASSOCIAZIONI</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-studente.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">STUDENTI</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/pages_images/default-azienda.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">AZIENDE</h5>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 pt-3 pb-5">
                    <div class="text-center">
                        <div class="img-cont medium-img mb-3">
                            <img src="{{asset('storage/users_images/default-freelancer.svg')}}" alt="">
                        </div>
                        <h5 class="text-white m-0">LIBERI PROFESSIONISTI</h5>
                    </div>
                </div>
            </div>
            <h4 class="pt-3 pb-3">Prendi parte al cambiamento, scorri e scopri di pi?? su  <strong>Growpla</strong>!</h4>
        </div>
    </section>
    <section class="screenshot pt-5 pb-5">
        <div class="container-fluid pt-5">
            <div class="row pb-5">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 order-1 order-sm-1 order-md-0">
                    <div class="text-container">
                        <h1 class="pb-5">Fai crescere la tua startup</h1>
                        <p>Growpla ti guida nel <strong>processo di crescita</strong> indicandoti le figure che fanno al caso tuo in base alla fase del <strong>ciclo di vita</strong> che attraversi con l???<strong>obiettivo</strong> di passare alla successiva!</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 order-0 order-sm-0 order-md-1 pr-0">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-1.svg") }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 pl-0">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-2.svg") }}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <div class="text-container">
                        <h1 class="pb-5">Scopri i futuri talenti</h1>
                        <p>Imposta i parametri che preferisci e fai <strong>scouting delle Startup</strong> facenti parte del nostro network</p>
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 order-1 order-sm-1 order-md-0">
                    <div class="text-container">
                        <h1 class="pb-5">Offri e cerca servizi</h1>
                        <p>Ottieni recensioni positive ed <strong>amplia la tua cerchia di clienti</strong>, comunica novit??, sconti e promozioni</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 order-0 order-sm-0 order-md-1 pr-0">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-3.svg") }}" alt="">
                    </div>
                </div>
            </div>
            <div class="row pb-5">
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 pl-0">
                    <div class="image-container">
                        <img src="{{asset("storage/images/monitor-4.svg") }}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <div class="text-container">
                        <h1 class="pb-5">Insieme si va pi?? lontano</h1>
                        <p>Vuoi diventare uno startupper ma non hai idee su cui puntare?</p>
                        <p><strong>Il progetto che fa per te potrebbe gi?? esistere, cercalo!</strong></p>
                        <p>Collabora alla realizzazione di idee di business interessanti mettendo a disposizione le tue capacit??.</p>
                    </div>
                </div>
            </div>
            <div class=" pb-5 d-flex justify-content-center">
                <a href="login#register" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
            </div>
        </div>
    </section>
    <section class="partner pt-5 pb-5 mb-5">
        <div class="container">
            <div class="pt-3 pb-5">
                <h5 class="pb-4"><strong>Growpla</strong> ?? una dimensione emergente ma gi?? solida, che gode del supporto di importanti <strong>realt?? affermate</strong>.</h5>
                <h5 class="pb-4">Ecco alcuni dei membri del nostro network:</h5>
            </div>
        </div>
        <div class="partner-cont pt-5 pb-5">
            <div class="main-multi-slider d-flex justify-content-center">
                <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://www.lum.it/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-lum-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://www.ic406.com/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-ic406-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://www.goheroes.it/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-heroes-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://abagenziadicomunicazione.com/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-ab-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://doz.consulting/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-doz-logo.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://www.viscontilegal.it/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-visconti-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://www.knowledge-hub.it/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-khub-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="multi-slider-item col-8 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                        <div class="d-flex justify-content-center align-items-center h-100">
                            <div class="card-style-mini">
                                <a href="https://startupmvp.dev/" target="_blank" class="d-inline-block">
                                    <img src="/storage/images/partner-startupmvp-logo.svg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left mobile-hide" id="button-left-1" v-cloak>
                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                </button>
                <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right mobile-hide" id="button-right-1" v-cloak>
                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                </button>
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
                                <h5 style="color: #7620BB">LUGLIO 2022</h5>
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
                                <p>introduzione della possibilit?? di effettuare transazioni in piattaforma e lasciare recensioni sui servizi ottenuti dagli altri utenti</p>
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
                                <p>introduzione di nuove funzionalit?? di discussione ed interazione</p>
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
                                <h5 style="color: #C3B50C">APRILE 2023</h5>
                                <span style="background-color: #C3B50C"></span>
                            </div>
                            <div class="">
                                <p>rilascio mobile app</p>
                            </div>
                        </div>
                    </div>
                    <div class="roadmap-item">
                        <div class="roadmap-img">
                            <img src="{{asset('storage/images/icon-roadmap-7.svg')}}" alt="" class="scale-nocursor">
                            <div class="roadmap-line">
                            </div>
                        </div>
                        <div class="roadmap-text">
                            <div class="title-cont">
                                <h5 style="color: #2D8329">IN DIVENIRE</h5>
                                <span style="background-color: #2D8329"></span>
                            </div>
                            <div class="">
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <p>Trova il profilo perfetto per le tue necessit??</p>
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
                <a href="login#register" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
            </div>
        </div>
    </section>
    <section class="reviews mt-5 pt-5 pb-5">
        <div class="container">
            <h1 class="col-sm-12 col-md-10 col-lg-10 col-xl-7">Cosa dicono di noi i nostri utenti</h1>
        </div>
        <div class="container-fluid" id="review-cont">
            <div class="card-slider-review pb-5">
                <div class="row">
                    <div class="MultiCarousel" data-items="1,1,1,2,3" data-slide="1" id="MultiCarousel"  data-interval="1000">
                        <div class="MultiCarousel-inner">
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/images/partner-khub-logo.png')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Growpla ?? il sistema ideale per permettere agli incubatori di scoprire le migliori idee emergenti.</p>
                                                <p>Attraverso la piattaforma si riescono a valorizzare le competenze e a individuare le soluzioni migliori per completare le necessit?? di ciascun team.</p>
                                            </div>
                                            <p class="text-white">K HUB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/images/review-visconti.png')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>La piattaforma ?? semplice ed intuitiva.</p>
                                                <p>Un luogo digitale perfetto per noi professionisti che ci permette di entrare in contatto con nuove idee e progetti ed offrire i nostri servizi di consulenza.</p>
                                            </div>
                                            <p class="text-white">Alfredo Simone V.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/images/review-patrizio.jpg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Nel mondo delle startup l???idea conta eccome, ma non quanto l???execution. ?? l???execution che trasforma idee brillanti in realt??. In questo senso Growpla ?? ci?? che serviva all???ecosistema dell???innovazione: una piattaforma che supporta i founder a trovare le persone con competenze necessarie per completare o supportare il team e trasformare le idee in azioni.</p>
                                            </div>
                                            <p class="text-white">Patrizio Guido A.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="pad15">
                                    <div class="info-container">
                                        <div class="image-container">
                                            <img src="{{asset('storage/images/review-alessia.jpg')}}" alt="">
                                        </div>
                                        <div class="text-container">
                                            <div class="main-text">
                                                <p>Creare una startup ?? difficile, ma trovare le persone giuste per crescere lo ?? ancora di pi??.</p>
                                                <p>Growpla mi ha permesso di mettermi in contatto con ottimi professionisti e creare un network realmente interessato al mio progetto. Ora il mio business ha raggiunto uno step in pi??!</p>
                                            </div>
                                            <p class="text-white">Alessia C.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn leftLst" id="left-btn">
                            <i class="mobile-hide fas fa-angle-left"></i>
                        </button>
                        <button class="btn rightLst" id="right-btn">
                            <i class="mobile-hide fas fa-angle-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pb-5">
        <div class="container">
            <h1 class="pb-5">Non perdere l???occasione di crescere con professionisti del settore e far decollare il tuo business.</h1>
        </div>
        <div class="pt-5 pb-5 d-flex justify-content-center">
            <a href="login#register" class="button-color-white iscriviti-ora m-2">iscriviti ora</a>
        </div>
    </section>
    <div v-if="showConsenScreen" class="cookie-consent" v-cloak>
        <p class="position-relative">
            <button @click="closeConsentScreen()" class="txt-blue edit-top-right scale">
                <i class="fas fa-times"></i>
            </button>
        </p>
        <div class="container">
            <p class="font-weight-bold">{{__('Growpla and third-party use technical cookies and similar technologies (???tracking tools???) to operate and improve the platform. For full details on how we use cookies please see the full')}} <a href="{{ route('cookiePolicy') }}" class="txt-green">cookie policy</a>.
            </p>
            <div v-if="cookieSettings" class="cookie-list pb-3">
                <div  class="switch-button-on-off pt-1 pb-2">
                    <label class="pt-2"for="">
                        {{__('Technical Cookies')}}
                        <span class="d-block txt-green font-weight-bold ">"Sempre abilitati"</span>
                    </label>
                    <div class="button r switch-button d-inline-block">
                        <input type="checkbox" class="checkbox" onclick="return false;" checked readonly>
                        <div class="knobs"></div>
                        <div class="layer"></div>
                    </div>
                </div>
                <div  class="switch-button-on-off pt-1 pb-2">
                    <label class="pt-2" for="">{{__('Analytical Cookies')}}</label>
                    <div class="button r switch-button d-inline-block">
                        <input type="checkbox" class="checkbox" v-model="analyticsCookie">
                        <div class="knobs"></div>
                        <div class="layer"></div>
                    </div>
                </div>
                <button class="txt-blue" @click="acceptSelected()">{{__('Accept selected')}}</button>
            </div>
            <p>
                <button class="txt-blue" @click="cookieSettings=!cookieSettings">
                    <span v-if="cookieSettings">{{__('Close customize')}}</span>
                    <span v-else>{{__('Customize')}}</span>
                </button>
                <button class="ml-5 txt-green" @click="acceptAll()">{{__('Accept all')}}</button>
            </p>
        </div>
    </div>
</div>
@endsection

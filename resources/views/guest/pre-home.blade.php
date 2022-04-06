@extends('layouts.app')

@section('content')
    <script type="text/javascript">
    </script>
    <div class="background not-log-main-hg" id="guest-prehome">
        <div class="container">
            <div class="row w-100 pb-5 d-flex justify-content-center align-items-center m-0">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <img src="{{ asset("storage/images/logo-fullsize1.svg") }}" alt="" class="w-100">
                    <h1 class="text-center" style="font-family: 'Raleway',Helvetica,Arial,Lucida,sans-serif; font-weight:700;font-size: 42px;">
                        Sito in costruzione</h1>
                    <h1 style="font-family: 'Raleway',Helvetica,Arial,Lucida,sans-serif; font-weight:700;font-size: 42px;" class="mb-5 text-center">Stay tuned!</h1>
                    <h4 class="mb-5 text-center" style="font-size: 23px;line-height: 1.6em;">
                       Crea la tua Startup, sviluppa la tua idea di business, forma il tuo team, incontra persone e stringi relazioni. Entra a far parte della prima piattaforma italiana che genera ecosistemi tra incubatori, acceleratori, investitori, aspiranti co-founder, enti, professionisti ed imprese al fine di favorire occupazione, contaminazione ed innovazione
                    </h4>
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

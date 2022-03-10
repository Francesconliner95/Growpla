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
                    <div v-if="!send_success" class="form-group text-center"  v-cloak>
                        <h6 class="pl-3 pr-3 pb-2">Inserisci qui la tua mail per essere contattato non appena Growpla sarà online</h6>
                        <div class="d-flex justify-content-center">
                            <input type="email" name="" value="" class="form-control mr-2 w-50" autocomplete="email" v-model="email" placeholder="Inserisci email qui">
                            <button type="button" name="button" class="button-style button-color" @click="sendEmail()">Invia</button>
                        </div>
                    </div>
                    <div v-else class="text-center" v-cloak>
                        <i class="fas fa-check-circle txt-green mb-4"></i>
                        <h4 for="email" class="text-center">Mail inviata correttamente.</h4>
                    </div>
                    <div v-if="error" class="input-error text-center"  v-cloak>
                        <strong>Email non valida</strong>
                    </div>
                    <div class="social">
                        <div class="text-center">
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
            <div class="container pb-2">
            <h3 class="section-title">
                <b></b>
                {{-- <span class="text-uppercase">{{__('partners')}}</span> --}}
                <b></b>
            </h3>
            <div class="partner row justify-content-center">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center fade-anim fade-right">
                    <h6 class="text-center">PATROCINIO</h6>
                   <a href="https://www.lum.it/" target="_blank" class="d-inline-block">
                       <img src="/storage/images/lum-logo.png" alt="">
                   </a>
               </div>
               <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center fade-anim fade-right">
                    <h6 class="text-center">INCUBATORE</h6>
                  <a href="https://www.ic406.com/" target="_blank" class="d-inline-block">
                      <img src="/storage/images/ic406-logo.png" alt="">
                  </a>

              </div>
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center fade-anim fade-right">
                    <h6 class="text-center">PARTNER</h6>
                    <a href="https://www.goheroes.it/" target="_blank" class="d-inline-block">
                        <img src="/storage/images/heroes-logo.png" alt="">
                    </a>
                </div>
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center fade-anim fade-right">
                    <h6 class="text-center">PARTNER</h6>
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

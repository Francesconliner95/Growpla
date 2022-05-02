@extends('layouts.app')

@section('content')
<div id="cookie-policy" class="legal-background">
    <div class="container not-log-main-hg">
        <div class="item-cont">
          <div class="row justify-content-center">
              <div class="col-sm-12 col-md-11 col-lg-10 col-xl-10 custom-card p-5" style="background-color: rgba(255,255,255,.5)">
                  <h3 class="text-center mb-4">
                      <a href="{{ route('home') }}" class="text-decoration-none">
                          <img src="{{ asset("storage/images/logo.svg") }}" alt="" class="title-logo">
                      </a>
                      <span class="text-nowrap text-uppercase   text-white">Cookie Policy</span>
                  </h3>
                  <div class="sub-ol">
                      <ol>
                          <li>.
                              <h6 class="d-inline">{{__('Definition')}}</h6>

                              <p>{{__('Tracking tools, such as cookies and similar technologies, are strings of text sent by a website visited by the user to his browser. They are filed and stored in order to store information related to the provision of an online service or for other purposes (statistical, advertising, etc. ...).')}}</p>

                          </li>
                          <li>.
                              <h6 class="d-inline">{{__('Tracking tools used')}}</h6>


                              <p>{{__('This site uses either "first-party" tracking tools that are managed directly by the Data Controller, or "third-party" tracking tools that enable third-party services. We use')}} <strong>{{__('technical cookies or similar tracking tools')}}</strong>
                              {{__('(first-party tracking tools) in order to provide you with the service you have requested. With your consent we use')}} <strong>{{__('analytical cookies')}}</strong>,
                              {{__('(third party tracking tools), such as Google Analytics, to acquire data that allows us to improve our platform by understanding how you interact with our service.')}}
                              {{__('At the following link you can read the full policy of Google Analytics:')}}
                              <a href="https://policies.google.com/technologies/cookies?hl=it">https://policies.google.com/technologies/cookies?hl=it</a>.
                              </p>
                              <ol class="mb-2">
                                  <li>
                                      <h6 class="d-inline">{{__('Legal basis and storage period')}}</h6>

                                      <p>{{__('The legal bases for the use of tracking tools are as follows:')}}</p>
                                          <span class="d-block pl-2">-{{__('for Essential Cookies is the legitimate interest pursuant to Art. 6(1)(f) of the EU;')}}</span>
                                          <span class="d-block pl-2">-{{__('GDPR;')}}</span>
                                          <span class="d-block pl-2">-{{__('for Analytical Cookies is identified in the specific consent from the data subject, pursuant to Art. 6(1)(a) of the EU;')}}</span>
                                  </li>
                              </ol>
                              <p>{{__('We will retain personal data processed through cookies for the time necessary for the purpose of processing.')}}</p>
                          </li>
                          <li>.
                              <h6 class="d-inline">{{__('Management of preferences and withdrawal of consent')}}</h6>

                              <p>{{__('You can give or revoke consent directly through your device settings. At the following links you will find information on how to manage or disable cookies for some of the most popular internet browsers')}}:
                                <a href="https://windows.microsoft.com/it-IT/internet-explorer/deletemanage-cookies">Internet Explorer</a>,
                                <a href="https://support.microsoft.com/it-it/microsoft-edge/eliminare-i-cookiein-microsoft-edge-63947406-40ac-c3b8-57b9-2a946a29ae09">Microsoft edge</a>,
                                <a href="https://support.google.com/chrome/answer/95647">Google Chrome</a>,
                                <a href="https://support.mozilla.org/it/kb/Gestione%20dei%20cookie">Mozilla Firefox</a>,
                                <a href="https://support.apple.com/it-it/HT201265">Safari</a>.
                               </p>


                              <p>
                                  <button class="button-style button-color-black" @click="showConsenScreen=true">{{__('Check or edit your cookie preference')}}</button>
                              </p>
                              {{-- <p>{{__('For tracking tools that depend on consent, the user can manage and change his preferences below:')}}</p>
                              @if ($consentValue=='accept')
                                  <a href="{{ route('acceptCookie') }}" class="ml-2 button-style button-color">Accettato</a>
                                  <a href="{{ route('rejectCookie') }}" class="ml-2 button-style button-color-red">Rifiuta</a>
                              @elseif ($consentValue=='reject')
                                  <a href="{{ route('acceptCookie') }}" class="ml-2 button-style button-color">Accetta</a>
                                  <a href="{{ route('rejectCookie') }}" class="ml-2 button-style button-color-red">Rifiutato</a>
                              @else
                                  <a href="{{ route('acceptCookie') }}" class="ml-2 button-style button-color">Accetta</a>
                                  <a href="{{ route('rejectCookie') }}" class="ml-2 button-style button-color-red">Rifiuta</a>
                              @endif --}}
                          </li>
                          <p class="pt-4">{{__('For more information about the processing of your personal data, including details of your rights and the data controller, you can consult our privacy policy at the following link') }}
                              <a href="{{ route('privacyPolicy') }}">Privacy policy</a>.
                          </p>
                      </ol>
                  </div>
              </div>
          </div>
      </div>
    </div>
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

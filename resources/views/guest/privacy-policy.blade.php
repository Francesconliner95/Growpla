@extends('layouts.app')

@section('content')
<div id="privacy-policy" class="legal-background">
    <div class="container not-log-main-hg">
      <div class="item-cont">
          <div class="row d-flex justify-content-center ">
              <div class="col-sm-12 col-md-11 col-lg-10 col-xl-10 custom-card p-5" style="background-color: rgba(255,255,255,.5)">
                  <h3 class="text-center mb-4">
                      <a href="{{ route('home') }}" class="text-decoration-none">
                          <img src="{{ asset("storage/images/logo.svg") }}" alt="" class="title-logo">
                      </a>
                      <span class="text-nowrap text-uppercase text-white">{{__('Privacy policy')}}</span>
                  </h3>
                  <div class="">
                      <h5 class=" text-white">{{__('Pursuant art. 13 of EU Regulation 679/2016')}}</h5>
                      <p>{{__('The Data Controller processes your personal data in order to identify you and to provide you with the service, to keep you updated on the service and in order to improve it. The provision of data is mandatory, in the absence we will not be able to perform the service. The data will be communicated to the professional and / or company where you intend to use the service and possibly to other parties responsible for treatment, to provide the requested service. The complete list is available from the owner. Contact us at')}} info@growpla.com</p>
                      <h6>1.	{{__('Data Controller')}}</h6>
                      <p>Vincenzo Tarantino, C.F. TRNVCN96A25B180N          mail: info@growpla.com</p>
                      <h6>2.	{{__('Purposes of the processing and legal basis')}}</h6>
                      <ul>
                          <li>{{__('Per gli utenti: Nome, Cognome, indirizzo mail, età, regione e città, immagine del profilo, identificazione (aspirante co-founder, business angel, libero professionista, dipendente, studente, founder, altro), sommario, presentazione, sito web, profilo linkedin, curriculum vitae, eventuali servizi che cercano/offrono, eventuali pagine che si desiderano creare (startup, azienda, incubatore-acceleratore, venture capital, piattaforma di crowdfunding, ente-associazione, private equity).')}}</li>
                          <li>{{__('Aggiuntivi per gli aspiranti Co-founder: formazione, ruolo che intende assumere.')}}</li>
                          <li>{{__('Aggiuntivi per i Business Angel: Taglio d’investimenti, quantità di progetti finanziati.')}}</li>
                          <li>{{__('Aggiuntivi per i dipendenti: azienda in cui lavora.')}}</li>
                          <li>{{__('Aggiuntivi per gli studenti: formazione.')}}</li>
                          <li>{{__('Per le pagine startup: Nome, immagine del profilo (logo), sommario, presentazione, sito web, profilo linkedin, eventuali servizi cercati, Stato della startup (Costituita/ non costituita); fase del ciclo di vita (pre-seed/ seed/ early stage/ early growth (round A o B)/ growth/ exit), pitch, MVP sì/no, sede legale, dati dei componenti del team (Foto, ruolo nella startup, profilo linkedin), settore d’appartenenza.')}}</li>
                          <li>{{__('Per le pagine azienda: Nome, immagine del profilo (logo), sommario, presentazione, sito web, profilo linkedin, eventuali servizi cercati/offerti, sede legale, dati dei componenti del team (Foto, ruolo nell’azienda, profilo linkedin), settore d’appartenenza.')}}</li>
                          <li>{{__('Per le pagine incubatore-acceleratore: Nome, immagine del profilo (logo), sommario, presentazione, sito web, profilo linkedin, sede legale, dati dei componenti del team (Foto, ruolo nell’azienda, profilo linkedin), tipologia (pubblico/privato), servizi erogati (fisici/online/fisici ed online), settore.')}}</li>
                          <li>{{__('Per le pagine ente-associazione, piattaforma di crowdfunding, private equity e venture capital: Nome, immagine del profilo (logo), sommario, presentazione, sito web, profilo linkedin, sede legale, dati dei componenti del team (Foto, ruolo nell’azienda, profilo linkedin), settore.')}}</li>
                      </ul>
                      <p>- {{__('The data will be processed to provide the service. Legal base art. 6 lett. B GDPR;')}}</p>
                      <p>- {{__('Data may be disclosed to public authorities to comply with specific provisions of the law (e.g. regarding taxation) Legal base art. 6 lett C GDPR;')}}</p>
                      <p>- {{__('The data will be processed in order to send you communications, such as newsletters. Legal base art. 6 LETT. F GDPR;')}}</p>
                      <p>- {{__('Data may be collected for statistical analysis and research in order to improve the platform')}}</p>
                      <h6>3.	{{__('Data recipients')}}</h6>
                      <p>{{__('The data will be processed by the Owner\'s staff, duly authorized. The data will be communicated to the user. The Owner uses, for some treatments (for example the hosting service), companies or professionals in charge of the treatment that have adequate security guarantees. It is possible to request an updated list of recipients from the Owner.')}}</p>
                      <h6>4.	{{__('Processed data and retention period')}}</h6>
                      <p>{{__('We keep your data until the end of the purpose referred to above and for 10 years thereafter (prescriptive term).')}}</p>
                      <h6>5.	{{__('Rights')}}</h6>
                      <ul>
                          {{__('You have the right to:')}}
                          <li>{{__('request access to personal data, correction or deletion of the same;')}}</li>
                          <li>{{__('revoke the consents given')}}</li>
                          <li>{{__('limit the processing of your data;')}}</li>
                          <li>{{__('request the portability of your data to another data controller;')}}</li>
                          <li>{{__('propose a complaint to the Guarantor Authority for the protection of personal data.')}}</li>
                      </ul>
                      <p>{{__('Requests to the owner can be made by email at')}} info@growpla.com</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection

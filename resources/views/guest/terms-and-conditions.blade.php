@extends('layouts.app')

@section('content')
    <div id="terms-and-conditions" class="legal-background">
        <div class="container not-log-main-hg">
          <div class="item-cont">
              <div class="row d-flex justify-content-center ">
                  <div class="col-sm-12 col-md-11 col-lg-10 col-xl-10 custom-card p-5" style="background-color: rgba(255,255,255,.5)">
                    <h3 class="text-center mb-4">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <img src="{{ asset("storage/images/logo.svg") }}" alt="" class="title-logo">
                        </a>
                        <span class="text-nowrap text-uppercase text-white">{{__('Terms and Conditions')}}</span>
                    </h3>
                    <div class="">
                        <p>{{__('These Terms and Conditions (the “Terms”) regulate the use of the “Growpla” platform through the website www.growpla.com .')}}</p>
                        <p>{{__('These Terms and Conditions form a binding agreement between each user (the “User”) and Vincenzo Tarantino C.F. TRNVCN96A25B180N (the “Owner”), Owner of the platform www.growpla.com .')}}</p>
                        <h6>{{__('GLOSSARY')}}</h6>
                        <p>{{__('For the purposes of these General Terms and Conditions, in this contract the following terms shall have the following meanings:')}}</p>
                        <ul>
                            <p>a)	{{__('“Site / Platform / Growpla”: to mean the website www.growpla.com owned by Mr. Vincenzo Tarantino C.F. TRNVCN96A25B180N')}}</p>
                            <p>b)	{{__('“Platform Service / Service”: to indicate the service offered by the platform;')}}</p>
                            <p>c)	{{__('“Contact”: to indicate the contact between users made through the platform service;')}}</p>
                            <p>d)	{{__('“User” to indicate the user of the site who intends to use the service offered by the platform;')}}</p>
                            <p>e)	{{__('“Vincenzo Tarantino / Mr. Tarantino / The Owner”: to indicate Vincenzo Tarantino C.F TRNVCN96A25B180N.')}}</p>
                        </ul>
                        <h6>{{__('PREMISES')}}</h6>
                        <ul>
                            <p>a)	{{__('Vincenzo Tarantino is the owner of the platform www.growpla.com;')}}</p>
                            <p>b)	{{__('Growpla owns the information and the IT tools useful to facilitate the contact among all the players of the startup community: startups, co-founders, startup incubators/accelerators, business angels, startup service providers and agencies. The above list is intended as an example and not exhaustive;')}}</p>
                            <p>c)	{{__('In order to use the service offered by the platform it is necessary to provide the mandatory data requested during registration;')}}</p>
                            <p>d)	{{__('In order to use the service offered by the platform it is necessary to accept these Terms and Conditions;')}}</p>
                            <p>e)	{{__('The user who accesses the site will be able to use the service offered by the platform;')}}</p>
                            <p>f)	{{__('The user who uses the service provided by the site shows a clear will to use the service in good faith excluding any kind of mendacious and/or fraudulent conduct and not to declare false information;')}}</p>
                            <p>g)	{{__('Mr. Tarantino can in no way be considered responsible for mendacious and/or fraudulent conduct of users or implications arising from such conduct of users; In any case it is the right of the owner to allow or deny access to the platform to the user without the obligation to justify the decision;')}}</p>
                            <p>h)	{{__('The service offered by the site is intended to be provided to the specific user. The service is in no case transferable, neither for free nor any type of economic payment;')}}</p>
                            <p>i)	{{__('By accepting this contract, the user undertakes to comply with the regulations applied to the use of the platform, and to refrain from any use contrary to the law, these Terms or harmful to the rights of other users or third parties.')}}</p>
                        </ul>
                        <h6>1.	{{__('USER REPRESENTATIONS AND WARRANTIES')}}</h6>
                        <p>{{__('The User declares and guarantees')}}</p>
                        <ul>
                            <p>a)	{{__('that he or she is of legal age;')}}</p>
                            <p>b)	{{__('that he or she may lawfully accept these Terms and use SGH in accordance with applicable law;')}}</p>
                            <p>c)	{{__('that the information communicated on the site during the use, are real and actual;')}}</p>
                            <p>d)	{{__('to be aware and accept that the owner reserves the right to verify at any time the authenticity of the information provided, and to request the User relevant supporting documentation;')}}</p>
                            <p>e)	{{__('to be aware and accept that the owner reserves the right to deny access to the site without notice, not responding to the unavailability of the site for any reason;')}}</p>
                            <p>f)	{{__('to be aware and accept that the owner reserves the right to delete the user\'s profile;')}}</p>
                            <p>g)	{{__('that you will use the platform for lawful purposes;')}}</p>
                            <p>h)	{{__('that the use of Growpla by the user, is not subject to restrictions or prohibitions and / or prohibit and / or limit;')}}</p>
                            <p>i)	{{__('that by using Growpla, you will not post or enter material that is injurious or defamatory to any individual, offensive, provocative, obscene, hateful, violent, disparaging, discriminatory, sexist, racist or promotes sexually explicit material.')}}</p>
                        </ul>
                        <p>{{__('In any case, the list of prohibited content is to be considered indicative and not exhaustive, the owner reserves the right to censor or remove the user\'s content independently of the fact that it is protected by law. The owner will not be obligated but may censor or remove user content at its discretion without prior notice, consent or communication.')}}</p>
                        <h6>2.	{{__('HOW TO "USE" GROWPLA')}}</h6>
                        <p>{{__('To access the service offered by the platform you must connect to the website www.startupgrowthub.com . It\'s up to the User obtain access to the Internet according to the rates applied by the provider chosen by the User. The use of the platform and the service are subject to the User\'s full acceptance of these Terms, by selecting and clicking on the appropriate Terms acceptance button on the Site. The Terms are available for download. The use of the platform by the User requires prior access to an internet browser, therefore a device capable of connecting to  internet on which a recent and updated browser compatible with the site is installed. The service is provided free of charge, the owner reserves the right to change the cost of the service upon notice and acceptance by the user.')}}</p>
                        <h6>3.	{{__('PLATFORM SERVICE')}}</h6>
                        <p>{{__('The platform will communicate the information necessary for the service to be provided efficiently and correctly, such as the data entered by the user during registration. The user may receive reminders and/or notifications in order to be updated on the contacts made with other users.The function of the service offered by the platform is to put in contact all the players of the startup world, for example: startups, co-founders, incubators/accelerators of startups, business angels, providers of services to startups, entities that promote announcements, contests and calls for startups.')}}
                        <p>{{__('The purpose of this contact is to generate a meeting point between supply and demand related to all the preliminary and preparatory stages to the consolidation of the startup, for example: pre-seed, seed, early stage, early growth (round A or B), growth, exit. The User will be entitled to use the service only in the manner and within the timeframe provided by the platform, with the exception of subsequent changes communicated by the platform.The User, with reference to the service, acknowledges that he/she will not occupy specific positions of prevalence over other users and that if he/she should occupy positions considered as less advantageous, or “losing position” to other users, he/she will not be entitled to make any claim in this regard. The owner reserves the right to attribute position and/or visibility on the platform to the users, in the way and for the reasons that he considers appropriate.')}}</p>
                        <p> {{__('The User accepts that the service offered will be valid no later than the time interval indicated on the Site. The owner reserves the right to delete the user\'s profile, in which case the user will lose all data relating to the account deleted.')}}</p>
                        <h6>4.	{{__('RESPONSIBILITIES')}}</h6>
                        <p>{{__('Vincenzo Tarantino is not responsible for any errors or omissions in the contents or for any technical problems encountered in the site or within the service, except in case of fraud or gross negligence. Within the limits established by law, the owner assumes no responsibility for damages or losses that users or third parties may suffer in relation to the site.')}}</p>
                        <p>{{__('The provisions of this article are inapplicable in relations between Mr. Tarantino and consumers, in case of fraud or serious negligence on the part of Vincenzo Tarantino, death or physical damage to the User resulting from negligence or misleading statements regarding essential statements and all cases for which the law provides for the exclusion of liability. The platform may not be available or work properly. The owner makes no warranty whatsoever about the operation or availability of the platform.')}}</p>
                        <h6>5.	{{__('INTELLECTUAL PROPERTY RIGHTS')}}</h6>
                        <p>{{__('The Site (and its contents and graphics), the Growpla trademark, the domain name “www.growpla.com” and all intellectual property rights and/or industrial property rights related to them, belong to Vincenzo Tarantino or have been licensed to him and are not transferred in any case to the User. Such intellectual property are protected by the current regulations on copyright and intellectual property at national and international level. The User agrees not to reproduce, duplicate, copy, sell, transfer, use for commercial purposes, modify, decode, disassemble, in whole or in part, the Site and/or the platform or create derivative work based on them or attempt to access their source code.')}}</p>
                        <h6>6.	{{__('SUSPENSION AND MODIFICATIONS')}}</h6>
                        <p>{{__('The closing of the platform by Vincenzo Tarantino, shall be interpreted as his exercise of the right of withdrawal from these Terms. Vincenzo Tarantino does not guarantee that SGH and access to the Site will be available and furthermore reserves the right to suspend or terminate permanently or temporarily access by the user at any time without notice. Even after these Terms have ceased to be effective, the following clauses of these Terms will remain valid and effective')}}:  1, 4, 5, 6, 7, 8, 9, 10.</p>
                        <h6>7.	{{__('TERMINATION')}}</h6>
                        <p>{{__('If you breach one or more of the provisions of these Terms, the owner may terminate these Terms with immediate effect and/or take one of the following measures, which are not exhaustive:')}}
                        <ul>
                            <p>- {{__('prohibit temporarily or permanently, the user’s access to the platform;')}}</p>
                            <p>- {{__('communicate a warning to the user;')}}</p>
                            <p>- {{__('take legal action against the user, including a claim for reimbursement of costs and damages caused by the violation;')}}</p>
                            <p>- {{__('to provide the competent public authority with the information considered necessary to enforce compliance with applicable law.')}}</p>
                        </ul>
                        </p>
                        <h6>8.	{{__('APPLICABLE LAW AND PLACE OF JURISDICTION')}}</h6>
                        <p>{{__('For any dispute on the interpretation and / or execution of this contract, the Italian law applies and the place of jurisdiction is elected to Naples. However, pursuant to Directive 2011/83/EU, if the User acts as a "consumer", the place of jurisdiction will be that of the place where the User has his residence or domicile in the Italian territory.')}}</p>
                        <h6>9.	{{__('CHANGES')}}</h6>
                        <p>{{__('Vincenzo Tarantino reserves the right to update or modify these Terms and Conditions at any time. Mr. Tarantino will inform Users of any changes directly on the Site.')}}</p>
                        <h6>10.	{{__('COMMUNICATIONS AND COMPLAINTS')}}</h6>
                        <p>{{__('For communications or complaints about these terms and conditions you can contact this address:')}}
                        info@growpla.com</p>
                    </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
@endsection

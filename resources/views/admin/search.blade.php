@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="search">
    @if(Auth::user()->tutorial)
    <div class="container">
        <h3 class="section-title">
            <b></b>
            <span>{{ __('Welcome to Growpla!') }}
             </span>
            <b></b>
        </h3>
        <p class="text-center m-0">
            {{ __('To complete your registration click here') }}
        </p>
        <div class="create-profile">
            <a class="item col-sm-12 col-md-6 col-lg-6 col-xl-6" href="{{ route('admin.users.tutorial') }}">{{__('Start')}}</a>
        </div>
    </div>
    @endif
    <div class="background">
        <div class="container">
            <div class="search">
                <h1>{{ __('What are you looking for?') }}</h1>
                <div class="search-type">
                    <div  class="switch-big-button-container pt-1 pb-2">
                        <div :class="search_type?
                        'button r switch-button text t-l d-inline-block':
                        'button r switch-button text t-r d-inline-block'">
                            <input type="checkbox" class="checkbox" v-model="search_type" @change="search_type_f()">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                </div>
                <div class="search-main" v-cloak>
                    <div v-if="!search_type" class="search-filter row">
                        <div class="search-style">
                            <h6>Cosa cerchi?</h6>
                            <select class="text-capitalize" name="" v-model="category_selected" @change="change_category()" required>
                                <option value="">Seleziona un'opzione</option>
                                <option value="1">{{--$pagetypes[0]->name--}}Startup</option>
                                <option value="2">{{--$usertypes[0]->name--}}Aspiranti Co-Founder</option>
                                <option value="3">Incubatore-Acceleratore</option>
                                <option value="4">Investitori</option>
                                <option value="5">Enti e associazioni</option>
                                <option value="6">Servizi</option>
                            </select>
                        </div>
                        {{-- startup --}}
                        <div v-if="pagetypes_id.includes(1)" class="search-style">
                            <h6>In quale fase del ciclo di vita?</h6>
                            <select class="text-capitalize" name="lifecycle_id" v-model="lifecycle_id_selected">
                                    <option value="">Non specificato</option>
                                @foreach ($lifecycles as $lifecycle)
                                    <option class="text-capitalize" value="{{$lifecycle->id}}">{{$lifecycle->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div v-if="pagetypes_id.includes(1)" class="search-style">
                            <h6>Cerca solo le startup che hanno bisogno di:</h6>
                            <select class="text-capitalize" name="needs" v-model="need_selected">
                                <option value="">Non specificato</option>
                                @foreach ($usertypes as $usertype)
                                    @if ($usertype->id==1 || $usertype->id==2)
                                        <option class="text-capitalize" :value="{'type':1, 'id':{{$usertype->id}}}">{{$usertype->name_it}}</option>
                                    @endif
                                @endforeach
                                @foreach ($pagetypes as $pagetype)
                                    @if ($pagetype->id==3 || $pagetype->id==5 || $pagetype->id==8)
                                        <option class="text-capitalize" :value="{'type':2, 'id':{{$pagetype->id}}}">{{$pagetype->name_it}}</option>
                                    @endif
                                @endforeach
                                <option class="text-capitalize" :value="{'type':3, 'id':''}">Servizi</option>
                            </select>
                        </div>

                        {{-- cofounder --}}
                        <div v-if="usertypes_id.includes(1)
                        || need_selected.type==1 && need_selected.id==1" class="search-style">
                            <div class="">
                                <h6 v-if="need_selected.id==1" for="" class="d-block">Cerco startup che hanno bisogno di profili che dispongono di</h6>
                                <h6 v-else for="" class="d-block">Cerco profili che dispongono di</h6>
                                <input type="radio" name="skillsToggle" value="false" v-model="skillsToggle" id="one-skill" class="w-auto h-auto" :checked="!skillsToggle">
                                <label for="one-skill">una delle seguenti competenze</label>
                                <input type="radio" name="skillsToggle" value="true" v-model="skillsToggle" id="all-skill" class="w-auto h-auto" :checked="skillsToggle">
                                <label for="all-skill">tutte le seguenti competenze</label>
                            </div>
                            <h6>Quali competenze devono possedere?</h6>
                            <div v-for="(skill,i) in skills" class="" v-cloak>
                              <input type="hidden" name="skills[]" :value="skill.name">
                              <label for="">@{{skill.name}}
                                <i class="fas fa-trash-alt" @click="removeSkill(i)"></i>
                              </label>
                            </div>
                            <input type="text" name="name" value="" placeholder="Nome competenza" v-model="skill_name" @keyup.enter="searchSkill()" v-on:input="searchSkill()" maxlength="70" class="form-control" autocomplete="off">
                            @error ('skill_name')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                            <div :class="skills_found.length>0?'found':'found d-none'" v-cloak>
                              <a class="item" v-for="skill_found in skills_found" @click="addSkill(skill_found)">
                                  @{{skill_found.name}}
                              </a>
                            </div>
                        </div>
                        {{-- investitori --}}
                        <div v-if="investors_selected" class="search-style">
                            <h6>Quale?</h6>
                            <select class="text-capitalize" name="" v-model="investor_selected" @change="investorType()">
                                    <option value="">Tutti</option>
                                    <option class="text-capitalize" value="1">
                                      Business Angel{{--$usertypes[1]->name--}}
                                    </option>
                                    <option class="text-capitalize" value="2">
                                      Venture Capital{{--$pagetypes[4]->name--}}
                                    </option>
                                    <option class="text-capitalize" value="3">
                                      Private Equity{{--$pagetypes[7]->name--}}
                                    </option>
                            </select>
                        </div>
                        {{-- servizi --}}
                        <div v-if="services_selected" class="search-style">
                            <h6 for="" class="d-block">Cerco profili che</h6>
                            <input type="radio" name="serviceToggle" value="false" v-model="serviceToggle" id="have-service" class="w-auto h-auto" :checked="!serviceToggle">
                            <label for="have-service">offrono</label>
                            <input type="radio" name="serviceToggle" value="true" v-model="serviceToggle" id="give-service" class="w-auto h-auto" :checked="serviceToggle">
                            <label for="give-service">cercano</label>
                        </div>
                        <div v-if="services_selected" class="search-style">
                            <input type="radio" name="serviceOrAndToggle" value="false" v-model="serviceOrAndToggle" id="one-service" class="w-auto h-auto" :checked="!serviceOrAndToggle">
                            <label for="one-service">uno dei seguenti servizi</label>
                            <input type="radio" name="serviceOrAndToggle" value="true" v-model="serviceOrAndToggle" id="many-service" class="w-auto h-auto" :checked="serviceOrAndToggle">
                            <label for="many-service">tutti i seguenti</label>
                        </div>
                        <div v-if="services_selected || need_selected.type==3" class="search-style">
                            <h6 v-if="need_selected.type==3" for="">Startup che cercano servizio di:</h6>
                            <div v-for="(service,i) in services" class="" v-cloak>
                              <input type="hidden" name="services[]" :value="service.name">
                              <label for="">@{{service.name}}
                                <i class="fas fa-trash-alt" @click="removeService(i)"></i>
                              </label>
                            </div>
                            <input type="text" name="name" value="" placeholder="Nome servizio" v-model="service_name" @keyup.enter="searchService()" v-on:input="searchService()" maxlength="70" class="form-control" autocomplete="off">
                            @error ('service_name')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                            <div :class="services_found.length>0?'found':'found d-none'" v-cloak>
                              <a class="item" v-for="service_found in services_found" @click="addService(service_found)">
                                  @{{service_found.name}}
                              </a>
                            </div>
                        </div>
                        {{-- settori --}}
                        <div v-if="category_selected && category_selected!=6" class="search-style">
                            <h6 for="" class="d-block">Cerco profili che</h6>
                            <input type="radio" name="sectorToggle" value="false" v-model="sectorToggle" id="one-sector" class="w-auto h-auto" :checked="!sectorToggle">
                            <label for="one-sector">includono uno dei i seguenti settori:</label>
                            <input type="radio" name="sectorToggle" value="true" v-model="sectorToggle" id="many-sector" class="w-auto h-auto" :checked="sectorToggle">
                            <label for="many-sector">includono tutti i seguenti settori:</label>
                        </div>
                        <div v-if="category_selected && category_selected!=6" class="search-style">
                            <h6 v-if="category_selected==1 || category_selected==2">Settore di appartenenza:</h6>
                            <h6 v-if="category_selected==3 || category_selected==5">Settore d'interesse:</h6>
                            <h6 v-if="category_selected==4">Settore d'interesse d'investimento:</h6>
                            <div v-for="(sector,i) in sectors" class="" v-cloak>
                              <label for="">@{{sector.name_it}}
                                <i class="fas fa-trash-alt" @click="removeSector(i)"></i>
                              </label>
                            </div>
                            <div class="row m-0">
                              <select name="sector_id" v-model="sector_selected" class="text-capitalize" @change="addSector()">
                                      <option value="">Tutti</option>
                                  @foreach ($sectors as $sector)
                                      <option class="text-capitalize" :value="{id:{{$sector->id}}, name_it:'{{$sector->name_it}}'}">{{$sector->name_it}}</option>
                                  @endforeach
                              </select>
                              {{-- <button v-if="this.sector_selected" class="button-style button-color col-sm-2 col-md-2 col-lg-2 col-xl-2" @click="addSector()">
                                  Aggiungi
                              </button> --}}
                            </div>
                        </div>
                        {{-- <div v-if="pagetypes_id.length>0 || usertypes_id.length>0 || investors_selected  || organizzations_selected" class="search-style">
                            <h6>Dove:</h6>
                            <select class="text-capitalize" name="country_id" v-model="country_id_selected" @change="getRegionsByCountry()">
                                    <option value="">In tutto il mondo</option>
                                @foreach ($countries as $country)
                                    <option class="text-capitalize" value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div v-if="category_selected{{--regions.length>1--}}" class="search-style" v-cloak>
                            <h6>Regione:</h6>
                            <select class="text-capitalize" name="region_id" v-model="region_id_selected" required>
                                <option value="">Tutte le regioni</option>
                                <option v-for="region in regions" :value="region.id"
                                :selected="region.id==region_id_selected">@{{region.name}}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div v-else class="search-filter row">
                      <div class="search-style" v-cloak>
                          <h6>Cerca per nome</h6>
                          <input type="text" name="name" value="" placeholder="Inserisci nome qui" v-model="name" @keyup.enter="" v-on:input="" maxlength="70" class="form-control" autocomplete="off">
                          @error ('name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>
                    </div>
                    <form v-if="search_type && name || category_selected" class="search-style row m-0" method="POST" action="{{ route('admin.found') }}" >
                        @csrf
                        <input v-for="usertype_id in usertypes_id" type="hidden" name="usertypes_id[]" :value="usertype_id">
                        <input v-for="pagetype_id in pagetypes_id" type="hidden" name="pagetypes_id[]" :value="pagetype_id">
                        <input type="hidden" name="name" :value="name">
                        {{-- startup --}}
                        <input type="hidden" name="lifecycle_id" :value="lifecycle_id_selected">
                        <input type="hidden" name="need_pagetype_id" :value="need_selected.type==2?need_selected.id:''">
                        <input type="hidden" name="need_usertype_id" :value="need_selected.type==1?need_selected.id:''">
                        <input type="hidden" name="skills_toggle" :value="skillsToggle">
                        <input v-for="skill in skills" type="hidden" name="skills[]" :value="skill.pivot.skill_id">
                        <input v-for="service in services" type="hidden" name="services[]" :value="service.pivot.service_id">
                        <input type="hidden" name="service_toggle" :value="serviceToggle">
                        <input type="hidden" name="service_or_and_toggle" :value="serviceOrAndToggle">
                        <input v-for="sector in sectors" type="hidden" name="sectors[]" :value="sector.id">
                        <input type="hidden" name="sector_toggle" :value="sectorToggle">
                        <input type="hidden" name="sector_id" :value="sector_selected">
                        <input type="hidden" name="country_id" value="1"{{--:value="country_id_selected"--}}>
                        <input type="hidden" name="region_id" :value="region_id_selected">
                        <button class="button-style button-color w-100" type="submit" name="button">{{__('Search')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h4>Ricerca rapida</h4>
        <div class="rapid-search row d-flex justify-content-center ">
            <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2">
                <form class="page-list" method="POST" action="{{ route('admin.found') }}">
                    @csrf
                    <input type="hidden" name="pagetypes_id[]" value="1">
                    <button class="" type="submit" name="button">Startup</button>
                </form>
            </div>
            <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2">
                <form class="page-list" method="POST" action="{{ route('admin.found') }}">
                    @csrf
                    <input type="hidden" name="pagetypes_id[]" value="3">
                    <button class="" type="submit" name="button">Incubatori/Acceleratori</button>
                </form>
            </div>
            <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2">
                <form class="page-list" method="POST" action="{{ route('admin.found') }}">
                    @csrf
                    <input type="hidden" name="usertypes_id[]" value="2">
                    <input type="hidden" name="pagetypes_id[]" value="5">
                    <input type="hidden" name="pagetypes_id[]" value="8">
                    <button class="" type="submit" name="button">Investitori</button>
                </form>
            </div>
            <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2">
                <form class="page-list" method="POST" action="{{ route('admin.found') }}">
                    @csrf
                    <input type="hidden" name="usertypes_id[]" value="1">
                    <button class="" type="submit" name="button">Aspiranti Co-founder</button>
                </form>
            </div>
            <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2">
                <form class="page-list" method="POST" action="{{ route('admin.found') }}">
                    @csrf
                    <button class="" type="submit" name="button">Servizi</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <h4>Necessità</h4>
        <a href="{{route('admin.needs.getAllHave')}}">Mostra altro</a>
    </div>
    <div class="container">
        <h4>Offerta</h4>
        <a href="{{route('admin.offers.getAllGive')}}">Mostra altro</a>
    </div>
    <div class="container">
        <h4>Collaborazioni</h4>
        <a href="{{route('admin.collaborations.all')}}">Mostra altro</a>
    </div>
</div>
{{-- PUSHER --}}
{{-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ba4b0371aa101a54a0a8', {
      cluster: 'eu'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        //cosa succede quando ricevo un evento?
        alert(JSON.stringify(data));//visualizzo un alert
    });
</script> --}}
@endsection

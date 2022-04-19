@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="search">
    @if(Auth::user()->tutorial)
    <div class="bg-white">
        <div class="container pb-5">
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
    </div>
    @endif
    <div class="background"
    style="background-image: url({{asset("storage/images/jumbotron.svg") }})">
        <div class="container">
            <div class="search">
                <div id="search-fixed" class="search-fixed">
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
                        <div v-if="!search_type" class="search-filter">
                            <div class="search-style col-sm-12 col-md-12 col-lg-6 col-xl-6 mx-auto">
                                <select class="text-capitalize" name="" v-model="category_selected" @change="change_category()" required>
                                    <option value="">Cosa cerchi?</option>
                                    <option value="1">{{--$pagetypes[0]->name--}}Startup</option>
                                    <option value="2">{{--$usertypes[0]->name--}}Aspiranti Co-Founder</option>
                                    <option value="3">Incubatore-Acceleratore</option>
                                    <option value="4">Investitori</option>
                                    <option value="5">Enti e associazioni</option>
                                    <option value="6">Servizi</option>
                                </select>
                            </div>
                        </div>
                        <div v-else class="search-filter">
                            <div class="search-style col-sm-12 col-md-12 col-lg-6 col-xl-6 mx-auto" v-cloak>
                                <input type="text" name="name" value="" placeholder="Cerca per nome" v-model="name" @keyup.enter="" v-on:input="" maxlength="70"    class="form-control" autocomplete="off">
                                @error ('name')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="filter-cont mt-3 mb-1">
                            <div class="row d-flex justify-content-center">
                                {{-- startup --}}
                                <div v-if="pagetypes_id.includes(1)" class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <span class="mini-txt font-weight-bold d-block">In quale fase del ciclo di vita?</span>
                                    <select class="text-capitalize" name="lifecycle_id" v-model="lifecycle_id_selected">
                                            <option value="">Non specificato</option>
                                        @foreach ($lifecycles as $lifecycle)
                                            <option class="text-capitalize" value="{{$lifecycle->id}}">{{$lifecycle->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div v-if="pagetypes_id.includes(1)" class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <span class="mini-txt font-weight-bold d-block">Cerca solo le startup che hanno bisogno di</span>
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
                                {{-- <div v-if="usertypes_id.includes(1)
                                || need_selected.type==1 && need_selected.id==1" class="">
                                    <div class="">
                                        <span v-if="need_selected.id==1" for="" class="d-block">Cerco startup che hanno bisogno di profili che dispongono di</span>
                                        <span v-else for="" class="d-block">Cerco profili che dispongono di</span>
                                        <input type="radio" name="skillsToggle" value="false" v-model="skillsToggle" id="one-skill" class="w-auto h-auto" :checked="!skillsToggle">
                                        <label for="one-skill">una delle seguenti competenze</label>
                                        <input type="radio" name="skillsToggle" value="true" v-model="skillsToggle" id="all-skill" class="w-auto h-auto" :checked="skillsToggle">
                                        <label for="all-skill">tutte le seguenti competenze</label>
                                    </div>
                                    <span>Quali competenze devono possedere?</span>
                                    <div v-for="(skill,i) in skills" class="" v-cloak>
                                      <input type="hidden" name="skills[]" :value="skill.name">
                                      <label for="">@{{skill.name}}
                                        <i class="fas fa-times"></i> @click="removeSkill(i)"></i>
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
                                </div> --}}
                                {{-- investitori --}}
                                <div v-if="investors_selected" class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <span class="mini-txt font-weight-bold d-block">Quale?</span>
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
                                <div v-if="services_selected || need_selected.type==3" class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <div class="">
                                        <span class="mini-txt font-weight-bold d-block" v-if="usertypes_id.includes(1)" for="" class="d-block">Cerco profili che offrono</span>
                                        <span class="mini-txt font-weight-bold d-block" v-else-if="need_selected.type==3" for="" class="d-block">Cerco startup che hanno bisogno di</span>
                                        <span class="mini-txt font-weight-bold d-block" v-else for="" class="d-block">Cerco profili che</span>
                                    </div>
                                    <div v-if="services_selected && !usertypes_id.includes(1)" class="sub-filter-cont mt-1">
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">offrono
                                                <input type="radio" name="serviceToggle" value="false" v-model="serviceToggle" id="have-service" class="w-auto h-auto mr-1" :checked="!serviceToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">cercano
                                                <input type="radio" name="serviceToggle" value="true" v-model="serviceToggle" id="give-service" class="w-auto h-auto mr-1" :checked="serviceToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="services_selected" class="mt-1">
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">uno dei seguenti servizi
                                                <input type="radio" name="serviceOrAndToggle" value="false" v-model="serviceOrAndToggle" id="one-service" class="w-auto h-auto mr-1" :checked="!serviceOrAndToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">tutti i seguenti servizi
                                                <input type="radio" name="serviceOrAndToggle" value="true" v-model="serviceOrAndToggle" id="many-service" class="w-auto h-auto mr-1" :checked="serviceOrAndToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <div v-for="(service,i) in services" class="border-style bg-white" v-cloak>
                                          <input type="hidden" name="services[]" :value="service.name">
                                          <label for="" class="m-0">@{{service.name}}
                                            <i class="fas fa-times" @click="removeService(i)"></i>
                                          </label>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <div v-if="services.length<4" class="">
                                            <span class="mini-txt font-weight-bold d-block">Seleziona uno o piu servizi</span>
                                            <div class="pl-1 pr-1">
                                                <div class="">
                                                    <select class="" name="" @change="changeMainService()" v-model="main_service_selected">
                                                        <option value="">Specifica settore</option>
                                                        <option v-for="main_service in main_services" :value="main_service.id">@{{main_service.name}}</option>
                                                    </select>
                                                </div>
                                                <div v-if="main_service_selected" class="">
                                                    <select class="" name=""
                                                    v-model="sub_service_selected" @change="addServiceSelected(sub_service_selected)">
                                                        <option value="">Specifica sottocategoria</option>
                                                        <option v-for="sub_service in sub_services_show" :value="sub_service.id">@{{sub_service.name}}</option>
                                                    </select>
                                                </div>
                                                {{-- <div v-if="sub_service_selected" class="">
                                                    <button type="button" name="button" @click="addServiceSelected(sub_service_selected)" class="w-100 button-style button-color-blue">Aggiungi</button>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- settori --}}
                                <div v-if="category_selected && category_selected!=6" class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <div class="">
                                        <span class="mini-txt font-weight-bold d-block">Cerco profili che includono</span>
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">uno dei i seguenti settori
                                                <input type="radio" name="sectorToggle" value="false" v-model="sectorToggle" id="one-sector" class="mr-1" :checked="!sectorToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="input-container m-0">tutti i seguenti settori
                                                <input type="radio" name="sectorToggle" value="true" v-model="sectorToggle" id="many-sector" class="mr-1" :checked="sectorToggle">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <span class="mini-txt font-weight-bold d-block" v-if="category_selected==1 || category_selected==2">Settore di appartenenza</span>
                                        <span class="mini-txt font-weight-bold d-block" v-if="category_selected==3 || category_selected==5">Settore d'interesse</span>
                                        <span class="mini-txt font-weight-bold d-block" v-if="category_selected==4">Settore d'interesse d'investimento</span>
                                        <div v-for="(sector,i) in sectors" class="border-style bg-white" v-cloak>
                                          <label for="" class="m-0">@{{sector.name_it}}
                                            <i class="fas fa-times" @click="removeSector(i)"></i>
                                          </label>
                                        </div>
                                        <div v-if="sectors.length<4" class="m-0">
                                          <select name="sector_id" v-model="sector_selected" class="text-capitalize" @change="addSector()">
                                                  <option value="">Tutti</option>
                                              @foreach ($sectors as $sector)
                                                  <option class="text-capitalize" :value="{id:{{$sector->id}}, name_it:'{{$sector->name_it}}'}">{{$sector->name_it}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div v-if="pagetypes_id.length>0 || usertypes_id.length>0 || investors_selected  || organizzations_selected" class="">
                                    <span>Dove:</span>
                                    <select class="text-capitalize" name="country_id" v-model="country_id_selected" @change="getRegionsByCountry()">
                                            <option value="">In tutto il mondo</option>
                                        @foreach ($countries as $country)
                                            <option class="text-capitalize" value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div v-if="category_selected{{--regions.length>1--}}" class="col-sm-12 col-md-12 col-lg-2 col-xl-2" v-cloak>
                                    <span class="mini-txt font-weight-bold d-block">Regione</span>
                                    <select class="text-capitalize" name="region_id" v-model="region_id_selected" required>
                                        <option value="">Tutte le regioni</option>
                                        <option v-for="region in regions" :value="region.id"
                                        :selected="region.id==region_id_selected">@{{region.name}}
                                        </option>
                                    </select>
                                </div>
                                <div v-if="pagetypes_id.includes(3)" class="col-sm-12 col-md-12 col-lg-2 col-xl-2" v-cloak>
                                    <a class="button-style button-color-blue" href="{{route('incubators')}}">Incubatori d'italia</a>
                                </div>
                            </div>
                        </div>
                        <form v-if="search_type && name || category_selected" class="text-center" method="POST" action="{{ route('admin.found') }}">
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
                            <button class="button-style button-color mt-2" type="submit" name="button">Ricerca</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h4 class="font-weight-bold text-center">Ricerca rapida</h4>
            <div class="rapid-search row d-flex justify-content-around pt-3 pb-5">
                <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
                    <form class="" method="POST" action="{{ route('admin.found') }}">
                        @csrf
                        <input type="hidden" name="pagetypes_id[]" value="1">
                        <button class="button-style button-color-green  w-100 h-100" type="submit" name="button">Startup</button>
                    </form>
                </div>
                <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
                    <form class="" method="POST" action="{{ route('admin.found') }}">
                        @csrf
                        <input type="hidden" name="pagetypes_id[]" value="3">
                        <button class="button-style button-color-green  w-100 h-100" type="submit" name="button">Incubatori/Acceleratori</button>
                    </form>
                </div>
                <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
                    <form class="" method="POST" action="{{ route('admin.found') }}">
                        @csrf
                        <input type="hidden" name="usertypes_id[]" value="2">
                        <input type="hidden" name="pagetypes_id[]" value="5">
                        <input type="hidden" name="pagetypes_id[]" value="8">
                        <button class="button-style button-color-green  w-100 h-100" type="submit" name="button">Investitori</button>
                    </form>
                </div>
                <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
                    <form class="" method="POST" action="{{ route('admin.found') }}">
                        @csrf
                        <input type="hidden" name="usertypes_id[]" value="1">
                        <button class="button-style button-color-green  w-100 h-100" type="submit" name="button">Aspiranti Co-founder</button>
                    </form>
                </div>
                <div class="rapid-search-item col-sm-12 col-md-4 col-lg-3 col-xl-2 p-1">
                    <form class="" method="POST" action="{{ route('admin.found') }}">
                        @csrf
                        <button class="button-style button-color-green w-100 h-100" type="submit" name="button">Servizi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="end-background">

    </div>
    {{-- SLIDER ESEMPIO --}}
    {{-- <div class="container">
        <div class="main-multi-slider">
            <div class="multi-slider-cont" id="multi-slider-cont-1">
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 1</span>
                </div>
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 2</span>
                </div>
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 3</span>
                </div>
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 4</span>
                </div>
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 5</span>
                </div>
                <div class="multi-slider-item col-sm-11 col-md-7 col-lg-5 col-xl-3">
                    <span>Slide 6</span>
                </div>
            </div>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left" v-cloak>
                <i class="fas fa-caret-left"></i>
            </button>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right" v-cloak>
                <i class="fas fa-caret-right"></i>
            </button>
        </div>
    </div> --}}
    <div v-if="offers.length>0" class="container pt-3 pb-3" v-cloak>
        <h4 class="font-weight-bold">Offerte</h4>
        <div class="main-multi-slider">
            <div class="multi-slider-cont" id="multi-slider-cont-1">
                <div v-for="offer in offers" class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <div class=" d-flex justify-content-center align-items-center h-100">
                        <div class="card-style card-color-green">
                            <div class="top pb-4">
                                <div class=" img-cont mini-img">
                                    <img v-if="offer.image" :src="'/storage/' + offer.image" alt="">
                                </div>
                                <p class="name text-capitalize text-dark">
                                    @{{offer.user_or_page? offer.name +' ' +offer.surname : offer.name}}
                                </p>
                                {{-- <span>@{{offer.service_id?'cerca servizio di':'cerca'}}</span> --}}
                                <p class="service text-capitalize">
                                    @{{offer.need}}
                                </p>
                            </div>
                            <div class="button text-center font-weight-normal">
                                <a :href="offer.user_or_page?'/admin/users/'+ offer.id : '/admin/pages/'+ offer.id" class="button-style button-color-blue">Visita profilo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left" id="button-left-1" v-cloak>
                <span class="arrow-black r-180"></span>
            </button>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')" class="slider-right" id="button-right-1" v-cloak>
                <span class="arrow-black"></span>
            </button>
            <span>@{{this.delay(1)}}</span>
        </div>
        <div class="text-center">
            <a href="{{route('admin.offers.getAllGive')}}" class="font-weight-bold text-dark">
                Scopri tutte le offerte >
            </a>
        </div>
    </div>
    <div v-if="needs.length>0" class="container pt-3 pb-3" v-cloak>
        <h4 class="font-weight-bold">Necessità</h4>
        <div class="main-multi-slider">
            <div class="multi-slider-cont" id="multi-slider-cont-2">
                <div v-for="need in needs" class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                    <div class=" d-flex justify-content-center align-items-center h-100">
                        <div class="card-style card-color-blue">
                            <div class="top pb-4">
                                <div class=" img-cont mini-img">
                                    <img v-if="need.image" :src="'/storage/' + need.image" alt="">
                                </div>
                                <p class="name text-capitalize text-dark">
                                    @{{need.user_or_page? need.name +' ' +need.surname : need.name}}
                                </p>
                                {{-- <span>@{{need.service_id?'cerca servizio di':'cerca'}}</span> --}}
                                <p class="service text-capitalize">
                                    @{{need.need}}
                                </p>
                            </div>
                            <div class="bottom text-center font-weight-normal">
                                <a :href="need.user_or_page?'/admin/users/'+ need.id : '/admin/pages/'+ need.id" class="button-style button-color-blue">Visita profilo</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(2,'left')" @mouseleave="stop(2,'left')" @mouseup="stop(2,'left')" class="slider-left" id="button-left-2" v-cloak>
                <span class="arrow-black r-180"></span>
            </button>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(2,'right')" @mouseleave="stop(2,'right')" @mouseup="stop(2,'right')"class="slider-right" id="button-right-2" v-cloak>
                <span class="arrow-black"></span>
            </button>
            <span>@{{this.delay(2)}}</span>
        </div>
        <div class="text-center">
            <a href="{{route('admin.needs.getAllHave')}}" class="font-weight-bold text-dark">
                Scopri tutte le richieste >
            </a>
        </div>
    </div>
    <div v-if="collaborations.length>0" class="container pt-3 pb-3" v-cloak>
        <h4 class="font-weight-bold">Collaborazioni</h4>
        <div class="main-multi-slider">
            <div class="multi-slider-cont" id="multi-slider-cont-3">
                <div v-for="collaboration in collaborations" class="multi-slider-item col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="card-collaboration border-green d-flex justify-content-between">
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center coll-item">
                                <div class="">
                                    <div class="img-cont medium-img">
                                        <img v-if="collaboration.account_1.image" :src="'/storage/' + collaboration.account_1.image" alt="">
                                    </div>
                                </div>
                                <div class="coll-info">
                                    <p class="text-capitalize text-truncate font-weight-bold">
                                        @{{collaboration.account_1.user_or_page? collaboration.account_1.name +' ' +collaboration.account_1.surname : collaboration.account_1.name}}
                                    </p>
                                    <a :href="collaboration.account_1.user_or_page?'/admin/users/'+ collaboration.account_1.id : '/admin/pages/'+ collaboration.account_1.id" class="button-style button-color-green">
                                        Visita profilo
                                    </a>
                                </div>
                            </div>
                            <div class="link">
                                <img src="/storage/images/link-icon.svg" alt="">
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center coll-item">
                                <div class="">
                                    <div class="img-cont img-cont-blue medium-img">
                                        <img v-if="collaboration.account_2.image" :src="'/storage/' + collaboration.account_2.image" alt="">
                                    </div>
                                </div>
                                <div class="coll-info">
                                    <p class="text-capitalize text-truncate font-weight-bold">
                                        @{{collaboration.account_2.user_or_page? collaboration.account_2.name +' ' +collaboration.account_2.surname : collaboration.account_2.name}}
                                    </p>
                                    <a :href="collaboration.account_2.user_or_page?'/admin/users/'+ collaboration.account_2.id : '/admin/pages/'+ collaboration.account_2.id" class="button-style button-color-blue">
                                        Visita profilo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(3,'left')" @mouseleave="stop(3,'left')" @mouseup="stop(3,'left')" class="slider-left" id="button-left-3" v-cloak>
                <span class="arrow-black r-180"></span>
            </button>
            <button v-if="!is_mobile" type="button" name="button" @mousedown="start(3,'right')" @mouseleave="stop(3,'right')" @mouseup="stop(3,'right')"class="slider-right" id="button-right-3" v-cloak>
                <span class="arrow-black"></span>
            </button>
            <span>@{{this.delay(3)}}</span>
        </div>
        <div class="text-center">
            <a href="{{route('admin.collaborations.index')}}" class="font-weight-bold text-dark">
                Scopri tutte le collaborazioni >
            </a>
        </div>
    </div>
    <div v-if="mostViewedAccounts.length>0" class="container pt-3 pb-5" v-cloak>
        <h4 class="font-weight-bold">I più popolari</h4>
        <div class="row pt-4">
            <a v-for="account in mostViewedAccounts" :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="col-sm-12 col-md-6 col-lg-3 col-xl-3 text-center">
                <div class="">
                    <div class="img-cont medium-img scale">
                        <img v-if="account.image" :src="'/storage/' + account.image" alt="">
                    </div>
                </div>
                <div class="">
                    <p class="text-capitalize font-weight-bold  text-dark text-truncate">@{{account.user_or_page? account.name +' ' +account.surname : account.name}}</p>
                </div>
                {{-- <a :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="button-style button-color">Visita profilo</a> --}}
            </a>
        </div>
    </div>
    <div v-show="myLatestViews.length>0" class="container pt-3 pb-5" v-cloak>
        <h4 class="font-weight-bold">Visti di recente</h4>
        <div class="row  pt-4">
            <a v-for="account in myLatestViews" :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="col-sm-12 col-md-6 col-lg-3 col-xl-3 text-center">
                <div class="">
                    <div class="img-cont medium-img scale">
                        <img v-if="account.image" :src="'/storage/' + account.image" alt="">
                    </div>
                </div>
                <div class="">
                    <p class="text-capitalize font-weight-bold text-dark text-truncate">@{{account.user_or_page? account.name +' ' +account.surname : account.name}}</p>
                </div>
            </a>
        </div>
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

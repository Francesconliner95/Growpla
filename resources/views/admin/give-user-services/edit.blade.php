@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = "{{$user}}";
    pagetype_id = "";
    services = @json($services);
    r_services = @json($recommended_services);
    lifecycles = "";
    lifecycle_id = "";
    cofounder_services = "";
</script>
<div id="service-edit">
    <div class="container" id="offer">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Servizi offerti</h2>
                </div>
                <h5 class="">Metti a disposizione della community la tua professionalità.</h5>
                {{-- <h6>Seleziona servizi che intendi offrire in piattaforma</h6>
                <div class="">
                    <button v-for="(r_service,i) in r_services_show"
                    class="d-inline-block border-style" type="button" name="button"
                    @click="addService(r_service)" :id="r_service.id+'-button'">
                        @{{r_service.name}}
                    </button>
                </div> --}}
                <form method="POST" action="{{ route('admin.give-user-services.update',$user->id) }}">
                    @csrf
                    @method('PUT')
                    {{-- <div  class="search">
                        <h6>Aggiungi servizio non in elenco</h6>
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                <input type="text" name="name" value="" placeholder="Nome servizio" v-model="service_name" @keyup.enter="searchService()" v-on:input="searchService()" maxlength="70" class="form-control" autocomplete="off">
                                @error ('service_name')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            <button type="button" name="button" @click="addManualSkill()" class="button-style button-color-blue col-sm-2 col-md-2 col-lg-2 col-xl-2">Aggiungi</button>
                        </div>
                        <div :class="services_found.length>0?'found':'found d-none'" v-cloak>
                          <a class="item" v-for="service_found in services_found" @click="addService(service_found)">
                              @{{service_found.name}}
                          </a>
                        </div>
                    </div> --}}
                    <div v-show="main_services.length>0" class="pt-3" v-cloak>
                        <h6 class="pb-2">Seleziona uno o più servizi che intendi offrire in piattaforma:</h6>
                        <div class="from-group row pr-3 pl-3 pb-3">
                            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-1">
                                <select class="form-control custom-select-green" name="" @change="changeMainService()" v-model="main_service_selected">
                                    <option value="">Specifica settore</option>
                                    <option v-for="main_service in main_services" :value="main_service.id">@{{main_service.name}}</option>
                                </select>
                            </div>
                            <div v-if="main_service_selected" class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-1">
                                <select class="form-control custom-select-green" name=""
                                v-model="sub_service_selected" @change="addServiceSelected(sub_service_selected)">
                                    <option value="">Specifica sottocategoria</option>
                                    <option v-for="sub_service in sub_services_show" :value="sub_service.id">@{{sub_service.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{-- <div v-for="(service,i) in services" class="d-inline-block border-style" v-cloak>
                          <input type="hidden" name="services[]" :value="service.name">
                          <span for="">@{{service.name}}
                            <i class="fas fa-trash-alt" @click="removeService(i)"></i>
                          </span>
                        </div> --}}
                        <div class="main-multi-slider">
                            <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                <div v-for="(service,i) in services" class="d-inline-block border-style multi-slider-item col-8 col-sm-8 col-md-5 col-lg-3 col-xl-3" v-cloak>
                                  <input type="hidden" name="services[]" :value="service.name">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="card-style-mini card-color-green position-relative">
                                            <div class="text-capitalize text-cont">
                                                @{{service.name}}
                                            </div>
                                            {{-- <div class="text-cont pt-5">
                                                @{{service.pivot.des}}
                                            </div> --}}
                                            <div class="edit-top-right scale">
                                                <i class="fas fa-times" @click="removeService(i)"></i>
                                            </div>
                                            {{-- <div class="img-cont micro-img edit-top-right scale" @click="removeService(i)">
                                                <img src="{{asset('storage/images/icon-x.svg')}}" alt="" class="p-2">
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white  mobile-hide" id="button-left-1" v-cloak>
                                <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                            </button>
                            <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right bg-white  mobile-hide" id="button-right-1" v-cloak>
                                <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                            </button>
                            <span>@{{this.delay(1)}}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h6 class="pb-2">Abilita la voce aspirante co-founder se sei disposto ad offrire i tuoi servizi in cambio di una percentuale di equity della startup in alternativa al denaro
                        </h6>
                        <div class="switch-button-on-off pt-1 pb-2 justify-content-start">
                            <div class="button r switch-button d-inline-block">
                                <input type="checkbox" class="checkbox" name="cofounder" id="cofounder" {{$user->usertypes->contains(1)?'checked':''}}>
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                            <label for="cofounder" class="px-2 m-0 font-weight-bold">
                                Aspirante cofounder (%Equity)
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-5">
                        <div class="">
                            <a href="{{ route('admin.supports.create') }}" class="font-weight-bold mini-txt txt-green">
                                Suggerisci altri servizi
                            </a>
                        </div>
                        <button type="submit" class="button-style button-color">
                            {{$user->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

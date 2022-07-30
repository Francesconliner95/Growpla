@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    pagetype_id = "{{$page->pagetype_id}}";
    services = @json($services);;
    r_services = @json($recommended_services);
    lifecycles = "";
    lifecycle_id = "";
    cofounder_services = "";
</script>
{{-- style="background-image: url({{asset("storage/images/bg-servizi.svg") }}); background-position: right -300px bottom -7px; background-repeat: no-repeat; background-size: 700px 500px;" --}}
<div id="service-edit">
    <div class="container" id="offer">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Servizi offerti</h2>
                </div>
                <h5>Metti a disposizione della community la tua professionalità.</h5>
                {{-- <h6>Seleziona servizi che intendi offrire in piattaforma</h6>
                <div class="">
                    <button v-for="(r_service,i) in r_services_show"
                    class="d-inline-block border-style" type="button" name="button"
                    @click="addService(r_service)" :id="r_service.id+'-button'">
                        @{{r_service.name}}
                    </button>
                </div> --}}
                <form method="POST" action="{{ route('admin.give-page-services.update',$page->id) }}">
                    @csrf
                    @method('PUT')
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
                        <div class="main-multi-slider">
                            <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                <div v-for="(service,i) in services" class="d-inline-block border-style multi-slider-item col-8 col-sm-8 col-md-5 col-lg-3 col-xl-3" v-cloak>
                                  <input type="hidden" name="services[]" :value="service.name">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="card-style-mini card-color-green position-relative">
                                            <div class="text-capitalize text-cont">
                                                @{{service.name}}
                                            </div>
                                            <div class="edit-top-right scale">
                                                <i class="fas fa-times" @click="removeService(i)"></i>
                                            </div>
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
                    <div class="d-flex justify-content-between mt-5">
                        <div class="">
                            <a href="{{ route('admin.supports.create') }}" class="font-weight-bold mini-txt txt-green">
                                Suggerisci altri servizi
                            </a>
                        </div>
                        <button type="submit" class="button-style button-color">
                            {{$page->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

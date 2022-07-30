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
    <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
        <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="item-style-visible">
                <button type="button" name="button" class="edit-top-right button-color-gray" @click="alert=false; sub_alert= false">
                    <i class="fas fa-times"></i>
                </button>
                <div v-if="!sub_alert" v-cloak>
                    <h4 class="p-2 pt-4 text-center">Hai soddisfatto questo bisogno grazie a Growpla?
                    </h4>
                    <div class="d-flex justify-content-around align-items-center">
                        <button type="button" name="button" class="button-style button-color-blue mr-5" @click="alert=false">
                            No
                        </button>
                        <button class="button-style button-color-green ml-5" type="button" name="button" @click="sub_alert=true">
                            Si
                        </button>
                    </div>
                </div>
                <div v-if="sub_alert" v-cloak>
                    <h4 class="p-2 pt-4 text-center">Vuoi aggiungere la collaborazione?
                    </h4>
                    <div class="d-flex justify-content-around align-items-center">
                        <button class="button-style button-color-green" type="button" name="button" @click="submitForm()">
                            Aggiungi collaborazione
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="need">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Servizi richiesti</h2>
                </div>
                <h5>Cerca ciò di cui hai bisogno in Growpla ed entra in contatto con i professionisti che fanno al caso tuo.</h5>
                {{-- <h6>Seleziona servizi che intendi richiedere in piattaforma</h6>
                <div class="">
                    <button v-for="(r_service,i) in r_services_show"
                    class="d-inline-block border-style" type="button" name="button"
                    @click="addService(r_service)" :id="r_service.id+'-button'">
                        @{{r_service.name}}
                    </button>
                </div> --}}
                <form method="POST" action="{{ route('admin.have-user-services.update',$user->id) }}" id="serviceForm">
                    @csrf
                    @method('PUT')
                    <input v-if="go_to_collaborations" type="hidden" name="go_to_collaborations" value="1" v-cloak>
                    <div v-show="main_services.length>0" class="pt-3" v-cloak>
                        <h6 class="pb-2">Quali sono i servizi di cui necessiti? Seleziona una o più delle seguenti alternative:</h6>
                        <div class="from-group row pr-3 pl-3 pb-3">
                            <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-1">
                                <select class="form-control custom-select-blue" name="" @change="changeMainService()" v-model="main_service_selected">
                                    <option value="">Specifica settore</option>
                                    <option v-for="main_service in main_services" :value="main_service.id">@{{main_service.name}}</option>
                                </select>
                            </div>
                            <div v-if="main_service_selected" class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-1">
                                <select class="form-control custom-select-blue" name=""
                                v-model="sub_service_selected" @change="addServiceSelected(sub_service_selected)">
                                    <option value="">Specifica sottocategoria</option>
                                    <option v-for="sub_service in sub_services_show" :value="sub_service.id">@{{sub_service.name}}</option>
                                </select>
                            </div>
                            {{-- <div v-if="sub_service_selected" class="col-sm-12 col-md-12 col-lg-2 col-xl-2 p-1">
                                <button type="button" name="button" @click="addServiceSelected(sub_service_selected)" class="w-100 button-style button-color-blue">Aggiungi</button>
                            </div> --}}
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="main-multi-slider">
                          <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                              <div v-for="(service,i) in services" class="d-inline-block border-style multi-slider-item col-8 col-sm-8 col-md-5 col-lg-3 col-xl-3" v-cloak>
                                <input type="hidden" name="services[]" :value="service.name">
                                  <div class="d-flex justify-content-center align-items-center h-100">
                                      <div class="card-style-mini card-color-blue position-relative">
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
                            {{$user->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

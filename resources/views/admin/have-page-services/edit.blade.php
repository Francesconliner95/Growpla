@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    pagetype_id = "{{$page->pagetype_id}}";
    services = @json($services);
    r_services = @json($recommended_services);
    lifecycles = @json($lifecycles);
    lifecycle_id = "{{$page->lifecycle_id}}";
    cofounder_services = @json($cofounder_services);
</script>
<div id="service-edit">
    <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
        <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="item-style-visible">
                <button type="button" name="button" class="edit-top-right button-color-gray" @click="alert=false; sub_alert=false">
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
                <form method="POST" action="{{ route('admin.have-page-services.update',$page->id) }}" id="serviceForm">
                    @csrf
                    @method('PUT')
                    <input v-if="go_to_collaborations" type="hidden" name="go_to_collaborations" value="1" v-cloak>
                    @if ($page->pagetype_id==1)
                        <div class="needs pb-2">
                            <h6>Cosa stai cercando?
                                <div class="d-inline-block p-2 mini-txt">
                                    <i class="fas fa-star"></i>
                                    <span>Consigliato per la tua fase</span>
                                </div>
                            </h6>
                            <div class="">
                              @foreach ($usertypes as $usertype)
                                  @if($usertype->id==1 || $usertype->id==2)
                                      <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                        <div class="pb-2">
                                          @if($usertype->description_it)
                                            <button type="button" class="tooltip-custom w-100 h-100" data-toggle="tooltip" data-placement="top" title="{{$usertype->description_it}}">
                                          @endif
                                          <div :class="isChecked('u-{{$usertype->id}}')?
                                          'active multichoise-b button-style multichoise-blue w-100 tool-tip-b':
                                          'multichoise-b button-style multichoise-blue w-100 tool-tip-b'" @click="checkboxToggle('u-{{$usertype->id}}')" id="u-{{$usertype->id}}-b" v-cloak>
                                          @if($errors->any())
                                            <input id="u-{{$usertype->id}}" class="d-none" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                                            {{ in_array($usertype->id, old('usertypes', [])) ? 'checked=checked' : ''}}>
                                          @else
                                            <input id="u-{{$usertype->id}}" class="d-none" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                                            {{$page->have_page_usertypes->contains($usertype)?'checked=checked':''}}>
                                          @endif
                                            <span class="m-0 text-capitalize" for="u-{{$usertype->name}}">{{$usertype->name_it}}</span>
                                            <span v-if="userRecommended.includes({{$usertype->id}})">
                                                <i class="fas fa-star"></i>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                      @if($usertype->id==1)
                                      <div v-if="usertype_selected==1" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="bg-green rounded p-3 mt-1 mb-3">
                                          <div v-if="cofounder_services.length>0" class="form-group" v-cloak>
                                              <div v-for="(service,i) in cofounder_services" class="d-inline-block border-style bg-white" v-cloak>
                                                <input type="hidden" name="cofounder_services_id[]" :value="service.id">
                                                <span for="">@{{service.name}}
                                                      <i class="fas fa-times scale" @click="removeCofounderService(i)"></i>
                                                </span>
                                              </div>
                                          </div>
                                          <h6 class="txt-green">Specifica le competenze che gli aspiranti co-founder devono possedere</h6>
                                          <div class="from-group row pr-3 pl-3">
                                              <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 p-1">
                                                  <select class="form-control custom-select-blue" name="" @change="changeMainCofounderService()" v-model="main_cofounder_service_selected">
                                                      <option value="">Specifica settore</option>
                                                      <option v-for="main_cofounder_service in main_cofounder_services" :value="main_cofounder_service.id">@{{main_cofounder_service.name}}</option>
                                                  </select>
                                              </div>
                                              <div v-if="main_cofounder_service_selected" class="col-sm-12 col-md-12 col-lg-5 col-xl-5 p-1">
                                                  <select class="form-control custom-select-blue" name=""
                                                  v-model="sub_cofounder_service_selected" @change="addCofounderServiceSelected(sub_cofounder_service_selected)">
                                                      <option value="">Specifica sottocategoria</option>
                                                      <option v-for="sub_cofounder_service in sub_cofounder_services_show" :value="sub_cofounder_service.id">@{{sub_cofounder_service.name}}</option>
                                                  </select>
                                              </div>
                                          </div>
                                        </div>
                                      </div>
                                      @endif
                                  @endif
                              @endforeach
                              @foreach ($pagetypes as $pagetype)
                                  @if($pagetype->id==3 || $pagetype->id==5 || $pagetype->id==6 || $pagetype->id==8)
                                  <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                      <div class="pb-2">
                                      @if($pagetype->description_it)
                                        <button type="button" class="tooltip-custom w-100 h-100" data-toggle="tooltip" data-placement="top" title="{{$pagetype->description_it}}">
                                      @endif
                                      <div type="button" name="button" :class="isChecked('p-{{$pagetype->id}}')?
                                      'active multichoise-b button-style multichoise-blue w-100 tool-tip-b text-center':
                                      'multichoise-b button-style multichoise-blue w-100 tool-tip-b text-center'" @click="checkboxToggle('p-{{$pagetype->id}}')" id="p-{{$pagetype->id}}-b" v-cloak>
                                      @if($errors->any())
                                          <input id="u-{{$pagetype->id}}" class="d-none" type="checkbox" name="pagetypes[]"   value="{{$pagetype->id}}"
                                          {{ in_array($pagetype->id, old('pagetypes', [])) ? 'checked=checked' : ''}}>
                                      @else
                                          <input id="p-{{$pagetype->id}}" class="d-none" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"
                                          @click="pagetypeCheck({{$pagetype->id}})"
                                          {{$page->have_page_pagetypes->contains($pagetype)?'checked=checked':''}}>
                                      @endif
                                          <span class="m-0 text-capitalize" for="u-{{$pagetype->name}}">{{$pagetype->name_it}}</span>
                                          <span v-if="pageRecommended.includes({{$pagetype->id}})">
                                              <i class="fas fa-star"></i>
                                          </span>
                                      </div>
                                  </div>
                                  </div>
                                  @endif
                              @endforeach
                              <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                              </div>
                            </div>
                        </div>
                    @endif
                    <div class="header pt-3">
                        <h2>Servizi richiesti</h2>
                    </div>
                    <h5 class="pb-2">Cerca ciò di cui hai bisogno in Growpla ed entra in contatto con i professionisti che fanno al caso tuo.</h5>
                    <div v-if="pagetype_id==1 && r_services.length>0" class="raccomanded-service col-sm-12 col-md-12 col-lg-12 col-xl-12" v-cloak>
                        <h6 v-if="pagetype_id==1" class="text-uppercase" v-cloak>Servizi consigliati per la tua fase del ciclo di vita</h6>
                        <h6 v-else>Seleziona servizi che intendi richiedere in piattaforma</h6>
                        <div class="pt-3 pb-3">
                            <button v-for="(r_service,i) in r_services_show"
                            class="d-inline-block border-style bg-white" type="button" name="button"
                            @click="addService(r_service)" :id="r_service.id+'-button'">
                                @{{r_service.name}}
                            </button>
                        </div>
                        <div class="img-1 img-cont small-img">
                            <img src="{{asset('storage/images/icon-search.svg')}}" alt="">
                        </div>
                        <div class="img-2 img-cont max-img mobile-hide">
                            <embed src="{{asset('storage/images/bg-bacchetta.svg')}}" alt="">
                        </div>
                    </div>
                    <div v-show="main_services.length>0" class="pt-3" v-cloak>
                        <h6>Quali sono i servizi di cui necessiti? Seleziona una o più delle seguenti alternative:</h6>
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
                        </div>
                    </div>
                    <div class="form-group">
                        {{-- <h6>Servizi di cui necessito</h6> --}}
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

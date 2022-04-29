@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    pagetype_id = "{{$page->pagetype_id}}";
    services = "{{$services}}";
    r_services = "{{$recommended_services}}";
    lifecycles = {!! json_encode($lifecycles->toArray()) !!};
    lifecycle_id = "{{$page->lifecycle_id}}";
    cofounder_services = "{{$cofounder_services}}";
</script>
<div id="service-edit" style="background-image: url({{asset("storage/images/bg-servizi.svg") }}); background-position: right -400px bottom -230px; background-repeat: no-repeat; background-size: 700px 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" action="{{ route('admin.have-page-services.update',$page->id) }}" id="serviceForm">
                    @csrf
                    @method('PUT')
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
                                            <button aria-label="{{$usertype->description_it}}" data-microtip-position="top" data-microtip-size="extra-large" role="tooltip" class="w-100" type="button">
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
                                                  {{-- <i class="fas fa-times" @click="removeCofounderService(i)"></i> --}}
                                                  <div class="img-cont icon-img scale" @click="removeCofounderService(i)">
                                                      <img src="{{asset('storage/images/icon-x.svg')}}" alt="">
                                                  </div>
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
                                      <button aria-label="{{$pagetype->description_it}}" data-microtip-position="top" data-microtip-size="extra-large" role="tooltip" class="w-100"  type="button">
                                      @endif
                                      <div type="button" name="button" :class="isChecked('p-{{$pagetype->id}}')?
                                      'active multichoise-b button-style multichoise-blue w-100 tool-tip-b':
                                      'multichoise-b button-style multichoise-blue w-100 tool-tip-b'" @click="checkboxToggle('p-{{$pagetype->id}}')" id="p-{{$pagetype->id}}-b" v-cloak>
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
                    <div class="header pb-3 pt-3">
                        <h2>Servizi richiesti</h2>
                    </div>
                    <div v-if="pagetype_id==1 && r_services.length>0" class="raccomanded-service col-sm-12 col-md-6 col-lg-6 col-xl-6" v-cloak>
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
                        {{-- <div class="img-2 img-cont max-img">
                            <embed src="{{asset('storage/images/bg-bacchetta.svg')}}" alt="">
                        </div> --}}
                    </div>
                    <div v-if="services.length>0" class="form-group pt-3" v-cloak>
                        <h6>Servizi di cui necessito</h6>
                        <div class="main-multi-slider">
                            <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                <div v-for="(service,i) in services" class="d-inline-block border-style multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3" v-cloak>
                                  <input type="hidden" name="services[]" :value="service.name">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <div class="card-style-mini card-color-blue position-relative">
                                            <div class="text-capitalize text-cont">
                                                @{{service.name}}
                                            </div>
                                            <div class="img-cont micro-img edit-top-right scale" @click="removeService(i)">
                                                <img src="{{asset('storage/images/icon-x.svg')}}" alt="" class="p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white" id="button-left-1" v-cloak>
                                <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                            </button>
                            <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right bg-white" id="button-right-1" v-cloak>
                                <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                            </button>
                            <span>@{{this.delay(1)}}</span>
                        </div>
                    </div>
                    <div v-show="main_services.length>0" class="pt-3" v-cloak>
                        <h6>Aggiungi un servizio</h6>
                        <div class="from-group row pr-3 pl-3">
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
                    <button type="submit" class="button-style button-color  mt-5" @click="submitForm()">Salva</button>
                </form>
                <div class="text-right">
                    <a href="{{ route('admin.supports.switch') }}" class="font-weight-bold mini-txt txt-green">
                        Suggerisci altri servizi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

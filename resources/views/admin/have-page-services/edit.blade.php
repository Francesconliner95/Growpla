@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    page = "{{$page}}";
    services = "{{$services}}";
    r_services = "{{$recommended_services}}";
    lifecycles = {!! json_encode($lifecycles->toArray()) !!};
    lifecycle_id = "{{$page->lifecycle_id}}";
    skills = "{{$skills}}";
</script>
<div class="container">
    <div id="service-edit">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" action="{{ route('admin.have-page-services.update',$page->id) }}">
                    @csrf
                    @method('PUT')
                    @if ($page->pagetype_id==1)
                        <h6>Seleziona fase del ciclo di vita in cui ti trovi
                        </h6>
                        <div class="row d-flex justify-content-center">
                            @foreach ($lifecycles as $lifecycle)
                                <div class="col-sm-12 col-md-6 col-lg-3 col-xl-2">
                                    <button type="button" name="button" :class="isChecked('l-{{$lifecycle->id}}')?
                                    'active multichoise-b button-style multichoise-green w-100 lifecycle-item tool-tip-b':
                                    'multichoise-b button-style multichoise-green w-100 lifecycle-item tool-tip-b'" @click="radioToggle({{$lifecycle->id}})" id="l-{{$lifecycle->id}}-b" v-cloak>
                                        <input id="l-{{$lifecycle->id}}" type="radio" name="lifecycle" class="d-none" value="{{$lifecycle->id}}">
                                        <span>{{$lifecycle->name}}
                                        </span>
                                        @if($lifecycle->description_it)
                                        <div class="tool-tip">
                                            {{$lifecycle->description_it}}
                                        </div>
                                        @endif
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <div class="needs">
                            <h6>Cosa stai cercando?</h6>
                            <div class="row d-flex justify-content-center">
                                @foreach ($usertypes as $usertype)
                                    @if($usertype->id==1 || $usertype->id==2)
                                        <div class="col-sm-12 col-md-6 col-lg-3 col-xl-2">
                                          <button type="button" name="button" :class="isChecked('u-{{$usertype->id}}')?
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
                                            @if($usertype->description_it)
                                            <div class="tool-tip">
                                                {{$usertype->description_it}}
                                            </div>
                                            @endif
                                          </button>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach ($pagetypes as $pagetype)
                                    @if($pagetype->id==3 || $pagetype->id==5 || $pagetype->id==6 || $pagetype->id==8)
                                    <div class="col-sm-12 col-md-6 col-lg-3 col-xl-2">
                                        <button type="button" name="button" :class="isChecked('p-{{$pagetype->id}}')?
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
                                            @if($pagetype->description_it)
                                                <div class="tool-tip">
                                                    {{$pagetype->description_it}}
                                                </div>
                                            @endif
                                        </button>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div v-if="usertype_selected==1" class="pt-2">
                            <h6>Specifica le competenze che gli aspiranti co-founder devono possedere</h6>
                            <div v-for="(skill,i) in skills" class="" v-cloak>
                              <input type="hidden" name="skills[]" :value="skill.name">
                              <label for="">@{{skill.name}}
                                <i class="fas fa-trash-alt" @click="removeSkill(i)"></i>
                              </label>
                            </div>
                            <div class="search">
                                <input type="text" name="name" value="" placeholder="Nome competenza" v-model="skill_name" @keyup.enter="searchSkill()" v-on:input="searchSkill()" maxlength="70" class="form-control" autocomplete="off">
                                @error ('skill_name')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                                <button type="button" name="button" @click="addManualSkill()" class="button-style button-color">Aggiungi</button>
                                <div :class="skills_found.length>0?'found':'found d-none'" v-cloak>
                                  <a class="item" v-for="skill_found in skills_found" @click="addSkill(skill_found)">
                                      @{{skill_found.name}}
                                  </a>
                                </div>
                            </div>
                        </div>
                        <div class="startup-services">
                            <h6>Servizi per startup</h6>
                            <div class="row">
                                @foreach (App\Service::where('main_service_id',5)->get() as $service)
                                    <div class="col-sm-12 col-md-6 col-lg-3 col-xl-2">
                                        <button type="button" name="button" :class="isChecked('s-{{$service->id}}')?
                                        'active multichoise-b button-style multichoise-blue w-100 tool-tip-b':
                                        'multichoise-b button-style multichoise-blue w-100 tool-tip-b'" @click="serviceToggle({{$service}})" id="s-{{$service->id}}-b" v-cloak>
                                        @if($errors->any())
                                            <input id="s-{{$service->id}}"
                                            type="checkbox" name="services[]"
                                            class="d-none" value="{{$service->id}}"
                                            {{ in_array($service->id, old('services', [])) ? 'checked=checked' : ''}}>
                                        @else
                                            <input id="s-{{$service->id}}" type="checkbox" name="services[]" class="d-none" value="{{$service->id}}"
                                            {{$page->have_page_services->contains($service)?'checked=checked':''}} >
                                        @endif
                                            <span for="service-{{$service->id}}" class="active">
                                                {{$service->name}}
                                                <span v-if="serviceRecommended.includes({{$service->id}})">
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </span>
                                            @if ($service->description)
                                            <div class="tool-tip">
                                                {{$service->description}}
                                            </div>
                                            @endif
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pt-2 pb-2">
                            <i class="fas fa-star"></i>
                            <span>Consigliato per la tua fase</span>
                        </div>
                    @endif
                @if($page->pagetype_id!=1)
                    <div class="header">
                        <h2>Servizi richiesti</h2>
                    </div>
                    <h6>Seleziona servizi che intendi richiedere in piattaforma</h6>
                    <div class="">
                        <button v-for="(r_service,i) in r_services_show"
                        class="d-inline-block border-style" type="button" name="button"
                        @click="addService(r_service)" :id="r_service.id+'-button'">
                            @{{r_service.name}}
                        </button>
                    </div>
                 @endif

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
                        <h6>Aggiungi un servizio specifico</h6>
                        <div class="from-group row pr-3 pl-3">
                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 p-1">
                                <select class="form-control" name="" @change="changeMainService()" v-model="main_service_selected">
                                    <option v-for="main_service in main_services" :value="main_service.id">@{{main_service.name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5 p-1">
                                <select class="form-control" name=""
                                v-model="sub_service_selected">
                                    <option v-for="sub_service in sub_services_show" :value="sub_service.id">@{{sub_service.name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 p-1">
                                <button type="button" name="button" @click="addServiceSelected(sub_service_selected)" class="w-100 button-style button-color-blue">Aggiungi</button>
                            </div>
                        </div>
                        <div v-if="services.length>0" class="form-group">
                            <h6>Servizi di cui necessito</h6>
                            <div v-for="(service,i) in services" class="d-inline-block border-style" v-cloak>
                              <input type="hidden" name="services[]" :value="service.name">
                              <span for="">@{{service.name}}
                                <i class="fas fa-trash-alt" @click="removeService(i)"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

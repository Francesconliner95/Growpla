@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    page = "{{$page}}";
</script>
<div class="container">
    <div id="page-edit">
        <div class="item-cont">
            <div class="item-style">
              <div class="row pb-5">
                  <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 left-area">
                    <div class="fixed">
                        <h4 class="text-capitalize font-weight-bold">{{$page->name}}</h4>
                        <p class="txt-green font-weight-bold m-0">La compilazione dei seguenti campi è facoltativa</p>
                        <p class="txt-green mini-txt">Tuttavia un profilo più completo ha più possibiltà di essere visionato dagli altri utenti</p>
                        <div class="pt-5">
                            <p class="mini-txt font-weight-bold">Appena terminato salva i progressi</p>
                            <button type="submit" class="button-style button-color" @click="submitForm()">
                                {{__('Save Changes')}}
                            </button>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 bg-gray right-area">
                      <form method="POST" id="pageForm" enctype="multipart/form-data" action="{{ route('admin.pages.update', ['page'=> $page->id]) }}" {{--@submit.prevent="submitForm()"--}}>
                        @csrf
                        @method('PUT')
                        {{-- NOME --}}
                        <div class="sub-section">
                            <h6>Nome {{$page->pagetype->name_it}}*</h6>
                            <input type="text" name="name" class="form-control" value="{{ old('name',$page->name) }}" minlength="3" maxlength="30" autocomplete="nope" required>
                            @error('name')
                                <span class="alert alert-danger">
                                    {{__($message)}}
                                </span>
                            @enderror
                        </div>
                        <div class="sub-section">
                            <h6>Sommario*</h6>
                            <textarea name="summary" rows="3" cols="80" class="form-control" placeholder="Descrivi brevente ciò che fai"  minlength="50" maxlength="250" required>{{ $page->summary }}</textarea>
                            @error ('summary')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        <div class="sub-section">
                            <h6>{{__('Presentation')}}</h6>
                            <textarea name="description" rows="8" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" maxlength="1000">{{ $page->description }}</textarea>
                            @error ('description')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        {{-- Startup --}}
                        @if (!$page->pagetype->hidden && $page->pagetype_id==1 && Auth::user()->pagetypes->contains($page->pagetype_id))
                        <div class="sub-section">
                            <h6>Pitch</h6>
                            <div class="edit-image-drag-drop row">
                                <div v-if="page.pitch" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <embed  src="{{ asset("storage/" . $page->pitch) }}" />
                                    <a class="txt-blue font-weight-bold" @click="page.pitch='';remove_pitch=true" href="#">Elimina</a>
                                </div>
                                <input type="hidden" name="remove_pitch" :value="remove_pitch">
                                <div class="drop-zone col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                        <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                    </span>
                                    <input ref="pitch" type="file" class="form-control-file drop-zone__input" name="pitch" accept="application/pdf">
                                    @error ('pitch')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="sub-section">
                            <div class="row">
                              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                  <h6>Costituita</h6>
                                  <div class="d-flex align-items-center">
                                      <label class="input-container m-0">Si
                                          <input type="radio" id="incorporated-yes" name="incorporated" value="1"
                                          {{$page->incorporated?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                      </label>
                                  </div>
                                  <div class="d-flex align-items-center">
                                      <label class="input-container m-0">No
                                        <input type="radio" id="incorporated-no" name="incorporated" value=""
                                        {{!$page->incorporated?'checked':''}} required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                  <h6>MVP</h6>
                                  <div class="d-flex align-items-center">
                                      <label class="input-container m-0">Si
                                        <input type="radio" id="mvp-yes" name="type_bool_1" value="1"
                                        {{$page->type_bool_1?'checked':''}} required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                  </div>
                                  <div class="d-flex align-items-center">
                                      <label class="input-container m-0">No
                                        <input type="radio" id="mvp-no" name="type_bool_1" value=""
                                        {{!$page->type_bool_1?'checked':''}} required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                  </div>
                                  {{-- <div>
                                    <input type="radio" id="mvp-yes" name="type_bool_1" value="1"
                                    {{$page->type_bool_1?'checked':''}} required>
                                    <label for="mvp-yes">Si</label>
                                  </div>
                                  <div>
                                    <input type="radio" id="mvp-no" name="type_bool_1" value=""
                                    {{!$page->type_bool_1?'checked':''}} required>
                                    <label for="mvp-no">No</label>
                                  </div> --}}
                              </div>
                            </div>
                        </div>
                        @endif
                        @if (!$page->pagetype->hidden && $page->pagetype_id==3)
                            <div class="sub-section">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <h6>Tipologia</h6>
                                        <label class="input-container m-0">Privato
                                          <input type="radio" id="i-private" name="type_bool_1" value=""
                                          {{!$page->type_bool_1?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                        </label>
                                        <label class="input-container m-0">Pubblico
                                          <input type="radio" id="i-public" name="type_bool_1" value="1"
                                          {{$page->type_bool_1?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <h6>Servizi erogati</h6>
                                        <label class="input-container m-0">Fisici
                                          <input type="radio" id="i-fisici" name="type_int_1" value=""
                                          {{!$page->type_int_1?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                        </label>
                                        <label class="input-container m-0">Online
                                          <input type="radio" id="i-online" name="type_int_1" value="1"
                                          {{$page->type_int_1==1?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                        </label>
                                        <label class="input-container m-0">Ibridi
                                          <input type="radio" id="i-ibrid" name="type_int_1" value="2"
                                          {{$page->type_int_1==2?'checked':''}} required>
                                          <span class="checkmark mt-1"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- SitoWeb --}}
                        <div class="sub-section">
                            <h6>{{__('Website')}}
                                <div class="info">
                                <button aria-label="Inserisci l'url del tuo sito web" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                                <i class="fas fa-info-circle"></i>
                              </div>
                          </h6>
                            <input type="text" name="website" class="form-control" maxlength="255" value="{{ old('website',$page->website)}}" placeholder="es. https://www.growpla.it">
                            @error ('website')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        {{-- Linkedin --}}
                        <div class="sub-section">
                            <h6>LinkedIn
                                <div class="info">
                                    <button aria-label="Inserisci l'url del tuo profilo linkedin" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </h6>
                            <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$page->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
                            @error ('linkedin')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        <div class="last-sub-section">
                            <h6>Indirizzo</h6>
                            <div class="row">
                                {{-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <label>Nazione</label>
                                    <select class="form-control" name="country_id" required @change="getRegionsByCountry()" v-model="country_id_selected">
                                        @foreach ($countries as $country)
                                            <option value="{{$country->id}}"
                                              @if($page->country_id)
                                              {{$country->id == $page->country_id ? 'selected=selected' : '' }}
                                              @endif
                                              >
                                              {{$country->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <input type="hidden" name="country_id" value="1">
                                <div v-if="regions.length>1" class="col-sm-12 col-md-6 col-lg-6 col-xl-6" v-cloak>
                                    <label>Regione</label>
                                    <select class="form-control" name="region_id" v-model="region_id_selected">
                                        <option value="">Non specificata</option>
                                        <option v-for="region in regions" :value="region.id">
                                              @{{region.name}}
                                        </option>
                                    </select>
                                </div>
                                <div v-else class="">
                                  <input type="hidden" name="region_id" value="">
                                </div>
                                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                  <label>Via</label>
                                  <input type="text" name="street_name" class="form-control"
                                  value="{{ old('street_name',$page->street_name)}}">
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                    <label>Numero</label>
                                    <input type="text" name="street_number" class="form-control" value="{{ old('street_number',$page->street_number)}}">
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <label>Città</label>
                                    <input type="text" name="municipality" class="form-control" value="{{ old('municipality',$page->municipality)}}" required>
                                </div>
                            </div>
                            {{-- <input type="hidden" name="latitude" v-model="latitude">
                            <input type="hidden" name="longitude" v-model="longitude">
                            <input type="hidden" name="address" v-model="address"> --}}
                        </div>
                    </form>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection

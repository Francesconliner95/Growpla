@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    page = @json($page);
</script>
<div id="page-edit" style="background-image: url({{asset("storage/images/bg-form.svg") }}); background-position: left 100px bottom -155px; background-repeat: no-repeat; background-size: 500px 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" id="pageForm" enctype="multipart/form-data" action="{{ route('admin.pages.update', ['page'=> $page->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="row pb-5">
                  <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 left-area order-1 order-sm-1 order-md-0">
                    <div class="h-100 d-flex align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pt-3 pb-3">
                            <h4 class="text-capitalize font-weight-bold">{{$page->name}}</h4>
                            <p class="txt-green font-weight-bold m-0">La compilazione dei seguenti campi è facoltativa</p>
                            <p class="txt-green mini-txt">Tuttavia un profilo più completo ha più possibiltà di essere visionato dagli altri utenti</p>
                            <div class="pt-5">
                                <p class="mini-txt font-weight-bold">Appena terminato salva i progressi</p>
                                <button type="submit" class="button-style button-color">
                                    {{__('Save Changes')}}
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 bg-gray right-area order-0 order-sm-0 order-md-1">
                        {{-- NOME --}}
                        <div class="sub-section">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                  <h6>Nome {{$page->pagetype->name_it}}*</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                  <input type="text" class="text-capitalize form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$page->name) }}" minlength="3" maxlength="35" autocomplete="do-not-autofill" required>
                                  @error('name')
                                      <span class="alert alert-danger">
                                          {{__($message)}}
                                      </span>
                                  @enderror
                                </div>
                              </div>
                        </div>
                        <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Sommario*</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <textarea name="summary" rows="3" cols="80" class="form-control" placeholder="Descrivi brevente ciò che fai"  minlength="50" maxlength="150">{{ $page->summary }}</textarea>
                              @error ('summary')
                                  <div class="alert alert-danger">
                                      {{__($message)}}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6>{{__('Presentation')}}</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <textarea name="description" rows="6" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" maxlength="1000">{{ $page->description }}</textarea>
                              @error ('description')
                                  <div class="alert alert-danger">
                                      {{__($message)}}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        {{-- Startup --}}
                        @if (!$page->pagetype->hidden && $page->pagetype_id==1)
                        <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Costituita</h6>
                                </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <div class="row">
                                  <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <div class="d-flex align-items-center mr-2">
                                        <label class="input-container m-0">Si
                                            <input type="radio" id="incorporated-yes" name="incorporated" value="1"
                                            {{$page->incorporated?'checked':''}} required>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                    <div class="d-flex align-items-center">
                                        <label class="input-container m-0">No
                                          <input type="radio" id="incorporated-no" name="incorporated" value=""
                                          {{!$page->incorporated?'checked':''}} required>
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>MVP</h6>
                                </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                <div class="row">
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                      <div class="d-flex align-items-center mr-2">
                                          <label class="input-container m-0">Si
                                            <input type="radio" id="mvp-yes" name="type_bool_1" value="1"
                                            {{$page->type_bool_1?'checked':''}} required>
                                            <span class="checkmark"></span>
                                          </label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                      <div class="d-flex align-items-center">
                                          <label class="input-container m-0">No
                                            <input type="radio" id="mvp-no" name="type_bool_1" value=""
                                            {{!$page->type_bool_1?'checked':''}} required>
                                            <span class="checkmark"></span>
                                          </label>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (!$page->pagetype->hidden && $page->pagetype_id==3)
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Tipologia</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <div class="row">
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center mr-2">
                                            <label class="input-container m-0">Privato
                                              <input type="radio" id="i-private" name="type_bool_1" value=""
                                              {{!$page->type_bool_1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center">
                                            <label class="input-container m-0">Pubblico
                                              <input type="radio" id="i-public" name="type_bool_1" value="1"
                                              {{$page->type_bool_1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Servizi erogati</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <div class="row">
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center mr-2">
                                            <label class="input-container m-0">Fisici
                                              <input type="radio" id="i-fisici" name="type_int_1" value=""
                                              {{!$page->type_int_1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center  mr-2">
                                            <label class="input-container m-0">Online
                                              <input type="radio" id="i-online" name="type_int_1" value="1"
                                              {{$page->type_int_1==1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center">
                                            <label class="input-container m-0">Fisici e online
                                              <input type="radio" id="i-ibrid" name="type_int_1" value="2"
                                              {{$page->type_int_1==2?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$page->pagetype->hidden && $page->pagetype_id==7)
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Servizi erogati</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <div class="row">
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center mr-2">
                                            <label class="input-container m-0">Altro
                                              <input type="radio" id="i-fisici" name="type_int_1" value=""
                                              {{!$page->type_int_1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center  mr-2">
                                            <label class="input-container m-0">Gratuitamente
                                              <input type="radio" id="i-online" name="type_int_1" value="1"
                                              {{$page->type_int_1==1?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                          <div class="d-flex align-items-center">
                                            <label class="input-container m-0">A pagamento
                                              <input type="radio" id="i-ibrid" name="type_int_1" value="2"
                                              {{$page->type_int_1==2?'checked':''}} required>
                                              <span class="checkmark"></span>
                                            </label>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- SitoWeb --}}
                        <div class="sub-section  row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <h6>{{__('Website')}}
                                <div class="info">
                                    <button type="button" class="tooltip-custom cursor-default" data-toggle="tooltip" data-placement="top" title="Inserisci l'url del tuo sito web">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <input type="url" name="website" class="form-control border-green" maxlength="255" value="{{ old('website',$page->website)}}" placeholder="es. https://www.growpla.it">
                            @error ('website')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                          </div>
                        </div>
                        {{-- Linkedin --}}
                        <div class="sub-section  row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <h6>LinkedIn
                                <div class="info">
                                    <button type="button" class="tooltip-custom cursor-default" data-toggle="tooltip" data-placement="top" title="Inserisci l'url del tuo profilo linkedin">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            </h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <input type="url" name="linkedin" class="form-control border-green" maxlength="255" value="{{ old('linkedin',$page->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
                            @error ('linkedin')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                          </div>
                        </div>
                          <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Indirizzo*</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <div class="row">
                                  {{-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                      <label>Nazione</label>
                                      <select class="form-control" name="country_id" required @change="getRegionsByCountry()" v-model="country_id_selected">
                                          @foreach ($countries as $country)
                                              <option value="{{$country->id}}"
                                              @if($user->country_id)
                                              {{$country->id == $user->country_id ? 'selected=selected' : '' }}
                                              @endif
                                              >
                                              {{$country->name}}
                                              </option>
                                          @endforeach
                                      </select>
                                  </div> --}}
                                  <input type="hidden" name="country_id" value="1">
                                  <div v-if="regions.length>1" class="col-sm-12 col-md-6 col-lg-6 col-xl-6  mt-1 mb-1" v-cloak>
                                      <label class="m-0">Regione</label>
                                      <select class="form-control" name="region_id" v-model="region_id_selected" required>
                                          <option value="">Non specificata</option>
                                          <option v-for="region in regions" :value="region.id">
                                                @{{region.name}}
                                          </option>
                                      </select>
                                  </div>
                                  <div v-else class="">
                                    <input type="hidden" name="region_id" value="">
                                  </div>
                                  <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-1 mb-1">
                                      <label class="m-0">Città</label>
                                      <input type="text" name="municipality" class="form-control text-capitalize" value="{{ old('municipality',$page->municipality)}}" required>
                                  </div>
                                  <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9  mt-1 mb-1">
                                    <label class="m-0">Via</label>
                                    <input type="text" name="street_name" class="form-control"
                                    value="{{ old('street_name',$page->street_name)}}">
                                  </div>
                                  <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mt-1 mb-1">
                                      <label class="m-0">Numero</label>
                                      <input type="text" name="street_number" class="form-control" value="{{ old('street_number',$page->street_number)}}">
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="sub-section row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>{{$page->pagetype_id==1?'Pitch':'Brochure'}}</h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <div class="edit-image-drag-drop row m-0">
                                <div v-if="page.pitch" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 pl-1 pr-1 mb-1" style="height:150px">
                                    <iframe :src="'/storage/'+page.pitch" class=""/></iframe>
                                </div>
                                <input type="hidden" name="remove_pitch" :value="remove_pitch">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pl-1 pr-1 mb-1" style="height:150px">
                                  <div class="drop-zone">
                                    <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                        <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                    </span>
                                    <input type="file" class="form-control-file drop-zone__input" name="pitch" accept="application/pdf">
                                    @error ('pitch')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                  </div>
                                </div>
                            </div>
                            <a v-if="page.pitch" class="txt-blue font-weight-bold" @click="page.pitch='';remove_pitch=true" href="#">Elimina</a>
                          </div>
                        </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</div>
@endsection

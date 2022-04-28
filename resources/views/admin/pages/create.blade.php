@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
</script>

<div id="page-create" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left 0px top 0px; background-repeat: no-repeat; background-attachment: fixed;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
              <form method="post" action="{{route('admin.pages.store')}}" enctype="multipart/form-data" id="formPageCreate">
                @csrf
                {{-- <div class="pb-3">
                  <input type="hidden" name="pagetype_id" value="{{$pagetype->id}}">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" minlength="3" maxlength="30" autocomplete="name" required>
                  @error('name')
                      <span class="alert alert-danger">
                          {{__($message)}}
                      </span>
                  @enderror
                </div> --}}
                <div class="step-container d-flex justify-content-between pb-5 pt-3">
                    <div v-for="(step_item,i) in max_step" class="w-100" v-cloak>
                        <div :class="step==i+1?'p-1 bg-green-3':'p-1 bg-gray'">
                        </div>
                        <h6 class="text-center pt-1">Step @{{i+1}}</h6>
                    </div>
                </div>
                <input type="hidden" name="pagetype_id" value="{{$pagetype->id}}">
                <div class="" style="height: 300px;">
                  {{-- NOME --}}
                  <div v-show="step==1" class="step" v-cloak>
                      <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <h6>Nome {{$pagetype->name_it}}*</h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <input type="text" class="text-capitalize form-control @error('name') is-invalid @enderror" name="name" value="" minlength="3" maxlength="25" autocomplete="do-not-autofill" v-model="name" required>
                            @error('name')
                                <span class="alert alert-danger">
                                    {{__($message)}}
                                </span>
                            @enderror
                          </div>
                          <p class="text-center mini-txt font-weight-bold txt-green w-100 pt-5">Inserisci nome</p>
                      </div>
                  </div>
                  <div v-show="step==2" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <h6>Sommario*</h6>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <textarea name="summary" rows="3" cols="80" class="form-control" placeholder="Descrivi brevente ciò che fai"  minlength="50" maxlength="150" v-model="summary"></textarea>
                        @error ('summary')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                      </div>
                      <p class="text-center mini-txt font-weight-bold txt-green w-100 pt-5">Lunghezza minima 50 caratteri</p>
                  </div>
                  <div v-show="step==3" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                          <h6>{{__('Presentation')}}</h6>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <textarea name="description" rows="6" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" maxlength="1000"></textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                      </div>
                  </div>
                  {{-- SitoWeb --}}
                  <div v-show="step==4" class="step  row" v-cloak>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                      <h6>{{__('Website')}}
                        <div class="info">
                          <button aria-label="Inserisci l'url del tuo sito web" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                          <i class="fas fa-info-circle"></i>
                        </div>
                      </h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                      <input type="text" name="website" class="form-control border-green" maxlength="255" value="" placeholder="es. https://www.growpla.it">
                      @error ('website')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                    </div>
                  </div>
                  {{-- Linkedin --}}
                  <div v-show="step==5" class="step  row" v-cloak>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                      <h6>LinkedIn
                          <div class="info">
                              <button aria-label="Inserisci l'url del tuo profilo linkedin" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                              <i class="fas fa-info-circle"></i>
                          </div>
                      </h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                      <input type="text" name="linkedin" class="form-control border-green" maxlength="255" value="" placeholder="es. https://www.linkedin.com/in/...">
                      @error ('linkedin')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                    </div>
                  </div>
                  <div v-show="step==6" class="step row" v-cloak>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                      <h6>Indirizzo*</h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <div class="row">
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
                            value="">
                          </div>
                          <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                              <label>Numero</label>
                              <input type="text" name="street_number" class="form-control" value="">
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                              <label>Città</label>
                              <input type="text" name="municipality" class="form-control" value="" required>
                          </div>
                      </div>
                    </div>
                  </div>
                  {{-- Startup --}}
                  @if ($pagetype->id==1)
                  <div v-show="step==7" class="step row" v-cloak>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <h6>Pitch</h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                      <div class="edit-image-drag-drop row m-0">
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
                    </div>
                  </div>
                  <div v-show="step==8" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Costituita</h6>
                          </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <div class="row">
                            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                              <div class="d-flex align-items-center mr-2">
                                  <label class="input-container m-0">Si
                                      <input type="radio" id="incorporated-yes" name="incorporated" value="1" checked required>
                                      <span class="checkmark"></span>
                                  </label>
                              </div>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                              <div class="d-flex align-items-center">
                                  <label class="input-container m-0">No
                                    <input type="radio" id="incorporated-no" name="incorporated" value="" required>
                                    <span class="checkmark"></span>
                                  </label>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <div v-show="step==9" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>MVP</h6>
                          </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                          <div class="row">
                              <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <div class="d-flex align-items-center mr-2">
                                    <label class="input-container m-0">Si
                                      <input type="radio" id="mvp-yes" name="type_bool_1" value="1" checked required>
                                      <span class="checkmark mt-1"></span>
                                    </label>
                                </div>
                              </div>
                              <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                <div class="d-flex align-items-center">
                                    <label class="input-container m-0">No
                                      <input type="radio" id="mvp-no" name="type_bool_1" value="" required>
                                      <span class="checkmark mt-1"></span>
                                    </label>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  @endif
                  @if ($pagetype->id==3)
                      <div v-show="step==7" class="step row" v-cloak>
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Tipologia</h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <div class="row">
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center mr-2">
                                      <label class="input-container m-0">Privato
                                        <input type="radio" id="i-private" name="type_bool_1" value="" checked required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center">
                                      <label class="input-container m-0">Pubblico
                                        <input type="radio" id="i-public" name="type_bool_1" value="1" required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div v-show="step==8" class="step row" v-cloak>
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Servizi erogati</h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <div class="row">
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center mr-2">
                                      <label class="input-container m-0">Fisici
                                        <input type="radio" id="i-fisici" name="type_int_1" value="" checked required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center  mr-2">
                                      <label class="input-container m-0">Online
                                        <input type="radio" id="i-online" name="type_int_1" value="1" required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center">
                                      <label class="input-container m-0">Ibridi
                                        <input type="radio" id="i-ibrid" name="type_int_1" value="2" required>
                                        <span class="checkmark mt-1"></span>
                                      </label>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endif
                </div>
                <div class="d-flex justify-content-between pt-5">
                    <button type="button" name="button" :class="prev_arrow()" @click="prev()">Indietro</button>
                    <button type="button" name="button" :class="next_arrow()" @click="next()">
                      @{{step==max_step?'Salva':'Avanti'}}
                    </button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

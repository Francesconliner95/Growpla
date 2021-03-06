@extends('layouts.app')

@section('content')
<script type="text/javascript">
    var language_id = "{{$user->language_id}}";
    var summary = "{{ old('summary',$user->summary) }}";
    var presentation = "{{ old('description',$user->description) }}";
    var city = "{{ old('municipality',$user->municipality) }}";
    var region_id_selected = "{{ old('region_id',$user->region_id) }}";
    var step = "1";
</script>
<div id="user-create" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left 0px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size:cover;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
              <form method="post" action="{{route('admin.users.store')}}" enctype="multipart/form-data" id="formUserCreate">
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
                <h6>Completa gli step di registrazione inserendo informazioni relative a te ed in linea con la categoria in cui ti sei identificato/a</h6>
                <div class="step-container d-flex justify-content-between pb-5 pt-3">
                    <div v-for="(step_item,i) in max_step" class="w-100" v-cloak>
                        <div :class="step==i+1?'p-1 bg-green-3':'p-1 bg-gray'">
                        </div>
                        <h6 class="text-center pt-1">Step @{{i+1}}</h6>
                    </div>
                </div>
                <div class="" style="height: 300px;">
                  <div v-show="step==1" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <h6>Sommario*</h6>
                        <p class="mini-txt font-weight-bold  txt-green">Campo obbligatorio</p>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <textarea name="summary" rows="3" cols="80" class="form-control custom-input" placeholder="Descrivi in almeno 50 caratteri chi sei e/o cosa fai (background, professione, ecc)"  minlength="50" maxlength="150" v-model="summary">{{old('summary',$user->summary)}}</textarea>
                        @error ('summary')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                            <script type="application/javascript">
                                step = "1";
                            </script>
                        @enderror
                        <div class="pt-1 d-flex justify-content-between" v-cloak>
                            <span class="mini-txt">@{{summary.length+'/150'}}</span>
                            <span class="mini-txt">Lunghezza minima 50 caratteri</span>
                        </div>
                        <div class="pt-3 text-center font-weight-bold txt-green">
                            <p class="text-dark mini-txt">ESEMPI</p>
                            <p class="mini-txt">"Background economico, appassionato di tecnologia ed innovazione. Startupper."</p>
                            <p class="mini-txt">"Graphic Designer di lavoro e passione. Freelancer per startup, agenzie di comunicazione, aziende e privati. Amo il design minimal ma originale!"</p>
                        </div>
                      </div>
                  </div>
                  <div v-show="step==2" class="step row" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                          <h6>{{__('Presentation')}}</h6>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <textarea name="description" rows="6" cols="80" class="form-control custom-input" placeholder="{{__('Write something about what you do')}}" maxlength="1000" v-model="presentation" value="">{{ old('description',$user->description) }}</textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                            <script type="application/javascript">
                                step = "2";
                            </script>
                        @enderror
                        <p class="pt-1 mini-txt" v-cloak>
                            @{{presentation.length+'/1000'}}
                        </p>
                      </div>
                  </div>
                  {{-- SitoWeb --}}
                  <div v-show="step==3" class="step" v-cloak>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <h6>LinkedIn
                                <div class="info">
                                    <button aria-label="Inserisci l'url del tuo profilo linkedin" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </h6>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <input type="url" name="linkedin" class="form-control border-green custom-input" maxlength="255" value="{{ old('linkedin',$user->linkedin) }}" placeholder="es. https://www.linkedin.com/in/...">
                            @error ('linkedin')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                                <script type="application/javascript">
                                    step = "3";
                                </script>
                            @enderror
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                          <h6>{{__('Website')}}
                            <div class="info">
                              <button aria-label="Inserisci l'url del tuo sito web" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                              <i class="fas fa-info-circle"></i>
                            </div>
                          </h6>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                          <input type="url" name="website" class="form-control border-green custom-input" maxlength="255" value="{{ old('website',$user->website) }}" placeholder="es. https://www.growpla.it">
                          @error ('website')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                                <script type="application/javascript">
                                    step = "3";
                                </script>
                          @enderror
                        </div>
                    </div>
                    <div class="row pt-3" v-cloak>
                      <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                          <h6>Curriculum vitae</h6>
                      </div>
                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <div class="edit-image-drag-drop row m-0">
                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 pl-1 pr-1 mb-1" style="height:150px">
                              <div class="drop-zone">
                                <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                    <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                </span>
                                <input type="file" class="form-control-file drop-zone__input" name="cv" accept="application/pdf">
                                @error ('cv')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                    <script type="application/javascript">
                                        step = "3";
                                    </script>
                                @enderror
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-show="step==4" class="step row" v-cloak>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                      <h6>Indirizzo*</h6>
                      <p class="mini-txt font-weight-bold txt-green">Campo obbligatorio</p>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                        <div class="row">
                          <input type="hidden" name="country_id" value="1">
                          <div v-if="regions.length>1" class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2 mb-2" v-cloak>
                              <label>Regione</label>
                              <select class="form-control custom-input" name="region_id" v-model="region_id_selected" value="{{ old('region_id',$user->region_id) }}">
                                  <option value="">Non specificata</option>
                                  <option v-for="region in regions" :value="region.id">
                                        @{{region.name}}
                                  </option>
                              </select>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-2 mb-2">
                              <label>Citt??</label>
                              <input type="text" name="municipality" class="form-control custom-input text-capitalize" value="{{ old('municipality',$user->municipality) }}" accept="" v-model="city" required>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-5">
                    <button type="button" name="button" :class="prev_arrow()" @click="prev()" v-cloak>Indietro</button>
                    <button type="button" name="button" :class="next_arrow()" @click="next()" v-cloak>
                      @{{step==max_step?'Salva':'Avanti'}}
                    </button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

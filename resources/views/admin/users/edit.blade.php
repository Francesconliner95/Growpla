@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    user = "{{$user}}";
    userTypes = "{{$userTypes}}";
</script>

<div id="user-edit" style="background-image: url({{asset("storage/images/bg-form.svg") }}); background-position: left 100px bottom -155px; background-repeat: no-repeat; background-size: 500px 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', ['user'=> $user->id]) }}" id="userForm">
                    @csrf
                    @method('PUT')
                    <div class="row pb-5">
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 left-area order-1 order-sm-1 order-md-0">
                            <div class="h-100 d-flex align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pt-3 pb-3">
                            <h4 class="text-capitalize font-weight-bold">{{$user->name}} {{$user->surname}}</h4>
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
                                        <h6>{{__('Name')}}*</h6>
                                      </div>
                                      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                        <input type="text" class="text-capitalize form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" minlength="3" maxlength="15" required>
                                        @error('name')
                                            <span class="alert alert-danger">
                                                {{__($message)}}
                                            </span>
                                        @enderror
                                      </div>
                                    </div>
                        </div>
                        <div class="sub-section">
                          <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>{{__('Surname')}}*</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <input type="text" class="text-capitalize form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname',$user->surname) }}" minlength="3" maxlength="20" required>
                              @error('surname')
                                  <span class="alert alert-danger">
                                      {{__($message)}}
                                  </span>
                              @enderror
                            </div>
                          </div>
                        </div>
                        <div class="sub-section row">
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Sommario</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                              <textarea name="summary" rows="3" cols="80" class="form-control" placeholder="Descrivi brevente ciò che fai"  minlength="50" maxlength="150">{{ $user->summary }}</textarea>
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
                              <textarea name="description" rows="6" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" maxlength="1000">{{ $user->description }}</textarea>
                              @error ('description')
                                  <div class="alert alert-danger">
                                      {{__($message)}}
                                  </div>
                              @enderror
                            </div>

                        </div>
                        <div class="sub-section  row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                              <h6>Curriculum Vitae</h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <div class="edit-image-drag-drop row m-0">
                                <div v-if="user.cv" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 pl-1 pr-1 mb-1" style="height:150px">
                                    <iframe :src="'/storage/'+user.cv" class=""/></iframe>
                                </div>
                                <input type="hidden" name="remove_cv" :value="remove_cv">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 pl-1 pr-1 mb-1" style="height:150px">
                                  <div class="drop-zone">
                                    <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                        <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                    </span>
                                    <input type="file" class="form-control-file drop-zone__input" name="cv" accept="application/pdf">
                                    @error ('cv')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                  </div>
                                </div>
                            </div>
                            <a v-if="user.cv" class="txt-blue font-weight-bold" @click="user.cv='';remove_cv=true" href="#">Elimina</a>
                          </div>
                        </div>
                        {{-- SitoWeb --}}
                        <div class="sub-section  row">
                          <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <h6>{{__('Website')}}
                              <div class="info">
                                <button aria-label="Inserisci l'url del tuo sito web" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                                <i class="fas fa-info-circle"></i>
                              </div>
                            </h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <input type="url" name="website" class="form-control border-green" maxlength="255" value="{{ old('website',$user->website)}}" placeholder="es. https://www.growpla.it">
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
                                    <button aria-label="Inserisci l'url del tuo profilo linkedin" data-microtip-position="top" data-microtip-size="medium" role="tooltip" type="button">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </h6>
                          </div>
                          <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                            <input type="url" name="linkedin" class="form-control border-green" maxlength="255" value="{{ old('linkedin',$user->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
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
                                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                      <label>Città</label>
                                      <input type="text" name="municipality" class="form-control" value="{{ old('municipality',$user->municipality)}}" required>
                                  </div>
                              </div>
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

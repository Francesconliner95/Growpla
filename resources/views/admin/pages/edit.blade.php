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
              <div class="header">
                  {{-- Nome --}}
                  <div class="">
                      <h1 class="text-capitalize">{{$page->name}}</h1>
                  </div>
                  <h1>
                      <i class="fas fa-pencil-alt"></i>
                  </h1>
              </div>

              <form method="POST" id="editPageForm" enctype="multipart/form-data" action="{{ route('admin.pages.update', ['page'=> $page->id]) }}" {{--@submit.prevent="submitForm()"--}}>
                  @csrf
                  @method('PUT')
                  <span class="mini-txt">{{__('Filling in some of the following fields is optional, however a more complete profile has more chance of being viewed by other pages')}}</span>
                  {{-- NOME --}}
                  <div class="sub-section">
                      <h6>Nome {{$page->pagetype->name_it}}*</h6>
                      <input type="text" name="name" class="form-control" value="{{ old('name',$page->name) }}" minlength="3" maxlength="70" autocomplete="nope" required>
                      @error('name')
                          <span class="alert alert-danger">
                              {{__($message)}}
                          </span>
                      @enderror
                  </div>
                  <div class="sub-section">
                      <h6>Sommario*</h6>
                      <textarea name="summary" rows="2" cols="80" class="form-control" placeholder="Descrivi brevente cio che fai"  minlength="50" maxlength="250" required>{{ $page->summary }}</textarea>
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
                  {{-- SitoWeb --}}
                  <div class="sub-section">
                      <h6>{{__('Website')}} <span>({{__('enter the URL of your web site')}})</span></h6>
                      <input type="text" name="website" class="form-control" maxlength="255" value="{{ old('website',$page->website)}}" placeholder="es. https://www.growpla.it">
                      @error ('website')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  {{-- Linkedin --}}
                  <div class="sub-section">
                      <h6>LinkedIn <span>({{__('enter your LinkedIn profile URL')}})</span></h6>
                      <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$page->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
                      @error ('linkedin')
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
                              <button type="button" @click="page.pitch='';remove_pitch=true" class="button-style button-color-red edit-top-right">
                                  <i class="fas fa-times"></i>
                              </button>
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
                      <div class="form-contrtol">
                          <h6>Costituita</h6>
                          <div>
                            <input type="radio" id="incorporated-yes" name="incorporated" value="1"
                            {{$page->incorporated?'checked':''}} required>
                            <label for="incorporated-yes">Si</label>
                          </div>
                          <div>
                            <input type="radio" id="incorporated-no" name="incorporated" value=""
                            {{!$page->incorporated?'checked':''}} required>
                            <label for="incorporated-no">No</label>
                          </div>
                      </div>
                  </div>
                  <div class="sub-section">
                      <div class="form-contrtol">
                          <h6>MVP</h6>
                          <div>
                            <input type="radio" id="mvp-yes" name="type_bool_1" value="1"
                            {{$page->type_bool_1?'checked':''}} required>
                            <label for="mvp-yes">Si</label>
                          </div>
                          <div>
                            <input type="radio" id="mvp-no" name="type_bool_1" value=""
                            {{!$page->type_bool_1?'checked':''}} required>
                            <label for="mvp-no">No</label>
                          </div>
                      </div>
                  </div>
                  @endif
                  @if (!$page->pagetype->hidden && $page->pagetype_id==3)
                      <div class="sub-section">
                          <div class="form-contrtol">
                              <h6>Tipologia</h6>
                              <div>
                                <input type="radio" id="i-private" name="type_bool_1" value=""
                                {{!$page->type_bool_1?'checked':''}} required>
                                <label for="i-private">Privato</label>
                              </div>
                              <div>
                                <input type="radio" id="i-public" name="type_bool_1" value="1"
                                {{$page->type_bool_1?'checked':''}} required>
                                <label for="i-public">Pubblico</label>
                              </div>
                          </div>
                      </div>
                      <div class="sub-section">
                          <div class="form-contrtol">
                              <h6>Servizi erogati:</h6>
                              <div>
                                <input type="radio" id="i-fisici" name="type_int_1" value=""
                                {{!$page->type_int_1?'checked':''}} required>
                                <label for="i-fisici">Fisici</label>
                              </div>
                              <div>
                                <input type="radio" id="i-online" name="type_int_1" value="1"
                                {{$page->type_int_1==1?'checked':''}} required>
                                <label for="i-online">Online</label>
                              </div>
                              <div>
                                <input type="radio" id="i-ibrid" name="type_int_1" value="2"
                                {{$page->type_int_1==2?'checked':''}} required>
                                <label for="i-ibrid">Ibridi</label>
                              </div>
                          </div>
                      </div>
                  @endif
                  @if (!$page->pagetype->hidden
                  && $page->pagetype_id==3 || $page->pagetype_id==4
                  || $page->pagetype_id==5 || $page->pagetype_id==8)
                  <div class="sub-section">
                      <h6>{{__('Taglio d\'investimenti')}}</span></h6>
                      <div class="form-contrtol">
                        @foreach ($moneyranges as $moneyrange)
                          <div>
                            <input type="radio" id="moneyrange-{{$moneyrange->id}}" name="moneyrange_id" value="{{$moneyrange->id}}"
                            {{-- {{old('moneyrange_id',$moneyrange->id)?'checked':''}} --}}
                            {{$moneyrange->id==$page->moneyrange_id?'checked':''}}
                            {{!$page->moneyrange_id && $moneyrange->id==1?'checked':''}} required>
                            <label for="moneyrange-{{$moneyrange->id}}">{{$moneyrange->range}}</label>
                          </div>
                        @endforeach
                      </div>
                      @error ('moneyrange')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  {{-- Startup Number --}}
                  <div class="sub-section">
                      <h6>Numero di startup supportate</h6>
                      <input type="number" name="startup_n" class="form-control" value="{{ old('startup_n',$page->startup_n)}}" min="0" placeholder="">
                      @error ('startup_n')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  @endif
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
                              <input type="text" name="municipality" class="form-control" value="{{ old('municipality',$page->municipality)}}">
                          </div>
                      </div>
                      {{-- <input type="hidden" name="latitude" v-model="latitude">
                      <input type="hidden" name="longitude" v-model="longitude">
                      <input type="hidden" name="address" v-model="address"> --}}
                  </div>
                  <button type="submit" class="button-style button-color">
                      {{__('Save Changes')}}
                  </button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

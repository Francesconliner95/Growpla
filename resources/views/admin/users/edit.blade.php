@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    user = "{{$user}}";
    userTypes = "{{$userTypes}}";
</script>
<div class="container">
    <div id="user-edit">
        <div class="item-cont">
            <div class="item-style">
              <h2>Modifica utente</h2>
              <div class="header">
                  {{-- Nome --}}
                  <div class="">
                      <h1 class="text-capitalize">{{$user->name}} {{$user->surname}}</h1>
                  </div>
                  <h1>
                      <i class="fas fa-pencil-alt"></i>
                  </h1>
              </div>

              <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.update', ['user'=> $user->id]) }}">
                  @csrf
                  @method('PUT')
                  <span class="mini-txt">{{__('Filling in some of the following fields is optional, however a more complete profile has more chance of being viewed by other users')}}</span>
                  {{-- NOME --}}
                  <div class="sub-section">
                      <h6>{{__('Name')}}*</h6>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}" minlength="3" maxlength="70" required autocomplete="name" required>
                      @error('name')
                          <span class="alert alert-danger">
                              {{__($message)}}
                          </span>
                      @enderror
                  </div>
                  <div class="sub-section">
                      <h6>{{__('Surname')}}*</h6>
                      <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname',$user->surname) }}" minlength="3" maxlength="70" required autocomplete="surname" required>
                      @error('surname')
                          <span class="alert alert-danger">
                              {{__($message)}}
                          </span>
                      @enderror
                  </div>

                  {{-- Descrizione --}}
                  <div class="sub-section">
                      <h6>{{__('Presentation')}}*</h6>
                      <textarea name="description" rows="8" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}"  minlength="50" maxlength="500" required>{{ $user->description }}</textarea>
                      @error ('description')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  <div class="sub-section">
                      <h6>Curriculum Vitae</h6>
                      <div class="edit-image-drag-drop row">
                          <div v-if="user.cv" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                              <embed src="{{ asset("storage/" . $user->cv) }}" />
                              <button type="button" @click="remove_file('cv')" class="button-style button-color-red edit-top-right">
                                  <i class="fas fa-times"></i>
                              </button>
                          </div>
                          <div class="drop-zone  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
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
                  {{-- SitoWeb --}}
                  <div class="sub-section">
                      <h6>{{__('Website')}} <span>({{__('enter the URL of your web site')}})</span></h6>
                      <input type="text" name="website" class="form-control" maxlength="255" value="{{ old('website',$user->website)}}" placeholder="es. https://www.growpla.it">
                      @error ('website')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  {{-- Linkedin --}}
                  <div class="sub-section">
                      <h6>LinkedIn <span>({{__('enter your LinkedIn profile URL')}})</span></h6>
                      <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$user->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
                      @error ('linkedin')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  {{-- Money range --}}
                  <div class="sub-section">
                      <h6>Moneyrange <span>({{__('Quanto hai investito sino ad oggi?')}})</span></h6>
                      <div class="form-contrtol">
                        @foreach ($moneyranges as $moneyrange)
                          <div>
                            <input type="radio" id="moneyrange-{{$moneyrange->id}}" name="moneyrange_id" value="{{$moneyrange->id}}"
                            {{-- {{old('moneyrange_id',$moneyrange->id)?'checked':''}} --}}
                            {{$moneyrange->id==$user->moneyrange_id?'checked':''}}
                            {{!$user->moneyrange_id && $moneyrange->id==1?'checked':''}} required>
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
                      <input type="number" name="startup_n" class="form-control" value="{{ old('startup_n',$user->startup_n)}}" min="0" placeholder="">
                      @error ('startup_n')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                      @enderror
                  </div>
                  <div class="form-group">
                      <h6>Indirizzo*</h6>
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
                  <button type="submit" class="button-style button-color">
                      {{__('Save Changes')}}
                  </button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

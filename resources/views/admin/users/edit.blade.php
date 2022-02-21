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
                      <textarea name="description" rows="8" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" min="50" required>{{ $user->description }}</textarea>
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
                  <button type="submit" class="button-style button-color">
                      {{__('Save Changes')}}
                  </button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    member = {!! json_encode($member->toArray()) !!};
    user = "{{$user}}";
</script>
<div class="container">
    <div id="team-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit')}}</h2>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form ref="editTeam" method="POST" enctype="multipart/form-data" action="{{ route('admin.teams.update', ['team'=> $member->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Aggiungi utente iscritto</h6>
                      <div>
                        <input type="radio" id="yes" name="registered_member" value="0" @click="registered_member=true" :checked="registered_member">
                        <label for="yes">Si</label>
                      </div>
                      <div>
                        <input type="radio" id="no" name="registered_member" value="1" @click="registered_member=false" :checked="!registered_member">
                        <label for="no">No</label>
                      </div>
                    </div>
                    <div v-if="registered_member" class="">
                      <input type="hidden" name="user_id" :value="user_selected.id">
                      <input type="hidden" name="name" value="">
                      <input type="hidden" name="surname" value="">
                      {{-- <input type="hidden" name="image" value=""> --}}
                      <input type="hidden" name="linkedin" value="">
                      <h6>Seleziona utente</h6>
                      <p v-if="user_selected">@{{user_selected.name}} @{{user_selected.surname}}
                        <button class="button-color-gray" @click="user_selected=''">
                            <i class="fas fa-trash"></i>
                        </button>
                      </p>
                      <div v-if="!user_selected" class="search">
                          <input type="hidden" name="user_id" value="">
                          <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control" autocomplete="off">
                          @error ('user_name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                          <div :class="users_found.length>0?'found':'found d-none'">
                              <p class="item" v-for="user_found in users_found"
                              >
                                <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="">
                                @{{user_found.name}} @{{user_found.surname}}
                                <button type="button" name="button" @click="addUser(user_found)">{{__('Add')}}</button>
                              </p>
                          </div>
                      </div>
                    </div>
                    <div v-else class="">                    
                      <input type="hidden" name="width" v-model="width">
                      <input type="hidden" name="height" v-model="height">
                      <input type="hidden" name="x" v-model="x">
                      <input type="hidden" name="y" v-model="y">

                      <input type="hidden" name="user_id" value="">

                      {{-- Nome --}}
                      <div class="form-group">
                          <h6>{{__('Name')}}</h6>
                          <input type="text" name="name" class="form-control" maxlength="70" value="{{ old('name',$member->name)}}" required>
                          @error ('name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>
                      <div class="form-group">
                          <h6>{{__('Surame')}}</h6>
                          <input type="text" name="surname" class="form-control" maxlength="70" value="{{ old('surname',$member->surname)}}" required>
                          @error ('surname')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group">
                          <h6>Linkedin</h6>
                          <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$member->linkedin)}}">
                          @error ('linkedin')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>
                    </div>

                      {{-- Ruolo --}}
                      <div class="form-group">
                          <h6>{{__('Role')}}</h6>
                          <input type="text" name="role" class="form-control" maxlength="50" value="{{ old('role',$member->role)}}" required>
                          @error ('role')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>

                      <div v-show="!registered_member" class="">
                        <h6>{{__('Image')}}</h6>
                        {{-- Immagine --}}
                        <div class="edit-image-drag-drop dd-cropper row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
                                <div class="drop-zone">
                                    <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                        <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg .png .jpg .gif .swg max:6Mb</span>
                                    </span>
                                    <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*" id="imgInp" >
                                    @error ('image')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
                                <div class="cropper c-circle" id="copper-main">
                                    <img v-if="image!='accounts_images/default_account_image.png'"
                                    {{--@load="createCrop()"--}} :src="image_src" id="croppr"/>
                                </div>
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

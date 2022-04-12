@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    team = {!! json_encode($team->toArray()) !!};
    user = "{{$user}}";
    default_images = "{{json_encode($default_images)}}";
</script>
<div class="container">
    <div id="team-edit">
        <div :class="delete_alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="alertCancel()">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">@{{message}}</h3>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="option1()">
                            @{{alert_b1}}
                        <button class="button-style button-color-red ml-5" type="submit" name="button" @click="option2()">
                            @{{alert_b2}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit')}}</h2>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form ref="editTeam" method="POST" enctype="multipart/form-data" action="{{ route('admin.teams.update', ['team'=> $team->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Aggiungi utente iscritto</h6>
                      <div>
                        <input type="radio" id="yes" name="registered_team" value="0" @click="registered_team=true" :checked="registered_team">
                        <label for="yes">Si</label>
                      </div>
                      <div>
                        <input type="radio" id="no" name="registered_team" value="1" @click="registered_team=false" :checked="!registered_team">
                        <label for="no">No</label>
                      </div>
                    </div>
                    <div v-if="registered_team" class="" v-cloak>
                      <input type="hidden" name="user_id" :value="user_selected.id" required>
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
                      <div v-if="!user_selected" class="search" v-cloak>
                          <input type="hidden" name="user_id" value="">
                          <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control" autocomplete="off" required>
                          @error ('user_name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                          <div :class="users_found.length>0?'found':'found d-none'" v-cloak>
                                <div class="item" v-for="user_found in users_found"
                                >
                                    <div class="img-cont mini-img">
                                      <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="">
                                    </div>
                                    @{{user_found.name}} @{{user_found.surname}}
                                    <button type="button" name="button" class="button-style button-color" @click="addUser(user_found)">{{__('Add')}}</button>
                                </div>
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
                          <input type="text" name="name" class="form-control" maxlength="70" value="{{ old('name',$team->name)}}" required>
                          @error ('name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>
                      <div class="form-group">
                          <h6>{{__('Surame')}}</h6>
                          <input type="text" name="surname" class="form-control" maxlength="70" value="{{ old('surname',$team->surname)}}" required>
                          @error ('surname')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>

                      <div class="form-group">
                          <h6>Linkedin</h6>
                          <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$team->linkedin)}}">
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
                          <input type="text" name="role" class="form-control" maxlength="50" value="{{ old('role',$team->role)}}" required>
                          @error ('role')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>

                      <div v-show="!registered_team" class="">
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
                      <div class="d-flex justify-content-between">
                          <button type="submit" class="button-style button-color">
                              {{__('Save Changes')}}
                          </button>
                          <button class="button-style button-color-red ml-5" type="button" name="button" @click="alertMenu(1)">
                              <i class="fas fa-trash-alt mr-1"></i>Elimina
                          </button>
                      </div>                      
                </form>
                <form method="post" name="deleteTeam" action="{{ route('admin.teams.destroy', ['team'=> $team->id])}}" class="invisible">
                @csrf
                @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

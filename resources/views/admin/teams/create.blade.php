@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div id="team-create" style="background-image: url({{asset("storage/images/bg-team.svg") }}); background-position: left 235px bottom 0px; background-repeat: no-repeat; background-size: 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <form ref="editTeam" method="POST" enctype="multipart/form-data" action="{{ route('admin.teams.storeTeam', ['page_id'=> $page_id]) }}" id="formCreateTeam">
                    @csrf
                    <div class="row pb-5">
                    <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 left-area order-1 order-sm-1 order-md-0">
                      <div class="h-100 d-flex align-items-center">
                          <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pt-3 pb-3">
                              <h4 class="font-weight-bold">
                                  Aggiungi membro del team
                              </h4>
                              <p class="txt-green font-weight-bold m-0">La compilazione dei seguenti campi è facoltativa</p>
                              <p class="txt-green mini-txt">Tuttavia un profilo più completo ha più possibiltà di essere visionato dagli altri utenti</p>
                              <div class="pt-3">
                                  <p class="mini-txt font-weight-bold">Appena terminato salva i progressi</p>
                                  <button type="submit" class="button-style button-color">
                                      Salva
                                  </button>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 bg-gray right-area order-0 order-sm-0 order-md-1">
                          <div class="sub-section text-center pb-4">
                              <h4 class="pb-2">Aggiungi utente iscritto?</h4>
                              <div class="row justify-content-center">
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center mr-2">
                                        <label class="input-container m-0">Si
                                            <input type="radio" id="yes" name="registered_team" value="0" @click="registered_team=true" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                  </div>
                                  <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <div class="d-flex align-items-center">
                                        <label class="input-container m-0">No
                                          <input type="radio" id="no" name="registered_team" value="1" @click="registered_team=false">
                                          <span class="checkmark"></span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <div v-if="registered_team" class="" v-cloak>
                            <input type="hidden" name="user_id" :value="user_selected.id">
                            <input type="hidden" name="name" value="">
                            <input type="hidden" name="surname" value="">
                            {{-- <input type="hidden" name="image" value=""> --}}
                            <input type="hidden" name="linkedin" value="">
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6 class="mt-2">@{{!user_selected?'Cerca utente':'Utente selezionato'}}</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                  <p v-if="user_selected" class="d-flex align-items-center text-capitalize" v-cloak>
                                    @{{user_selected.name}} @{{user_selected.surname}}
                                    <button class="button-color-gray" @click="user_selected=''">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                  </p>
                                  <div v-else class="search" v-cloak>
                                      <input type="hidden" name="user_id" value="">
                                      <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control" autocomplete="off" required>
                                      @error ('user_name')
                                          <div class="alert alert-danger">
                                              {{__($message)}}
                                          </div>
                                      @enderror
                                      <div :class="users_found.length>0?'found':'found d-none'" v-cloak>
                                        <div class="item" v-for="user_found in users_found">
                                            <div class="img-cont mini-img">
                                                <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="">
                                            </div>
                                            @{{user_found.name}} @{{user_found.surname}}
                                            <button type="button" name="button" class="button-style button-color" @click="addUser(user_found)">{{__('Add')}}</button>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div v-else class="" v-cloak>
                            <input type="hidden" name="width" v-model="width">
                            <input type="hidden" name="height" v-model="height">
                            <input type="hidden" name="x" v-model="x">
                            <input type="hidden" name="y" v-model="y">
                            {{-- Nome --}}
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Nome</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <input type="text" name="name" class="form-control" maxlength="15" value="" required>
                                    @error ('name')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Cognome</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <input type="text" name="surname" class="form-control" maxlength="20" value="" required>
                                    @error ('surname')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="sub-section row">
                                <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                    <h6>Linkedin</h6>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                    <input type="url" name="linkedin" class="form-control" maxlength="255" value="">
                                    @error ('linkedin')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                          </div>

                          {{-- Ruolo --}}
                          <div class="sub-section row">
                              <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                  <h6>Ruolo</h6>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                  <input type="text" name="role" class="form-control" maxlength="25" value="" required>
                                  @error ('role')
                                      <div class="alert alert-danger">
                                          {{__($message)}}
                                      </div>
                                  @enderror
                              </div>
                          </div>

                          {{-- Immagine --}}
                          <div v-show="!registered_team" class="sub-section row" v-cloak>
                              <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                  <h6>Immagine</h6>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                  <div  class="edit-image-drag-drop dd-cropper row" >
                                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1" style="height:150px">
                                          <div class="drop-zone">
                                              <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                                  <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg-.png .jpg max:6Mb</span>
                                              </span>
                                              <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*" id="imgInp" >
                                              @error ('image')
                                                  <div class="alert alert-danger">
                                                      {{__($message)}}
                                                  </div>
                                              @enderror
                                          </div>
                                      </div>
                                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1" style="height:150px">
                                          <div class="cropper  c-circle" id="copper-main">
                                              <img v-if="image"
                                              {{--@load="createCrop()"--}} :src="image_src" id="croppr"/>
                                          </div>
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

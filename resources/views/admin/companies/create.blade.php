@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>

<div id="company-create" style="background-image: url({{asset("storage/images/bg-azienda.svg") }}); background-position: left 235px bottom 0px; background-repeat: no-repeat; background-size: 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
              <div class="row pb-5">
                  <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 left-area order-1 order-sm-1 order-md-0">
                    <div class="h-100 d-flex align-items-center">
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pt-3 pb-3">
                            <h4 class="font-weight-bold">
                                Aggiungi azienda per cui lavori
                            </h4>
                            <p class="txt-green font-weight-bold m-0">La compilazione dei seguenti campi è facoltativa</p>
                            <p class="txt-green mini-txt">Tuttavia un profilo più completo ha più possibiltà di essere visionato dagli altri utenti</p>
                            <div class="pt-3">
                                <p class="mini-txt font-weight-bold">Appena terminato salva i progressi</p>
                                <button type="submit" class="button-style button-color" @click="submitForm()">
                                    {{__('Save')}}
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 bg-gray right-area order-0 order-sm-0 order-md-1">
                    <form ref="editTeam" method="POST" enctype="multipart/form-data" action="{{ route('admin.companies.store') }}" id="formCreateCompany">
                        @csrf

                        <div class="sub-section text-center pb-4">
                            <h4 class="pb-2">Aggiungi pagina iscritta?</h4>
                            <div class="row justify-content-center">
                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                  <div class="d-flex align-items-center mr-2">
                                      <label class="input-container m-0">Si
                                          <input type="radio" id="yes" name="registered_company" value="0" @click="registered_company=true" checked>
                                          <span class="checkmark"></span>
                                      </label>
                                  </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                  <div class="d-flex align-items-center">
                                      <label class="input-container m-0">No
                                        <input type="radio" id="no" name="registered_company" value="1" @click="registered_company=false">
                                        <span class="checkmark"></span>
                                      </label>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="registered_company" class="" v-cloak>
                          <input type="hidden" name="page_id" :value="page_selected.id">
                          <input type="hidden" name="name" value="">
                          <input type="hidden" name="surname" value="">
                          {{-- <input type="hidden" name="image" value=""> --}}
                          <input type="hidden" name="linkedin" value="">
                          <div class="sub-section row">
                              <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                  <h6 class="mt-2">@{{!page_selected?'Cerca pagina':'Pagina selezionata'}}</h6>
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                <p v-if="page_selected" class="d-flex align-items-center text-capitalize" v-cloak>
                                  @{{page_selected.name}} @{{page_selected.surname}}
                                  <button class="button-color-gray" @click="page_selected=''">
                                      <i class="fas fa-trash"></i>
                                  </button>
                                </p>
                                <div v-else class="search" v-cloak>
                                    <input type="hidden" name="page_id" value="">
                                    <input type="text" name="page" value="" placeholder="Nome pagina" v-model="page_name" @keyup.enter="searchPage()" v-on:input="searchPage()" maxlength="70" class="form-control" autocomplete="off" required>
                                    @error ('page_name')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                    <div :class="pages_found.length>0?'found':'found d-none'" v-cloak>
                                      <div class="item" v-for="page_found in pages_found">
                                          <div class="img-cont mini-img">
                                              <img v-if="page_found.image" :src="'/storage/' + page_found.image" alt="">
                                          </div>
                                          @{{page_found.name}} @{{page_found.surname}}
                                          <button type="button" name="button" class="button-style button-color" @click="addPage(page_found)">{{__('Add')}}</button>
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
                                  <h6>Nome azienda</h6>
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
                        </div>
                        {{-- Immagine --}}
                        <div v-show="!registered_company" class="sub-section row" v-cloak>
                            <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                                <h6>Immagine</h6>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10">
                                <div  class="edit-image-drag-drop dd-cropper row" >
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1" style="height:150px">
                                        <div class="drop-zone">
                                            <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                                <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg-.png .jpg .gif .swg max:6Mb</span>
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
                                            <img v-if="image" :src="image_src" id="croppr"/>
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
    </div>
</div>
@endsection

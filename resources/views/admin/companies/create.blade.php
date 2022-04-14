@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="company-create">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h4>Aggiungi azienda per cui sei dipendente</h4>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.companies.store') }}">
                    @csrf

                    <div class="form-group">
                      <h6>Aggiungi azienda registrata</h6>
                      <div>
                        <input type="radio" id="yes" name="registered_company" value="0" @click="registered_company=true" checked>
                        <label for="yes">Si</label>
                      </div>
                      <div>
                        <input type="radio" id="no" name="registered_company" value="1" @click="registered_company=false">
                        <label for="no">No</label>
                      </div>
                    </div>
                    <div v-if="registered_company" class="" v-cloak>
                      <input type="hidden" name="page_id" :value="page_selected.id">
                      <input type="hidden" name="name" value="">
                      <input type="hidden" name="linkedin" value="">
                      <h6>Seleziona pagina</h6>
                      <p v-if="page_selected">@{{page_selected.name}}
                        <button class="button-color-gray" @click="page_selected=''">
                            <i class="fas fa-trash"></i>
                        </button>
                      </p>
                      <div v-if="!page_selected" class="search" v-cloak>
                          <input type="hidden" name="page_id" value="">
                          <input type="text" name="page" value="" placeholder="Nome azienda" v-model="page_name" @keyup.enter="searchPage()" v-on:input="searchPage()" maxlength="70" class="form-control" autocomplete="off" required>
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
                    <div v-else class="">
                      <input type="hidden" name="width" v-model="width">
                      <input type="hidden" name="height" v-model="height">
                      <input type="hidden" name="x" v-model="x">
                      <input type="hidden" name="y" v-model="y">
                      {{-- Nome --}}
                      <div class="form-group">
                          <h6>{{__('Name')}}</h6>
                          <input type="text" name="name" class="form-control" maxlength="50" value="" required>
                          @error ('name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div>
                      {{-- <div class="form-group">
                          <h6>Linkedin</h6>
                          <input type="text" name="linkedin" class="form-control" maxlength="255" value="">
                          @error ('linkedin')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                      </div> --}}
                    </div>

                    {{-- Immagine --}}
                    <h6>{{__('Image')}}</h6>
                    <div v-show="!registered_company" class="edit-image-drag-drop dd-cropper row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
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
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
                            <div class="cropper  c-circle" id="copper-main">
                                <img v-if="image"
                                {{--@load="createCrop()"--}} :src="image_src" id="croppr"/>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    page_id = "{{$page_id}}";
    image = "{{$image}}";
    default_images = @json($default_images);
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div class="container">
    <div id="edit-page-image">
        <div class="item-cont">
            <div class="item-style">
                {{-- Immagine --}}
                <h6>Cambia immagine</h6>
                <form runat="server" id="saveImageForm" class="file-cont" ref="editImage" method="POST" enctype="multipart/form-data" action="{{ route('admin.images.updatePageImage',$page_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="page_id" value="{{$page_id}}">
                    <div class="edit-image-drag-drop dd-cropper row justify-content-center">
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-1">
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                    <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg .png .jpg max:6Mb</span>
                                </span>
                                <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*" id="imgInp" >
                                @error ('image')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-1">
                            <div class="cropper c-circle" id="copper-main">
                                <img v-if="image" :src="image_src" id="croppr"/>
                            </div>
                            <button v-if="!default_images.includes(image)" type="button" name="button" class="txt-blue" @click="submitForm('deleteImageForm')" v-cloak>{{__('Delete')}}</button>
                        </div>
                    </div>
                    <input type="hidden" name="width" v-model="width">
                    <input type="hidden" name="height" v-model="height">
                    <input type="hidden" name="x" v-model="x">
                    <input type="hidden" name="y" v-model="y">
                </form>
                <form method="post" name="" id="deleteImageForm"
                action="{{ route('admin.images.removePageImage',$page_id)}}" class="">
                @csrf
                @method('DELETE')
                </form>
                <div class="d-flex justify-content-center mt-5">
                    <button type="button" name="button" class="button-style button-color" @click="submitForm('saveImageForm')">{{__('Save Changes')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

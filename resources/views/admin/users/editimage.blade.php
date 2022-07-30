@extends('layouts.app')

@section('content')
<script type="text/javascript">
    user_id = "{{$user_id}}";
    image = "{{$image}}";
    default_images = @json($default_images);
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div class="container">
    <div id="edit-user-image">
        <div class="item-cont">
            <div class="item-style">
                {{-- Immagine --}}
                <h6>{{Auth::user()->tutorial?'Aggiungi immagine di profilo':'Cambia immagine'}}  </h6>
                <form runat="server" class="file-cont" ref="editImage" method="POST" enctype="multipart/form-data" action="{{ route('admin.images.updateUserImage') }}">
                    @csrf
                    @method('PUT')
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
                            <button v-if="!default_images.includes(image)" type="button" name="button" class="txt-blue" @click="removeUserImage()" v-cloak>Elimina</button>
                        </div>
                    </div>
                    <input type="hidden" name="width" v-model="width">
                    <input type="hidden" name="height" v-model="height">
                    <input type="hidden" name="x" v-model="x">
                    <input type="hidden" name="y" v-model="y">
                    <div class="d-flex justify-content-center align-items-center mt-5">
                        <button type="submit" name="button" class="button-style button-color">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

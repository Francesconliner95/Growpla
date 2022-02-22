@extends('layouts.app')

@section('content')
<script type="text/javascript">
    page_id = "{{$page_id}}";
    image = "{{$image}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div class="container">
    <div id="edit-page-image">
        <div class="item-cont">
            <div class="item-style">
                {{-- Immagine --}}
                <h6>{{__('Page image')}}</h6>
                LOL
                <form runat="server" class="file-cont" ref="editImage" method="POST" enctype="multipart/form-data" action="{{ route('admin.images.updatePageImage',$page_id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="page_id" value="{{$page_id}}">
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
                                <img v-if="image" :src="image_src" id="croppr"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="width" v-model="width">
                    <input type="hidden" name="height" v-model="height">
                    <input type="hidden" name="x" v-model="x">
                    <input type="hidden" name="y" v-model="y">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <button type="submit" name="button" class="button-style button-color">{{__('Save Changes')}}</button>
                        <button v-if="image" type="button" name="button" class="button-style button-color-red" @click="removePageImage()">{{__('Delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

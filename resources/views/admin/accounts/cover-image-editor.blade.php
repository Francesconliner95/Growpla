@extends('layouts.app')

@section('content')
<script type="text/javascript">
    account_id = "{{$account_id}}";
    image = "{{$image}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div class="container">
    <div id="cover-image-editor">
        <div class="item-cont">
            <div class="item-style">
                {{-- Immagine --}}
                <h6>{{__('Cover image')}}</h6>
                <form runat="server" class="file-cont" ref="editAccount" method="POST" enctype="multipart/form-data" action="{{ route('admin.accounts.updateCoverImage', ['account_id'=> $account_id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="edit-image-drag-drop dd-cropper row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                    <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg .png .jpg .gif .swg max:6Mb</span>
                                </span>
                                <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*" id="imgInp">
                                @error ('image')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-1">
                            <div class="cropper" id="copper-main">
                                <img v-show="image!='accounts_cover_images/default_account_cover_image.jpg'" :src="image_src" id="croppr"/>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="width" v-model="width">
                    <input type="hidden" name="height" v-model="height">
                    <input type="hidden" name="x" v-model="x">
                    <input type="hidden" name="y" v-model="y">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <button type="submit" name="button" class="button-style button-color">{{__('Save Changes')}}</button>
                        <button v-if="image!='accounts_cover_images/default_account_cover_image.jpg'" type="button" name="button" class="button-style button-color-red" @click="remove_file('cover_img')">{{__('Delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

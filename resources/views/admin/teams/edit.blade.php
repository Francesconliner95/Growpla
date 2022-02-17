@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    member = {!! json_encode($member->toArray()) !!};
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
                    <input type="hidden" name="width" v-model="width">
                    <input type="hidden" name="height" v-model="height">
                    <input type="hidden" name="x" v-model="x">
                    <input type="hidden" name="y" v-model="y">
                    {{-- <div class="edit-image-drag-drop mt-4 mb-4 row">

                        <div v-if="member.image!='accounts_images/default_account_image.png'" class="file-cont col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                            <img src="{{ asset("storage/" . $member->image) }}" alt="">
                            <button
                            v-if="member.image!='accounts_images/default_account_image.png'" type="button" @click="remove_file('team_img')" class="button-style button-color-red edit-top-right">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="drop-zone col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                            <span class="drop-zone__prompt">Drop file here or click to upload
                                <span class="mini-txt d-block">Formati supportati .jpeg,.png,.jpg,.gif,.swg max:6Mb</span>
                            </span>
                            <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*">
                            @error ('image')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}

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

                    {{-- Ruolo --}}
                    <div class="form-group">
                        <h6>{{__('Role')}}</h6>
                        <input type="text" name="role" class="form-control" maxlength="50" value="{{ old('role',$member->role)}}">
                        @error ('role')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <h6>{{__('Description')}}</h6>
                        <textarea class="form-control" name="description" rows="2" cols="80" maxlength="255">{{$member->description}}</textarea>
                        @error ('description')
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

                    <button type="submit" class="button-style button-color">
                        {{__('Save Changes')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

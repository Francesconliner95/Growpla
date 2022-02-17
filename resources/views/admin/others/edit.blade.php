@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    other = {!! json_encode($other->toArray()) !!};
</script>
<div class="container">
    <div id="other-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit')}}</h2>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form ref="editTeam" method="POST" enctype="multipart/form-data" action="{{ route('admin.others.update', ['other'=> $other->id]) }}" name="formName">
                    @csrf
                    @method('PUT')
                    <h6>{{__('Image')}}</h6>
                    {{-- Immagine --}}
                    <div class="edit-image-drag-drop mt-4 mb-4 row">
                        <div v-if="other.image" class="file-cont col-sm-12 col-md-6 col-lg-6 col-xl-6  mb-2">
                            <img src="{{ asset("storage/" . $other->image) }}" alt="">
                            <button type="button" @click="remove_file('other_img')" class="button-style button-color-red edit-top-right">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="drop-zone col-sm-12 col-md-6 col-lg-6 col-xl-6  mb-2">
                            <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                <span class="mini-txt d-block">{{__('Supported format')}} .jpeg .png .jpg .gif .swg max:6Mb</span>
                            </span>
                            <input ref="mainImage" type="file" class="form-control-file drop-zone__input" name="image" accept="image/*">
                            @error ('image')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                    </div>

                    {{-- Titolo --}}
                    <div class="form-group">
                        <h6>{{__('Title')}}</h6>
                        <input type="text" name="title" class="form-control" value="{{ old('title',$other->title)}}">
                        @error ('title')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Sottotitolo --}}
                    <div class="form-group">
                        <h6>{{__('Subtitle')}}</h6>
                        <input type="text" name="sub_title" class="form-control"  value="{{ old('sub_title',$other->sub_title)}}">
                        @error ('sub_title')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Descrizione --}}
                    <div class="form-group">
                        <h6>{{__('Description')}}</h6>
                        <textarea name="description" rows="8" cols="80" class="form-control">{{ old('description',$other->description)}}</textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Link --}}
                    <div class="form-group">
                        <h6>Link</h6>
                        <input type="text" name="link" class="form-control" maxlength="255" value="{{ old('link',$other->link)}}">
                        @error ('link')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                    <button type="button" name="button" class="button-style button-color" @click="submitAndRemove()">
                        {{__('Save Changes')}}
                    </button>

                    {{-- <button type="submit" class="button-style button-color">
                        Salva Modifiche
                    </button> --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

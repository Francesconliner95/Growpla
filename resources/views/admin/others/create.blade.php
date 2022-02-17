@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="other-create">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Add section')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form ref="editOther" method="POST" enctype="multipart/form-data" action="{{ route('admin.others.storeOther', ['section_id'=> $section_id]) }}">
                    @csrf
                    <h6>{{__('Image')}}</h6>
                    {{-- Immagine --}}
                    <div class="edit-image-drag-drop mt-4 mb-4">
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                <span class="mini-txt d-block">{{__('Supported formats')}} .jpeg .png .jpg .gif .swg max:6Mb</span>
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
                        <input type="text" name="title" class="form-control" value="">
                        @error ('title')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Sottotitolo --}}
                    <div class="form-group">
                        <h6>{{__('Subtitle')}}</h6>
                        <input type="text" name="sub_title" class="form-control"  value="">
                        @error ('sub_title')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Descrizione --}}
                    <div class="form-group">
                        <h6>{{__('Description')}}</h6>
                        <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Link --}}
                    <div class="form-group">
                        <h6>Link</h6>
                        <input type="text" name="link" class="form-control" maxlength="255" value="">
                        @error ('link')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
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

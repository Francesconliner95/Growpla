@extends('layouts.app')

@section('content')
<script src="https://cdn.tiny.cloud/1/w2g37gqrnhwko0zrava1ao1ntgx3yjb6d3utdjs1omplyl5d/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea', //tipo di tag su cui viene eseguito tinymce
        plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
        toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        //images_upload_url: 'postAcceptor.php',
        images_file_types: 'jpg,svg,webp,png',
        //images_upload_base_path: '/storage/blog_images'
        //images_upload_credentials: true,
    });
</script>
<div id="blog-admin-edit">
    <div class="container">
        <div class="item-cont">
            <form action="{{route('admin.blogs.update',$blog->id)}}" enctype="multipart/form-data" method="post" action="/details" id="blog-update-form">
                @csrf
                @method('PUT')
                <div class="pb-3">
                    <h6>Titolo*</h6>
                    <input type="text" name="title" value="{{ old('title',$blog->title) }}" class="form-control">
                    @error ('title')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pb-3">
                    <h6>Sottotitolo</h6>
                    <input type="text" name="subtitle" value="{{ old('subtitle',$blog->subtitle) }}" class="form-control">
                    @error ('subtitle')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pb-1">
                    <h6>Descrizione*</h6>
                    <textarea name="description" rows="8" cols="80" class="form-control">{{ old('description',$blog->description) }}</textarea>
                    @error ('description')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <h6 class="text-dark">Immagini</h6>
                <div class="bg-blue pt-3">
                    <div class="row">
                        @if($blog->main_image)
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 position-relative">
                            <img src="{{ asset('storage/'.$blog->main_image) }}" alt="" class="w-100" style="height: 200px; object-fit: contain">
                        </div>
                        @endif
                        @foreach ($images as $image)
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 position-relative">
                                <img src="{{ asset('storage/'.$image->path) }}" alt="" class="w-100" style="height: 200px; object-fit: contain">
                            </div>
                        @endforeach
                    </div>
                    @if($blog->main_image || count($images)>0)
                    <div class="pt-2 text-center">
                        <a href="{{route('admin.blogs.deleteBlogImages',$blog->id)}}" class="button-style button-color-red">
                            Elimina tutte le immagini
                        </a>
                        <p class="mini-txt txt-green">Salva prima le modifiche</p>
                    </div>
                    @endif
                </div>
                <div class="pt-3 pb-3">
                    <h6>Aggiungi immagini</h6>
                    <input type="file" name="images[]" class="form-control" multiple>
                    @error ('images')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
            </form>
            <form method="post"
            action="{{ route('admin.blogs.destroy',$blog->id)}}" class="d-inline-block" id="blog-delete-form">
                @csrf
                @method('DELETE')

            </form>
            <div class="d-flex justify-content-between pt-5">
                <button type="submit" class=" button-style button-color-red" onclick="document.getElementById('blog-delete-form').submit();">
                    Elimina
                </button>
                <button type="submit" class="button-style button-color" onclick="document.getElementById('blog-update-form').submit();">
                    Salva Modifiche
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

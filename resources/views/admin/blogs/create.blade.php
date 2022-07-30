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
      images_file_types: 'jpg,svg,webp,png',
    });
</script>

<div id="admin-blog-create">
    <div class="container">
        <div class="item-cont">
            <form action="{{route('admin.blogs.store')}}" enctype="multipart/form-data" method="post" action="/details" id="create-blog-form">
                @csrf
                <div class="pb-3">
                    <h6>Titolo*</h6>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" minlength="20" required>
                    @error ('title')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pb-3">
                    <h6>Sottotitolo</h6>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="form-control">
                    @error ('subtitle')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pb-1">
                    <h6>Descrizione*</h6>
                    <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
                    @error ('description')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="pb-3">
                    <h6>Immagini</h6>
                    <input type="file" name="images[]" class="form-control" multiple>
                    @error ('images')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <div class="text-right pt-5">
                    <button type="submit" class="button-style button-color-green">
                        Pubblica
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

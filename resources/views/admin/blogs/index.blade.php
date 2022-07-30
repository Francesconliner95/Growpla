@extends('layouts.app')

@section('content')
<script type="text/javascript">

</script>
<div id="blog-admin-index" class="container">
    <div class="item-cont">
        <div class="pb-3">
            <h6>News</h6>
            <a href="{{ route('admin.blogs.create')}}">
                <i class="fas fa-plus"></i> Aggiungi
            </a>
        </div>
        <div class="pb-3">
            <h6>Lista</h6>
            @foreach($blogs as $key => $blog)
                <div class="row border-bottom">
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                        <strong>{{$key+1}}.</strong>
                    </div>
                    <div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10 text-truncate">
                        {{$blog->title}}
                    </div>
                    <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                        <a href="{{route('admin.blogs.edit', $blog->id)}}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="{{route('blogs.show', $blog->id)}}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

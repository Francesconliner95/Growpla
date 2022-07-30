@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="blog-show">
    <div class="container p-0">
        <div class="item-cont pt-0">
            <div class="blog" style="border-radius: 20px;">
                <div class="blog-header">
                    @if($blog->main_image)
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @if(count($images)>0)
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                @foreach ($images as $key => $image)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{$key+1}}"></li>
                                @endforeach
                            @endif
                        </ol>
                        <div class="carousel-inner">
                            @if($blog->main_image)
                                <div class="carousel-item active">
                                    <div class="w-100" style="height:400px; background-color:#01B59C">
                                        <img src="{{asset('storage/'.$blog->main_image)}}" alt="" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                </div>
                            @endif
                            @if(count($images)>0)
                                @foreach ($images as $image)
                                    <div class="carousel-item">
                                        <div class="w-100" style="height:400px; background-color:#01B59C">
                                            <img src="{{asset('storage/'.$image->path)}}" alt="" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if(count($images)>0)
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>
                    @endif
                    <h1 class="font-weight-bold pb-3">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 text-center text-uppercase">
                            {{$blog->title}}
                        </div>
                        <div class="date">
                            <span>{{$blog->created_at->format('d-m-Y')}}</span>
                        </div>
                    </h1>
                </div>
                <div class="">
                    <div class="row justify-content-between py-5 m-0">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
                            <div class="px-5 px-sm-5 px-md-5 px-lg-0 px-xl-0">
                                @if($blog->subtitle)
                                <h2 class="font-weight-bold pb-4">{{$blog->subtitle}}</h2>
                                @endif
                                <div class="blog-description description">
                                    @php
                                        echo $blog->description;
                                    @endphp
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 mobile-hide">
                            <div class="d-flex justify-content-end">
                                <h5 style="width:220px;" class="font-weight-bold mb-4">Ultime news</h5>
                            </div>
                            <div v-for="blog in blogs" class="mb-5">
                                <div class="d-flex justify-content-end align-items-center h-100">
                                    <div class="card-style card-color-gray">
                                        <img :src="blog.main_image?'/storage/'+
                                        blog.main_image : '/storage/images/news.svg'" alt="" class="cover-image">
                                        <div class="top pb-4">
                                            <div  class="w-100 mb-1" style="height:110px;">
                                            </div>
                                            <p class="text-dark title mb-1 font-weight-bold">
                                                @{{blog.title}}
                                            </p>
                                            <p class="date">
                                                @{{getDate(blog.created_at)}}
                                            </p>
                                        </div>
                                        <div class="button text-center font-weight-normal">
                                            <a :href="'/blogs/'+ blog.id" class="button-style button-color-green">Leggi</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div style="width:220px;" class="text-center">
                                    <a href="{{route('blogs.index')}}" class="font-weight-bold text-dark text-center">
                                        Scopri tutte le news >
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="blogs.length>0" class="container pt-5 pb-3 mobile-show" v-cloak>
                <div class="main-multi-slider" style="margin:0px -15px;">
                    <div class="multi-slider-cont" id="multi-slider-cont-blog">
                        <div v-for="blog in blogs" class="multi-slider-item col-8 col-sm-8 col-md-5 col-lg-3 col-xl-3">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="card-style card-color-gray">
                                    <img :src="blog.main_image?'/storage/'+
                                    blog.main_image : '/storage/images/news.svg'" alt="" class="cover-image">
                                    <div class="top pb-4">
                                        <div  class="w-100 mb-1" style="height:110px;">
                                        </div>
                                        <p class="text-dark title mb-1 font-weight-bold">
                                            @{{blog.title}}
                                        </p>
                                        <p class="date">
                                            @{{getDate(blog.created_at)}}
                                        </p>
                                    </div>
                                    <div class="button text-center font-weight-normal">
                                        <a :href="'/blogs/'+ blog.id" class="button-style button-color-green">Leggi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" name="button" @mousedown="start('blog','left')" @mouseleave="stop('blog','left')" @mouseup="stop('blog','left')" class="slider-left mobile-hide" id="button-left-blog" v-cloak>
                        <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                    </button>
                    <button type="button" name="button" @mousedown="start('blog','right')" @mouseleave="stop('blog','right')" @mouseup="stop('blog','right')" class="slider-right mobile-hide" id="button-right-blog" v-cloak>
                        <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                    </button>
                    <span>@{{this.delay('blog')}}</span>
                </div>
                <div class="text-center">
                    <a href="{{route('blogs.index')}}" class="font-weight-bold text-dark">
                        Scopri tutte le news >
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

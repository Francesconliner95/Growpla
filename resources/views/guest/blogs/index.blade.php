@extends('layouts.app')

@section('content')
<script type="text/javascript">
    blogs = @json($blogs);
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="blog-index" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left -150px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <button v-if="showScrollTop" type="button" name="button" class="button-scroll" @click="scrollTop()">
                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-90l" alt="">
                </button>
                <h3>News</h3>
                <div class="">
                    <div v-for="blog in blogs_show" class="row gray-cont p-0" v-cloak>
                        <img :src="blog.main_image?'/storage/' + blog.main_image:'/storage/images/news.svg'" alt="" class="cover-image col-sm-12 col-md-12 col-lg-3 col-xl-3 p-0" v-cloak>
                        <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 p-0" style="height:200px;">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 p-3">
                            <h5 class="font-weight-bold">@{{blog.title}}</h5>
                            <h6 class="pb-3">@{{blog.subtitle}}</h6>
                            <p class="mini-txt">
                                @{{getDate(blog.created_at)}}
                            </p>
                            <a :href="'/blogs/'+ blog.id" class="button-style button-color mr-2">Leggi</a>
                            <a :href="'/blogs/'+ blog.id" class="button-style button-color" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div v-if="blogs_show.length==0 && !in_load" class="" v-cloak>
                        <h5>Nessun risultato</h5>
                    </div>
                    <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div v-if="!in_load && blogs_show.length<blogs.length" class="text-center pt-3 pb-2" v-cloak>
                        <button type="button" name="button" class="button-style text-dark" @click="showMore()">Mostra altro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

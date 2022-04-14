@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    needs = "{{json_encode($needs)}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="needs">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 >Tutte le necessità</h3>
                <div class="">
                    <div v-for="need in needs_show" class="row" v-cloak>
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <div class=" img-cont medium-img">
                                <img v-if="need.image" :src="'/storage/' + need.image" alt="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10">
                            <div class="">
                                <strong class="text-capitalize">
                                    @{{need.user_or_page? need.name +' ' +need.surname : need.name}}
                                </strong>
                                <span>@{{need.service_id?'cerca servizio di':'cerca'}}</span>
                                <strong class="text-capitalize">
                                    @{{need.need}}
                                </strong>
                            </div>
                            <p>@{{need.summary}}</p>
                            {{-- <div class="">
                                <div v-for="sector in need.sectors" class="d-inline-block border-style" v-cloak>
                                  <span>@{{sector.name}}</span>
                                </div>
                            </div> --}}
                            <a :href="need.user_or_page?'/admin/users/'+ need.id : '/admin/pages/'+ need.id" class="button-style button-color">Visita profilo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    needs = @json($needs);
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="needs" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left -150px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <button v-if="showScrollTop" type="button" name="button" class="button-scroll" @click="scrollTop()">
                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-90l" alt="">
                </button>
                <h3 >Tutte le necessità</h3>
                <div class="">
                    <div v-for="need in needs_show" class="row gray-cont" v-cloak>
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
                                <span v-if="need.service_id">cerca servizio di</span>
                                <span v-else-if="need.cofounder_service_id">cerca aspirante cofounder con competenze in</span>
                                <span v-else>cerca</span>
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
                    <div v-if="needs_show.length==0 && !in_load" class="" v-cloak>
                        <h5>Nessun risultato</h5>
                    </div>
                    <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div v-if="!in_load && needs_show.length<needs.length" class="text-center pt-3 pb-2" v-cloak>
                        <button type="button" name="button" class="button-style text-dark" @click="showMore()">Mostra altro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

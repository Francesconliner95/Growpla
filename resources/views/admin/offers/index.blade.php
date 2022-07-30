@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    offers = @json($offers);
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="offers" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left -150px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3>{{$webpage_typename}}</h3>
                <button v-if="showScrollTop" type="button" name="button" class="button-scroll" @click="scrollTop()">
                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-90l" alt="">
                </button>
                <div class="">
                    <div v-for="offer in offers_show" class="row gray-cont" v-cloak>
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <div class=" img-cont medium-img">
                                <img v-if="offer.image" :src="'/storage/' + offer.image" alt="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10">
                            <div class="">
                                <strong class="text-capitalize">
                                    @{{offer.user_or_page? offer.name +' ' +offer.surname : offer.name}}
                                </strong>
                                <span>offre servizio di</span>
                                <strong class="text-capitalize">
                                    @{{offer.need}}
                                </strong>
                            </div>
                            <p>@{{offer.summary}}</p>
                            {{-- <div class="">
                                <div v-for="sector in offer.sectors" class="d-inline-block border-style" v-cloak>
                                  <span>@{{sector.name}}</span>
                                </div>
                            </div> --}}
                            <a :href="offer.user_or_page?'/admin/users/'+ offer.id : '/admin/pages/'+ offer.id" class="button-style button-color mr-2">Visita profilo</a>
                            <span aria-label="Apri in un'altra scheda" data-microtip-position="top" data-microtip-size="medium" role="tooltip" class="cursor-default">
                            <a :href="offer.user_or_page?'/admin/users/'+ offer.id : '/admin/pages/'+ offer.id" class="button-style button-color" target="_blank">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div v-if="offers_show.length==0 && !in_load" class="" v-cloak>
                        <h5>Nessun risultato</h5>
                    </div>
                    <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div v-if="!in_load && offers_show.length<offers.length" class="text-center pt-3 pb-2" v-cloak>
                        <button type="button" name="button" class="button-style text-dark" @click="showMore()">Mostra altro</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

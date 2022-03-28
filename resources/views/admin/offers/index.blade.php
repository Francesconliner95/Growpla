@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    offers = "{{json_encode($offers)}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="offers">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 >Tutte le offerte</h3>
                <div class="">
                    <div v-for="offer in offers_show" class="row" v-cloak>
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
                            <a :href="offer.user_or_page?'/admin/users/'+ offer.id : '/admin/pages/'+ offer.id" class="button-style button-color">Visita profilo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

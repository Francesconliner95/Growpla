@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    pages_id = "{{json_encode($pages_id)}}";
    users_id = "{{json_encode($users_id)}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="found">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 >Risultati per "{{$search_type}}"</h3>
                <div class="">
                    <div v-for="account in accounts_show" class="row" v-cloak>
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                            <div class=" img-cont medium-img">
                                <img v-if="account.image" :src="'/storage/' + account.image" alt="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-10 col-lg-10 col-xl-10">
                            <span class="text-capitalize font-weight-bold">@{{account.user_or_page? account.name +' ' +account.surname : account.name}}</span>
                            <p>@{{account.summary}}</p>
                            <div class="">
                                <div v-for="sector in account.sectors" class="d-inline-block border-style" v-cloak>
                                  <span>@{{sector.name}}</span>
                                </div>
                            </div>
                            <a :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="button-style button-color">Visita profilo</a>
                        </div>
                    </div>
                </div>
                {{-- <button v-if="show_prev" type="button" name="button" class="" @click="showAccounts(-1)">Indietro</button>
                <button v-if="show_next" type="button" name="button" class="" @click="showAccounts(1)">Avanti</button> --}}
                {{-- <button v-if="show_more" type="button" name="button" class="" @click="showMore()" v-cloak>Mostra altro</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection

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
                <h3 >Risultati</h3>
                <div class="">
                    <div v-for="account in accounts_show" class="" v-cloak>
                        <div class="img-cont medium-img">
                            <img v-if="account.image" :src="'/storage/' + account.image" alt="">
                        </div>
                        <span class="text-capitalize">@{{account.user_or_page? account.name +' ' +account.surname : account.name}}</span>
                        <a :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="button-style button-color">Visita profilo</a>
                    </div>
                </div>
                <button v-if="show_prev" type="button" name="button" class="" @click="showAccounts(-1)">Indietro</button>
                <button v-if="show_next" type="button" name="button" class="" @click="showAccounts(1)">Avanti</button>
            </div>
        </div>
    </div>
</div>
@endsection

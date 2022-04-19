@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    pages_id = "{{json_encode($pages_id)}}";
    users_id = "{{json_encode($users_id)}}";
    my_user_id = {{Auth::user()->id}};
    my_pages_id = {{Auth::user()->pages->pluck('id')}};
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="found">
    <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
        <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="item-style-visible">
                <button type="button" name="button" class="edit-top-right button-color-gray" @click="alert=false">
                    <i class="fas fa-times"></i>
                </button>
                <div class="">
                    <h6>Seleziona l'account con cui vuoi contattare
                    </h6>
                    <a href="#" @click="startChat()" class="d-block" v-cloak>
                        <div class="img-cont mini-img">
                            <img v-if="list_user.image" :src="'/storage/' + list_user.image" alt="">
                        </div>
                        @{{list_user.name + ' ' + list_user.surname}}
                    </a>
                    <a v-for="page in list_pages" href="#" @click="startChat(page.id)" class="d-block" v-cloak>
                        <div class="img-cont mini-img">
                            <img v-if="page.image" :src="'/storage/'+page.image" alt="">
                        </div>
                        @{{page.name}}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 >Risultati per "<strong>{{$search_type}}</strong>"</h3>
                <div class="pt-3">
                    <div v-for="(account,i) in accounts_show" class="p-2" v-cloak>
                        <div class="row gray-cont">
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2  text-center">
                                <div class=" img-cont medium-img">
                                    <img v-if="account.image" :src="'/storage/' + account.image" alt="">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <span class="text-capitalize font-weight-bold">@{{account.user_or_page? account.name +' ' +account.surname : account.name}}
                                        </span>
                                    </div>
                                    <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                        <div v-for="sector in account.sectors" class="d-inline-block border-style bg-white mini-txt" v-cloak>
                                          <span>@{{sector.name_it}}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="mini-txt">@{{account.summary}}</p>
                                <div class="row">
                                    <div v-if="account.give.length>0" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <h6>Offro</h6>
                                        <span v-for="(give,i) in account.give" class="mini-txt">
                                            @{{give.name}}
                                            @{{i < account.give.length-1?',':''}}
                                        </span>
                                    </div>
                                    <div v-if="account.have.length>0" class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <h6>Cerco</h6>
                                        <span v-for="(have,i) in account.have" class="mini-txt">
                                            @{{have.name_it?have.name_it:have.name}}
                                            @{{i < account.have.length-1?',':''}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3  text-center pt-3">
                                <a :href="account.user_or_page?'/admin/users/'+ account.id : '/admin/pages/'+ account.id" class="button-style button-color-green m-1">Visita profilo</a>
                                <div v-if="account.user_or_page" class="d-inline-block">
                                    <div v-if="account.id!=my_user_id" class="d-inline-block">
                                        <button  class="button-style button-color-blue m-1" type="button" name="button" @click="switchAccounts(i)">
                                            <span>Messaggio</span>
                                        </button>
                                    </div>
                                </div>
                                <div v-else class="d-inline-block">
                                    <div v-if="(!my_pages_id.includes(account.id))" class="d-inline-block">
                                        <button  class="button-style button-color-blue m-1" type="button" name="button" @click="switchAccounts(i)">
                                            <span>Messaggio</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
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

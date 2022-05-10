@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    id = "{{$my_id}}";
    user_or_page = "{{$user_or_page}}";
</script>
<div class="container">
    <div id="my-collaboration">
        <div :class="delete_alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="alertCancel()">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">@{{message}}</h3>
                    <div class="d-flex justify-content-around">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="option1()">
                            @{{alert_b1}}
                        <button class="button-style button-color-red ml-5" type="submit" name="button" @click="option2()">
                            @{{alert_b2}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <div class="pb-4">
                    <h6>Aggiungi nuova collaborazione</h6>
                    <div class="search" v-cloak>
                        <input type="text" name="account" value="" placeholder="Nome pagina o utente" v-model="account_name" @keyup.enter="searchAccount()" v-on:input="searchAccount()" maxlength="70" class="form-control custom-input-blue col-sm-12 col-md-6 col-lg-4 col-xl-4" autocomplete="off" required>
                        @error ('account_name')
                          <div class="alert alert-danger">
                              {{__($message)}}
                          </div>
                        @enderror
                        <div :class="accounts_found.length>0?'found':'found d-none'" v-cloak>
                            <div class="item" v-for="account_found in accounts_found">
                                <div class="profile-info">
                                    <div class="img-cont mini-img">
                                        <img v-if="account_found.image" :src="'/storage/' + account_found.image" alt="">
                                    </div>
                                    @{{account_found.user_or_page=='user'?
                                    account_found.name + ' ' + account_found.surname
                                    : account_found.name}}
                                </div>
                                <button type="button" name="button"
                                class="button-style button-color" @click="addAccount(account_found)">Aggiungi</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-4" style="height: 350px">
                    <h6>Tutte le mie collaborazioni</h6>
                    <div v-if="collaborations.length>0" class="main-multi-slider" v-cloak>
                        <div class="multi-slider-cont" id="multi-slider-cont-1">
                            <div v-for="collaboration in collaborations" class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class=" d-flex justify-content-center align-items-center h-100">
                                    <div class="card-style card-color-gray text-center position-relative">
                                        <div class="img-cont medium-img">
                                            <img
                                            v-if="collaboration.account.image"
                                            :src="'/storage/' +collaboration.account.image" alt="" class="">
                                        </div>
                                        <div class="card-info">
                                            <span>@{{collaboration.account.name}}
                                              @{{collaboration.account.surname?
                                              collaboration.account.surname:''}}
                                            </span>
                                            </div class="inf">
                                                <a :href="collaboration.recipient_user_id?
                                                '/admin/users/'+collaboration.account.id
                                                :'/admin/pages/'+collaboration.account.id" class="button-style button-color-green mt-5">
                                                    Visita profilo
                                                </a>
                                                <button class="edit-top-right button-style-circle button-color-gray" type="submit" name="button" @click="alertMenu(1,collaboration)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left" id="button-left-1" v-cloak>
                            <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                        </button>
                        <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')" class="slider-right" id="button-right-1" v-cloak>
                            <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                        </button>
                        <span>@{{this.delay(1)}}</span>
                    </div>
                    <div v-if="collaborations.length==0 && !in_load_1" class="d-flex justify-content-center align-items-center h-100" v-cloak>
                        <h5>Nessuna collaborazione</h5>
                    </div>
                    <div v-if="in_load_1" class="d-flex justify-content-center align-items-center h-100" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="pb-4" style="height: 350px">
                    <h6>Collaborazioni da confermare</h6>
                    <div v-if="prop_collaborations.length>0" class="main-multi-slider" v-cloak>
                        <div class="multi-slider-cont" id="multi-slider-cont-2">
                            <div v-for="collaboration in prop_collaborations" class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                <div class=" d-flex justify-content-center align-items-center h-100">
                                    <div class="card-style card-color-gray text-center position-relative">
                                        <div class="img-cont medium-img">
                                            <img
                                            v-if="collaboration.account.image"
                                            :src="'/storage/' +collaboration.account.image" alt="" class="">
                                        </div>
                                        <div class="card-info">
                                            <span>@{{collaboration.account.name}}
                                              @{{collaboration.account.surname?
                                              collaboration.account.surname:''}}
                                            </span>
                                            </div class="inf">
                                                <button class="button-style button-color-blue font-weight-bold mt-2" type="submit" name="button" @click="alertMenu(2,collaboration)">
                                                    Conferma
                                                </button>
                                                <a :href="collaboration.sender_user_id?
                                                '/admin/users/'+collaboration.account.id
                                                :'/admin/pages/'+collaboration.account.id" class="button-style button-color-green mt-2">
                                                    Visita profilo
                                                </a>
                                                <button class="edit-top-right button-style-circle button-color-gray" type="submit" name="button" @click="alertMenu(2,collaboration)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <button type="button" name="button" @mousedown="start(2,'left')" @mouseleave="stop(2,'left')" @mouseup="stop(2,'left')" class="slider-left" id="button-left-2" v-cloak>
                            <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                        </button>
                        <button type="button" name="button" @mousedown="start(2,'right')" @mouseleave="stop(2,'right')" @mouseup="stop(2,'right')" class="slider-right" id="button-right-2" v-cloak>
                            <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                        </button>
                        <span>@{{this.delay(2)}}</span>
                    </div>
                    <div v-if="prop_collaborations.length==0 && !in_load_2" class="d-flex justify-content-center align-items-center h-100" v-cloak>
                        <h5>Nessuna collaborazione da confermare</h5>
                    </div>
                    <div v-if="in_load_2" class="d-flex justify-content-center align-items-center h-100" v-cloak>
                        <div class="spinner-border text-secondary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

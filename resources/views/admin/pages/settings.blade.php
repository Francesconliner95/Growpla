@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    user_id = "{{Auth::user()->id}}";
    page_id = "{{$page_id}}";
</script>
<div class="container">
    <div id="page-settings">
        <div :class="delete_alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="alertCancel()">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">@{{message}}</h3>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="option1()">
                            @{{alert_b1}}
                        <button class="button-style button-color-red ml-5" type="submit" name="button" @click="option2()">
                            @{{alert_b2}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" name="deletePage" action="{{ route('admin.pages.destroy', ['page'=> $page_id])}}" class="invisible">
            @csrf
            @method('DELETE')
        </form>
        <div class="item-cont">
            <div class="item-style">
                <h3 class="pb-3">Impostazioni pagina
                    <span class="text-capitalize font-weight-bold">
                    {{$page->name}}
                    </span>
                </h3>
                <div class="pb-3">
                    <h6>Admin</h6>
                    <div v-for="admin in admins" v-cloak>
                        <div class="border-style bg-blue">
                            <span class="text-capitalize">@{{admin.name}} @{{admin.surname}}</span>
                            <button class="" @click="alertMenu(2,admin.id)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div v-if="error_message" v-cloak>
                        @{{error_message}}
                    </div>
                </div>
                <div class="pb-3">
                    <h6>Aggiungi admin</h6>
                    <div class="search">
                        <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control col-sm-12 col-md-6 col-lg-4 col-xl-4 custom-input-blue" autocomplete="off">
                        @error ('user_name')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                        <div :class="users_found.length>0?'found':'found d-none'" v-cloak>
                            <div class="item" v-for="user_found in users_found"
                            v-cloak>
                                <div class="profile-info">
                                    <div class="img-cont mini-img">
                                        <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="" >
                                    </div>
                                    <a :href="'/admin/users/'+user_found.id">
                                        @{{user_found.name}} @{{user_found.surname}}
                                    </a>
                                </div>
                                <button type="button" name="button" class="button-style button-color" @click="addAdmin(user_found.id)">
                                    {{__('Add')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <button type="button" name="button" class="button-style button-color-black" @click="alertMenu(1)">
                        <i class="fas fa-trash-alt mr-1"></i>
                        Elimina pagina
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

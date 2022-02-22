@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    page_id = "{{$page_id}}";
</script>
<div class="container">
    <div id="page-settings">
        <div class="item-cont">
            <div class="item-style">
                <h3>Settings</h3>
                <div class="sub-section">
                    <div class="">
                      <h6>Admin</h6>
                      <p v-for="admin in admins">@{{admin.name}} @{{admin.surname}}
                        <button class="button-color-gray" @click="removeAdmin(admin.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                      </p>
                    </div>
                    <div class="search">
                        <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control" autocomplete="off">
                        @error ('user_name')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                        <div :class="users_found.length>0?'found':'found d-none'">
                            <p class="item" v-for="user_found in users_found"
                            >
                              <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="">
                              @{{user_found.name}} @{{user_found.surname}}
                              <button type="button" name="button" @click="addAdmin(user_found.id)">{{__('Add')}}</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

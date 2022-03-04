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
        <div :class="delete_alert?'delete-alert active-alert':'delete-alert deactive-alert'"
        v-cloak>
            <div class="item-cont delete-alert-item  col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style">
                    <button type="button" name="button" class="edit-top-right button-style button-color" @click="delete_alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">{{__('Are you really sure you want to delete your account?')}}
                    </h3>
                    <span class="pb-4">{{__('The action is irreversible, by doing so you will lose all your information')}}</span>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="delete_alert=false">
                            {{__('Cancel')}}
                        </button>
                        <form method="post" action="{{ route('admin.pages.destroy', ['page'=> $page_id])}}" class="p-0 m-0 d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="button-style button-color-red ml-5" type="submit" name="button">
                            <i class="fas fa-trash-alt mr-1"></i>{{__('Proceed')}}
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <h3>Settings</h3>
                <div class="sub-section">
                    <div class="">
                      <h6>Admin</h6>
                      <p v-for="admin in admins" v-cloak>@{{admin.name}} @{{admin.surname}}
                        <button class="button-color-gray" @click="removeAdmin(admin.id)">
                            <i class="fas fa-trash"></i>
                        </button>
                      </p>
                      <div v-if="message" class="alert alert-danger" v-cloak>
                          @{{message}}
                      </div>
                    </div>
                    <div class="search">
                        <input type="text" name="user" value="" placeholder="Nome o cognome utente" v-model="user_name" @keyup.enter="searchUser()" v-on:input="searchUser()" maxlength="70" class="form-control" autocomplete="off">
                        @error ('user_name')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                        <div :class="users_found.length>0?'found':'found d-none'" v-cloak>
                            <p class="item" v-for="user_found in users_found"
                            >
                              <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="" v-cloak>
                              @{{user_found.name}} @{{user_found.surname}}
                              <button type="button" name="button" @click="addAdmin(user_found.id)">{{__('Add')}}</button>
                            </p>
                        </div>
                    </div>
                    <div class="text-center col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <button type="button" name="button" class="button-style button-color-red" @click="delete_alert=true">
                            <i class="fas fa-trash-alt mr-1"></i> {{__('Delete page')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

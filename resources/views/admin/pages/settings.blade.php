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
        <div :class="delete_alert?'alert active-alert':'alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style">
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
                <h3>Settings</h3>
                <div class="">
                  <h6>Admin</h6>
                  <p v-for="admin in admins" v-cloak>@{{admin.name}} @{{admin.surname}}
                    <button class="button-color-gray" @click="alertMenu(2,admin.id)">
                        <i class="fas fa-trash"></i>
                    </button>
                  </p>
                  <div v-if="error_message" v-cloak>
                      @{{error_message}}
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
                        <div class="item" v-for="user_found in users_found"
                        v-cloak>
                            <div class="img-cont mini-img">
                                <img v-if="user_found.image" :src="'/storage/' + user_found.image" alt="" >
                            </div>
                            <a :href="'/admin/users/'+user_found.id">
                                @{{user_found.name}} @{{user_found.surname}}
                            </a>
                          <button type="button" name="button" class="button-style button-color" @click="addAdmin(user_found.id)">{{__('Add')}}</button>
                      </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                    <button type="button" name="button" class="button-style button-color-red" @click="alertMenu(1)">
                        <i class="fas fa-trash-alt mr-1"></i> {{__('Delete page')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

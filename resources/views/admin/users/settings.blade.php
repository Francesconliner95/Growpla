@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = "{{$user}}";
    lang = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="user-settings">
        <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-style button-color" @click="alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <h4 class="p-2 pt-4 text-center">{{__('Are you really sure you want to delete your account?')}}
                    </h4>
                    <div class="p-3 pb-5 text-center">
                        <span class="">{{__('The action is irreversible, by doing so you will lose all your information')}}</span>
                        <span class="d-block txt-red font-weight-bold pt-2 pb-2">Se sei propietario di una o più pagine e non hai nominato altri amministratori anche le tue pagine verrano eliminate</span>
                    </div>
                    <div class="">
                        <div v-if="!confirm_delete_alert" class="d-flex justify-content-between align-items-center">
                            <button type="button" name="button" class="button-style button-color mr-5" @click="alert=false">
                                {{__('Cancel')}}
                            </button>
                            <button class="button-style button-color-red ml-5" type="button" name="button" @click="confirm_delete_alert=true">
                                <i class="fas fa-trash-alt mr-1"></i>{{__('Proceed')}}
                            </button>
                        </div>
                        <form v-if="confirm_delete_alert" method="post" action="{{ route('admin.users.destroy', ['user'=> $user->id])}}" class="text-center">
                        @csrf
                        @method('DELETE')
                          <span class="d-block txt-red font-weight-bold pb-2">Sei davvero sicuro?</span>
                          <button class="button-style button-color-red" type="submit" name="button">
                              <i class="fas fa-trash-alt mr-1"></i>Elimina Account
                          </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                 <div class="header">
                    <div class="">
                        <h2>{{__('Settings')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-cog"></i>
                    </h1>
                </div>
                {{-- <div class="sub-section">
                    <h6 class="text-uppercase d-inline-block pr-2">{{__('Language')}}</h6>
                    <select class="form-control d-inline-block w-auto text-capitalize" name="" @change="changeLang()" v-model="selected_lang">
                        @foreach ($languages as $language)
                            <option class="text-capitalize" value="{{$language->id}}"
                                {{$language->id == old('language_id', Auth::user()->language_id) ? 'selected=selected' : '' }}
                                >{{$language->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                  <a class="button-style button-color" href="{{route('admin.users.create')}}">
                    Modifica account
                  </a>
                </div> --}}
                {{--<div class="sub-section">
                    <h6 class="text-uppercase">{{__('messages')}}</h6>
                    <h6>{{__('I want to receive messages from')}}</h6>
                    <div v-for="accountType in accountTypes" class="form-check">
                        <input v-if="accountType.id!=1" type="checkbox" name="" :value="accountType.id"
                        :checked="accountType.checked"
                        @click="setFilterMessage(accountType.id)">
                        <label>@{{lang==1?accountType.name_en:accountType.name}}</label>
                        <div v-if="accountType.id==1" v-for="startupState in startupStates" class="form-check">
                            <input type="checkbox" name="" :value="startupState.id"
                            :checked="startupState.checked"
                            @click="setFilterMessage(accountType.id,startupState.id)"
                            >
                            <label>@{{startupState.name}}</label>
                        </div>
                    </div>
                </div>
                <div class="sub-section">
                    <h6 class="text-uppercase">{{__('Notifications')}}</h6>
                    <h6>{{__('I want to receive notifications if')}}</h6>
                    <div v-for="filterNotType in filterNotTypes"
                        class="form-check"
                        v-show="filterNotType.show">
                        <input type="checkbox" name="" :value="filterNotType.id"
                        :checked="filterNotType.checked"
                        @click="setFilterNotf(filterNotType.id)">
                        <label v-if="lang==1">@{{filterNotType.name_en}}</label>
                        <label v-if="lang==2">@{{filterNotType.name_it}}</label>
                    </div>
                </div>
                <div class="sub-section">
                    <h6 class="text-uppercase">{{__('Mails')}}</h6>
                    <h6>{{__('I want to receive mail if')}}</h6>
                    <div v-for="filterType in filterTypes"
                        class="form-check"
                        v-show="filterType.show">
                        <input type="checkbox" name="" :value="filterType.id"
                        :checked="filterType.checked"
                        @click="setFilterMail(filterType.id)">
                        <label v-if="lang==1">@{{filterType.name_en}}</label>
                        <label v-if="lang==2">@{{filterType.name_it}}</label>
                    </div>
                </div>--}}
                <div v-if="user" class="sub-section pt-3 pb-2" v-cloak>
                    <div class="row">
                        <div class="text-center col-sm-12 col-md-12 col-lg-8 col-xl-8 d-flex justify-content-start align-items-center pb-2">
                            <div class="img-cont mini-img d-inline-block mr-3" v-cloak>
                                <img :src="'/storage/' + user.image" alt="" class="">
                            </div>
                            <h4 class="d-inline-block text-capitalize m-0">@{{user.name}}</h4>
                        </div>
                        <div class="text-center col-sm-12 col-md-12 col-lg-4 col-xl-4">
                            <button type="button" name="button" class="button-style button-color-red" @click="alert=true">
                                <i class="fas fa-trash-alt mr-1"></i> {{__('Delete account')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

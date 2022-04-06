@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    account = {!! json_encode($account->toArray()) !!};
    accountTypes = {!! json_encode($accountTypes->toArray()) !!};
    startupStates = {!! json_encode($startupStates->toArray()) !!};
    filter_messages = {!! json_encode($filter_messages->toArray()) !!};
    filter_mails = {!! json_encode($filter_mails->toArray()) !!};
    filter_notfs = {!! json_encode($filter_notfs->toArray()) !!};
    lang = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="settings-index">
        <div :class="delete_alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item  col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-style button-color" @click="delete_alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">{{__('Are you really sure you want to delete your page?')}}
                    </h3>
                    <span class="pb-4">{{__('The action is irreversible, by doing so you will lose all your information')}}</span>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="delete_alert=false">
                            {{__('Cancel')}}
                        </button>
                        <form method="post" action="{{ route('admin.accounts.destroy', ['account'=> $account->id])}}" class="p-0 m-0 d-inline-block">
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
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h2>{{__('Settings')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-cog"></i>
                    </h1>
                </div>
                <div class="sub-section">
                    <h6 class="text-uppercase d-inline-block pr-2">{{__('Language')}}</h6>
                    <select class="form-control d-inline-block w-auto text-capitalize" name="" @change="changeLang()" v-model="selected_lang">
                        @foreach ($languages as $language)
                            <option class="text-capitalize" value="{{$language->id}}"
                                {{$language->id == old('language_id', Auth::user()->language_id) ? 'selected=selected' : '' }}
                                >{{$language->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sub-section">
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
                </div>
                <div class="main-section pt-3 pb-2">
                    <div class="sub-item-cont">
                        <div class="sub-item-style delete-account row">
                            <div class="text-center col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <img :src="'/storage/' + account.image" alt="" class="">
                            </div>
                            <div class="text-center col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <h4>@{{account.name}}</h4>
                            </div>
                            <div class="text-center col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <button type="button" name="button" class="button-style button-color-red" @click="delete_alert=true">
                                    <i class="fas fa-trash-alt mr-1"></i> {{__('Delete account')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

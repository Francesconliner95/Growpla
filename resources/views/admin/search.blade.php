@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="search">
  RICERCA
    {{-- @if(!Auth::user()->user_usertype) --}}
    <div class="container">
        <h3 class="section-title">
            <b></b>
            <span>{{ __('Welcome to Growpla!') }}
             </span>
            <b></b>
        </h3>
        <p class="text-center m-0">
            {{ __('To complete your registration click here') }}
        </p>
        <div class="create-profile">
            <a class="item col-sm-12 col-md-6 col-lg-6 col-xl-6" href="{{ route('admin.users.create') }}">{{__('Start')}}</a>
        </div>
    </div>
    {{-- @endif --}}
    <div class="background">
        <div class="container">
            <div class="search">
                <h1>{{ __('What are you looking for?') }}</h1>
                <div class="search-type">
                    <div  class="switch-big-button-container pt-1 pb-2">
                        <div :class="search_type?
                        'button r switch-button text t-l d-inline-block':
                        'button r switch-button text t-r d-inline-block'">
                            <input type="checkbox" class="checkbox" v-model="search_type" @change="search_type_f()">
                            <div class="knobs"></div>
                            <div class="layer"></div>
                        </div>
                    </div>
                </div>
                <div class="search-main" v-cloak>
                    <div v-if="!search_type" class="search-filter row">
                        <div class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <select class="search-style-hover"
                            v-model="account_selected">
                                <option value="">{{ __('All accounts') }}</option>
                                <option v-for="accountType in accountTypes" :value="accountType.id">
                                    @{{lang==1?accountType.name_en:accountType.name}}
                                </option>
                            </select>
                            <div v-if="account_selected==1" class="">
                                <select class="search-style-hover"
                                v-model="startupState_selected">
                                    <option value="">{{ __('All phases') }}</option>
                                    <option v-for="startupState in startupStates" :value="startupState.id">@{{startupState.name}}</option>
                                </select>
                                <select class="search-style-hover"
                                v-if="startupState_selected!=6 && startupState_selected!=7"
                                v-model="need_selected" @change="show()">
                                    <option value="">{{ __('All needs') }}</option>
                                    <option v-for="accountType in accountTypes"
                                    v-if="accountType.id!=1 && accountType.id!=7 && accountType.id!=8"
                                    :value="setNeeds(accountType.id,null)">
                                    @{{accountType.name}}
                                    </option>
                                    <option v-for="serviceType in serviceTypes" :value="setNeeds(7,serviceType.id)">@{{serviceType.name}}</option>
                                </select>
                                <div v-if="need_selected.accountType==2" class="tag-search">
                                    <input type="text" name="" value="" placeholder="{{__('Search by role')}}" v-model="search_role" @keyup.enter="searchRole()" v-on:input="searchRole()">
                                    <div  :class="roles_found.length?'tag-found':'tag-found d-none'">
                                        <a class="item text-capitalize" v-for="role_found in roles_found"
                                        @click="setRole(role_found.name)">@{{role_found.name}}
                                        </a>
                                        <p  class="item" v-if="roles_found.length==0 && search_role">{{__('No role found')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="account_selected==2" class="tag-search">
                                <input type="text" name="" value="" placeholder="{{__('Search by role')}}" v-model="search_role" @keyup.enter="searchRole()" v-on:input="searchRole()">
                                <div  :class="roles_found.length?'tag-found':'tag-found d-none'">
                                    <p class="item text-capitalize" v-for="role_found in roles_found">@{{role_found.name}}
                                        <button type="button" name="button" @click="setRole(role_found.name)">{{__('Add')}}</button>
                                    </p>
                                    <p  class="item" v-if="roles_found.length==0 && search_role">{{__('No role found')}}</p>
                                </div>
                            </div>
                            <div v-if="account_selected==7" class="search-style-hover">
                                <select class=""
                                v-model="startupserviceType_selected">
                                    <option value="">{{__('All services')}}</option>
                                    <option v-for="type in startupserviceType" :value="type.id">@{{type.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <button class="button-style button-color" type="button" name="button" @click="search()">{{__('Search')}}</button>
                        </div>
                    </div>
                    <div v-else class="search-filter row">
                        <div  class="search-style search-style-hover col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <input type="text" name="" value="" placeholder="{{__('Search by name')}}"
                            v-model="account_name">
                        </div>
                        <div class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <button class="button-style button-color" type="button" name="button" @click="search()">{{__('Search')}}</button>
                        </div>
                    </div>
                </div>
                <div v-if="accounts.length>0" class="search-found">
                    <div class="account-found-items ml-n3 mr-n3" id="swipe-anim-cont">
                        <div class="account-found-item anim-item" v-for="account_show in accounts_show">
                            <a class="item hover-scale" :href="'/admin/accounts/' + account_show.id">
                                <div class="item-part">
                                    <img :src="'/storage/'+account_show.image" alt="">
                                </div>
                                <div class="item-part">
                                    <span class="name text-capitalize">
                                        @{{account_show.name}}
                                    </span>
                                    <div class="">
                                        <span class="tag text-capitalize" v-for="tag in account_show.tags">@{{tag.name}}
                                        </span>
                                    </div>
                                </div>
                                <div class="item-part">
                                    <span>
                                        @{{lang==1?account_show.account_types_name_en:account_show.account_types_name}}
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="account-items-nav">
                        <button type="button" name="button" @click="changePage(-1)" :class="arrowClass('left')">
                            <i  class="fas fa-chevron-left"></i>
                        </button>
                        <span>@{{page}} - @{{Math.ceil(accounts.length/6)}}</span>
                        <button type="button" name="button"  @click="changePage(+1)" :class="arrowClass('right')">
                            <i  class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div v-else-if="is_in_search" class="intro">
                    <div class="anim-load-cont">
                        <span v-for="item in 5" class="anim-item"></span>
                    </div>
                </div>
                <div v-else-if="first_search" class="intro">
                    <p>{{__('No results found')}}</p>
                </div>
                <div v-else class="intro">
                    <h2 class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        {{ __('The platform allows interaction between the players of the startup ecosystem in order to favor their birth and growth') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

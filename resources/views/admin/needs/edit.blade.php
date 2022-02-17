@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    account = {!! json_encode($account->toArray()) !!};
    startupStates = {!! json_encode($startupStates->toArray()) !!};
    accountNeeds = {!! json_encode($accountNeeds->toArray()) !!};
    account_types = {!! json_encode($account_types->toArray()) !!};
    startupservice_types = {!! json_encode($startupservice_types->toArray()) !!};
</script>
<div class="container">
    <div id="need-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h2>{{__('Life cycle')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <div class="main-section pt-3 pb-2 row">
                    <div class="startup_states col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <h6>{{__('Specify the stage of the life cycle that your startup goes through')}}</h6>
                        <div v-for="startupState in startupStates" class="startup_state form-check pl-0">
                            <div class="info">
                                <button :aria-label="lang==1?startupState.description_en:startupState.description" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                <i class="fas fa-info-circle"></i>
                                {{--<span class="info-message">@{{startupState.description}}</span> --}}
                            </div>
                            <input :id="'state' + startupState.id" type="radio" name="startup_status_id" :value="startupState.id"
                            :checked="account.startup_status_id
                            ==startupState.id" v-model="startup_state">
                            <label :for="'state' + startupState.id">@{{startupState.name}}
                            </label>
                        </div>
                        <div class="advice" v-if="startup_state==1
                        || startup_state==4
                        || startup_state==5">
                            <span class="mini-txt">{{__('Recommendations for the selected phase')}}</span>
                            <ul>
                                <li v-if="startup_state==1">{{__('Notices')}}
                                    <div class="info">
                                        <button aria-label="{{__('Public competitions that allow access to funds')}}" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                        {{-- <span class="info-message">Concorsi pubblici che permettono di accedere a fondi</span> --}}
                                    </div>
                                </li>
                                <li v-if="startup_state==4">Family Office
                                    <div class="info">
                                        <button aria-label="{{__('Private funds of large families that make investments in order to diversify their portfolio')}}" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                        {{-- <span class="info-message">Fondi privati di grandi famiglie che effettuano investimenti al fine di diversificare il proprio portfolio</span> --}}
                                    </div>
                                </li>
                                <li v-if="startup_state==5">{{__('Banks')}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="needs col-sm-12 col-md-12 col-lg-6 col-xl-6"
                     {{-- v-if="startup_state!=7" --}}
                    >
                        <h6>{{__('Looking for')}}:</h6>
                        <div v-for="account_type in account_types" v-if="account_type.id!=1 && account_type.id!=7 && account_type.id!=8">
                            <div class="info">
                                <button :aria-label="lang==1?account_type.description_en:account_type.description" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                <i class="fas fa-info-circle"></i>
                                {{-- <span :class="account_type.description.length>500?'info-message-long':'info-message'">
                                    @{{account_type.description}}
                                </span> --}}
                            </div>
                            <input :id="'account_type' + account_type.id" type="checkbox" name="" :value="account_type.id" :checked="account_type.checked" @change="account_type.checked=!account_type.checked">
                            <label :for="'account_type' + account_type.id" class="active" {{--:class="active(account_type.id)"--}}>
                            @{{lang==1?account_type.name_en:account_type.name}}
                                <span v-if="active(account_type.id)=='active'" class="mini-txt">
                                    {{__('Recommended')}}
                                    {{-- @{{active(account_type.id)=='active'?'Consigliato':''}} --}}
                                </span>
                            </label>
                            <div v-if="account_type.id==2 && account_type.checked" class="">
                                <ul>
                                    <li v-for="cofounder in cofounders" class="cofounder">
                                        <i class="fas fa-user-tie"></i>
                                        <span>@{{cofounder.name}}</span>
                                        <a @click="deleteCofounder(cofounder.id)">
                                            <i class="fas fas fa-times"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="search">
                                    <input class="input" type="text" name="" value="" placeholder="{{__('Search Role')}}" v-model="search_role" @keyup.enter="searchRole()" v-on:input="searchRole()">
                                    <div  :class="roles_found?'found':'found d-none'">
                                        <p class="item" v-for="role_found in roles_found">@{{role_found.name}}
                                            <button type="button" name="button" @click="addCofounder(role_found.id)">{{__('Add')}}</button>
                                        </p>
                                        <p class="item" v-if="roles_found.length==0 && search_role">{{__('No role found')}}
                                            "@{{search_role}}"
                                            <button type="button" name="button" @click="createRole()">{{__('Create')}}</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="startup-services">
                            <button @click="show_ss_types=!show_ss_types" id="ss_button"
                            :class="!show_ss_types?'fas fa-plus-circle':'fas fa-minus-circle'"></button>
                            <label class="active" for="ss_button">{{__('Startup Services')}}</label>
                            <div v-if="show_ss_types" v-for="ss_type in startupservice_types" class="startup-services-item">
                                <input :id="'ss_types' + ss_type.id"
                                type="checkbox" name="" :value="ss_type.id"
                                :checked="ss_type.checked"
                                @change="ss_type.checked=!ss_type.checked">
                                <label :for="'ss_types' + ss_type.id" class="active">@{{lang==1?ss_type.name_en:ss_type.name}}
                                    <div v-if="ss_type.description" class="info">
                                        <button :aria-label="lang==1?ss_type.description_en:ss_type.description" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                        {{-- <span class="info-message">@{{ss_type.description}}</span> --}}
                                    </div>
                                    <span v-if="active_ss(ss_type.id)=='active'" class="mini-txt">
                                            {{__('Recommended')}}
                                        {{-- @{{active_ss(ss_type.id)=='active'?'Consigliato':''}} --}}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="needs">
                        <h6>In cerca di:</h6>
                        <div v-for="need in needs" v-if="">
                            <input type="checkbox" name="needs_id[]" :value="need.id" :checked="need.checked" @change="need.checked=!need.checked">
                            <label :class="need.startup_state_id==startup_state?'active':''">
                            @{{need.account_type_id!=7?need.name:need.startupservice_type_name}}
                            </label>
                            <div v-if="need.need_id==1 && need.checked" class="">
                                <ul>
                                    <li v-for="cofounder in cofounders" class="cofounder">
                                        <i class="fas fa-user-tie"></i>
                                        <span>@{{cofounder.name}}</span>
                                        <a @click="deleteCofounder(cofounder.id)">
                                            <i class="fas fas fa-times"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="search">
                                    <input class="input" type="text" name="" value="" placeholder="Cerca Ruolo" v-model="search_role" @keyup.enter="searchRole()" v-on:input="searchRole()">
                                    <div  :class="roles_found?'found':'found d-none'">
                                        <p class="item" v-for="role_found in roles_found">@{{role_found.name}}
                                            <button type="button" name="button" @click="addCofounder(role_found.id)">Aggiungi</button>
                                        </p>
                                        <p class="item" v-if="roles_found.length==0 && search_role">Nessun ruolo trovato con
                                            "@{{search_role}}"
                                            <button type="button" name="button" @click="createRole()">Crea</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <button @click="updateNeed()" class="button-style button-color">
                    {{__('Save Changes')}}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

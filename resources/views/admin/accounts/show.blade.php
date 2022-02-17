@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    is_my_account = "{{(Auth::user()->id==$account->user_id)?true:false}}";
    my_account_selected = "{{$my_account_selected}}";
    account_type_id = "{{$account->account_type_id}}";
    account = {!! json_encode($account->toArray()) !!};
    my_accounts_id = {!! json_encode($my_accounts_id->toArray()) !!};
    team_members = {!! json_encode($team_members->toArray()) !!};
    team_num = "{{$team_num}}";
    multipleSections = {!! json_encode($multipleSections->toArray()) !!};
    startup_states = {!! json_encode($startupStates->toArray()) !!};
    lang = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="account-show">
        <div :class="delete_alert?'delete-alert active-alert':'delete-alert deactive-alert'" v-cloak>
            <div class="item-cont delete-alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="rejectDelete()">
                        <i class="fas fa-times"></i>
                    </button>
                    <h3 class="p-2 pt-4">@{{delete_alert_message}}</h3>
                    <div class="">
                        <button type="button" name="button" class="button-style button-color mr-5" @click="rejectDelete()">
                            {{__('Cancel')}}
                        <button class="button-style button-color-red ml-5" type="submit" name="button" @click="confirmDelete()">
                            <i class="fas fa-trash-alt mr-1"></i>{{__('Proceed')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style item-no-padding">
                <a v-if="is_my_account" class="edit-bottom-right button-color-gray" href="{{route('admin.accounts.edit', $account->id)}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <div class="profile">
                    {{-- Cover Immagine --}}
                    <div class="profile-cover-cont">
                        <img src="{{ asset("storage/" . $account->cover_image) }}" alt="" class="profile-cover">
                        {{-- Immagine --}}
                        <div class="profile-image">
                            <div class="position-relative w-100 h-100">
                                <img src="{{ asset("storage/" . $account->image) }}" alt="" class="">
                                <a v-if="is_my_account" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.accounts.showImageEditor', $account->id)}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </div>
                        <a v-if="is_my_account" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.accounts.showCoverImageEditor', $account->id)}}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </div>

                    <div class="item-padding">
                        <div class="profile-header row">
                            {{-- Nome --}}
                            <div class="name col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <h2 class="text-capitalize">
                                    {{$account->name}}
                                </h2>
                                <span>
                                {{Auth::user()->language_id==1?
                                $accountType->name_en:$accountType->name}}
                                    @if ($account->account_type_id==7)
                                        @if ($account->private_association==1)
                                            - {{__('Freelancer')}}
                                        @elseif ($account->private_association==2)
                                            - {{__('Company')}}
                                        @else
                                            - {{__('Employee')}}
                                        @endif
                                    @endif
                                </span>
                            </div>

                            <div class="main-buttons col-sm-12 col-md-12 col-lg-6 col-xl-6 pt-3">
                                <div v-if="!is_my_account" class="d-inline-block">
                                    {{-- Follow --}}
                                    <button  :class="already_follow?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="setFollow()">
                                        <span v-if="already_follow">{{__('Following')}}</span>
                                        <span v-else>{{__('Follow')}}</span>
                                    </button>

                                    {{-- Message --}}
                                    <div class="message d-inline-block">
                                        <span v-if="alert"class="mini-txt">@{{alert}}</span>
                                        <button v-else class="button-style button-color-blue" type="button" name="button" @click="sendMessage()">{{__('Message')}}</button>
                                    </div>
                                </div>

                                <div v-if="is_my_account" class="d-inline-block">
                                    <a class="button-style button-color-blue" href="{{route('admin.follows.index')}}">
                                        {{__('Followed')}}
                                    </a>
                                    @if ($account->account_type_id==2)
                                        <a class="button-style button-color-blue" href="{{ route('admin.nominations.cofounder')}}">
                                            {{__('Nominations')}}
                                        </a>
                                    @endif
                                    {{-- <p>Ricorda di aggiungere più informazioni possibili per rendere il tuo profilo più interessante</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="first-sub-section tag-main" v-show="is_my_account || tags.length>0">
                            {{-- Tag --}}
                            <div class="tag-cont">
                                <h6>{{__('Keywords')}}
                                    <div v-if="is_my_account" class="info">
                                        <button aria-label="{{__('Enter keywords related to the activities and the sector you are involved in. In this way your account will appear in correlated searches')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                </h6>
                                <span class="tag text-capitalize" v-for="tag in tags">@{{tag.name}}
                                    <a v-if="is_my_account" @click="deleteTag(tag.id)">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                                <span v-if="tags.length==0">{{__('No Keyword')}}</span>
                            </div>
                            <div v-if="is_my_account" class="search">
                                <input class="input" type="text" name="" value="" placeholder="{{__('Add Keyword')}}" v-model="search_tag" @keyup.enter="searchTag()" v-on:input="searchTag()" minlength="3" maxlength="50">
                                <span class="mini-txt">@{{tag_message}}</span>
                                <div  :class="search_tag?'found':'found d-none'">
                                    <p class="item" v-for="tag_found in tags_found">@{{tag_found.name}}
                                        <button type="button" name="button" @click="addTag(tag_found.id)">{{__('Add')}}</button>
                                    </p>
                                    <p class="item" v-if="search_tag
                                    && !alreadyTagExist()">
                                        <span>@{{search_tag}}</span>
                                        <button type="button" name="button" @click="createTag()">{{__('Create')}}</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Descrizione --}}
                        @if($account->description)
                        <div class="sub-section">
                            {{-- @if ($account->account_type_id==2
                            || $account->account_type_id==4)
                                <h6>Informazioni personali</h6>
                            @else
                                <h6>Descrizione</h6>
                            @endif --}}
                                <h6>{{__('Presentation')}}</h6>
                                <p class="description">{{$account->description}}</p>
                        </div>
                        @endif

                        @if($account->website
                        || $account->linkedin
                        || $account->pitch
                        || $account->roadmap
                        || $account->curriculum_vitae)
                        <div class="sub-section link-cont">
                            {{-- SitoWeb --}}
                            @if($account->website)
                            <div class="link-item">
                                <a class="website" href="{{$account->website}}" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-globe-americas"></i>
                                    <span>{{__('Website')}}</span>
                                </a>
                            </div>
                            @endif

                            {{-- Linkedin --}}
                            @if($account->linkedin)
                            <div class="link-item">
                                <a class="linkedin" href="{{$account->linkedin}}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                    <span>LinkedIn</span>
                                </a>
                            </div>
                            @endif

                            {{-- STURTUP --}}
                            @if ($account->account_type_id==1)
                                {{-- Pitch --}}
                                @if ($account->pitch)
                                    <div class="link-item">
                                        <a class="pitch" href="#" @click="open(account.pitch)">
                                            <i class="far fa-images"></i>
                                            <span>Pitch</span>
                                        </a>
                                    </div>
                                @endif
                                {{-- Roadmap --}}
                                @if ($account->roadmap)
                                <div class="link-item">
                                    <a class="roadmap" href="#" @click="open(account.roadmap)">
                                        <i class="fas fa-route"></i>
                                        <span>Roadmap</span>
                                    </a>
                                </div>
                                @endif
                            @endif

                            {{-- CO-FOUNDER-UTENTE --}}
                            @if ($account->account_type_id==2
                            || $account->account_type_id==7 && $account->private_association==1 || $account->private_association==3)
                                @if ($account->curriculum_vitae)
                                <div class="link-item">
                                    <a class="curriculum_vitae" href="#" @click="open(account.curriculum_vitae)">
                                        <i class="fas fa-address-card"></i>
                                        <span>CV</span>
                                    </a>
                                </div>
                                @endif
                            @endif
                        </div>
                        @endif

                        {{-- INCUBATORE-INVESTITORE --}}
                        @if ($account->account_type_id==3
                            ||$account->account_type_id==4
                            ||$account->account_type_id==5
                            ||$account->account_type_id==6)
                            <div v-if="account.num_startup || account.money" class="sub-section">
                                <div class="row justify-content-center">
                                    <div v-if="account.num_startup" class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <h6>{{__('Amount of')}}
                                            {{-- Quantità di @{{account.account_type_id==3?'startup incubate':'progetti finanziati'}} --}}
                                            <span v-if="account.account_type_id==3" class="font-weight-bold">{{__('startups incubated')}}</span>
                                            <span v-else class="font-weight-bold">{{__('projects funded')}}</span>
                                        </h6>
                                        <h3 class="font-weight-bold">@{{account.num_startup}}</h3>
                                    </div>
                                    <div v-if="account.money" class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <h6>
                                            {{-- Quantità di @{{account.account_type_id==3?' fondi raccolti per le startup incubate':' denaro investito'}} --}}
                                            {{__('Amount of')}}
                                            <span v-if="account.account_type_id==3" class="font-weight-bold">{{__('funds raised for incubated startups')}}</span>
                                            <span v-else class="font-weight-bold">{{__('invested money')}}</span>
                                        </h6>
                                        <h3 class="font-weight-bold"
                                        >@{{account.money}}{{$currencies[$account->currency_id-1]->symbol}}</h3>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- SERVIZI ALLE STARTUP --}}
                        @if ($account->account_type_id==7)
                            {{-- @if ($account->private_association==3 && $company)
                                <div class="sub-section">
                                    <h6>{{__('Company')}}</h6>
                                    <p class="m-0">
                                        {{$company->company_name}}
                                    </p>
                                </div>
                            @endif --}}
                            <div v-if="services.length>0" class="sub-section">
                                <h6>{{__('Offered services')}}</h6>
                                <p class="service mt-1 mb-0" v-for="service in services">
                                    <i class="fas fa-dot-circle"></i>
                                    @{{service.name}}
                                </p>
                            </div>
                        @endif

                        <div class="last-sub-section">

                        @if ($account->account_type_id==1)
                            @if ($account->incorporated)
                                <div class="">
                                    <span>{{__('Incorporated on ')}}{{$account->incorporated}}</span>
                                </div>
                            @endif
                        @endif

                        @if ($account->account_type_id==2
                        || $account->account_type_id==7 && $account->private_association==1 || $account->private_association==3)
                            {{-- Ruolo --}}
                            @if($account->role)
                                <div class="">
                                    <i class="fas fa-user-tie"></i>
                                    <span class="text-capitalize">{{$account->role}}</span>
                                </div>
                            @endif
                        @endif

                        {{-- BUSINESS ANGEL --}}
                        @if ($account->account_type_id==4)
                            @if($account->private_association==1)
                                <span>{{__('Physical person')}}</span>
                            @else
                                <span>{{__('Association')}}</span>
                            @endif
                        @endif

                        {{-- BANDI --}}
                        @if ($account->account_type_id==8)
                            <div class="form-group">
                                <label>{{__('Agency')}}</label>
                                @if($account->nation_region==1)
                                    <span>{{__('National')}}</span>
                                @else
                                    <span>{{__('Regional')}}</span>
                                @endif
                                @if ($account->nation_region==2 && $region)
                                    - {{$region->name}}
                                @endif
                            </div>
                        @endif

                        {{-- P.IVA --}}
                        @if($account->vat_number)
                            @if($account->account_type_id==1
                            && $account->incorporated
                            ||$account->account_type_id==3
                            ||$account->account_type_id==5
                            ||$account->account_type_id==6
                            ||$account->account_type_id==7
                            ||$account->account_type_id==8)
                            <div class="">
                                <span>{{__('VAT number ')}}{{$account->vat_number}}</span>
                            </div>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- In cerca di --}}
        @if ($account->account_type_id==1)
        <div class="item-cont" v-if="is_my_account || account.startup_status_id">
            <div class="item-style">
                <h3>{{__('Life cycle')}}
                    <div v-if="is_my_account" class="info">
                        <button aria-label="{{__('Specify the life cycle\'s stage of your startup')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    {{-- <div class="info">
                        <i class="fas fa-info-circle"></i>
                        <span class="info-message">Specifica la fase del ciclo di vita che attraversa la tua startup</span>
                    </div> --}}
                </h3>
                <a v-if="is_my_account" :href="'/admin/needs/' + account.id +'/edit'" class="edit-top-right button-color-gray">
                    <i :class="account.startup_status_id?'fas fa-pencil-alt':'fas fa-plus-circle'"></i>
                </a>
                {{-- StatoSturtup --}}
                @if($account->startup_status_id)
                {{-- <div class="">
                    <span>Stato Sturtup: {{$startupStates[$account->startup_status_id-1]->name}}</span>
                </div> --}}
                <div class="cicle-container sub-section">
                    <div v-for="state in startup_states" class="pre-seed cicle-item">
                        <div :class="state.id<=account.startup_status_id?
                        'circle c-active':'circle'">
                            <span>@{{state.name}}</span>
                        </div>
                        <span v-if="state.id<startup_states.length" :class="state.id<account.startup_status_id?'n-active net':'net'"></span>
                    </div>
                </div>
                @endif
                <div v-if="needs.length>0" class="needs last-sub-section">
                    <h6>{{__('Looking for')}}</h6>
                    <div v-for="need in needs">
                        <div>
                            <p><i class="fas fa-dot-circle"></i>
                                <span v-if="need.account_type_id!=7">@{{lang==1?need.account_type_name_en:need.account_type_name}}</span>
                                <span v-else>{{__('Service for ' )}}
                                    @{{lang==1?need.startupservice_type_name_en:need.startupservice_type_name}}
                                </span>
                                {{-- @{{need.account_type_id!=7?need.account_type_name
                                :'Servizio per ' + need.startupservice_type_name}} --}}
                            </p>
                            <ul v-if="need.cofounders">
                                <li v-for="cofounder in need.cofounders">
                                    <i class="fas fa-user-tie"></i>
                                    @{{cofounder.name}}
                                    <button v-if="!is_my_account && cofounder.nomination" class="button-style button-color"  @click="sendNomination(cofounder.id)">
                                        <span v-if="cofounder.nomination==1">{{__('Already candidate')}}</span>
                                        <span v-else>{{__('Applicant')}}</span>
                                        {{-- @{{cofounder.nomination==1?'Candidato':'Candidati'}} --}}
                                    </button>
                                </li>
                                <a v-if="is_my_account" class="link-color" href="{{route('admin.nominations.startup',$account->id)}}">{{__('Show nominations')}}</a>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($account->account_type_id==1
        || $account->account_type_id==3
        || $account->account_type_id==7 && $account->private_association==2)
        <div class="item-cont" v-if="is_my_account || team_members.length>0">
            <div class="item-style">
                <h3>Team
                    <div v-if="is_my_account" class="info">
                        <button aria-label="{{__('Add team member')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    {{-- <div class="info">
                        <i class="fas fa-info-circle"></i>
                        <span class="info-message">Aggiungi componente al team</span>
                    </div> --}}
                </h3>
                <div class="row justify-content-center">
                    <div v-for="member in team_members" class="team-member-cont col-sm-12 col-md-6 col-lg-4 col-xl-4" >
                        <div class="team-member sub-item-style">

                            <img :src="'/storage/'+ member.image" alt="">

                            <h6>@{{member.name}}
                                <a v-if="member.linkedin" class="linkedin" :href="member.linkedin" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </h6>
                            <span v-if="member.role">
                                <i class="fas fa-user-tie"></i>
                                @{{member.role}}
                            </span>

                            <div class="description">
                                <span>@{{member.description}}</span>
                            </div>
                            <div v-if="is_my_account" class="edit-top-left-small">
                                <button v-if="member.position!=0" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,-1)">
                                    <i  class="fas fa-sort-up"></i>
                                </button>
                                <button v-if="member.position<team_members.length-1" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,1)">
                                    <i  class="fas fa-sort-down"></i>
                                </button>
                            </div>
                            <div v-if="is_my_account" class="edit-top-right-vert">
                                <a class="button-color-gray" @click="deleteController(1,member.id)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <a :href="'/admin/teams/' + member.id +'/edit'" class="button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="team_num>3" class="text-center d-block w-100 pb-2">
                        <a href="javascript:void(0)" @click="teamToggle()" class="mini-txt">
                            {{-- @{{team_members.length<=3?'Mostra tutto':'Mostra meno'}} --}}
                            <span v-if="team_members.length<=3">{{__('Show all')}}</span>
                            <span v-else>{{__('Show less')}}</span>
                        </a>
                    </div>
                    <div v-if="is_my_account" class="d-flex justify-content-center w-100">
                        <a href="{{route('admin.teams.addMember', $account->id)}}" class="button-color-gray">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="multiple-sections" v-if="multipleSections.length>0">
            <div class="item-cont" v-for="(section,s_index) in multipleSections" v-if="is_my_account || section.others.length>0">
                <div class="item-style">
                    <div class="">
                        <h3 v-show="!section.edit">@{{section.name}}</h3>
                        <div v-show="section.edit" class="">
                            <input class="input" type="text" name="" placeholder="{{__('Section name')}}" v-model="section_name">
                            <button type="button" name="button" class=" button-style button-color" @click="updateMultipleSections(section.id,section.name)">{{__('Save')}}</button>
                        </div>
                        <div v-if="is_my_account" class="edit-top-left-small  z-index">
                            <button v-if="section.position!=0" type="button" name="button" class="button-color-gray" @click="changeMultipleOtherPosition(section.id,-1)">
                                <i  class="fas fa-sort-up"></i>
                            </button>
                            <button v-if="section.position<multipleSections.length-1" type="button" name="button" class="button-color-gray" @click="changeMultipleOtherPosition(section.id,1)">
                                <i  class="fas fa-sort-down"></i>
                            </button>
                        </div>
                        <div v-if="is_my_account" class="edit-top-right d-flex">
                            <a v-if="section.edit==false" @click="changename(s_index,section.name)"
                            class=" button-color-gray mr-1">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a v-else @click="section.edit=false"
                            class="button-color-gray mr-1">
                                <i class="fas fa-times-circle"></i>
                            </a>
                            <a @click="deleteController(2,section.id)" class="button-color-gray" >
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                    <div v-for="other in section.others" class="sub-item-cont">
                        <div :class="other.image?'sub-item-style other-with-image row':'sub-item-style row'">
                            <div v-if="is_my_account" class="edit-top-left-small  z-index">
                                <button v-if="other.position!=0" type="button" name="button" class="button-color-gray">
                                    <i class="fas fa-sort-up" @click="changeOtherPosition(section.id,other.id,-1)"></i>
                                </button>
                                <button
                                v-if="other.position<section.others.length-1" type="button" name="button" class="button-color-gray">
                                    <i class="fas fa-sort-down" @click="changeOtherPosition(section.id,other.id,1)"></i>
                                </button>
                            </div>
                            <div v-if="is_my_account" class="edit-top-right-small z-index d-flex">
                                <a :href="'/admin/others/' + other.id +'/edit'" class="button-color-gray mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a @click="deleteController(3,{other_id:other.id,section_id:section.id})" class="button-color-gray">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                            <div v-if="other.image" class="img-cont col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <img v-if="other.image" :src="'/storage/'+ other.image" alt="" class="">
                            </div>
                            <div :class="other.image?'other-text col-sm-12 col-md-12 col-lg-6 col-xl-6':'other-text'">
                                <h4>@{{other.title}}</h4>
                                <h5 v-if="other.sub_title">
                                    @{{other.sub_title}}
                                </h5>
                                <span v-if="other.description">
                                    @{{other.description}}
                                </span>
                                <a v-if="other.link" class="" :href="other.link" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="section.other_num>1" class="text-center d-block w-100 pb-2">
                        <a href="javascript:void(0)" @click="otherToggle(section.id,section.others.length<=1?'open':'closed')" class="mini-txt">
                            {{-- @{{section.others.length<=1?'Mostra tutto':'Mostra meno'}} --}}
                            <span v-if="section.others.length<=1">{{__('Show all')}}</span>
                            <span v-else>{{__('Show less')}}</span>
                        </a>
                    </div>
                    <div v-if="is_my_account" class="d-flex justify-content-center">
                        <a :href="'/admin/addOther/' + section.id" class="button-color-gray">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont" v-if="is_my_account">
            <div class="item-style">
                <h3 v-if="!openMultipleSection">{{__('New section')}}
                    <div class="info">
                        <button v-if="is_my_account" aria-label="{{__('You can use this section to enter any type of information you want in order to customize your profile and stand out from others. Set a name for the section and add as much content as you want.')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    {{-- <div class="info">
                        <i class="fas fa-info-circle"></i>
                        <span class="info-message">Puoi utilizzare questa sezione per inserire qualunque tipo di informazione desideri in modo da personalizzare il tuo profilo e distinguerti dagli altri!
                        <span class="d-block">Imposta un nome alla sezione e aggiungi tutti i contenuti che vuoi.</span>
                        </span>
                    </div> --}}
                </h3>
                <div v-else>
                    <input type="text" name="" value="" placeholder="{{__('Section name')}}" v-model="section_name" class="input">
                    <button type="button" name="button" @click="addMultipleSection()" class=" button-style
                    button-color">{{__('Save')}}</button>
                </div>
                <div class="d-flex justify-content-center">
                    <button @click="openMultipleSection=!openMultipleSection"
                    class="button-color-gray">
                        <i :class="openMultipleSection?
                            'fas fa-times-circle'
                            :'fas fa-plus-circle'"></i>
                    </button>
                </div>
            </div>
        </div>
        {{-- Collaborazioni--}}
        {{-- @if ($account->account_type_id!=8) --}}
        <div class="item-cont cooperations" v-if="is_my_account || cooperations.length>0">
            <div class="item-style">
                <h3>
                    {{__('Collaborations')}}
                    <div v-if="is_my_account" class="info">
                        <button aria-label="{{__('Use this section to enter collaborations with other accounts on the platform')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    {{-- <div class="info">
                        <i class="fas fa-info-circle"></i>
                        <span class="info-message">Utilizza questa sezione per inserire collaborazioni con altri account presenti in piattaforma</span>
                    </div> --}}
                </h3>
                <div v-if="is_my_account" class="search-cooperations search">
                    <input class="input" type="text" name="" value="" placeholder="{{__('Search account')}}" v-model="cooperation_name" @keyup.enter="searchCooperation()" v-on:input="searchCooperation()">
                    <div  :class="cooperations_found?'found':'found d-none'">
                        <p class="item" v-for="cooperation in cooperations_found">
                            <a :href="'/admin/accounts/' + cooperation.id">@{{cooperation.name}}</a>
                            <button type="button" name="button" @click="addCooperation(cooperation.id)">{{__('Add')}}</button>
                        </p>
                        <p class="item" v-if="cooperations_found.length==0 && cooperation_name">{{__('No accounts found with ')}}
                            "@{{cooperation_name}}"
                        </p>
                    </div>
                </div>
                <div v-for="cooperation in cooperations"
                class="sub-item-cont cooperation-item col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="sub-item-style">
                        <img :src="'/storage/'+ cooperation.image" alt="">
                        <h6 class="text-capitalize">@{{cooperation.name}}</h6>
                        <div class="buttons-cont edit-top-right-vert">
                            <button v-if="is_my_account" @click="deleteController(4,cooperation.id)" class="button-color-gray">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <a :href="'/admin/accounts/'+cooperation.id" class="button-color-gray">
                                <i class="far fa-eye"></i>
                            </a>
                        </div>
                        <button v-if="is_my_startup(cooperation.id) && !cooperation.confirmed" class="button-style button-color edit-top-left-small" type="button" name="button" @click="confirmCooperation(cooperation.id)">{{__('Confirm')}}</button>
                        <span v-else-if="cooperation.confirmed">
                            <i class="fas fa-check"></i>
                            {{__('Verified')}}
                        </span>
                        {{-- <span v-else>
                        </span> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- @endif --}}
        {{-- Contatti --}}
        <div class="item-cont"
        v-if="is_my_account || account.street || account.city || account.region_id || account.state_id || account.email || account.phone_number">
            <div class="item-style">
                <h3>{{__('Contacts')}}</h3>
                <a v-if="is_my_account" class="edit-top-right button-color-gray" href="{{route('admin.accounts.edit', $account->id)}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <div class="contacts">
                    @if ($account->street
                    || $account->civic
                    || $account->city
                    || $account->region_id
                    || $account->state_id)
                        <div class="">
                            <span>
                                <i class="fas fa-map-marker-alt"></i>
                                @if($account->account_type_id==1
                                && $account->incorporated
                                ||$account->account_type_id==3
                                ||$account->account_type_id==5
                                ||$account->account_type_id==6
                                ||$account->account_type_id==7
                                ||$account->account_type_id==8)
                                    {{$account->street}}
                                    {{$account->civic?' n.':''}}
                                    {{$account->civic}}
                                    {{$account->civic?'-':''}}
                                @endif
                                    {{$account->city}}
                                    {{$account->name?'-':''}}
                                    @if ($region)
                                        {{$region->name}}
                                    @endif
                                {{-- {{$account->state_id?',':''}}
                                {{$account->state_id}}
                                , Italia --}}
                            </span>
                        </div>
                    @endif

                    @if ($account->email)
                        <div class="">
                            <span>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{$account->email}}">{{$account->email}}</a>
                            </span>
                        </div>
                    @endif

                    @if ($account->phone_number)
                        <div class="">
                            <span>
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{$account->phone_number}}">{{$account->phone_number}}</a>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

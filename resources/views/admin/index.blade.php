@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="index">
  RICERCA
    {{-- <div class="container" v-if="my_accounts.length==0" v-cloak>
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
            <a class="item col-sm-12 col-md-6 col-lg-6 col-xl-6" href="{{ route('admin.accounts.create') }}">{{__('Start')}}</a>
        </div>
    </div> --}}
    {{-- <div class="background">
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
                        <div class="search-style search-style-hover col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <select class=""
                            v-model="region_selected">
                                <option value="">{{__('All regions')}}</option>
                                <option v-for="region in regions" :value="region.id">@{{region.name}}</option>
                            </select>
                        </div>
                        <div class="search-style search-style-hover col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <div class="tag-search">
                                <input type="text" name="" value="" placeholder="{{__('Keywords')}}" v-model="search_tag" @keyup.enter="searchTag()" v-on:input="searchTag()">
                                <div  :class="tags_found?'tag-found':'tag-found d-none'">
                                    <p class="item text-capitalize" v-for="tag_found in tags_found">@{{tag_found.name}}
                                        <button type="button" name="button" @click="addTag(tag_found)">{{__('Add')}}</button>
                                    </p>
                                    <p  class="item" v-if="tags_found.length==0 && search_tag">{{__('Keyword not found')}}</p>
                                </div>
                                <div class="placeholder-info">
                                    <button aria-label="{{__('Search here for activity carried out, sector to which it belongs and much more')}}" data-microtip-position="top-left" data-microtip-size="medium" role="tooltip">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </div>
                            <div class="">
                                <span class="tag" v-for="(tag,index) in tags">@{{tag.name}}
                                    <a @click="deleteTag(index)" href="#">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
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
    <div class="top-accounts pt-4 container">
        <h3 class="section-title">
            <b></b>
            <span class="text-uppercase">{{__('network')}}</span>
            <b></b>
         </h3>
        <h5 class="text-center">
            {{__('they are already part of our network')}}
        </h5>
        <div class="row justify-content-center">
            <div class="item-cont col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a class="item-style p-0 hover-scale" href="{{ route('admin.accounts.show', ['account'=> 8])}}">
                    <div class="img-cont">
                        <img src="/storage/network/andreina-serena-romano.jpg" alt="">
                    </div>
                    <div class="a-info">
                        <h6>Andreina Serena Romano</h6>
                        <p class="description">
                            {{__('Businesswoman, Innovation Manager and Made in Italy expert. Mentor and Startup advisor. CEO and Founder of Heroes S.r.l., Co-founder of Growpla, founder of ATOMICA and TWILO. Member of the Advisory Committee of Potenza of Banca Montepruno, of the Scientific Committee of ANGI and National Vice-president of Confinternational')}}
                        </p>
                    </div>
                </a>
            </div>
            <div class="item-cont col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a class="item-style p-0 hover-scale" href="{{ route('admin.accounts.show', ['account'=> 19])}}">
                    <div class="img-cont">
                        <img src="/storage/network/ivano-deturi.png" alt="">
                    </div>
                    <div class="a-info">
                        <h6>Ivano De Turi</h6>
                        <p class="description">
                            {{__('Researcher and Professor at LUM University, Technical Coordinator of the Start Cup Puglia and Innovation Manager. Awarded as Best Coach of the Need Next Hackathon 2021')}}
                        </p>
                    </div>
                </a>
            </div>
            <div class="item-cont col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a class="item-style p-0 hover-scale" href="{{ route('admin.accounts.show', ['account'=> 11])}}">
                    <div class="img-cont">
                        <img src="/storage/network/simona-miglietta.png" alt="">
                    </div>
                    <div class="a-info">
                        <h6>Simona Miglietta</h6>
                        <p class="description">
                            {{__('Innovation specialist at Intesa Sanpaolo for the territories of Basilicata, Puglia and Molise. Mentor and jury member in various Startup Competitions')}}
                        </p>
                    </div>
                </a>
            </div>
            <div class="item-cont col-sm-12 col-md-6 col-lg-6 col-xl-3">
                <a class="item-style p-0 hover-scale" href="{{ route('admin.accounts.show', ['account'=> 18])}}">
                    <div class="img-cont">
                        <img src="/storage/network/joris-gadaleta.png" alt="">
                    </div>
                    <div class="a-info">
                        <h6>Joris Gadaleta</h6>
                        <p class="description">
                            {{__('Lawyer, Professor at LUM University, Coordinator of the K HUB, Co-founder and Legal Manager of Energy by O.S.C.A.R. S.r.l.')}}
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div> --}}
    {{-- <div v-if="needs.length>0" class="container">
        <h3 class="section-title">
            <b></b>
            <span class="text-uppercase">{{__('needs')}}</span>
            <b></b>
        </h3>
        <!--Carousel Wrapper-->
        <div id="multi-item-example" class="carousel slide carousel-multi-item pb-5 m-n2" data-ride="carousel">

            <!--Controls-->
            <div class="controls-top text-center">
                <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
            </div>
            <!--/.Controls-->

            <!--Indicators-->
            <ol class="carousel-indicators">
                <li v-if="needs.slice(0, 3).length>0" data-target="#multi-item-example" data-slide-to="0" class="active"></li>
                <li v-if="needs.slice(3, 6).length>0" data-target="#multi-item-example" data-slide-to="1"></li>
                <li v-if="needs.slice(6, 9).length>0" data-target="#multi-item-example" data-slide-to="2"></li>
            </ol>
            <!--/.Indicators-->

            <!--Slides-->
            <div class="carousel-inner p-2" role="listbox">
                <!--First slide-->
                <div v-if="needs.slice(0, 3).length>0" class="carousel-item active">
                    <div class="row">
                        <div v-for="need in needs.slice(0, 3)"class="col-md-4 item-cont">
                            <div class="item-style mb-2  need-carousel">
                                <span class="account">@{{need.name}}</span>
                                <span class="need">@{{need.need_name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Second slide-->
                <div v-if="needs.slice(3, 6).length>0" class="carousel-item">
                    <div class="row">
                        <div v-for="need in needs.slice(3, 6)"class="col-md-4 item-cont ">
                            <div class="item-style mb-2 need-carousel">
                                <span class="account">@{{need.name}}</span>
                                <span class="need">@{{need.need_name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Third slide-->
                <div v-if="needs.slice(6, 9).length>0" class="carousel-item">
                    <div class="row">
                        <div v-for="need in needs.slice(6, 9)"class="col-md-4 item-cont">
                            <div class="item-style mb-2  need-carousel">
                                <span class="account">@{{need.name}}</span>
                                <span class="need">@{{need.need_name}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="container">
        <h3 class="section-title">
            <b></b>
            <span class="text-uppercase">{{__('partners')}}</span>
            <b></b>
        </h3>
        <div class="partner row justify-content-center">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                <a href="https://www.lum.it/" target="_blank" class="d-inline-block">
                    <img src="/storage/images/lum-logo.png" alt="">
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                <a href="https://www.goheroes.it/" target="_blank" class="d-inline-block">
                    <img src="/storage/images/heroes-logo.png" alt="">
                </a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 text-center fade-anim fade-right">
                <a href="https://www.viscontilegal.it/" target="_blank" class="d-inline-block">
                    <img src="/storage/images/visconti-logo.png" alt="">
                </a>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="search">
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
                            <select class="" name="" v-model="category_selected" @change="change_category()" required>
                                <option value="">Seleziona un'opzione</option>
                                <option value="1">{{$pagetypes[0]->name}}</option>
                                <option value="2">{{$usertypes[0]->name}}</option>
                                <option value="3">{{$pagetypes[2]->name}}</option>
                                <option value="4">Investitori</option>
                                <option value="5">Enti e associazioni</option>
                                <option value="6">Servizi</option>
                            </select>
                        </div>
                        {{-- startup --}}
                        <div v-if="pagetype_id==1" class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <select class="" name="lifecycle_id">
                                    <option value="">Tutte le fasi</option>
                                @foreach ($lifecycles as $lifecycle)
                                    <option class="text-capitalize" value="{{$lifecycle->id}}">{{$lifecycle->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div v-if="pagetype_id || usertype_id" class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <select class="" name="sector_id">
                                    <option value="">Tutti i settori</option>
                                @foreach ($sectors as $sector)
                                    <option class="text-capitalize" value="{{$sector->id}}">{{$sector->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div v-if="pagetype_id || usertype_id" class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <select class="" name="country_id">
                                    <option value="">Tutto il mondo</option>
                                @foreach ($countries as $country)
                                    <option class="text-capitalize" value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <button class="button-style button-color" type="button" name="button" @click="search()">{{__('Search')}}</button>
                        </div>
                    </div>
                    <div v-else class="search-filter row">
                        <div  class="search-style search-style-hover col-sm-12 col-md-12 col-lg-9 col-xl-9">
                        </div>
                        <div class="search-style col-sm-12 col-md-12 col-lg-3 col-xl-3">
                            <button class="button-style button-color" type="button" name="button" @click="search()">{{__('Search')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

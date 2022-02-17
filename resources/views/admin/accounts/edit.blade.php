@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    account_type_id = "{{$account->account_type_id}}";
    account = {!! json_encode($account->toArray()) !!};
    company = "{{$company}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
    startupStates = {!! json_encode($startupStates->toArray()) !!};
    accountNeeds = {!! json_encode($accountNeeds->toArray()) !!};
</script>
<div class="container">
    <div id="account-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h1 class="text-capitalize">{{$account->name}}</h1>
                        <span class="d-block">{{Auth::user()->language_id?$accountType->name_en:$accountType->name}}</span>
                    </div>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>

                <form ref="editAccount" method="POST" enctype="multipart/form-data" action="{{ route('admin.accounts.update', ['account'=> $account->id]) }}">
                    @csrf
                    @method('PUT')
                    <span class="mini-txt">{{__('Filling in some of the following fields is optional, however a more complete profile has more chance of being viewed by other users')}}</span>
                    {{-- NOME --}}
                    <div class="sub-section">
                        <h6>{{__('Name')}}*</h6>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$account->name) }}" minlength="3" maxlength="70" required autocomplete="name" required>
                        @error('name')
                            <span class="alert alert-danger">
                                {{__($message)}}
                            </span>
                        @enderror
                    </div>
                    @if ($account->private_association==1)
                        <div class="sub-section">
                            <h6>{{__('How do you want to use Growpla?')}}</h6>
                            <div class="form-check">
                                <input id="investor" type="checkbox"
                                 name="investor" value="1" {{$account->investor?'checked':''}} @click="investor?investor=0:investor=1">
                                <label for="investor">{{__('invest')}}</label>
                            </div>
                            <div class="form-check">
                                <input id="p_services" type="checkbox"
                                name="services" value="1" {{$account->services?'checked':''}}  @click="p_services?p_services=0:p_services=1">
                                <label for="p_services">{{__('offer services')}}</label>
                            </div>
                            <div class="form-check">
                                <input id="cofounder" type="checkbox"
                                name="cofounder" value="1" {{$account->cofounder?'checked':''}} @click="cofounder?cofounder=0:cofounder=1">
                                <label for="cofounder">{{__('become co-founder')}}</label>
                            </div>
                        </div>
                    @endif
                    <div v-if="p_services || account.account_type_id==1" class="sub-section" v-cloak>
                        <h6 v-if="p_services">{{__('You are a')}}</h6>
                        <h6 v-if="account.account_type_id==1">{{__('You are a startup')}}</h6>
                        <div class="form-check d-inline-block">
                            <input id="subcategory_1" type="radio" name="subcategory" value="1" @click="subcategory=1" :checked="subcategory==1">
                            <label v-if="p_services" for="subcategory_1">{{__('freelance')}}</label>
                            <label v-if="account.account_type_id==1" for="subcategory_1">{{__('No')}}</label>
                        </div>
                        <div class="form-check d-inline-block">
                            <input id="subcategory_2" type="radio" name="subcategory" value="2" @click="subcategory=2"  :checked="subcategory==2">
                            <label v-if="p_services" for="subcategory_2">{{__('employee')}}</label>
                            <label v-if="account.account_type_id==1" for="subcategory_2">{{__('Yes')}}</label>
                        </div>
                    </div>

                    {{-- Nome Company --}}
                    {{-- freelance=1 employee=2 --}}
                    {{-- Nome Incubatore --}}
                    {{-- company=1 startup=2 --}}
                    <div v-if="subcategory==2" class="sub-section" v-cloak>
                        <h6 v-if="p_services">{{__('Company you work for')}}</h6>
                        <h6 v-if="account.account_type_id==1" >{{__('Incubated by')}}</h6>
                        <div class="search">
                            <input type="text" name="company_name" value="" placeholder="{{$account->account_type_id==1?__('Incubator name'):__('Company name')}}" v-model="search_company" @keyup.enter="searchCompany()" v-on:input="searchCompany()" maxlength="50" class="form-control" autocomplete="off">
                            @error ('company_name')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                            <div :class="companies_found.length>0?'found':'found d-none'">
                                <a class="item" v-for="company_found in companies_found"
                                @click="addCompany(company_found.id)">@{{company_found.company_name}}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- STURTUP --}}
                    @if ($account->account_type_id==1)
                        <div v-if="subcategory==2" v-cloak>
                            {{-- Startup Costituita --}}
                            <div class="sub-section">
                                <h6>{{__('Incorporated startup')}}</h6>
                                <div class="form-check d-inline-block">
                                    <input id="inc_2"
                                    type="radio" name="inc_switch"  @click="incorporated_switch=0" :checked="!incorporated">
                                    <label for="inc_2">{{__('No')}}</label>
                                </div>
                                <div class="form-check d-inline-block">
                                    <input id="inc_1"  type="radio" name="inc_switch" @click="incorporated_switch=1" :checked="incorporated">
                                    <label for="inc_1">{{__('Yes')}}</label>
                                </div>
                                <div v-show="incorporated_switch" class="" v-cloak>
                                    <h6>{{__('Date of constitution')}}</h6>
                                    <input  type="date" name="incorporated" :value="incorporated"
                                    min="" :max="getTodayDate()" class="form-control col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                    @error ('incorporated')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Pitch --}}
                            <div class="sub-section">
                                <h6>Pitch</h6>
                                <div class="edit-image-drag-drop row">
                                    <div v-if="account.pitch" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <embed  src="{{ asset("storage/" . $account->pitch) }}" />
                                        <button type="button" @click="remove_file('pitch')" class="button-style button-color-red edit-top-right">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="drop-zone col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                            <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                        </span>
                                        <input ref="pitch" type="file" class="form-control-file drop-zone__input" name="pitch" accept="application/pdf">
                                        @error ('pitch')
                                            <div class="alert alert-danger">
                                                {{__($message)}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- Roadmap --}}
                            <div class="sub-section">
                                <h6>Roadmap</h6>
                                <div class="edit-image-drag-drop row">
                                    <div v-if="account.roadmap" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <embed src="{{ asset("storage/" . $account->roadmap) }}" />
                                        <button type="button" @click="remove_file('roadmap')" class="button-style button-color-red edit-top-right">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="drop-zone  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                        <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                            <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                        </span>
                                        <input ref="roadmap" type="file" class="form-control-file drop-zone__input" name="roadmap" accept="application/pdf">
                                        @error ('roadmap')
                                            <div class="alert alert-danger">
                                                {{__($message)}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- SERVIZI ALLE STARTUP --}}
                    @if ($account->account_type_id==1
                    || $account->account_type_id==2)
                        <div v-if="p_services || account.account_type_id==1"
                        class="sub-section services" v-cloak>
                            <h6>{{__('Offered services')}}</h6>
                            <p class="service mt-1 mb-0" v-for="service in services" v-cloak>
                                <i class="fas fa-dot-circle"></i>
                                @{{lang==1?service.name_en:service.name}}
                                <a @click="deleteService(service.id)">
                                    <i class="fas fa-times"></i>
                                </a>
                            </p>
                            <select class="form-control " name="startupservice_type_id" v-model="service_selected">
                                <option value="">{{__('Select a service')}}</option>
                                @foreach ($allStartupserviceTypes as $type)
                                    <option value="{{$type->id}}">
                                        {{Auth::user()->language_id==1?$type->name_en:$type->name}}
                                    </option>
                                @endforeach
                            </select>
                            <button  v-if="service_selected" type="button" name="button" class="button-style button-color" @click="addService()">{{__('Add')}}</button>
                        </div>
                    @endif

                    {{-- INCUBATORE-INVESTITORE --}}
                    <div v-if="investor || account.account_type_id==3 || account.account_type_id==5 || account.account_type_id==6" class="">
                        <div  class="sub-section">
                            <h6>{{__('Amount of')}} {{$account->account_type_id==3?__('startups incubated'):__('projects funded')}}</h6>
                            <input type="number" name="num_startup" class="form-control" min="0" max="100000" :value="account.num_startup">
                            @error ('num_startup')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                        <div class="sub-section">
                            <h6>{{__('Amount of')}} {{$account->account_type_id==3?__('funds raised for incubated startups'):__('invested money')}}</h6>
                            <div class="row">
                                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 mb-1">
                                    <input type="number" name="money" class="form-control" min="0" max="100000000000" :value="account.money">
                                    @error ('money')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 mb-1">
                                    <select class="form-control" name="currency_id">
                                        @foreach ($currencies as $currency)
                                            <option value="{{$currency->id}}"
                                            {{$currency->id == old('currency_id', $account->currency_id) ? 'selected=selected' : '' }}
                                            >
                                                {{$currency->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CO-FOUNDER-UTENTE --}}
                    @if ($account->private_association==1)
                    <div v-if="p_services || cofounder " class="role sub-section" v-cloak>
                        <h6>
                            {{__('Sector')}}*
                        </h6>
                        <div class="search">
                            <input type="text" name="role" value="{{ old('role',$account->role)}}" placeholder="" v-model="search_role" @keyup.enter="searchRole()" v-on:input="searchRole()" maxlength="50" class="form-control" autocomplete="off" required>
                            <div :class="roles_found.length>0?'found':'found d-none'">
                                <a class="item" v-for="role_found in roles_found"
                                @click="addRole(role_found.id)">@{{role_found.name}}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ENTE --}}
                    @if ($account->account_type_id==7)
                        <div class="sub-section">
                            <h6>{{__('You work for')}}</h6>
                                <div class="form-check d-inline-block">
                                    <input id="n_r_1" type="radio"
                                    v-model="nation_region" name="nation_region" value="1"
                                     {{ $account->nation_region==1? 'checked=checked' : '' }}>
                                    <label for="n_r_1">{{__('National')}}</label>
                                </div>
                                <div class="form-check d-inline-block">
                                    <input id="n_r_2" type="radio"
                                    v-model="nation_region" name="nation_region" value="2"
                                     {{ $account->nation_region==2? 'checked=checked' : '' }}>
                                    <label for="n_r_2">{{__('Regional')}}</label>
                                </div>
                            @error ('nation_region')
                                <div class="alert alert-danger">
                                    {{__($message)}}
                                </div>
                            @enderror
                        </div>
                    @endif
                    {{-- Altro --}}
                    {{-- Descrizione --}}
                    <div class="sub-section">
                        <h6>{{__('Presentation')}}*</h6>
                        <textarea name="description" rows="8" cols="80" class="form-control" placeholder="{{__('Write something about what you do')}}" min="50" required>{{ $account->description }}</textarea>
                        @error ('description')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- P.IVA --}}
                    @if($account->private_association==2)
                    <div v-if="subcategory==1"
                        class="sub-section">
                        <h6>{{__('VAT number ')}}</h6>
                        <input type="text" name="vat_number" class="form-control" maxlength="30" value="{{ old('vat_number',$account->vat_number)}}">
                        @error ('vat_number')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                    @endif

                    {{-- COFOUNDER --}}
                    @if ($account->private_association==1)
                        <div class="sub-section">
                            <h6>Curriculum Vitae</h6>
                            <div class="edit-image-drag-drop row">
                                <div v-if="account.curriculum_vitae" class="file-cont  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <embed src="{{ asset("storage/" . $account->curriculum_vitae) }}" />
                                    <button type="button" @click="remove_file('cv')" class="button-style button-color-red edit-top-right">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="drop-zone  col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-2">
                                    <span class="drop-zone__prompt">{{__('Drop file here or click to upload')}}
                                        <span class="mini-txt d-block">{{__('Supported formats')}} .pdf max:6Mb</span>
                                    </span>
                                    <input ref="curriculum_vitae" type="file" class="form-control-file drop-zone__input" name="curriculum_vitae" accept="application/pdf">
                                    @error ('curriculum_vitae')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    {{-- SitoWeb --}}
                    <div class="sub-section">
                        <h6>{{__('Website')}} <span>({{__('enter the URL of your web page')}})</span></h6>
                        <input type="text" name="website" class="form-control" maxlength="255" value="{{ old('website',$account->website)}}" placeholder="es. https://www.growpla.it">
                        @error ('website')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- Linkedin --}}
                    <div class="sub-section">
                        <h6>LinkedIn <span>({{__('enter your LinkedIn profile URL')}})</span></h6>
                        <input type="text" name="linkedin" class="form-control" maxlength="255" value="{{ old('linkedin',$account->linkedin)}}" placeholder="es. https://www.linkedin.com/in/...">
                        @error ('linkedin')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    {{-- CONTATTI --}}
                    <div class="sub-section">
                        <h6>{{__('Address')}}</h6>
                        <div class="row">
                            <div class="form-sub-group col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <label>{{__('Region')}}</label>
                                <select class="form-control" name="region_id">
                                        <option value="">
                                            {{__('Select a region')}}
                                        </option>
                                    @foreach ($regions as $region)
                                        <option value="{{$region->id}}"
                                        {{$region->id == old('region_id', $account->region_id) ? 'selected=selected' : '' }}
                                        >
                                            {{$region->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-sub-group col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <label>{{__('City')}}</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city',$account->city)}}">
                                @error ('city')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            @if($account->private_association==2)
                            <div v-if="subcategory==1" class="form-sub-group col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <label>{{__('Street')}}</label>
                                <input type="text" name="street" class="form-control" value="{{ old('street',$account->street)}}">
                                @error ('street')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            <div v-if="subcategory==1" class="form-sub-group col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                <label>{{__('Street number')}}</label>
                                <input type="text" name="civic" class="form-control" value="{{ old('civic',$account->civic)}}">
                                @error ('civic')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            @endif

                            {{-- <div class="form-group">
                                <label>Nazione:</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="state_id">
                                        @foreach ($states as $state)
                                            <option value="{{$state->id}}"
                                            {{$state->id == old('state_id', $account->state_id) ? 'selected=selected' : '' }}
                                            >
                                                {{$state->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="sub-section">
                        <h6>Email</h6>
                        <input type="text" name="email" class="form-control" value="{{ old('email',$account->email)}}">
                        @error ('email')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>
                    <div class="last-sub-section">
                        <h6>{{__('Phone number')}}</h6>
                        <input type="tel" name="phone_number" class="form-control" maxlength="15"
                        value="{{ old('phone_number',$account->phone_number)}}">
                        @error ('phone_number')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="button-style button-color">
                        {{__('Save Changes')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

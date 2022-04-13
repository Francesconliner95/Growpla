@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    id = "{{$user->id}}";
    lang = "{{Auth::user()->language_id}}";
    is_my_user = "{{$is_my_user}}";
    following = "{{Auth::user()->user_following->contains($user)}}";
</script>
<div class="container">
    <div id="user-show">
        <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="">
                        <h6>Seleziona l'account con cui vuoi contattare
                        </h6>
                        <a v-if="list_user.id!=id" href="#" @click="startChat()" class="d-block" v-cloak>
                            <div class="img-cont mini-img">
                                <img v-if="list_user.image" :src="'/storage/' + list_user.image" alt="">
                            </div>
                            @{{list_user.name + ' ' + list_user.surname}}
                        </a>
                        <div v-if="list_pages.length>0" class=""  v-cloak>
                            <a v-for="page in list_pages" href="#" @click="startChat(page.id)" class="d-block">
                                <div class="img-cont mini-img">
                                    <img v-if="page.image" :src="'/storage/'+page.image" alt="">
                                </div>
                                @{{page.name}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <div class="profile">
                    <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.users.edit', $user->id)}}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <div class="row">
                        {{-- Immagine --}}
                        <div class="profile-image col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center">
                            <div class="img-cont big-img position-relative">
                                @if($user->image)
                                  <img src="{{ asset("storage/" . $user->image) }}" alt="" class="">
                                @endif
                                <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editUserImage')}}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                            <div class="row">
                                <h2 class="text-capitalize col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    {{$user->name}} {{$user->surname}}
                                    <a class="button-style-circle button-color-gray" href="{{route('admin.users.create')}}">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </h2>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <a v-if="is_my_user" class="button-style button-color-green" href="{{route('admin.follows.index')}}">
                                        {{count(Auth::user()->user_following)
                                        +count(Auth::user()->page_following)}} Seguiti
                                    </a>
                                    <button v-if="!is_my_user" :class="following?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="toggleFollow({{$user->id}})" v-cloak>
                                        <span v-if="following">{{__('Following')}}</span>
                                        <span v-else>{{__('Follow')}}</span>
                                    </button>
                                    @if(!$is_my_user)
                                    <button class="button-style button-color-blue" type="button" name="button" @click="switchAccounts()">
                                        <span>Messaggio</span>
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="">
                                @foreach ($user->usertypes as $key => $usertype)
                                    <button aria-label="{{$usertype->name_it}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                    @if(in_array ($usertype->id, array(1, 2)))
                                        <div class="micro-img d-inline-block">
                                            <img src="{{ asset("storage/" . $usertype->image) }}" alt="">
                                        </div>
                                    @endif
                                    {{-- @if(in_array ($usertype->id, array(1, 2)))
                                        <span class="text-capitalize font-weight-bold">
                                            {{$usertype->name_it}}
                                        </span>
                                        @if($usertype->id!=2)
                                            <span>|</span>
                                        @endif
                                    @endif --}}
                                @endforeach
                            </div>
                            <div class="address">
                                <span>{{$user->region_id?$user->region->name:''}}</span>
                                <span>{{$user->region_id && $user->municipality?',':''}}</span>
                                <span>{{$user->municipality}}</span>
                            </div>
                            @if($user->summary)
                            <div class="pt-3">
                                <p class="description">{{$user->summary}}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- @if($is_my_user || count($user->sectors)>0)
                <div class="sub-section">
                  <h6>{{__('Sector')}}
                      <a  v-if="is_my_user" class="button-style-circle button-color-gray" href="{{route('admin.users.sectors', $user->id)}}">
                          <i class="fas fa-pencil-alt"></i>
                      </a>
                  </h6>
                  <div class="">
                    @foreach ($user->sectors as $sector)
                      <span class="border-style">{{$sector->name_it}}</span>
                    @endforeach
                  </div>
                </div>
                @endif --}}
                @if($user->website
                || $user->linkedin
                || $user->pitch
                || $user->cv)
                <div class="sub-section link-cont">
                    @if($user->linkedin)
                    <div class="link-item">
                        <a class="linkedin" href="{{$user->linkedin}}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                    @endif
                    @if($user->website)
                    <div class="link-item">
                        <a class="website" href="{{$user->website}}" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe-americas"></i>
                            <span>{{__('Website')}}</span>
                        </a>
                    </div>
                    @endif
                    @if ($user->cv)
                    <div class="link-item">
                        <a class="cv" href="#" @click="open('{{$user->cv}}')">
                            <i class="fas fa-address-card"></i>
                            <span>CV</span>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
                {{-- BUSINESS ANGEL --}}
                @if($user->usertypes->contains(2))
                  @if($is_my_user || $user->startup_n || $user->moneyrange_id)
                  <div class="sub-section">
                      <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.users.businessAngel')}}">
                          <i class="fas fa-pencil-alt"></i>
                      </a>
                      <div class="row justify-content-center">
                          @if($is_my_user || $user->startup_n)
                          <div class="text-center col-sm-12 col-md-6 col-lg-4 col-xl-4">
                              <h6>Quantità di progetti finanziati
                              </h6>
                              <h3 class="font-weight-bold">{{$user->startup_n}}</h3>
                          </div>
                          @endif
                          @if($is_my_user || $user->moneyrange_id)
                          <div class="text-center col-sm-12 col-md-6 col-lg-4 col-xl-4">
                              <h6>Taglio d'investimenti</h6>
                              <h3 class="font-weight-bold">
                                {{$user->moneyrange_id?$user->moneyrange->range:''}} {{$user->currency->symbol}}
                              </h3>
                          </div>
                          @endif
                      </div>
                  </div>
                  @endif
                @endif
                {{-- SERVIZI --}}
                @if($is_my_user || count($user->give_user_services)>0 || count($user->have_user_services)>0)
                <div id="services" class="sub-section">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        @if($is_my_user || count($user->give_user_services)>0)
                            <h6>{{__('Offro')}}
                                <a v-if="is_my_user" href="{{route('admin.give-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </h6>
                            @if(count($user->give_user_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                    @foreach ($user->give_user_services as $service)
                                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class=" d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini card-color-green">
                                                    <div class="text-capitalize text-cont">
                                                        {{$service->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white" id="button-left-1" v-cloak>
                                    <i class="fas fa-caret-left"></i>
                                </button>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right bg-white" id="button-right-1" v-cloak>
                                    <i class="fas fa-caret-right"></i>
                                </button>
                            </div>
                            @endif
                        @endif
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        @if($is_my_user || count($user->have_user_services)>0)
                            <h6>{{__('Cerco')}}
                                <a v-if="is_my_user" href="{{route('admin.have-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </h6>
                            @if(count($user->have_user_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-2">
                                    @foreach ($user->have_user_services as $service)
                                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class=" d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini card-color-blue">
                                                    <div class="text-capitalize text-cont">
                                                        {{$service->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start(2,'left')" @mouseleave="stop(2,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white" id="button-left-2" v-cloak>
                                    <i class="fas fa-caret-left"></i>
                                </button>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start(2,'right')" @mouseleave="stop(2,'right')" @mouseup="stop(2,'right')"class="slider-right bg-white" id="button-right-2" v-cloak>
                                    <i class="fas fa-caret-right"></i>
                                </button>
                            </div>
                            @endif
                        @endif
                        </div>
                    </div>
                </div>
                @endif
                {{-- ASPIRANTE CO-FOUNDER --}}
                {{-- @if($user->usertypes->contains(1)) --}}
                    @if($is_my_user || count($user->give_user_skills)>0)
                    <div class="sub-section">
                      <h6>{{__('Competenze')}}
                        <a v-if="is_my_user" href="{{route('admin.give_user_skills.edit',$user->id)}}" class="edit-top-right button-style-circle button-color-gray">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                      </h6>
                      @foreach ($user->give_user_skills as $skill)
                          <p>{{$skill->name}}</p>
                      @endforeach

                    </div>
                    @endif
                {{-- @endif --}}
                @if($user->description)
                <div class="sub-section">
                  <h6>{{__('Presentation')}}</h6>
                  <p class="description">{{$user->description}}</p>
                </div>
                @endif
                {{-- DIPENDENTE --}}
                @if($user->usertypes->contains(4))
                  @if($is_my_user || count($user->companies)>0)
                  <div class="sub-section">
                      <h6>Aziende per cui lavoro</h6>
                      <div class="row pt-3">
                          @foreach ($user->companies as $company)
                          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                                @if($company->page_id)
                                    <div class="text-center">
                                        <div class="">
                                            <div class="img-cont mini-img">
                                              @if($company->page->image)
                                                <img src="{{ asset("storage/" . $company->page->image) }}" alt="" class="">
                                              @endif
                                            </div>
                                        </div>
                                        <p class="text-dark">
                                            {{$company->page->name}}
                                            @if($company->page->linkedin)
                                              <a class="linkedin" href="{{$company->page->linkedin}}" target="_blank" rel="noopener noreferrer">
                                                  <i class="fab fa-linkedin"></i>
                                              </a>
                                            @endif
                                        </p>
                                        <a href="{{route('admin.pages.show', $company->page->id)}}" class="button-style button-color-green">Visita profilo</a>
                                    </div>
                              @else
                                    <div class="text-center">
                                        <div class="">
                                            <div class="img-cont mini-img">
                                                @if($company->image)
                                                  <img src="{{ asset("storage/" . $company->image) }}" alt="" class="">
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-dark">
                                            {{$company->name}}
                                            @if($company->linkedin)
                                                <a class="linkedin" href="{{$company->linkedin}}" target="_blank" rel="noopener noreferrer">
                                                    <i class="fab fa-linkedin"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                              @endif
                              <a v-if="is_my_user" href="{{route('admin.companies.edit', $company->id)}}" class="edit-top-right button-style-circle button-color-gray">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                          </div>
                          @endforeach
                      </div>
                        <div v-if="is_my_user" class="d-flex justify-content-center w-100">
                            <a href="{{route('admin.companies.create')}}" class="text-dark text-center">
                                <i class="fas fa-plus"></i>
                                <p>Aggiungi azienda per cui lavori</p>
                            </a>
                        </div>
                  </div>
                  @endif
                @endif
            </div>
        </div>
        <div class="sub-section">
            @foreach ($pageTypes  as $key => $pageType)
                @if($user->pageTypes->contains($pageType->id))
                    @if (count($user->pages->where('pagetype_id',$pageType->id))>0 || $is_my_user)
                        <div class="gray-cont">
                            <h3 class="text-capitalize d-flex align-items-center">
                                <div class="img-cont mini-img">
                                    <img src="{{ asset("storage/" . $pageType->image) }}" alt="" class="">
                                </div>
                                <span class="pl-2">{{__($pageType->name_it)}}</span>
                            </h3>
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-{{$key+3}}">
                                    @foreach ($user->pages->where('pagetype_id',$pageType->id)  as $page)
                                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini">
                                                    <a href="{{ route('admin.pages.show', ['page'=> $page->id]) }}" class="">
                                                        <div class="text-cont">
                                                            <div class="img-cont mini-img">
                                                                @if($page->image)
                                                                <img src="{{ asset("storage/" . $page->image) }}" alt="" class="">
                                                                @endif
                                                            </div>
                                                            <span class="d-block text-dark">{{$page->name}}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini">
                                                    <a class="" href="{{ route('admin.pages.newPage', ['pagetype_id'=> $pageType->id]) }}">
                                                        <div class="text-cont  text-dark">
                                                            <i class="fas fa-plus"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start({{$key+3}},'left')" @mouseleave="stop({{$key+3}},'left')" @mouseup="stop({{$key+3}},'left')" class="slider-left" id="button-left-{{$key+3}}" v-cloak>
                                    <i class="fas fa-caret-left"></i>
                                </button>
                                <button v-if="!is_mobile" type="button" name="button" @mousedown="start({{$key+3}},'right')" @mouseleave="stop({{$key+3}},'right')" @mouseup="stop({{$key+3}},'right')"class="slider-right" id="button-right-{{$key+3}}" v-cloak>
                                    <i class="fas fa-caret-right"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        <div v-if="is_my_user || collaborations.length>0" id="collaborations" class="item-cont" v-cloak>
            <div class="item-style">
                <h3 class="text-capitalize">Collaborazioni
                    <div v-if="is_my_user" class="info">
                        <button aria-label="{{__('Use this section to enter collaborations with other accounts on the platform')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <a  v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.collaborations.my', [$user->id,'user'])}}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </h3>
                <div class="main-multi-slider">
                    <div class="multi-slider-cont mini" id="multi-slider-cont-20">
                        <div v-for="collaboration in collaborations" class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="card-style-mini">
                                    <a :href="collaboration.recipient_user_id?
                                    '/admin/users/'+collaboration.account.id
                                    :'/admin/pages/'+collaboration.account.id" class="">
                                        <div class="text-cont">
                                            <div class="img-cont mini-img">
                                              <img
                                              v-if="collaboration.account.image"
                                              :src="'/storage/' +collaboration.account.image" alt="" class="">
                                            </div>
                                            <span class="d-block text-dark">
                                                @{{collaboration.account.name}}
                                                @{{collaboration.account.surname?
                                                collaboration.account.surname:''}}
                                                <i v-if="collaboration.confirmed" class="fas fa-certificate txt-blue"></i>
                                                {{-- @{{collaboration.confirmed?'confermata':''}} --}}
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-3 col-xl-3">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="card-style-mini">
                                    <a class="" href="{{ route('admin.collaborations.create', ['id'=> $user->id,'user_or_page'=> 'user']) }}">
                                        <div class="text-cont text-dark">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button v-if="!is_mobile" type="button" name="button" @mousedown="start(20,'left')" @mouseleave="stop(20,'left')" @mouseup="stop(20,'left')" class="slider-left" id="button-left-20" v-cloak>
                        <i class="fas fa-caret-left"></i>
                    </button>
                    <button v-if="!is_mobile" type="button" name="button" @mousedown="start(20,'right')" @mouseleave="stop(20,'right')" @mouseup="stop(20,'right')"class="slider-right" id="button-right-20" v-cloak>
                        <i class="fas fa-caret-right"></i>
                    </button>
                    <span>@{{this.delay(20)}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

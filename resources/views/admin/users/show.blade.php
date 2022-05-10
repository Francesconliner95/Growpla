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
                        <a v-if="list_user.id!=id" href="#" @click="startChat()" class="" v-cloak>
                            <div class="img-cont mini-img">
                                <img v-if="list_user.image" :src="'/storage/' + list_user.image" alt="">
                            </div>
                            @{{list_user.name + ' ' + list_user.surname}}
                        </a>
                        <div v-if="list_pages.length>0" class=""  v-cloak>
                            <a v-for="page in list_pages" href="#" @click="startChat(page.id)" class="">
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
                    <a v-if="is_my_user" class="edit-top-left button-style-circle button-color-gray pl-1" href="{{route('admin.users.accounts',$user->id)}}" v-cloak>
                        <i class="fas fa-cog"></i>
                    </a>
                    <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.users.edit', $user->id)}}" v-cloak>
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <div class="row">
                        {{-- Immagine --}}
                        <div class="profile-image col-sm-12 col-md-12 col-lg-2 col-xl-2  d-flex justify-content-center align-items-center">
                            <div class="img-cont big-img position-relative">
                                @if($user->image)
                                  <img src="{{ asset("storage/" . $user->image) }}" alt="" class="">
                                @endif
                                <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editUserImage')}}" v-cloak>
                                    <i class="fas fa-pencil-alt"></i>
                                    {{-- <div class="img-cont micro-img">
                                        <img src="{{ asset("storage/images/icon-edit.svg") }}" alt="">
                                    </div> --}}
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                            <h2 class="text-capitalize m-0 d-flex justify-content-start align-items-center pt-1 pb-1">
                                {{$user->name}} {{$user->surname}}
                            </h2>
                            <div class="address pb-1">
                                <span>{{$user->region_id?$user->region->name:''}}</span>
                                <span>{{$user->region_id && $user->municipality?',':''}}</span>
                                <span class="text-capitalize">{{$user->municipality}}</span>
                            </div>
                            <div class="d-flex justify-content-start align-items-center pb-1">
                                @foreach ($user->usertypes as $key => $usertype)
                                    @if(in_array ($usertype->id, array(1, 2, 3)))
                                        <div class="d-inline-block">
                                            <button aria-label="{{$usertype->name_it}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                            <div class="micro-img d-inline-block m-1">
                                                <img src="{{ asset("storage/" . $usertype->image) }}" alt="">
                                            </div>
                                        </div>
                                    @endif
                                    {{-- DIPENDENTE --}}
                                    @if($usertype->id==4)
                                      @if(count($user->companies)<=0)
                                        <div class="d-inline-block">
                                            <button aria-label="{{$usertype->name_it}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                            <div class="micro-img d-inline-block m-1">
                                                <img src="{{ asset("storage/" . $usertype->image) }}" alt="">
                                            </div>
                                        </div>
                                        @if($is_my_user)
                                            <a href="{{route('admin.companies.create')}}" class="text-dark text-center">
                                                <i class="fas fa-plus"></i>
                                                <span>Aggiungi azienda per cui sei dipendente</span>
                                            </a>
                                        @endif
                                      @else
                                          @foreach ($user->companies as $company)
                                                @if($company->page_id)
                                                    <div class="d-inline-block mt-1">
                                                            <button aria-label="dipendente di {{$company->page->name}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                                            <a href="{{route('admin.pages.show', $company->page->id)}}" class="d-inline-block" >
                                                                <div class="img-cont micro-img m-1">
                                                                  @if($company->page->image)
                                                                    <img src="{{ asset("storage/" . $company->page->image) }}" alt="" class="">
                                                                  @endif
                                                                </div>
                                                            </a>
                                                        {{-- @if($company->page->linkedin)
                                                          <a class="linkedin" href="{{$company->page->linkedin}}" target="_blank" rel="noopener noreferrer">
                                                              <i class="fab fa-linkedin"></i>
                                                          </a>
                                                        @endif --}}
                                                    </div>
                                              @else
                                                  <div class="d-inline-block">
                                                      <button aria-label="dipendente di {{$company->name}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                                      <div class="img-cont micro-img">
                                                          @if($company->image)
                                                            <img src="{{ asset("storage/" . $company->image) }}" alt="" class="">
                                                          @endif
                                                      </div>
                                                  </div>
                                              @endif
                                              <a v-if="is_my_user" href="{{route('admin.companies.edit', $company->id)}}" class="button-style-circle button-color-gray">
                                                  <i class="fas fa-pencil-alt"></i>
                                              </a>
                                          @endforeach
                                      @endif
                                      @if($is_my_user && count($user->companies)<0)
                                          <a href="{{route('admin.companies.create')}}" class="text-dark text-center">
                                              <i class="fas fa-plus"></i>
                                              <span>Aggiungi azienda per cui lavori</span>
                                          </a>
                                      @endif
                                    @endif
                                @endforeach
                            </div>
                            @if($user->summary)
                            <div class="pt-2">
                                <p class="description m-0">{{$user->summary}}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
                          <div class="pt-2 text-center">
                              <a v-if="is_my_user" class="button-style button-color-green m-1" href="{{route('admin.follows.index')}}">
                                  {{count(Auth::user()->user_following)
                                  +count(Auth::user()->page_following)}} Seguiti
                              </a>
                              <button v-if="!is_my_user" :class="following?'button-style m-1':'button-style button-color-green m-1'" type="button" name="button" @click="toggleFollow({{$user->id}})" v-cloak>
                                  <span v-if="following">{{__('Following')}}</span>
                                  <span v-else>{{__('Follow')}}</span>
                              </button>
                              @if(!$is_my_user)
                              <button class="button-style button-color-blue m-1" type="button" name="button" @click="switchAccounts()">
                                  <span>Messaggio</span>
                              </button>
                              @endif
                          </div>
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
                        <a class="txt-blue" href="{{$user->linkedin}}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                            <span class="mini-txt font-weight-bold">LinkedIn</span>
                        </a>
                    </div>
                    @endif
                    @if($user->website)
                    <div class="link-item">
                        <a class="txt-green" href="{{$user->website}}" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe-americas"></i>
                            <span class="mini-txt font-weight-bold">{{__('Website')}}</span>
                        </a>
                    </div>
                    @endif
                    @if ($user->cv)
                    <div class="link-item">
                        <a class="txt-blue" href="#" @click="open('{{$user->cv}}')">
                            <i class="fas fa-address-card"></i>
                            <span class="mini-txt font-weight-bold">CV</span>
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
                    <div class="row pb-2 justify-content-between">
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 mb-3">
                        @if($is_my_user || count($user->give_user_services)>0)
                            <h4 class="txt-green font-weight-bold pb-3  d-flex justify-content-start align-items-center">
                                <span class="mr-1">
                                  {{__('Offro')}}
                                </span>
                                <a v-if="is_my_user" href="{{route('admin.give-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </h4>
                            @if(count($user->give_user_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                    @foreach ($user->give_user_services as $service)
                                        <div class="multi-slider-item col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6">
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
                                <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white mobile-hide" id="button-left-1" v-cloak>
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                                    {{-- <i class="fas fa-caret-left"></i> --}}
                                </button>
                                <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right bg-white mobile-hide" id="button-right-1" v-cloak>
                                    {{-- <i class="fas fa-caret-right"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                                </button>
                            </div>
                            @endif
                        @endif
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5  mb-3">
                        @if($is_my_user || count($user->have_user_services)>0)
                            <h4 class="txt-blue font-weight-bold pb-3 d-flex justify-content-start align-items-center">
                                <span class="mr-1">
                                    {{__('Cerco')}}
                                </span>
                                <a v-if="is_my_user" href="{{route('admin.have-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </h4>
                            @if(count($user->have_user_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-2">
                                    @foreach ($user->have_user_services as $service)
                                        <div class="multi-slider-item col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6">
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
                                <button type="button" name="button" @mousedown="start(2,'left')" @mouseleave="stop(2,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white mobile-hide" id="button-left-2" v-cloak>
                                    {{-- <i class="fas fa-caret-left"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                                </button>
                                <button type="button" name="button" @mousedown="start(2,'right')" @mouseleave="stop(2,'right')" @mouseup="stop(2,'right')"class="slider-right bg-white mobile-hide" id="button-right-2" v-cloak>
                                    {{-- <i class="fas fa-caret-right"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
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
                            <div v-if="is_my_user" class="info" v-cloak>
                                <button aria-label="Inserisci competenze correlate a ciò che sai fare (SW utilizzati, linguaggi di programmazione, soft skill, aree di conoscenza e competenza e molto altro)" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        <a v-if="is_my_user" href="{{route('admin.give_user_skills.edit',$user->id)}}" class="edit-top-right button-style-circle button-color-gray">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                      </h6>
                      <div class="">
                          @foreach ($user->give_user_skills as $skill)
                            <span class="border-style bg-green txt-green font-weight-bold">{{$skill->name}}</span>
                          @endforeach
                      </div>
                    </div>
                    @endif
                {{-- @endif --}}
                @if($user->usertypes->contains(1)
                || $user->usertypes->contains(5))
                    @if($is_my_user || count($user->backgrounds)>0)
                    <div class="sub-section">
                      <h6>Formazione
                        <a v-if="is_my_user" href="{{route('admin.users.background', $user->id)}}" class="edit-top-right button-style-circle button-color-gray">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                      </h6>
                      <div class="">
                          @foreach ($user->backgrounds as $background)
                            <span class="border-style bg-blue txt-green font-weight-bold">{{$background->name}}</span>
                          @endforeach
                      </div>
                    </div>
                    @endif
                @endif
                @if($user->description)
                <div class="sub-section">
                  <h6>{{__('Presentation')}}</h6>
                  <p class="description">{{$user->description}}</p>
                </div>
                @endif
            </div>
        </div>
        @if(count($user->pages)>0)
        <div class="sub-section">
            @foreach ($pageTypes  as $key => $pageType)
                @if($user->pageTypes->contains($pageType->id))
                    @if (count($user->pages->where('pagetype_id',$pageType->id))>0 || $is_my_user)
                        <div class="gray-cont position-relative pt-5">
                            <div class="edit-top-left">
                              <button aria-label="{{__($pageType->name_it)}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                              <div class="img-cont mini-img">
                                  <img src="{{ asset("storage/" . $pageType->image) }}" alt="" class="">
                              </div>
                            </div>
                            <div class="main-multi-slider d-flex justify-content-center">
                                <div class="multi-slider-cont mini col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10" id="multi-slider-cont-{{$key+3}}">
                                    @foreach ($user->pages->where('pagetype_id',$pageType->id)  as $page)
                                        <div class="multi-slider-item col-8 col-sm-8 col-md-8 col-lg-6 col-xl-6">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini">
                                                    <a href="{{ route('admin.pages.show', ['page'=> $page->id]) }}" class="">
                                                        <div class="text-cont">
                                                            <div class="img-cont small-img">
                                                                @if($page->image)
                                                                <img src="{{ asset("storage/" . $page->image) }}" alt="" class="scale">
                                                                @endif
                                                            </div>
                                                            <span class="d-block text-dark text-truncate text-capitalize">{{$page->name}}</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                        <div v-if="is_my_user" class="multi-slider-item col-sm-12 col-md-6 col-lg-4 col-xl-4" v-cloak>
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <div class="card-style-mini">
                                                    <a class="" href="{{ route('admin.pages.newPage', ['pagetype_id'=> $pageType->id]) }}">
                                                        <div class="text-cont  text-dark">
                                                            <i class="fas fa-plus scale"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <button type="button" name="button" @mousedown="start({{$key+3}},'left')" @mouseleave="stop({{$key+3}},'left')" @mouseup="stop({{$key+3}},'left')" class="slider-left mobile-hide" id="button-left-{{$key+3}}" v-cloak>
                                    {{-- <i class="fas fa-caret-left"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                                </button>
                                <button type="button" name="button" @mousedown="start({{$key+3}},'right')" @mouseleave="stop({{$key+3}},'right')" @mouseup="stop({{$key+3}},'right')"class="slider-right  mobile-hide" id="button-right-{{$key+3}}" v-cloak>
                                    {{-- <i class="fas fa-caret-right"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                                </button>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        </div>
        @endif
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
                    <div class="multi-slider-cont" id="multi-slider-cont-20" style="height: 160px;">
                        <div v-for="collaboration in collaborations" class="multi-slider-item col-8 col-sm-5 col-md-5 col-lg-3 col-xl-3">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="card-style-mini">
                                    <a :href="collaboration.recipient_user_id?
                                    '/admin/users/'+collaboration.account.id
                                    :'/admin/pages/'+collaboration.account.id" class="d-inline-block">
                                        <div class="text-cont">
                                            <div class="img-cont medium-img mt-2">
                                              <img
                                              v-if="collaboration.account.image"
                                              :src="'/storage/' +collaboration.account.image" alt="" class="scale">
                                            </div>
                                            <span class="d-block text-dark">
                                                @{{collaboration.account.name}}
                                                @{{collaboration.account.surname?
                                                collaboration.account.surname:''}}
                                                <div  v-if="collaboration.confirmed"
                                                 class="d-inline-block">
                                                    <button aria-label="Collaborazione verificata" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                                    <i class="fas fa-certificate txt-blue"></i>
                                                </div>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" name="button" @mousedown="start(20,'left')" @mouseleave="stop(20,'left')" @mouseup="stop(20,'left')" class="slider-left mobile-hide" id="button-left-20" v-cloak>
                        {{-- <span class="arrow-black r-180"></span> --}}
                        {{-- <i class="fas fa-caret-left"></i> --}}
                        <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                    </button>
                    <button type="button" name="button" @mousedown="start(20,'right')" @mouseleave="stop(20,'right')" @mouseup="stop(20,'right')"class="slider-right mobile-hide" id="button-right-20" v-cloak>
                        {{-- <i class="fas fa-caret-right"></i> --}}
                        <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                    </button>
                    <span>@{{this.delay(20)}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

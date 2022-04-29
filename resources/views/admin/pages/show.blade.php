@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    page = "{{$page}}";
    id = "{{$page->id}}";
    is_my_page = "{{$is_my_page}}";
    team_members = "{{$team_members}}";
    team_num = "{{$team_num}}";
    following = "{{Auth::user()->page_following->contains($page)}}";
</script>
<div class="container">
    <div id="page-show">
        <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-color-gray" @click="alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="">
                        <h6>Seleziona l'account con cui vuoi contattare</h6>
                        <a v-if="list_user.id" href="#" @click="startChat()" class="d-block" v-cloak>
                            <div class="img-cont mini-img">
                                <img v-if="list_user.image" :src="'/storage/' + list_user.image" alt="">
                            </div>
                            @{{list_user.name + ' ' + list_user.surname}}
                        </a>
                        <a v-for="page in list_pages"
                        v-if="page.id!=id" href="#" @click="startChat(page.id)" class="d-block" v-cloak>
                            <div class="img-cont mini-img">
                                <img v-if="page.image" :src="'/storage/'+page.image" alt="">
                            </div>
                            @{{page.name}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                <div class="profile">
                    <a v-if="is_my_page" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.pages.edit', $page->id)}}" v-cloak>
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <div class="row">
                        {{-- Immagine --}}
                        <div class="profile-image col-sm-12 col-md-12 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
                            <div class="img-cont big-img position-relative">
                                @if($page->image)
                                  <img src="{{ asset("storage/" . $page->image) }}" alt="" class="">
                                @endif
                                <a v-if="is_my_page" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editPageImage',$page->id)}}" v-cloak>
                                    <i class="fas fa-pencil-alt"></i>
                                 </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                            <h2 class="text-capitalize d-flex align-items-center">
                                {{$page->name}}
                                <a v-if="is_my_page" class="button-style-circle button-color-gray ml-1" href="{{route('admin.pages.settings', $page->id)}}">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </h2>
                            <div class="">
                                <div class="d-inline-block pr-2">
                                    <button aria-label="{{$page->pagetype->name_it}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                    <div class="micro-img d-inline-block">
                                        <img src="{{ asset("storage/" . $page->pagetype->image) }}" alt="">
                                    </div>
                                </div>
                                {{-- {{$page->pagetype->image}} --}}
                                @switch($page->pagetype_id)
                                    @case(1){{-- Startup --}}
                                        @if($page->incorporated)
                                            <div class="d-inline-block pr-2 ">
                                                <span class="font-weight-bold mini-txt">Costituita</span>
                                                <i class="fas fa-check-circle txt-blue"></i>
                                            </div>
                                        @endif
                                        @if($page->type_bool_1)
                                            <div class="d-inline-block pr-2">
                                                  <span class="font-weight-bold mini-txt">MVP</span>
                                                  <i class="fas fa-check-circle  txt-blue"></i>
                                            </div>
                                        @endif
                                    @break
                                    @case(2)

                                    @break
                                    @case(3){{-- Incubatore --}}
                                        <div class="d-inline-block pr-2  mini-txt">
                                            <span class="font-weight-bold mini-txt">Tipologia:</span>
                                            @if(!$page->type_bool_1)
                                                <span>Privato</span>
                                            @elseif($page->type_bool_1)
                                                <span>Pubblico</span>
                                            @endif
                                        </div>
                                        <div class="d-inline-block pr-2  mini-txt">
                                            <span class="font-weight-bold mini-txt">Servizi erogati:</span>
                                            @if(!$page->type_int_1)
                                                <span>Fisici</span>
                                            @elseif($page->type_int_1==1)
                                                <span>Online</span>
                                            @elseif($page->type_int_1==2)
                                                <span>Ibridi</span>
                                            @endif
                                        </div>
                                    @break
                                @endswitch
                            </div>
                            <div class="address">
                                <span>{{$page->region_id?$page->region->name:''}}</span>
                                <span>{{$page->region_id && $page->municipality?',':''}}</span>
                                <span>{{$page->municipality}}</span>
                                <span>{{$page->municipality && $page->street_name?',':''}}</span>
                                <span>{{$page->municipality && $page->street_name?$page->street_name:''}}</span>
                                <span>{{$page->municipality && $page->street_name && $page->street_number?$page->street_number:''}}</span>
                            </div>
                            @if($page->summary)
                            <div class="pt-3">
                                <p class="description">{{$page->summary}}</p>
                            </div>
                            @endif
                            <div class="d-flex align-items-center">
                                @if(count($page->sectors)>0)
                                    @foreach ($page->sectors as $sector)
                                        <span class="border-style bg-white">{{$sector->name_it}}</span>
                                    @endforeach
                                @endif
                                @if($is_my_page && count($page->sectors)<=0)
                                    <h6 v-if="is_my_page" class="d-inline-block m-0 pr-1">{{__('Sector')}}
                                    </h6>
                                @endif
                                @if($is_my_page)
                                    <a class="button-style-circle button-color-gray" href="{{route('admin.pages.sectors', $page->id)}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
                          <div class="">
                              <button v-if="!is_my_page" :class="following?'button-style m-1':'button-style button-color m-1'" type="button" name="button" @click="toggleFollow({{$page->id}})" v-cloak>
                                  <span v-if="following">{{__('Following')}}</span>
                                  <span v-else>{{__('Follow')}}</span>
                              </button>
                              @if(!$is_my_page)
                              <button class="button-style button-color-blue m-1" type="button" name="button" @click="switchAccounts()">
                                  <span>Messaggio</span>
                              </button>
                              @endif
                          </div>
                        </div>
                    </div>
                </div>
                @if($page->pagetype_id==1)
                    @if($page->lifecycle_id || $is_my_page)
                        <div class="sub-section" id="lifecycle">
                            <h6>{{__('Life cycle')}}
                                <div v-if="is_my_page" class="info">
                                    <button aria-label="{{__('Specify the life cycle\'s stage of your startup')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </h6>
                            <a href="{{route('admin.lifecycles.edit',$page->id)}}" class="button-color-gray edit-top-right">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            {{-- @if($page->lifecycle_id) --}}
                            <div v-if="!is_mobile" class="cicle-container">
                                @foreach ($lifecycles as $lifecycle)
                                  <div class="pre-seed cicle-item">
                                      <div :class="{{$lifecycle->id}}<={{$page->lifecycle_id?$page->lifecycle_id:0}}?
                                      'circle c-active':'circle'">
                                          <span>{{$lifecycle->name}}</span>
                                      </div>
                                      {{-- <span v-if="{{$lifecycle->id}}<{{count($lifecycles)}}"
                                        :class="{{$lifecycle->id}}<{{$page->lifecycle_id?$page->lifecycle_id:0}}?'n-active net':'net'">
                                      </span> --}}
                                  </div>
                                @endforeach
                            </div>
                            @if ($page->lifecycle_id)
                                <div v-else class="cicle-container">
                                    <div class="cicle-item">
                                        <div class="circle c-active">
                                            <span>{{$page->lifecycle->name}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- @endif --}}
                        </div>
                    @endif
                @endif
                @if($page->description)
                <div class="sub-section">
                    <h6>{{__('Presentation')}}</h6>
                    <p class="description">{{$page->description}}</p>
                </div>
                @endif
                @if($page->website
                || $page->linkedin
                || $page->pitch)
                <div class="sub-section link-cont">

                    {{-- Linkedin --}}
                    @if($page->linkedin)
                    <div class="link-item">
                        <a class="txt-blue" href="{{$page->linkedin}}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                            <span class="mini-txt font-weight-bold">LinkedIn</span>
                        </a>
                    </div>
                    @endif
                    {{-- SitoWeb --}}
                    @if($page->website)
                    <div class="link-item">
                        <a class="txt-green" href="{{$page->website}}" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe-americas"></i>
                            <span class="mini-txt font-weight-bold">{{__('Website')}}</span>
                        </a>
                    </div>
                    @endif
                    @if ($page->pitch)
                    <div class="link-item">
                        <a class="txt-blue" href="#" @click="open(page.pitch)">
                            <i class="fas fa-bullhorn"></i>
                            <span class="mini-txt font-weight-bold">Pitch</span>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
                {{-- posso accedere ai servizi solo se la pagina è: startup o azienda --}}
                @if($is_my_page || count($page->give_page_services)>0 || count($page->have_page_services)>0)
                <div id="services" class="sub-section">
                    <div class="row">
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        @if($page->pagetype_id!=1 && $is_my_page || count($page->give_page_services)>0)
                            <h4 class="txt-green font-weight-bold pb-3  d-flex justify-content-start align-items-center">
                              <span class="mr-1">
                                {{__('Offro')}}
                              </span>
                                <a v-if="is_my_page" href="{{route('admin.give-page-services.edit',$page->id)}}" class="button-style-circle button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </h4>
                            @if(count($page->give_page_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-1">
                                    @foreach ($page->give_page_services as $service)
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
                                <button type="button" name="button" @mousedown="start(1,'left')" @mouseleave="stop(1,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white" id="button-left-1" v-cloak>
                                    {{-- <i class="fas fa-caret-left"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                                </button>
                                <button type="button" name="button" @mousedown="start(1,'right')" @mouseleave="stop(1,'right')" @mouseup="stop(1,'right')"class="slider-right bg-white" id="button-right-1" v-cloak>
                                    {{-- <i class="fas fa-caret-right"></i> --}}
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow" alt="">
                                </button>
                            </div>
                            @endif
                        @endif
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2">
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        @if($is_my_page || count($page->have_page_services)>0)
                          <h4 class="txt-blue font-weight-bold pb-3  d-flex justify-content-start align-items-center">
                              <span class="mr-1">
                                  {{__('Cerco')}}
                              </span>
                              <a v-if="is_my_page" href="{{route('admin.have-page-services.edit',$page->id)}}" class="button-style-circle button-color-gray">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                          </h4>
                            @if(count($page->have_page_services)>0)
                            <div class="main-multi-slider">
                                <div class="multi-slider-cont mini" id="multi-slider-cont-2">
          @if($page->pagetype_id==1){{-- IN CASO SONO UNA STARTUP --}}
              @foreach ($page->have_page_pagetypes as $pagetype)
                  <div class="multi-slider-item col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <div class=" d-flex justify-content-center align-items-center h-100">
                          <div class="card-style-mini card-color-blue">
                              <div class="text-capitalize text-cont">
                                  {{$pagetype->name_it}}
                              </div>
                          </div>
                      </div>
                  </div>
              @endforeach
              @foreach ($page->have_page_usertypes as $usertype)
                    @if($usertype->id==1 && $page->have_page_cofounders)
                        @foreach ($page->have_page_cofounders as $i => $service)
                          <div class="multi-slider-item col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="d-flex justify-content-center align-items-center h-100">
                                  <div class="card-style-mini card-color-blue">
                                      <div class="text-capitalize text-cont">
                                      {{$usertype->name_it}}
                                        <span class="mini-txt text-dark">
                                          {{$service->name}}
                                        </span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                        @endforeach
                    @else
                        <div class="multi-slider-item col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class=" d-flex justify-content-center align-items-center h-100">
                                <div class="card-style-mini card-color-blue">
                                    <div class="text-capitalize text-cont">
                                    {{$usertype->name_it}}
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endif
                  @endforeach
              @endif{{--FINE IN CASO SONO UNA STARTUP --}}
                                    @foreach ($page->have_page_services as $service)
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
                                <button type="button" name="button" @mousedown="start(2,'left')" @mouseleave="stop(2,'left')" @mouseup="stop(1,'left')" class="slider-left bg-white" id="button-left-2" v-cloak>
                                    <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                                    {{-- <i class="fas fa-caret-left"></i> --}}
                                </button>
                                <button type="button" name="button" @mousedown="start(2,'right')" @mouseleave="stop(2,'right')" @mouseup="stop(2,'right')"class="slider-right bg-white" id="button-right-2" v-cloak>
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
            </div>
        </div>
        <div class="item-cont sub-section" v-if="is_my_page || team_members.length>0" v-cloak>
            <div class="item-style">
                <h3>Team
                    <div v-if="is_my_page" class="info">
                        <button aria-label="{{__('Add team member')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </h3>
                <div class="row justify-content-center">
                    <div v-for="member in team_members" class="team-member-cont col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2 mb-2" v-cloak>
                        <div class="team-member">
                            <div class="img-cont mini-img">
                                <img v-if="member.image" :src="'/storage/'+ member.image" alt="">
                            </div>
                            <h5 class="name text-capitalize txt-blue font-weight-bold mt-2">@{{member.name}} @{{member.surname}}
                                <a v-if="member.linkedin" class="linkedin" :href="member.linkedin" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </h5>
                            <p v-if="member.role" class="role font-weight-bold">
                                {{-- <i class="fas fa-user-tie"></i> --}}
                                @{{member.role}}
                            </p>
                            <div class="show-profile text-center mt-4">
                                <a v-if="member.user_id" :href="'/admin/users/'+member.user_id" class="button-style button-color-green">Visita profilo</a>
                            </div>
                            <div v-if="is_my_page" class="edit-center-center-small d-flex justify-content-between w-100">
                                <div class="d-inline-block" style="margin-left: -30px;">
                                    <a v-if="member.position!=0" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,-1)">
                                        {{-- <i  class="fas fa-sort-up"></i> --}}
                                        <i class="fas fa-caret-left"></i>
                                    </a>
                                </div>
                                <div class="d-inline-block" style="margin-right: -30px;">
                                    <a v-if="member.position<team_members.length-1" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,1)">
                                        {{-- <i  class="fas fa-sort-down"></i> --}}
                                        <i class="fas fa-caret-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div v-if="is_my_page" class="edit-top-right-vert">
                                <a :href="'/admin/teams/' + member.id +'/edit'" class="button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="team_num>3" class="text-center d-block w-100 pb-2">
                        <a href="javascript:void(0)" @click="teamToggle()" class="mini-txt">
                            <img v-if="team_members.length<=3" src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-90r" alt="">
                            <img v-else src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-90l" alt="">
                        </a>
                    </div>
                    <div v-if="is_my_page" class="d-flex justify-content-center w-100">
                        <a href="{{route('admin.teams.addTeam', $page->id)}}" class="button-color-gray">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="is_my_page || collaborations.length>0" id="collaborations" class="item-cont" v-cloak>
            <div class="item-style">
                <h3 class="text-capitalize">Collaborazioni
                    <div v-if="is_my_page" class="info">
                        <button aria-label="{{__('Use this section to enter collaborations with other accounts on the platform')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <a  v-if="is_my_page" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.collaborations.my', [$page->id,'page'])}}">
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
                                              :src="'/storage/' +collaboration.account.image" alt="" class="scale">
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
                    </div>
                    <button type="button" name="button" @mousedown="start(20,'left')" @mouseleave="stop(20,'left')" @mouseup="stop(20,'left')" class="slider-left" id="button-left-20" v-cloak>
                        <img src="{{ asset("storage/images/arrows-black-icon.svg") }}" class="arrow r-180" alt="">
                        {{-- <i class="fas fa-caret-left"></i> --}}
                    </button>
                    <button type="button" name="button" @mousedown="start(20,'right')" @mouseleave="stop(20,'right')" @mouseup="stop(20,'right')"class="slider-right" id="button-right-20" v-cloak>
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

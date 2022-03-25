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
        {{-- <div :class="delete_alert?'alert active-alert':'alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
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
        </div> --}}
        <div class="item-cont">
            <div class="item-style">
                <div class="profile row">
                    {{-- Immagine --}}
                    <div class="profile-image col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="img-cont medium-img position-relative">
                        @if($page->image)
                          <img src="{{ asset("storage/" . $page->image) }}" alt="" class="">
                        @endif
                          <a v-if="is_my_page" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editPageImage',$page->id)}}">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <h2 class="text-capitalize ">
                            {{$page->name}}
                            <a v-if="is_my_page" class="button-style-circle button-color-gray" href="{{route('admin.pages.edit', $page->id)}}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a v-if="is_my_page" class="button-color-gray" href="{{route('admin.pages.settings', $page->id)}}">
                                <i class="fas fa-cogs"></i>
                            </a>
                            @if($page->pagetype_id==1 && $page->incorporated)
                              <p>Costituita</p>
                            @endif
                        </h2>
                        <div class="">
                            <button v-if="!is_my_page" :class="following?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="toggleFollow({{$page->id}})" v-cloak>
                                <span v-if="following">Seguito</span>
                                <span v-else>Segui</span>
                            </button>
                            <a href="{{route('admin.chats.createChat',[$page->id,'page'])}}" class="button-style button-color-blue" type="button" name="button" v-cloak>
                                <span>Messaggio</span>
                            </a>
                        </div>
                    </div>
                </div>
                @if($is_my_page || count($page->sectors)>0)
                <div class="sub-section">
                  <h6>{{__('Sector')}}
                      <a  v-if="is_my_page" class="button-style-circle button-color-gray" href="{{route('admin.pages.sectors', $page->id)}}">
                          <i class="fas fa-pencil-alt"></i>
                      </a>
                  </h6>
                  <div class="">
                    @foreach ($page->sectors as $sector)
                      <span class="border-style">{{$sector->name_it}}</span>
                    @endforeach
                  </div>
                </div>
                @endif
                @if($page->summary)
                <div class="sub-section">
                    <h6>Sommario</h6>
                    <p class="description">{{$page->summary}}</p>
                </div>
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
                    {{-- SitoWeb --}}
                    @if($page->website)
                    <div class="link-item">
                        <a class="website" href="{{$page->website}}" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe-americas"></i>
                            <span>{{__('Website')}}</span>
                        </a>
                    </div>
                    @endif

                    {{-- Linkedin --}}
                    @if($page->linkedin)
                    <div class="link-item">
                        <a class="linkedin" href="{{$page->linkedin}}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                    @endif

                    @if ($page->pitch)
                    <div class="link-item">
                        <a class="pitch" href="#" @click="open(page.pitch)">
                            <i class="fas fa-address-card"></i>
                            <span>Pitch</span>
                        </a>
                    </div>
                    @endif
                </div>
                @endif
                @if($is_my_page || count($page->give_page_services)>0 || count($page->have_page_services)>0)
                <div class="sub-section row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <h6>{{__('Offro')}}</h6>
                        @if($is_my_page || count($page->give_page_services)>0)
                        <div class="services">
                        <label>{{__('Servizo di')}}:
                          <a v-if="is_my_page" href="{{route('admin.give-page-services.edit',$page->id)}}" class="button-color-gray">
                              <i class="fas fa-pencil-alt"></i>
                          </a>
                        </label>
                        @foreach ($page->give_page_services as $service)
                            <p class="mb-1">{{$service->name}}</p>
                        @endforeach
                        </div>
                      @endif
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        @if($is_my_page || count($page->have_page_services)>0)
                        <h6>{{__('Cerco')}}</h6>
                        <div class="services">
                            <label>{{__('Servizo di')}}:
                                <a v-if="is_my_page" href="{{route('admin.have-page-services.edit',$page->id)}}" class="button-color-gray">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </label>
                            @foreach ($page->have_page_services as $service)
                                <p class="mb-1">{{$service->name}}</p>
                            @endforeach
                            @if($page->pagetype_id==1)
                            <div class="pages">
                                <label>{{__('Aziende')}}:
                                    <a v-if="is_my_page" href="{{route('admin.have-page-pagetypes.edit',$page->id)}}" class="button-color-gray">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </label>
                                @foreach ($page->have_page_pagetypes as $pagetype)
                                    <p class="mb-1">{{$pagetype->name}}</p>
                                @endforeach
                            </div>
                            <div class="users">
                              <label>{{__('Persone')}}:
                                  <a v-if="is_my_page" href="{{route('admin.have-page-usertypes.edit',$page->id)}}" class="button-color-gray">
                                      <i class="fas fa-pencil-alt"></i>
                                  </a>
                              </label>
                            @foreach ($page->have_page_usertypes as $usertype)
                                <p class="mb-1">{{$usertype->name}}</p>
                                @if($usertype->id == 1 && $page->have_page_cofounders)
                                  <ul>
                                    @foreach ($page->have_page_cofounders as $skill)
                                      <li>{{$skill->name}}</li>

                                    @endforeach
                                  </ul>
                                @endif
                            @endforeach
                            </div>
                          @endif
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if($page->pagetype_id==1)
        <div class="item-cont">
            <div class="item-style">
              <h3>{{__('Life cycle')}}
                  <div v-if="is_my_page" class="info">
                      <button aria-label="{{__('Specify the life cycle\'s stage of your startup')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                      <i class="fas fa-info-circle"></i>
                  </div>
              </h3>
              <a href="{{route('admin.lifecycles.edit',$page->id)}}" class="button-color-gray edit-top-right">
                  <i class="fas fa-pencil-alt"></i>
              </a>
              @if($page->lifecycle_id)
              <div class="cicle-container">
                  @foreach ($lifecycles as $lifecycle)
                    <div class="pre-seed cicle-item">
                        <div :class="{{$lifecycle->id}}<={{$page->lifecycle_id}}?
                        'circle c-active':'circle'">
                            <span>{{$lifecycle->name}}</span>
                        </div>
                        <span v-if="{{$lifecycle->id}}<{{count($lifecycles)}}"
                          :class="{{$lifecycle->id}}<{{$page->lifecycle_id}}?'n-active net':'net'">
                        </span>
                    </div>
                  @endforeach
              </div>
              @endif
            </div>
        </div>
        @endif
        <div class="item-cont" v-if="is_my_page || team_members.length>0">
            <div class="item-style">
                <h3>Team
                    <div v-if="is_my_page" class="info">
                        <button aria-label="{{__('Add team member')}}" data-microtip-position="top" data-microtip-size="medium" role="tooltip">
                        <i class="fas fa-info-circle"></i>
                    </div>
                </h3>
                <div class="row justify-content-center">
                    <div v-for="member in team_members" class="team-member-cont col-sm-12 col-md-6 col-lg-4 col-xl-4" >
                        <div class="team-member sub-item-style">
                            <div class="img-cont medium-img">
                                <img v-if="member.image" :src="'/storage/'+ member.image" alt="">
                            </div>
                            <h6>@{{member.name}} @{{member.surname}}
                                <a v-if="member.linkedin" class="linkedin" :href="member.linkedin" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </h6>
                            <span v-if="member.role">
                                <i class="fas fa-user-tie"></i>
                                @{{member.role}}
                            </span>
                            <div v-if="is_my_page" class="edit-top-left-small">
                                <a v-if="member.position!=0" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,-1)">
                                    <i  class="fas fa-sort-up"></i>
                                </a>
                                <a v-if="member.position<team_members.length-1" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,1)">
                                    <i  class="fas fa-sort-down"></i>
                                </a>
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
                            <span v-if="team_members.length<=3">{{__('Show all')}}</span>
                            <span v-else>{{__('Show less')}}</span>
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
        <div v-if="is_my_page || collaborations.length>0" class="item-cont" v-cloak>
            <div class="item-style">
                <h3 class="text-capitalize">Collaborazioni
                    <a  v-if="is_my_page" class="button-style-circle button-color-gray" href="{{route('admin.collaborations.index', [$page->id,'page'])}}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                </h3>
                <div class="row">
                    <div v-for="collaboration in collaborations"class="col-sm-12 col-md-6 col-lg-4 col-xl-3  p-1">
                        <div class="page-list">
                            <a :href="collaboration.recipient_user_id?
                            '/admin/users/'+collaboration.account.id
                            :'/admin/pages/'+collaboration.account.id" class="">
                                <div class="img-cont mini-img">
                                  <img
                                  v-if="collaboration.account.image"
                                  :src="'/storage/' +collaboration.account.image" alt="" class="">
                                </div>
                                <span>@{{collaboration.account.name}}
                                    @{{collaboration.account.surname?
                                    collaboration.account.surname:''}}
                                    @{{collaboration.confirmed?'confermata':''}}
                                </span>
                            </a>
                        </div>
                    </div>
                    @if($is_my_page)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1">
                      <div class="page-list">
                          <a class="" href="{{ route('admin.collaborations.create', ['id'=> $page->id,'user_or_page'=> 'page']) }}">
                            <i class="fas fa-plus"></i>
                          </a>
                      </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

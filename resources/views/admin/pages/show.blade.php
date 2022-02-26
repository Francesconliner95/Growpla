@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    page = "{{$page}}";
    is_my_page = "{{$is_my_page}}";
    team_members = {!! json_encode($team_members->toArray()) !!};
    team_num = "{{$team_num}}";
</script>
<div class="container">
    <div id="page-show">
        {{-- <div :class="delete_alert?'delete-alert active-alert':'delete-alert deactive-alert'" v-cloak>
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
        </div> --}}

        <div class="item-cont">
            <div class="item-style item-no-padding">
                <a v-if="is_my_page" class="button-color-gray" href="{{route('admin.pages.settings', $page->id)}}">
                    <i class="fas fa-cogs"></i>
                </a>
                <a v-if="is_my_page" class="edit-bottom-right button-color-gray" href="{{route('admin.pages.edit', $page->id)}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <div class="profile">
                    {{-- Cover Immagine --}}
                    <div class="profile-cover-cont">
                        {{-- Immagine --}}
                        <div class="profile-image">
                            <div class="position-relative w-100 h-100">
                                @if($page->image)
                                  <img src="{{ asset("storage/" . $page->image) }}" alt="" class="">
                                @endif
                                <a v-if="is_my_page" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editPageImage', $page->id)}}">
                                  <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="item-padding">
                        <div class="profile-header row">
                            {{-- Nome --}}
                            <div class="name col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <h2 class="text-capitalize">
                                    {{$page->name}}
                                </h2>
                            </div>

                            {{-- <div class="main-buttons col-sm-12 col-md-12 col-lg-6 col-xl-6 pt-3">
                                <div v-if="!is_my_page" class="d-inline-block">

                                    <button  :class="already_follow?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="setFollow()">
                                        <span v-if="already_follow">{{__('Following')}}</span>
                                        <span v-else>{{__('Follow')}}</span>
                                    </button>

                                    <div class="message d-inline-block">
                                        <span v-if="alert"class="mini-txt">@{{alert}}</span>
                                        <button v-else class="button-style button-color-blue" type="button" name="button" @click="sendMessage()">{{__('Message')}}</button>
                                    </div>
                                </div>

                                <div v-if="is_my_page" class="d-inline-block">
                                    <a class="button-style button-color-blue" href="{{route('admin.follows.index')}}">
                                        {{__('Followed')}}
                                    </a>
                                    @if ($page->page_type_id==2)
                                        <a class="button-style button-color-blue" href="{{ route('admin.nominations.cofounder')}}">
                                            {{__('Nominations')}}
                                        </a>
                                    @endif

                                </div>
                            </div> --}}
                        </div>
                        <div class="sub-section">
                          <div class="">
                            @if($page->sectors)
                              @foreach ($page->sectors as $sector)
                                <span class="sector-style mb-2">{{$sector->name}}</span>
                              @endforeach
                            @endif
                          </div>
                          <a  v-if="is_my_page" class="button-style button-color-orange" href="{{route('admin.pages.sectors', $page->id)}}">
                              Modifica Settore
                          </a>
                        </div>

                        {{-- Descrizione --}}
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
                    </div>
                </div>
            </div>
        </div>
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
                            <img v-if="member.image" :src="'/storage/'+ member.image" alt="">
                            <h6>@{{member.name}} @{{member.surname}}
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
                            <div v-if="is_my_page" class="edit-top-left-small">
                                <button v-if="member.position!=0" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,-1)">
                                    <i  class="fas fa-sort-up"></i>
                                </button>
                                <button v-if="member.position<team_members.length-1" type="button" name="button" class="button-color-gray" @click="changeTeamPosition(member.id,1)">
                                    <i  class="fas fa-sort-down"></i>
                                </button>
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
    </div>
</div>
@endsection

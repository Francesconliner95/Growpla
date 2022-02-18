@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    user = "{{$user}}";
    is_my_user = "{{(Auth::user()->id==$user->id)?true:false}}";
</script>
<div class="container">
    <div id="user-show">
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
                <a v-if="is_my_user" class="edit-bottom-right button-color-gray" href="{{route('admin.users.edit', $user->id)}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <div class="profile">
                    {{-- Cover Immagine --}}
                    <div class="profile-cover-cont">
                        {{-- Immagine --}}
                        <div class="profile-image">
                            <div class="position-relative w-100 h-100">
                                @if($user->image)
                                  <img src="{{ asset("storage/" . $user->image) }}" alt="" class="">
                                @endif
                                <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.users.editImage', $user->id)}}">
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
                                    {{$user->name}}
                                </h2>

                            </div>

                            {{-- <div class="main-buttons col-sm-12 col-md-12 col-lg-6 col-xl-6 pt-3">
                                <div v-if="!is_my_user" class="d-inline-block">

                                    <button  :class="already_follow?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="setFollow()">
                                        <span v-if="already_follow">{{__('Following')}}</span>
                                        <span v-else>{{__('Follow')}}</span>
                                    </button>

                                    <div class="message d-inline-block">
                                        <span v-if="alert"class="mini-txt">@{{alert}}</span>
                                        <button v-else class="button-style button-color-blue" type="button" name="button" @click="sendMessage()">{{__('Message')}}</button>
                                    </div>
                                </div>

                                <div v-if="is_my_user" class="d-inline-block">
                                    <a class="button-style button-color-blue" href="{{route('admin.follows.index')}}">
                                        {{__('Followed')}}
                                    </a>
                                    @if ($user->user_type_id==2)
                                        <a class="button-style button-color-blue" href="{{ route('admin.nominations.cofounder')}}">
                                            {{__('Nominations')}}
                                        </a>
                                    @endif

                                </div>
                            </div> --}}
                        </div>

                        {{-- Descrizione --}}
                        @if($user->description)
                        <div class="sub-section">
                          <h6>{{__('Presentation')}}</h6>
                          <p class="description">{{$user->description}}</p>
                        </div>
                        @endif

                        @if($user->website
                        || $user->linkedin
                        || $user->pitch
                        || $user->cv)
                        <div class="sub-section link-cont">
                            {{-- SitoWeb --}}
                            @if($user->website)
                            <div class="link-item">
                                <a class="website" href="{{$user->website}}" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-globe-americas"></i>
                                    <span>{{__('Website')}}</span>
                                </a>
                            </div>
                            @endif

                            {{-- Linkedin --}}
                            @if($user->linkedin)
                            <div class="link-item">
                                <a class="linkedin" href="{{$user->linkedin}}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                    <span>LinkedIn</span>
                                </a>
                            </div>
                            @endif

                            {{-- STURTUP --}}

                            {{-- Pitch --}}
                            @if ($user->pitch)
                                <div class="link-item">
                                    <a class="pitch" href="#" @click="open(user.pitch)">
                                        <i class="far fa-images"></i>
                                        <span>Pitch</span>
                                    </a>
                                </div>
                            @endif


                            {{-- CO-FOUNDER-UTENTE --}}
                            @if ($user->cv)
                            <div class="link-item">
                                <a class="cv" href="#" @click="open(user.cv)">
                                    <i class="fas fa-address-card"></i>
                                    <span>CV</span>
                                </a>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

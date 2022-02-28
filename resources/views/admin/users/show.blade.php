@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    user = "{{$user}}";
    is_my_user = "{{$is_my_user}}";
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
                                <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editUserImage')}}">
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
                                    {{$user->name}} {{$user->surname}}
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
                        @if($is_my_user || count($user->sectors)>0)
                        <div class="sub-section">
                          <h6>{{__('Sector')}}</h6>
                          <div class="">
                            @foreach ($user->sectors as $sector)
                              <span class="d-block{{--sector-style mb-2--}}">{{$sector->name}}</span>
                            @endforeach
                          </div>
                          <a  v-if="is_my_user" class="" href="{{route('admin.users.sectors', $user->id)}}">
                              <i class="fas fa-pencil-alt"></i>
                          </a>
                        </div>
                        @endif

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
                    @if($user->startup_n || $user->moneyrange_id)
                    <div class="sub-section">
                        <div class="row justify-content-center">
                            @if($user->startup_n)
                            <div v-if="user.startup_n" class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <h6>{{__('Amount of')}}
                                    <span class="font-weight-bold">{{__('startups incubated')}}</span>
                                    <span  class="font-weight-bold">{{__('projects funded')}}</span>
                                </h6>
                                <h3 class="font-weight-bold">{{$user->startup_n}}</h3>
                            </div>
                            @endif
                            @if($user->moneyrange_id)
                            <div class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <h6>
                                    {{__('Amount of')}}
                                    <span  class="font-weight-bold">{{__('funds raised for incubated startups')}}</span>
                                    <span class="font-weight-bold">{{__('invested money')}}</span>
                                </h6>
                                <h3 class="font-weight-bold">
                                  {{$user->moneyrange->range}} {{$user->currency->symbol}}
                                </h3>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    @if($is_my_user || count($user->skills)>0)
                    <div class="sub-section">
                      <h6>{{__('Skills')}}</h6>
                      @foreach ($user->skills as $skill)
                          <p>{{$skill->name}}
                              <a href="{{route('admin.skills.edit',$skill->id)}}" class="button-gray">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                          </p>
                      @endforeach
                      <div v-if="is_my_user" class="d-flex justify-content-center w-100">
                          <a href="{{route('admin.skills.create')}}" class="text-gray">
                              <i class="fas fa-plus-circle"></i>Aggiungi abilità
                          </a>
                      </div>
                    </div>
                    @endif

                    @if($is_my_user || count($give_services)>0)
                    <div class="sub-section">
                      <h6>{{__('Servizi offerti')}}</h6>
                      @foreach ($give_services as $service)
                          <p>{{$service->name}}
                              <a href="{{route('admin.give-user-services.edit',$service->id)}}" class="button-gray">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                          </p>
                      @endforeach
                      <div v-if="is_my_user" class="d-flex justify-content-center w-100">
                          <a href="{{route('admin.give-user-services.create')}}" class="text-gray">
                              <i class="fas fa-plus-circle"></i>Aggiungi servizio offerto
                          </a>
                      </div>
                    </div>
                    @endif
                    @if($is_my_user || count($user->companies)>0)
                    <div class="">
                        <h6>{{__('Companies')}}</h6>
                        @foreach ($user->companies as $company)
                        <div>
                            @if($company->page_id)
                                {{$company->page->name}}
                            @else
                                {{$company->name}}
                            @endif
                            <a v-if="is_my_user" href="{{route('admin.companies.edit', $company->id)}}" class="text-gray">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div v-if="is_my_user" class="d-flex justify-content-center w-100">
                        <a href="{{route('admin.companies.create')}}" class="text-gray">
                            <i class="fas fa-plus-circle"></i>Aggiungi azienda per cui lavori
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
          @foreach ($pageTypes as $pageType)
            @if($user->pageTypes->contains($pageType->id))
                <div class="item-cont">
                    <div class="item-style">
                      <h3>{{__($pageType->name)}}</h3>
                      <div class="">
                        @foreach ($user->pages->where('pagetype_id',$pageType->id) as $page)
                          <div class="">
                            <a href="{{ route('admin.pages.show', ['page'=> $page->id]) }}">
                              <span>{{$page->name}}</span>
                            </a>
                          </div>
                        @endforeach
                        @if($is_my_user)
                        <div class="">
                          <a href="{{ route('admin.pages.newPage', ['pagetype_id'=> $pageType->id]) }}">Aggiungi</a>
                        </div>
                        @endif
                      </div>
                    </div>
                </div>
            @endif
          @endforeach
          {{-- STARTUP --}}
          {{-- @if($user->pageTypes->contains(1))
            @if($is_my_user || $startups)
              <div class="item-cont">
                  <div class="item-style">
                    <h3>{{__('Startups')}}</h3>
                    <div class="">
                      @foreach ($startups as $startup)
                        <div class="">
                          <span>{{$startup->page_name}}</span>
                        </div>
                      @endforeach
                      <div class="">
                        <a href="{{ route('admin.pages.newPage', ['pagetype_id'=> 1]) }}">Aggiungi</a>
                      </div>
                    </div>
                  </div>
              </div>
            @endif
          @endif --}}
          {{-- AZIENDA --}}
          {{-- @if($user->pageTypes->contains(2))
            @if($is_my_user || $companies)
              <div class="item-cont">
                  <div class="item-style">
                    <h3>{{__('Companies')}}</h3>
                    @foreach ($companies as $company)
                      <div class="">
                        <span>{{$company->page_name}}</span>
                      </div>
                    @endforeach
                    <div class="">
                      <a href="{{ route('admin.pages.newPage', ['pagetype_id'=> 2]) }}">Aggiungi</a>
                    </div>
                  </div>
              </div>
            @endif
          @endif --}}
    </div>
</div>
@endsection

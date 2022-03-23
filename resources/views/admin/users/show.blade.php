@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    lang = "{{Auth::user()->language_id}}";
    is_my_user = "{{$is_my_user}}";
    following = "{{Auth::user()->user_following->contains($user)}}";
</script>
<div class="container">
    <div id="user-show">
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
                        @if($user->image)
                          <img src="{{ asset("storage/" . $user->image) }}" alt="" class="">
                        @endif
                          <a v-if="is_my_user" class="edit-top-right button-style-circle button-color-gray" href="{{route('admin.images.editUserImage')}}">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <h2 class="text-capitalize ">
                            {{$user->name}} {{$user->surname}}
                            <a v-if="is_my_user" class="button-style-circle button-color-gray" href="{{route('admin.users.edit', $user->id)}}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </h2>
                        <div class="">
                            <a v-if="is_my_user" class="button-style button-color-orange" href="{{route('admin.follows.index')}}">
                                {{count(Auth::user()->user_following)
                                +count(Auth::user()->page_following)}} Seguiti
                            </a>
                            <button v-if="!is_my_user" :class="following?'button-style button-color-orange':'button-style button-color'" type="button" name="button" @click="toggleFollow({{$user->id}})" v-cloak>
                                <span v-if="following">{{__('Following')}}</span>
                                <span v-else>{{__('Follow')}}</span>
                            </button>
                            <a href="{{route('admin.chats.createChat',[$user->id,'user'])}}" class="button-style button-color-blue" type="button" name="button" v-cloak>
                                <span>Messaggio</span>
                            </a>
                        </div>
                    </div>
                </div>
                @if($is_my_user || count($user->sectors)>0)
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
                @endif
                @if($user->summary)
                <div class="sub-section">
                    <h6>Sommario</h6>
                    <p class="description">{{$user->summary}}</p>
                </div>
                @endif
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
                    @if($user->website)
                    <div class="link-item">
                        <a class="website" href="{{$user->website}}" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe-americas"></i>
                            <span>{{__('Website')}}</span>
                        </a>
                    </div>
                    @endif
                    @if($user->linkedin)
                    <div class="link-item">
                        <a class="linkedin" href="{{$user->linkedin}}" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-linkedin"></i>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                    @endif
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
                {{-- BUSINESS ANGEL --}}
                @if($user->usertypes->contains(2))
                  @if($user->startup_n || $user->moneyrange_id)
                  <div class="sub-section">
                      <div class="row justify-content-center">
                          @if($user->startup_n)
                          <div class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <h6>Quantità di progetti finanziati</h6>
                              <h3 class="font-weight-bold">{{$user->startup_n}}</h3>
                          </div>
                          @endif
                          @if($user->moneyrange_id)
                          <div class="text-center col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <h6>Taglio d'investimenti</h6>
                              <h3 class="font-weight-bold">
                                {{$user->moneyrange->range}} {{$user->currency->symbol}}
                              </h3>
                          </div>
                          @endif
                      </div>
                  </div>
                  @endif
                @endif
                {{-- ASPIRANTE CO-FOUNDER --}}
                @if($user->usertypes->contains(1))
                    @if($is_my_user || count($user->give_user_skills)>0)
                    <div class="sub-section">
                      <h6>{{__('Competenze')}}
                        <a v-if="is_my_user" href="{{route('admin.give_user_skills.edit',$user->id)}}" class="button-style-circle button-color-gray">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                      </h6>
                      @foreach ($user->give_user_skills as $skill)
                          <p>{{$skill->name}}</p>
                      @endforeach

                    </div>
                    @endif
                @endif
                {{-- SERVIZI --}}
                @if($is_my_user || count($user->give_user_services)>0 || count($user->have_user_services)>0)
                <div class="sub-section row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <h6>{{__('Offro')}}
                      </h6>
                      @if($is_my_user || count($give_services)>0)
                        <h6>{{__('Servizio di:')}}
                          <a v-if="is_my_user" href="{{route('admin.give-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                              <i class="fas fa-pencil-alt"></i>
                          </a>
                        </h6>
                        @foreach ($give_services as $service)
                            <p>{{$service->name}}</p>
                        @endforeach
                      @endif
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    @if($is_my_user || count($user->have_user_services)>0)
                    <h6>{{__('Cerco')}}</h6>
                    <div class="services">
                      <h6>{{__('Servizo di')}}:
                        <a v-if="is_my_user" href="{{route('admin.have-user-services.edit',$user->id)}}" class="button-style-circle button-color-gray">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                      </h6>
                      @foreach ($user->have_user_services as $service)
                          <p class="mb-1">{{$service->name}}</p>
                      @endforeach
                    </div>
                    @endif
                  </div>
                </div>
                @endif
                {{-- DIPENDENTE --}}
                @if($user->usertypes->contains(4))
                  @if($is_my_user || count($user->companies)>0)
                  <div class="last-sub-section">
                      <h6>Aziende per cui lavoro</h6>
                      <div class="row">
                          @foreach ($user->companies as $company)
                          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                              @if($company->page_id)
                                  <a href="{{route('admin.pages.show', $company->page->id)}}" class="text-gray">
                                      <div class="img-cont mini-img">
                                          @if($company->page->image)
                                            <img src="{{ asset("storage/" . $company->page->image) }}" alt="" class="">
                                          @endif
                                      </div>
                                      {{$company->page->name}}
                                  </a>
                                  @if($company->page->linkedin)
                                      <a class="linkedin" href="{{$company->page->linkedin}}" target="_blank" rel="noopener noreferrer">
                                          <i class="fab fa-linkedin"></i>
                                      </a>
                                  @endif
                              @else
                                  <div class="img-cont mini-img">
                                      @if($company->image)
                                        <img src="{{ asset("storage/" . $company->page->image) }}" alt="" class="">
                                      @endif
                                  </div>
                                  {{$company->name}}
                                  @if($company->linkedin)
                                      <a class="linkedin" href="{{$company->linkedin}}" target="_blank" rel="noopener noreferrer">
                                          <i class="fab fa-linkedin"></i>
                                      </a>
                                  @endif
                              @endif
                              <a v-if="is_my_user" href="{{route('admin.companies.edit', $company->id)}}" class="button-style-circle button-color-gray">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>
                          </div>
                          @endforeach
                      </div>
                  </div>
                  <div v-if="is_my_user" class="d-flex justify-content-center w-100">
                      <a href="{{route('admin.companies.create')}}" class="text-gray">
                          <i class="fas fa-plus-circle"></i>Aggiungi azienda per cui lavori
                      </a>
                  </div>
                  @endif
                @endif
            </div>
        </div>
        @foreach ($pageTypes as $pageType)
          @if($user->pageTypes->contains($pageType->id))
              <div class="item-cont">
                  <div class="item-style">
                    <h3 class="text-capitalize">{{__($pageType->name_it)}}</h3>
                    <div class="row">
                      @foreach ($user->pages->where('pagetype_id',$pageType->id) as $page)
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3  p-1">
                            <div class="page-list">
                                <a href="{{ route('admin.pages.show', ['page'=> $page->id]) }}" class="">
                                  <div class="img-cont mini-img">
                                  @if($page->image)
                                    <img src="{{ asset("storage/" . $page->image) }}" alt="" class="">
                                  @endif
                                  </div>
                                  <span>{{$page->name}}</span>
                                </a>
                            </div>
                        </div>
                      @endforeach
                      @if($is_my_user)
                      <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1">
                        <div class="page-list">
                            <a class="" href="{{ route('admin.pages.newPage', ['pagetype_id'=> $pageType->id]) }}">
                              <i class="fas fa-plus"></i>
                            </a>
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
              </div>
          @endif
        @endforeach
    </div>
</div>
@endsection

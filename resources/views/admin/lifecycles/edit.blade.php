@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    lifecycles = {!! json_encode($lifecycles->toArray()) !!};
    lifecycle_id = "{{$page->lifecycle_id}}";
    skills = "{{$skills}}";
</script>
<div class="container">
    <div id="lifecycle-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    {{-- Nome --}}
                    <div class="">
                        <h2>{{__('Life cycle')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-pencil-alt"></i>
                    </h1>
                </div>
                <form method="POST" id="editPageForm" enctype="multipart/form-data" action="{{ route('admin.lifecycles.update', $page->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="main-section pt-3 pb-2 row">
                        <div class="lifecycle_selecteds col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <h6>{{__('Specify the stage of the life cycle that your startup goes through')}}</h6>
                            @foreach ($lifecycles as $lifecycle)
                              <div class="lifecycle_selected form-check pl-0">
                                  <div class="info">
                                      <button aria-label="{{$lifecycle->description}}" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                      <i class="fas fa-info-circle"></i>
                                  </div>
                                  <input id="lifecycle-{{$lifecycle->id}}" type="radio" name="lifecycle"
                                  value="{{$lifecycle->id}}" v-model="lifecycle_selected"
                                  @change="recommended()"
                                  >
                                  <label for="lifecycle-{{$lifecycle->id}}">{{$lifecycle->name}}
                                  </label>
                              </div>
                            @endforeach
                            <div class="advice" v-if="lifecycle_selected==1
                            || lifecycle_selected==4
                            || lifecycle_selected==5">
                                <span class="mini-txt">{{__('Recommendations for the selected phase')}}</span>
                                <ul>
                                    <li v-if="lifecycle_selected==1">{{__('Notices')}}
                                        <div class="info">
                                            <button aria-label="{{__('Public competitions that allow access to funds')}}" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </li>
                                    <li v-if="lifecycle_selected==4">Family Office
                                        <div class="info">
                                            <button aria-label="{{__('Private funds of large families that make investments in order to diversify their portfolio')}}" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                    </li>
                                    <li v-if="lifecycle_selected==5">{{__('Banks')}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="needs col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <h6>{{__('Cosa stai cercando?')}}:</h6>
                            @foreach ($usertypes as $usertype)
                              @if($usertype->id==1 || $usertype->id==2)
                              <div>
                                  @if($errors->any())
                                    <input id="usertype-{{$usertype->id}}" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                                    {{ in_array($usertype->id, old('usertypes', [])) ? 'checked=checked' : ''}}>
                                  @else
                                    <input id="usertype-{{$usertype->id}}" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                                    {{$page->have_page_usertypes->contains($usertype)?'checked=checked':''}}>
                                  @endif
                                  <label for="usertype-{{$usertype->id}}" class="active">
                                      {{$usertype->name}}
                                      @if($usertype->description)
                                      <div class="info">
                                          <button aria-label="{{$usertype->description}}" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                          <i class="fas fa-info-circle"></i>
                                      </div>
                                      @endif
                                      <span v-if="userRecommended.includes({{$usertype->id}})" class="mini-txt">
                                          {{__('Recommended')}}
                                      </span>
                                  </label>
                                  @if($usertype->id==1)
                                  <div v-for="(skill,i) in skills" class="" v-cloak>
                                    {{-- <input type="hidden" name="skills[]" :value="skill.pivot.skill_id"> --}}
                                    <input type="hidden" name="skills[]" :value="skill.name">
                                    <label for="">@{{skill.name}}
                                      <i class="fas fa-trash-alt" @click="removeSkill(i)"></i>
                                    </label>
                                  </div>
                                  <div  class="search">
                                      <input type="text" name="name" value="" placeholder="Nome abilità" v-model="skill_name" @keyup.enter="searchSkill()" v-on:input="searchSkill()" maxlength="70" class="form-control" autocomplete="off">
                                      @error ('skill_name')
                                          <div class="alert alert-danger">
                                              {{__($message)}}
                                          </div>
                                      @enderror
                                      <button type="button" name="button" @click="addManualSkill()" class="button-style button-color">Aggiungi</button>
                                      <div :class="skills_found.length>0?'found':'found d-none'" v-cloak>
                                        <a class="item" v-for="skill_found in skills_found" @click="addSkill(skill_found)">
                                            @{{skill_found.name}}
                                        </a>
                                      </div>
                                  </div>
                                  @endif
                              </div>
                              @endif
                            @endforeach
                            @foreach ($pagetypes as $pagetype)
                              @if($pagetype->id!=1)
                              <div>
                                  @if($errors->any())
                                    <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"
                                    {{ in_array($pagetype->id, old('pagetypes', [])) ? 'checked=checked' : ''}}>
                                  @else
                                    <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"
                                    {{$page->have_page_pagetypes->contains($pagetype)?'checked=checked':''}}>
                                  @endif
                                  {{-- <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}"> --}}
                                  <label for="pagetype-{{$pagetype->id}}" class="active">
                                      {{$pagetype->name}}
                                      @if($pagetype->description)
                                      <div class="info">
                                          <button aria-label="{{$pagetype->description}}" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                          <i class="fas fa-info-circle"></i>
                                      </div>
                                      @endif
                                      <span v-if="pageRecommended.includes({{$pagetype->id}})" class="mini-txt">
                                          {{__('Recommended')}}
                                      </span>
                                  </label>
                              </div>
                              @endif
                            @endforeach
                            <div class="startup-services">
                                @foreach ($services as $service)
                                  <div class="startup-services-item">
                                      @if($errors->any())
                                        <input id="service-{{$service->id}}"
                                        type="checkbox" name="services[]" value="{{$service->id}}"
                                        {{ in_array($service->id, old('services', [])) ? 'checked=checked' : ''}}>
                                      @else
                                        <input id="service-{{$service->id}}" type="checkbox" name="services[]" value="{{$service->id}}"
                                        {{$page->have_page_services->contains($service)?'checked=checked':''}}>
                                      @endif
                                      <label for="service-{{$service->id}}" class="active">
                                        {{$service->name}}
                                          @if($service->description)
                                          <div class="info">
                                              <button aria-label="{{$service->description}}" data-microtip-position="top" data-microtip-size="large" role="tooltip">
                                              <i class="fas fa-info-circle"></i>
                                          </div>
                                          @endif
                                          <span v-if="serviceRecommended.includes({{$service->id}})" class="mini-txt">
                                                  {{__('Recommended')}}
                                          </span>
                                      </label>
                                  </div>
                                @endforeach
                            </div>
                        </div>
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

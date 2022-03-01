@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    lifecycles = {!! json_encode($lifecycles->toArray()) !!};
    lifecycle_id = "{{$lifecycle_id}}";
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
                <form method="POST" id="editPageForm" enctype="multipart/form-data" action="{{ route('admin.lifecycles.update', $page_id) }}">
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
                                  <input id="usertype-{{$usertype->id}}" type="checkbox" name="usertypes[]" value="{{$usertype->id}}">
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
                              </div>
                              @endif
                            @endforeach
                            @foreach ($pagetypes as $pagetype)
                              @if($pagetype->id!=1)
                              <div>
                                  <input id="pagetype-{{$pagetype->id}}" type="checkbox" name="pagetypes[]" value="{{$pagetype->id}}">
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
                                      <input id="service-{{$service->id}}"
                                      type="checkbox" name="services[]" value="{{$service->id}}">
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

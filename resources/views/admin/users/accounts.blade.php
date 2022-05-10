@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    userTypes = @json($userTypes);
    pageTypes = @json($pageTypes);
</script>
<div class="container">
    <div id="user-accounts">
        <div class="item-cont">
            <div class="item-style">
              <form method="post" id="user-create-form" action="{{route('admin.users.storeAccounts',$user->id)}}">
                @csrf
                @method('PUT')
                <h4 class="pb-1">Come ti identifichi?</h4>
                <div class="row d-flex justify-content-center checkbox-group required">
                  @foreach ($userTypes as $userType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-4 justify-content-center">
                      @if($userType->description_it)
                          <button aria-label="{{$userType->description_it}}" data-microtip-position="top" data-microtip-size="large" role="tooltip" class="w-100" type="button">
                      @endif
                      <div :class="isChecked('u-{{$userType->id}}')?
                      'active multichoise-b button-style multichoise-green w-100 tool-tip-b  text-center':
                      'multichoise-b button-style multichoise-green w-100 tool-tip-b  text-center'" @click="checkboxToggle('u-{{$userType->id}}')" id="u-{{$userType->id}}-b" v-cloak>
                        @if($errors->any())
                          <input type="checkbox" name="usertypes[]" class="d-none user-checkbox" value="{{$userType->id}}" id="u-{{$userType->id}}"
                          {{ in_array($userType->id, old('usertypes', [])) ? 'checked=checked' : ''}}>
                        @else
                          <input type="checkbox" name="usertypes[]" class="d-none user-checkbox" value="{{$userType->id}}" id="u-{{$userType->id}}"
                          {{$user->userTypes->contains($userType)?'checked=checked':''}}>
                        @endif
                        <span class="m-0 text-capitalize" for="u-{{$userType->name}}">{{$userType->name_it}}</span>
                        {{-- @if ($userType->description_it)
                        <div class="tool-tip">
                            {{$userType->description_it}}
                        </div>
                        @endif --}}
                      </div>
                    </div>
                  @endforeach
                  <div v-show="display_message" class="text-center" v-cloak>
                      <span class="mini-txt txt-red font-weight-bold">@{{display_message}}</span>
                  </div>
                </div>
                <h4 class="pb-1">Crea pagina</h4>
                <p class="font-weight-bold txt-blue mini-txt">Growpla ti permette di associare al tuo profilo personale delle pagine connesse alle attività che possiedi o per le quali operi.</p>
                <div class="row d-flex justify-content-center mt-3">
                  @foreach ($pageTypes as $pageType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-4 justify-content-center">
                      @if($pageType->description_it)
                          <button aria-label="{{$pageType->description_it}}" data-microtip-position="top" data-microtip-size="large" role="tooltip" class="w-100" type="button">
                      @endif
                      <div type="button" name="button" :class="isChecked('p-{{$pageType->name}}')?
                      'active multichoise-b button-style multichoise-blue w-100 tool-tip-b text-center':
                      'multichoise-b button-style multichoise-blue w-100 tool-tip-b text-center'" @click="checkboxToggle('p-{{$pageType->name}}')" id="p-{{$pageType->name}}-b" v-cloak>
                        @if($errors->any())
                          <input type="checkbox" name="pagetypes[]" class="d-none" value="{{$pageType->id}}" id="p-{{$pageType->name}}"
                          {{ in_array($pageType->id, old('pagetypes', [])) ? 'checked=checked' : ''}}
                          >
                        @else
                          <input type="checkbox" name="pagetypes[]" class="d-none" value="{{$pageType->id}}" id="p-{{$pageType->name}}"
                          {{$user->pageTypes->contains($pageType)?'checked=checked':''}}>
                        @endif
                        <span class="m-0 text-capitalize" for="p-{{$pageType->name}}">{{$pageType->name_it}}</span>
                        {{-- @if ($pageType->description_it)
                        <div class="tool-tip">
                            {{$pageType->description_it}}
                        </div>
                        @endif --}}
                      </div>
                    </div>
                  @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <h6 class="m-0">Seleziona una o più delle precedenti alternative</h6>
                        <span class="mini-txt">Potrai modificare queste opzioni in qualsiasi momento</span>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 text-right">
                        <button type="button" name="button" class="button-style button-color-blue" @click="submitForm()">
                            {{$user->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

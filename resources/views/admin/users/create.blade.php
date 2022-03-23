@extends('layouts.app')

@section('content')
<script type="text/javascript">
    language_id = "{{Auth::user()->language_id}}";
    userTypes = "{{$userTypes}}";
    pageTypes = "{{$pageTypes}}";
</script>
<div class="container">
    <div id="user-create">
        <div class="item-cont">
            <div class="item-style">
              <form method="post" action="{{route('admin.users.store')}}">
                @csrf
                <h4 class="pb-1">Come ti identifichi?</h4>
                <div class="row d-flex justify-content-center">
                  @foreach ($userTypes as $userType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-4 justify-content-center">
                      <button type="button" name="button" :class="isChecked('u-{{$userType->id}}')?
                      'button-active-multichoise button-style button-color-multichoise w-100':
                      'button-style button-color-multichoise w-100'" @click="checkboxToggle('u-{{$userType->id}}')" id="u-{{$userType->id}}-b" v-cloak>
                        @if($errors->any())
                          <input type="checkbox" name="usertypes[]" class="d-none" value="{{$userType->id}}" id="u-{{$userType->id}}"
                          {{ in_array($userType->id, old('usertypes', [])) ? 'checked=checked' : ''}}
                          >
                        @else
                          <input type="checkbox" name="usertypes[]" class="d-none" value="{{$userType->id}}" id="u-{{$userType->id}}"
                          {{$user->userTypes->contains($userType)?'checked=checked':''}}>
                        @endif
                        <span class="m-0 text-capitalize" for="u-{{$userType->name}}">{{$userType->name_it}}</span>
                      </button>
                    </div>
                  @endforeach
                </div>
                <h4 class="pb-1">Cosa possiedi?</h4>
                <div class="row d-flex justify-content-center">
                  @foreach ($pageTypes as $pageType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-4 justify-content-center">
                      <button type="button" name="button" :class="isChecked('p-{{$pageType->name}}')?
                      'button-active-multichoise button-style button-color-multichoise w-100':
                      'button-style button-color-multichoise w-100'" @click="checkboxToggle('p-{{$pageType->name}}')" id="p-{{$pageType->name}}-b" v-cloak>
                        @if($errors->any())
                          <input type="checkbox" name="pagetypes[]" class="d-none" value="{{$pageType->id}}" id="p-{{$pageType->name}}"
                          {{ in_array($pageType->id, old('pagetypes', [])) ? 'checked=checked' : ''}}
                          >
                        @else
                          <input type="checkbox" name="pagetypes[]" class="d-none" value="{{$pageType->id}}" id="p-{{$pageType->name}}"
                          {{$user->pageTypes->contains($pageType)?'checked=checked':''}}>
                        @endif
                        <span class="m-0 text-capitalize" for="p-{{$pageType->name}}">{{$pageType->name_it}}</span>
                      </button>
                    </div>
                  @endforeach
                </div>
                <h6 class="pb-2">Seleziona una o più delle seguenti alternative</h6>
                <button type="submit" name="button" class="button-style button-color-blue">Salva</button>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

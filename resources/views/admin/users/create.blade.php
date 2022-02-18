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
              <h2>Come ti identifichi?</h2>
              <h4>Seleziona una o più delle seguenti alternative</h4>
              <form method="post" action="{{route('admin.users.store')}}">
                @csrf
                <h6>Utenti</h6>
                <div class="row">
                  @foreach ($userTypes as $userType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-4 justify-content-center">
                      {{-- <button type="button" name="button" class="button-style button-color w-100
                      @if($errors->any())
                        {{ in_array($userType->id, old('usertypes', [])) ? 'button-active' : ''}}
                      @else
                        {{$user->userTypes->contains($userType)?'button-active':''}}
                      @endif
                      " > --}}
                      <button type="button" name="button" :class="isChecked('{{$userType->name}}')?
                      'button-active button-style button-color w-100':
                      'button-style button-color w-100'" @click="checkboxToggle('{{$userType->name}}')" id="{{$userType->name}}-b">
                        @if($errors->any())
                          <input type="checkbox" name="usertypes[]" class="d-none" value="{{$userType->id}}" id="{{$userType->name}}"
                          {{ in_array($userType->id, old('usertypes', [])) ? 'checked=checked' : ''}}
                          >
                        @else
                          <input type="checkbox" name="usertypes[]" class="d-none" value="{{$userType->id}}" id="{{$userType->name}}"
                          {{$user->userTypes->contains($userType)?'checked=checked':''}}>
                        @endif
                        <label class="m-0" for="{{$userType->name}}">{{$userType->name}}</label>
                      </button>
                    </div>
                  @endforeach
                </div>
                <h6>Pagine</h6>
                @foreach ($pageTypes as $pageType)
                  <div class="">
                    @if($errors->any())
                      <input type="checkbox" name="pagetypes[]" value="{{$pageType->id}}" id="{{$pageType->name}}"
                      {{ in_array($pageType->id, old('pagetypes', [])) ? 'checked=checked' : ''}}>
                    @else
                      <input type="checkbox" name="pagetypes[]" value="{{$pageType->id}}" id="{{$pageType->name}}"
                    {{$user->pageTypes->contains($pageType)?'checked=checked':''}}>
                    @endif
                    <label for="{{$pageType->name}}">{{$pageType->name}}</label>
                  </div>
                @endforeach
                <button type="submit" name="button">Salva</button>
              </form>
              {{-- <div v-for="pageType in pageTypes" class="">
                <input type="checkbox" name="pagetype" :value="pageType.id" :id="pageType.name">
                <label :for="pageType.name">@{{language_id==1?pageType.name:pageType.name_it}}</label>
              </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

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
                @if($user->tutorial)
                    <h2 class="">Crea il tuo profilo personale</h2>
                @endif
                <h5 class="pb-3">Seleziona
                la categoria (o le categorie) a cui appartieni</h5>
                <div class="row d-flex justify-content-center checkbox-group required py-4">
                  @foreach ($userTypes as $userType)
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mb-5">
                        <div class="text-center">
                            <div :class="isChecked('u-{{$userType->id}}')?
                            'active multichoise-b button-style multichoise-green tool-tip-b text-center rounded-circle scale  d-flex justyfy-content-center align-items-center m-auto':
                            'multichoise-b button-style multichoise-green tool-tip-b text-center rounded-circle scale d-flex justyfy-content-center align-items-center m-auto'" @click="checkboxToggle('u-{{$userType->id}}')" id="u-{{$userType->id}}-b"  style="height:85px; width:85px; "v-cloak>
                                @if($errors->any())
                                  <input type="checkbox" name="usertypes[]" class="d-none user-checkbox" value="{{$userType->id}}" id="u-{{$userType->id}}"
                                  {{ in_array($userType->id, old('usertypes', [])) ? 'checked=checked' : ''}}>
                                @else
                                  <input type="checkbox" name="usertypes[]" class="d-none user-checkbox" value="{{$userType->id}}" id="u-{{$userType->id}}"
                                  {{$user->userTypes->contains($userType)?'checked=checked':''}}>
                                @endif
                                <div class="img-cont small-img m-auto d-block">
                                    <img src="{{asset('storage/'.$userType->image)}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="text-center pt-2">
                            <span class="m-0 text-uppercase font-weight-bold text-dark" for="u-{{$userType->name}}">
                                {{$userType->name_it}}
                                @if($userType->description_it)
                                <button type="button" class="tooltip-custom cursor-default" data-toggle="tooltip" data-placement="top" title="{{$userType->description_it}}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                @endif
                            </span>
                        </div>
                    </div>
                  @endforeach
                </div>
                <div v-show="display_message" class="text-center" v-cloak>
                    <span class="mini-txt txt-red font-weight-bold">@{{display_message}}</span>
                </div>
                <div class="text-right">
                    <button type="button" name="button" class="button-style button-color-blue" @click="submitForm()">
                        {{$user->tutorial?'Avanti':'Salva'}}
                    </button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
@endsection

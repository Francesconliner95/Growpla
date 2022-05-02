@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = "{{$user}}";
    lang = "{{Auth::user()->language_id}}";
</script>
<div class="container">
    <div id="user-settings">
        <div :class="alert?'d-alert active-alert':'d-alert deactive-alert'" v-cloak>
            <div class="item-cont alert-item col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="item-style-visible">
                    <button type="button" name="button" class="edit-top-right button-style button-color" @click="alert=false">
                        <i class="fas fa-times"></i>
                    </button>
                    <h4 class="p-2 pt-4 text-center">{{__('Are you really sure you want to delete your account?')}}
                    </h4>
                    <div class="p-3 pb-5 text-center">
                        <span class="">{{__('The action is irreversible, by doing so you will lose all your information')}}</span>
                        <span class="d-block txt-red font-weight-bold pt-2 pb-2">Se sei propietario di una o più pagine e non hai nominato altri amministratori anche le tue pagine verrano eliminate</span>
                    </div>
                    <div class="">
                        <div v-if="!confirm_delete_alert" class="d-flex justify-content-between align-items-center">
                            <button type="button" name="button" class="button-style button-color mr-5" @click="alert=false">
                                {{__('Cancel')}}
                            </button>
                            <button class="button-style button-color-red ml-5" type="button" name="button" @click="confirm_delete_alert=true">
                                <i class="fas fa-trash-alt mr-1"></i>{{__('Proceed')}}
                            </button>
                        </div>
                        <form v-if="confirm_delete_alert" method="post" action="{{ route('admin.users.destroy', ['user'=> $user->id])}}" class="text-center">
                        @csrf
                        @method('DELETE')
                          <span class="d-block txt-red font-weight-bold pb-2">Sei davvero sicuro?</span>
                          <button class="button-style button-color-red" type="submit" name="button">
                              <i class="fas fa-trash-alt mr-1"></i>Elimina Account
                          </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="item-cont">
            <div class="item-style">
                 <div class="header">
                    <div class="">
                        <h2>{{__('Settings')}}</h2>
                    </div>
                    <h1>
                        <i class="fas fa-cog"></i>
                    </h1>
                </div>
                <div class="mb-5">
                    <h6>Voglio ricevere mail</h6>
                    @foreach ($mail_settings as $mail_setting)
                        <div class="">
                            {{-- @if($errors->any())
                              <input type="checkbox" name="mail_settings[]" class="" value="{{$mail_setting->id}}" id="ms-{{$mail_setting->id}}"
                              {{ in_array($mail_setting->id, old('mail_settings', [])) ? 'checked=checked' : ''}} @click="checkboxToggle({{$mail_setting->id}})">
                            @else --}}
                              <input type="checkbox" name="mail_settings[]" class="" value="{{$mail_setting->id}}" id="ms-{{$mail_setting->id}}"
                              {{!$user->mail_settings->contains($mail_setting)?'checked=checked':''}} @click="checkboxToggle({{$mail_setting->id}})">
                            {{-- @endif --}}
                            <label class="pl-2" for="ms-{{$mail_setting->id}}">{{$mail_setting->name_it}}</label>
                        </div>
                    @endforeach
                </div>
                <div v-if="user" class="pt-3 pb-2 d-flex justify-content-center" v-cloak>
                    <div class="text-center card-style card-color-gray">
                        <div class="mb-5">
                            <div class="img-cont mini-img d-inline-block mb-2" v-cloak>
                                <img :src="'/storage/' + user.image" alt="" class="">
                            </div>
                            <h6 class="d-inline-block text-capitalize m-0">@{{user.name}} @{{user.surname}}</h6>
                        </div>
                        <a :href="'/admin/users/'+user.id" class="txt-green mb-3 d-inline-block">Torna al profilo</a>
                        <button type="button" name="button" class="button-style button-color-black" @click="alert=true">
                            <i class="fas fa-trash-alt"></i> {{__('Delete account')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

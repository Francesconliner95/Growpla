@extends('layouts.app')

@section('content')
<div class="container">
    <div id="account-create">
        <div class="item-cont">
            <div class="item-style">
                <form method="POST" action="{{ route('admin.accounts.store') }}">
                @csrf
                <div class="pt-3 pb-3 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="">{{__('You are a')}}</label>
                        <div class="form-check">
                            <input id="p_a_1" type="radio"
                            v-model="private_association" name="private_association" value="1" @change="private_selected()" required>
                            <label for="p_a_1">{{__('Private')}}</label>
                        </div>
                        <div class="form-check">
                            <input id="p_a_2" type="radio"
                            v-model="private_association" name="private_association" value="2" @change="association_selected()" required>
                            <label for="p_a_2">{{__('Legal entity')}}</label>
                        </div>
                    @error('private_association')
                        <div class="alert alert-danger">
                            {{__($message)}}
                        </div>
                    @enderror
                </div>
                <input v-if="private_association==1" type="hidden" name="account_type_id" value="2">
                <div v-else class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <label for="account-type-id" class="">{{__('Select an account')}}</label>
                    <div class="">
                        <select class="form-control" name="account_type_id"
                        v-model="account_selected" required v-cloak>
                            <option v-for="accountType in accountTypes" v-if="accountType.id!=2" :value="accountType.id">
                                @if($lang_id==2)
                                    @{{accountType.name}}
                                @else
                                    @{{accountType.name_en}}
                                @endif
                            </option>
                        </select>
                        @error('account_type_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{__($message)}}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <p v-for="accountType in accountTypes" v-if="account_selected==accountType.id" class="col-12 pt-2 mini-txt" v-cloak>
                    @if($lang_id==2)
                        @{{accountType.description}}
                    @else
                        @{{accountType.description_en}}
                    @endif
                </p>

                <div class="">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <label v-if="account_selected==2" for="name" class="">{{__('Name and Surname')}}*</label>
                        <label v-else for="name" class="">{{__('Name')}}*</label>
                        <div class="">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" minlength="3" maxlength="70" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{__($message)}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <p class="mini-txt ml-3 pt-2">{{__('When filling in, please enter truthful information. Your profile will be quality checked by the admins')}}</p>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <button type="submit" class="button-style button-color">
                        {{__('Confirm')}}
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

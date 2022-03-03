@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = "{{$user}}";
    services = "{{$services}}";
</script>
<div class="container">
    <div id="service-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit services')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.give-user-services.update',$user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Modifica</h6>
                    </div>
                    <div v-for="(service,i) in services" class="" v-cloak>
                      {{-- <input type="hidden" name="services[]" :value="service.pivot.service_id"> --}}
                      <input type="hidden" name="services[]" :value="service.name">
                      <label for="">@{{service.name}}
                        <i class="fas fa-trash-alt" @click="removeService(i)"></i>
                      </label>
                    </div>
                    <div  class="search">
                        <input type="text" name="name" value="" placeholder="Nome abilità" v-model="service_name" @keyup.enter="searchService()" v-on:input="searchService()" maxlength="70" class="form-control" autocomplete="off">
                        @error ('service_name')
                            <div class="alert alert-danger">
                                {{__($message)}}
                            </div>
                        @enderror
                        <button type="button" name="button" @click="addManualService()" class="button-style button-color">Aggiungi</button>
                        <div :class="services_found.length>0?'found':'found d-none'" v-cloak>
                          <a class="item" v-for="service_found in services_found" @click="addService(service_found)">
                              @{{service_found.name}}
                          </a>
                        </div>
                    </div>
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

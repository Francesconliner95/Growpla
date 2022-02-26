@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    skill = "{{$skill}}";
</script>
<div class="container">
    <div id="skill-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit skill')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.skills.update',$skill->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Aggiungi skill</h6>
                    </div>
                    <div class="">
                      <input type="hidden" name="name" value="">
                      <input type="hidden" name="linkedin" value="">
                      <h6>Seleziona abilità</h6>
                      <div  class="search">
                          <input type="text" name="name" value="" placeholder="Nome abilità" v-model="skill_name" @keyup.enter="searchSkill()" v-on:input="searchSkill()" maxlength="70" class="form-control" autocomplete="off">
                          @error ('skill_name')
                              <div class="alert alert-danger">
                                  {{__($message)}}
                              </div>
                          @enderror
                          <div :class="skills_found.length>0?'found':'found d-none'">
                            <a class="item" v-for="skill_found in skills_found" @click="addSkill(skill_found)">
                                @{{skill_found.name}}
                            </a>
                          </div>
                      </div>
                    </div>
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
                <form method="post" action="{{ route('admin.skills.destroy', $skill->id)}}" class="p-0 m-0 d-inline-block">
                @csrf
                @method('DELETE')
                    <button class="button-style button-color-red ml-5" type="submit" name="button">
                        <i class="fas fa-trash-alt mr-1"></i>Elimina
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = "{{$user}}";
    skills = "{{$skills}}";
</script>
<div class="container">
    <div id="skill-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit skills')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.give_user_skills.update',$user->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Modifica</h6>
                    </div>
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
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

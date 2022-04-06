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
                    <h2>Competenze</h2>
                </div>
                <form method="POST" action="{{ route('admin.give_user_skills.update',$user->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        @if ($user->usertypes->contains(1))
                            <h6>Inserisci competenze per cui una startup dovrebbe sceglierti</h6>
                        @else
                            <h6>Inserisci competenze</h6>
                        @endif
                    </div>
                    <div v-for="(skill,i) in skills" class="d-inline-block border-style" v-cloak>
                      <input type="hidden" name="skills[]" :value="skill.name">
                      <span>@{{skill.name}}
                          <i class="fas fa-trash-alt" @click="removeSkill(i)"></i>
                      </span>
                    </div>
                    <div  class="search">
                        <div class="row">
                            <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
                                <input type="text" name="name" value="" placeholder="Nome competenza" v-model="skill_name" @keyup.enter="searchSkill()" v-on:input="searchSkill()" maxlength="70" class="form-control" autocomplete="off">
                                @error ('skill_name')
                                    <div class="alert alert-danger">
                                        {{__($message)}}
                                    </div>
                                @enderror
                            </div>
                            <button type="button" name="button" @click="addManualSkill()" class="button-style button-color-blue col-sm-2 col-md-2 col-lg-2 col-xl-2">Conferma</button>
                        </div>
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

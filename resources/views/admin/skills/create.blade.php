@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="skill-create">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Add skill')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.skills.store') }}">
                    @csrf

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
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    page = "{{$page}}";
    skills = "{{$skills}}";
</script>
<div class="container">
    <div id="page-usertypes-edit">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>{{__('Edit usertypes')}}</h2>
                    <h1>
                        <i class="fas fa-plus-circle"></i>
                    </h1>
                </div>
                <form method="POST" action="{{ route('admin.have-page-usertypes.update',$page->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <h6>Modifica</h6>
                    </div>
                    @foreach ($usertypes as $usertype)
                      @if($usertype->id==1 || $usertype->id==2)
                      <div>
                          @if($errors->any())
                            <input id="usertype-{{$usertype->id}}" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                            {{ in_array($usertype->id, old('usertypes', [])) ? 'checked=checked' : ''}}>
                          @else
                            <input id="usertype-{{$usertype->id}}" type="checkbox" name="usertypes[]" value="{{$usertype->id}}"
                            {{$page->have_page_usertypes->contains($usertype)?'checked=checked':''}}>
                          @endif
                          <label for="usertype-{{$usertype->id}}" class="active">
                              {{$usertype->name}}
                              @if($usertype->description)
                              <div class="info">
                                  <button aria-label="{{$usertype->description}}" data-microtip-position="top-right" data-microtip-size="large" role="tooltip">
                                  <i class="fas fa-info-circle"></i>
                              </div>
                              @endif
                          </label>
                          @if($usertype->id==1)
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
                          @endif
                      </div>
                      @endif
                    @endforeach
                    <button type="submit" class="button-style button-color">
                        {{__('Save')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

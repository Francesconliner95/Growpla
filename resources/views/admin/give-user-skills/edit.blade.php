@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    user = @json($user);
    skills = @json($skills);
</script>
<div id="skill-edit" style="background-image: url({{asset("storage/images/bg-servizi.svg") }}); background-position: right -300px bottom -7px; background-repeat: no-repeat; background-size: 700px 500px;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Competenze</h2>
                </div>
                <form method="POST" action="{{ route('admin.give_user_skills.update',$user->id)}}" id="skillForm">
                    @csrf
                    @method('PUT')
                    <div class="" style="min-height:300px;">
                        <div class="form-group">
                            @if ($user->usertypes->contains(1))
                                <h6>Perché una startup dovrebbe sceglierti?
                                </h6>
                            @else
                                <h6>Quali sono le tue competenze?</h6>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 pt-3 pb-3">
                            <div v-for="(skill,i) in skills" class="d-inline-block border-style txt-green bg-green font-weight-bold" v-cloak>
                              <input type="hidden" name="skills[]" :value="skill.name">
                              <span>@{{skill.name}}
                                  <i class="fas fa-times" @click="removeSkill(i)"></i>
                              </span>
                            </div>
                        </div>
                        <div  class="search pl-3">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5  mt-1 mb-1">
                                    <input type="text" name="name" value="" placeholder="Nome competenza" v-model="skill_name" @keyup.enter="addManualSkill()" v-on:input="searchSkill()" maxlength="25" class="form-control custom-input-green" autocomplete="off">
                                    @error ('skill_name')
                                        <div class="alert alert-danger">
                                            {{__($message)}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2 mt-1 mb-1">
                                    <button type="button" name="button" @click="addManualSkill()" class="button-style button-color-blue">Aggiungi</button>
                                </div>
                            </div>
                            <div :class="skills_found.length>0?'found':'found d-none'" v-cloak>
                                <a class="item" href="#" v-for="skill_found in skills_found" @click="addSkill(skill_found)">
                                    @{{skill_found.name}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <h6 class="col-sm-12 col-md-10 col-lg-8 col-xl-8 txt-blue mt-4">Inserisci competenze correlate a ciò che sai fare (SW utilizzati, linguaggi di programmazione, soft skill, aree di conoscenza e competenza e molto altro)</h6>
                    <div class="d-flex justify-content-between mt-5">
                        <div class="">

                        </div>
                        <button type="submit" class="button-style button-color">
                            {{$user->tutorial?'Avanti':'Salva'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

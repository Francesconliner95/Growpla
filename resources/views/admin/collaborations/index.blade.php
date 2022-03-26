@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    id = "{{$my_id}}";
    user_or_page = "{{$user_or_page}}";
</script>
<div class="container">
    <div id="collaboration-index">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <h2>Le mie collaborazioni</h2>
                </div>
                <div class="row">
                    <div v-for="collaboration in collaborations"class="col-sm-12 col-md-6 col-lg-4 col-xl-3  p-1" v-cloak>
                        <div class="card-list">
                            <div class="img-cont mini-img">
                              <img
                              v-if="collaboration.account.image"
                              :src="'/storage/' +collaboration.account.image" alt="" class="">
                            </div>
                            <div class="card-info">
                                <span>@{{collaboration.account.name}}
                                  @{{collaboration.account.surname?
                                  collaboration.account.surname:''}}
                                </span>
                                <a :href="collaboration.recipient_user_id?
                                '/admin/users/'+collaboration.account.id
                                :'/admin/pages/'+collaboration.account.id" class="button-style button-color">
                                    Visita profilo
                                </a>
                            </div class="inf">
                            <button class="edit-top-right button-style-circle button-color-gray" type="submit" name="button" @click="deleteCooperation(collaboration.id)">
                                <i class="fas fa-trash-alt mr-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 p-1">
                      <div class="page-list">
                          <a class="" href="{{ route('admin.collaborations.create',
                            ['id'=> $my_id,'user_or_page'=> $user_or_page]) }}">
                            <i class="fas fa-plus"></i>
                          </a>
                      </div>
                    </div>
                </div>
                <div v-if="prop_collaborations.length>0" class="" v-cloak>
                    <div class="header">
                        <h2>Da confermare</h2>
                    </div>
                    <div class="row">
                        <div v-for="collaboration in prop_collaborations"class="col-sm-12 col-md-6 col-lg-4 col-xl-3  p-1" v-cloak>
                            <div class="card-list">
                                <div class="img-cont mini-img">
                                  <img
                                  v-if="collaboration.account.image"
                                  :src="'/storage/' +collaboration.account.image" alt="" class="">
                                </div>
                                <div class="card-info">
                                    <span>@{{collaboration.account.name}}
                                      @{{collaboration.account.surname?
                                      collaboration.account.surname:''}}
                                    </span>
                                    <a :href="collaboration.sender_user_id?
                                    '/admin/users/'+collaboration.account.id
                                    :'/admin/pages/'+collaboration.account.id" class="button-style button-color">
                                        Visita profilo
                                    </a>
                                </div class="inf">
                                <button class="button-style button-color" type="submit" name="button" @click="confirmCooperation(collaboration.id)">
                                    Conferma
                                </button>
                                <button class="edit-top-right button-style-circle button-color-gray" type="submit" name="button" @click="deleteCooperation(collaboration.id)">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

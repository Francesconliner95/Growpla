@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    followed = @json($followed);
</script>
<div  id="follows-index" style="background-image: url({{asset("storage/images/bg-follow.svg") }}); background-position: left -250px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h2 class="text-center mb-3">Seguiti</h2>
                <div class="d-flex justify-content-center">
                    <div class="pr-4 col-sm-12 col-md-10 col-lg-9 col-xl-9">
                        <p v-if="followed.length==0  && !in_load" class="text-center" v-cloak>Nessun seguito</p>
                        <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                            <div class="spinner-border text-secondary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                      <div v-for="(following,i) in followed" class="sub-item-cont text-capitalize gray-cont p-2 pl-4" v-cloak>
                        <div v-if="following.user_id" class="row align-items-center">
                          <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 d-flex align-items-center">
                              <div class="img-cont mini-img mr-3">
                                  <img :src="'/storage/'+following.user_image" alt="">
                              </div>
                              <span class="text-capitalize font-weight-bold text-truncate">
                                  @{{following.user_name}} @{{following.user_surname}}
                              </span>
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 text-center">
                            <button type="button" name="button" class="button-style txt-blue font-weight-bold" @click="toggleFollow(following.user_id,1,i)">
                                Rimuovi
                            </button>
                            <a :href="'/admin/users/' + following.user_id" class="button-style button-color-green">
                            Visita profilo</a>
                          </div>
                        </div>
                        <div v-else class="row align-items-center">
                          <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 d-flex align-items-center">
                              <div class="img-cont mini-img mr-3">
                                  <img :src="'/storage/'+following.page_image" alt="">
                              </div>
                              <span class="text-capitalize font-weight-bold text-truncate">
                                  @{{following.page_name}}
                              </span>
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 text-center">
                            <button type="button" name="button" class="button-style txt-blue font-weight-bold" @click="toggleFollow(following.page_id,2,i)">
                                Rimuovi
                            </button>
                            <a :href="'/admin/pages/' + following.page_id" class="button-style button-color-green">
                            Visita profilo</a>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

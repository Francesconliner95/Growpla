@extends('layouts.app')

@section('content')
<script type="text/javascript">
    lang = "{{Auth::user()->language_id}}";
    collaborations = "{{json_encode($collaborations)}}";
    window.csrf_token = "{{ csrf_token() }}"; //token per axios api post/put/delete
</script>
<div id="collaboration-index">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <h3 >Collaborazioni</h3>
                <div class="">
                    {{-- <div v-for="collaboration in collaborations_show" class="row sub-section" v-cloak>
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 text-center">
                            <div class="">
                                <div class="img-cont medium-img">
                                    <img v-if="collaboration.account_1.image" :src="'/storage/' + collaboration.account_1.image" alt="">
                                </div>
                            </div>
                            <strong class="text-capitalize d-block">
                                @{{collaboration.account_1.user_or_page? collaboration.account_1.name +' ' +collaboration.account_1.surname : collaboration.account_1.name}}
                            </strong>
                            <div class="">
                                <a :href="collaboration.account_1.user_or_page?'/admin/users/'+ collaboration.account_1.id : '/admin/pages/'+ collaboration.account_1.id" class="button-style button-color">Visita profilo</a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2 col-xl-2 d-flex justify-content-center align-items-center">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 text-center">
                            <div class="">
                                <div class="img-cont medium-img">
                                    <img v-if="collaboration.account_2.image" :src="'/storage/' + collaboration.account_2.image" alt="">
                                </div>
                            </div>
                            <strong class="text-capitalize d-block">
                                @{{collaboration.account_2.user_or_page? collaboration.account_2.name +' ' +collaboration.account_2.surname : collaboration.account_2.name}}
                            </strong>
                            <div class="">
                                <a :href="collaboration.account_2.user_or_page?'/admin/users/'+ collaboration.account_2.id : '/admin/pages/'+ collaboration.account_2.id" class="button-style button-color">Visita profilo</a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div v-for="collaboration in collaborations_show" class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-1" style="height: 220px;" v-cloak>
                            <div class="card-collaboration d-flex justify-content-between">
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center coll-item">
                                    <div class="">
                                        <div class="img-cont medium-img">
                                            <img v-if="collaboration.account_1.image" :src="'/storage/' + collaboration.account_1.image" alt="">
                                        </div>
                                    </div>
                                    <p class="text-capitalize text-truncate font-weight-bold">
                                        @{{collaboration.account_1.user_or_page? collaboration.account_1.name +' ' +collaboration.account_1.surname : collaboration.account_1.name}}
                                    </p>
                                    <div class="coll-info">
                                      <a :href="collaboration.account_1.user_or_page?'/admin/users/'+ collaboration.account_1.id : '/admin/pages/'+ collaboration.account_1.id" class="button-style button-color-green">
                                            Visita profilo
                                        </a>
                                    </div>
                                </div>
                                <div class="link">
                                    <img src="/storage/images/icon-link.svg" alt="">
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center coll-item">
                                    <div class="">
                                        <div class="img-cont img-cont medium-img">
                                            <img v-if="collaboration.account_2.image" :src="'/storage/' + collaboration.account_2.image" alt="">
                                        </div>
                                    </div>
                                    <p class="text-capitalize text-truncate font-weight-bold">
                                        @{{collaboration.account_2.user_or_page? collaboration.account_2.name +' ' +collaboration.account_2.surname : collaboration.account_2.name}}
                                    </p>
                                    <div class="coll-info">
                                        <a :href="collaboration.account_2.user_or_page?'/admin/users/'+ collaboration.account_2.id : '/admin/pages/'+ collaboration.account_2.id" class="button-style button-color-blue">
                                            Visita profilo
                                        </a>
                                    </div>
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

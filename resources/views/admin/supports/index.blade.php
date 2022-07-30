@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script type="text/javascript">
    supportTypes = @json($supportTypes);
    usertypes = @json($usertypes);
    users_date = @json($users_date);
    pages_date = @json($pages_date);
    users_comp_date = @json($users_complete_date);
    users_incomp_date = @json($users_not_complete_date);
</script>
<div id="support-index" class="container">
    <div class="item-cont">
        <div class="item-style">
            <h2>Pannello di controllo admin</h2>
            <div class="menu pb-3">
                <h5>Gestisci</h5>
                <a href="{{ route('admin.blogs.index')}}" class="txt-green">News</a>
            </div>
            <div class="info-generali pb-3">
                <h5>Info Generali</h5>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <h6>Utenti e pagine:
                            {{$user + $page}}
                        </h6>
                        <h6>Utenti: {{$user}}</h6>
                        <ul>
                            @for ($i=0; $i < count($usertypes['name']); $i++)
                                <li class="text-capitalize">
                                    {{$usertypes['name'][$i]}}:
                                    {{$usertypes['count'][$i]}}
                                </li>
                            @endfor
                        </ul>
                        <h6>Pagine: {{$page}}</h6>
                        <ul>
                            @foreach ($pagetypes as $pagetype)
                                <li class="text-capitalize">{{$pagetype->name_it}}: {{App\Page::where('pagetype_id',$pagetype->id)->count()}}</li>
                            @endforeach
                        </ul>
                        <h6>Collaborazioni verificate: {{$collaborations_ver}}</h6>
                        <h6>Collaborazioni suggerite ora: {{$collaborations_rec}}</h6>
                        <h6>Chat: {{$chats_cont}}</h6>
                        <h6>Messaggi: {{$messages_cont}}</h6>
                        <h6>Seguiti: {{$follows_cont}}</h6>
                        <h6>Offerte: {{$offers_cont}}</h6>
                        <h6>Neccessità: {{$needs_cont}}</h6>
                        <h6>Utenti che hanno completato la registrazione: {{$user_complete}}</h6>
                        <h6>Pagine che hanno completato la registrazione: {{$page_complete}}</h6>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="py-3">
                            <h6>Utenti e pagine</h6>
                            <canvas id="usersDate"></canvas>
                            <div class="row pt-2 px-2">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0">
                                    <select class="form-control" v-model="year_selected" @change="select_year">
                                        <option value="">Da sempre</option>
                                        <option v-for="year in years" :value="year">@{{year}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0">
                                    <select v-if="year_selected" class="form-control" v-model="month_selected" @change="select_month()">
                                        <option value="">Tutto</option>
                                        <option value="01">Gennaio</option>
                                        <option value="02">Febbraio</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Aprile</option>
                                        <option value="05">Maggio</option>
                                        <option value="06">Giungo</option>
                                        <option value="07">Luglio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Settembre</option>
                                        <option value="10">Ottobre</option>
                                        <option value="11">Novembre</option>
                                        <option value="12">Dicembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="py-3">
                            <h6>Completamento registrazione</h6>
                            <canvas id="usersComplete"></canvas>
                            <div class="row pt-2 px-2">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0">
                                    <select class="form-control" v-model="year_comp_selected" @change="select_comp_year">
                                        <option value="">Da sempre</option>
                                        <option v-for="year in years" :value="year">@{{year}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0">
                                    <select v-if="year_comp_selected" class="form-control" v-model="month_comp_selected" @change="select_comp_month()">
                                        <option value="">Tutto</option>
                                        <option value="01">Gennaio</option>
                                        <option value="02">Febbraio</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Aprile</option>
                                        <option value="05">Maggio</option>
                                        <option value="06">Giungo</option>
                                        <option value="07">Luglio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Settembre</option>
                                        <option value="10">Ottobre</option>
                                        <option value="11">Novembre</option>
                                        <option value="12">Dicembre</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <h6>Tipologia di utenti</h6>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <h5>Messaggi</h5>
                <div v-for="support in supports"class="sub-item-cont p-1" v-cloak>
                    <a :href="'./supports/' + support.id"
                    class="sub-item-style d-inline-block col-12 p-1 pl-2 pr-2"
                    :class="!support.readed?'bg-green':''">
                        <div class="row pl-3">
                            <div class="">@{{support.id}})</div>
                            <div class="col-2">User_id: @{{support.user_id}}</div>
                            <div class="text-capitalize font-weight-bold col-4">
                                @{{support.name}} @{{support.surname}}
                            </div>
                            <div class="col-4">@{{support.email}}</div>
                        </div>
                        <div class="">
                            <p class="m-0">
                                Categoria:
                                <span class="font-weight-bold">@{{supportTypes[support.support_type_id-1].name_it}}</span>
                            </p>
                            <span class="d-block">@{{support.title}}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

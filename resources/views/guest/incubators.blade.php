@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div id="incubators" style="background-image: url({{asset("storage/images/bg-shadow.svg") }}); background-position: left -150px top 0px; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="container not-log-main-hg">
        <div class="item-cont">
            <div class="item-style">
                <h3 class="text-center mb-4">
                    Incubatori - Acceleratori
                </h3>
                <div class="mb-5 row">
                    <select class="form-control col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-auto custom-select-blue" name="regions" @change="filterByRegion()" v-model="region_id_selected">
                        <option value="">Tutte le regioni</option>
                        @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-auto ">
                        <input type="text" name="" value=""
                        v-model="name" class="form-control custom-input-blue" v-on:input="searchByName()" placeholder="Cerca per nome">
                    </div>
                </div>
                <div class="row">
                    <div v-if="incubators_show.length>0" v-for="incubator in incubators_show"
                    class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center p-2" v-cloak>
                        <a v-if="incubator.website" :href="incubator.website" target="_blank" class="d-inline-block">
                            <img :src="'/storage/'+incubator.image" alt="" style="width: 80%; height: 100px; object-fit: contain;">
                        </a>
                        <h5 class="font-weight-bold m-0 text-truncate">@{{incubator.name}}</h5>
                        <span class="d-block">@{{incubator.region_name}}</span>
                        <div class="mt-1" style="height: 40px;">
                            <a v-if="incubator.page_id" :href="'/admin/pages/'+incubator.page_id" class="button-style button-color-green">Vedi Profilo</a>
                            {{-- <a v-if="incubator.page_id" :href="'/admin/pages/'+incubator.page_id" class="button-style button-color-blue">Messaggio</a> --}}
                        </div>
                    </div>
                </div>
                <div v-if="incubators_show.length==0  && !in_load" class="w-100" v-cloak>
                    <h5 class="text-center">Nessun incubatore</h5>
                </div>
                <div v-if="in_load" class="d-flex justify-content-center" v-cloak>
                    <div class="spinner-border text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

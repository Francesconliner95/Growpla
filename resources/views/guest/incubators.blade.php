@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    incubators = "{{$incubators}}";
</script>
    <div id="incubators" class="container not-log-main-hg">
        <div class="item-cont">
            <div class="item-style">
                <h3 class="text-center mb-4">
                    Incubatori
                </h3>
                <div class="mb-5">
                    <select class="form-control col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-auto" name="regions" @change="filterByRegion()" v-model="region_id_selected">
                        <option value="">Tutte le regioni</option>
                        @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div v-for="incubator in incubators_show"
                    class="col-sm-12 col-md-6 col-lg-4 col-xl-3 text-center p-2" v-cloak>
                        <a v-if="incubator.website" :href="incubator.website" target="_blank" class="d-inline-block">
                            <img :src="'/storage/'+incubator.image" alt="" style="width: 80%; height: 100px; object-fit: contain;">
                        </a>
                        <h5 class="font-weight-bold m-0 text-truncate">@{{incubator.name}}</h5>
                        <span class="d-block">@{{incubator.region_name}}</span>
                        <div class="mt-1" style="height: 40px;">
                            <a v-if="incubator.page_id" :href="'/admin/pages/'+incubator.page_id" class="button-style button-color-green">Vedi Profilo</a>
                            <a v-if="incubator.page_id" :href="'/admin/pages/'+incubator.page_id" class="button-style button-color-blue">Messaggio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

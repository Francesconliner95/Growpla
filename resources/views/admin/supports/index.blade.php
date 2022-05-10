@extends('layouts.app')

@section('content')
<script type="text/javascript">
    supportTypes = @json($supportTypes);
</script>
<div id="support-index" class="container">
    <div class="item-cont">
        <div class="item-style">
            <h2>Messaggi</h2>
            <div v-for="support in supports"class="sub-item-cont p-1">
                <a :href="'./supports/' + support.id"
                class="sub-item-style d-inline-block col-12 p-1 pl-2 pr-2 scale"
                :class="!support.readed?'bg-green':''">
                    <span>@{{support.id}})</span>
                    <span>User_id(@{{support.user_id}})</span>
                    <span>@{{support.email}}</span>
                    <h6>
                        @{{supportTypes[support.support_type_id-1].name}}
                    </h6>
                    <span class="d-block">@{{support.title}}</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

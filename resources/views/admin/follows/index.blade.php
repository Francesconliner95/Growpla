@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    my_follows = {!! json_encode($my_follows->toArray()) !!};    
</script>
<div class="container">
    <div  id="follows-index">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <div class="">
                        <h2>Seguiti</h2>
                    </div>
                    <h1>
                        <i class="fas fa-user-check"></i>
                    </h1>
                </div>
                <p v-if="my_follows.length<1">Nessun seguito</p>
                <div v-for="my_follow in my_follows" class="follow-item sub-item-cont">
                    <a :href="'/admin/accounts/' + my_follow.account_id" class="sub-item-style">
                        @{{my_follow.name}}
                    </a>
                    <button type="button" name="button" class="button-style button-color" @click="setFollow(my_follow.account_id)">
                        {{-- <i class="fas fa-user-check"></i> --}}
                        {{-- <i class="fas fa-user-plus"></i>--}}
                        <i class="fas fa-user-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

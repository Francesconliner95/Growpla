@extends('layouts.app')

@section('content')
<script type="text/javascript">
    chats = {!! json_encode($chats->toArray()) !!};
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="chat-index">
        <div class="item-cont h-100">
            <div class="item-style h-100">
                <div class="header">
                    <h2>{{__('Chats')}}</h2>
                    <h1>
                        <i class="fas fa-comments"></i>
                    </h1>
                </div>
                <div class="chat-cont">
                    <p v-if="chats.length<1">{{__('No conversation started, to start one press message go to the account concerned')}}</p>
                    <a v-for="chat in chats" :href="'/admin/chats/' + chat.id" class="chat-item">
                        <span class="text-capitalize">@{{chat.name}}</span>
                        <span class="mini-txt">@{{lang==1?chat.account_type_name_en:chat.account_type_name}}</span>
                        <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

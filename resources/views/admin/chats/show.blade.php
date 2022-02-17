@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    my_account_id = "{{ $my_account_id }}";
    chat_id = "{{ $chat_id }}";
    your_account = {!! json_encode($your_account->toArray()) !!};
</script>
<div class="container">
    <div id="chat-show">
        <div class="item-cont h-100">
            <div class="item-style h-100" v-cloak>
                <div class="header">
                    <h4 class="">
                        <a :href="'/admin/accounts/'+ your_account.id" class="text-capitalize txt-green">@{{your_account.name}}</a>
                    </h4>
                    <h1>
                        <i class="fas fa-comment"></i>
                    </h1>
                </div>
                <div class="messages-cont" id="scroll-messages">
                    <div
                    v-for="message in messages.slice().reverse()"
                    :class="message.sender_account_id==my_account_id?'my-message-item message-item':'message-item'">
                        <span>@{{message.message}}
                            <small>@{{getDate(message.created_at)}}</small>
                        </span>
                    </div>
                </div>
                <div class="messages-footer">
                    <input v-model="message_text" @keyup.enter="sendMessage()" type="text" name="" value="" class="input" placeholder="{{__('Write a message')}}...">
                    <button type="button" name="button" @click="sendMessage()" class="button-style button-color">{{__('Send')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

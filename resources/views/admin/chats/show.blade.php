@extends('layouts.app')

@section('content')
<script type="text/javascript">
    window.csrf_token = "{{ csrf_token() }}";
    chat_id = "{{$chat_id}}";
    my_user_id = "{{$my_user_id}}";
    your_user_id = "{{$your_user_id}}";
    my_page_id = "{{$my_page_id}}";
    your_page_id = "{{$your_page_id}}";
    displayed_name = "{{$displayed_name}}";
</script>
<div id="chat-show">
    <div class="container h-100">
        <div class="item-cont h-100">
            <div class="item-style h-100" v-cloak>
                <div class="header">
                    <h4 class="">
                        <a href="{{$your_user_id?route('admin.users.show',$your_user_id):route('admin.pages.show',$your_page_id)}}" class="text-capitalize text-dark">
                            {{$displayed_name}}
                        </a>
                        <div class="img-cont micro-img no-br">
                            <img src="{{ asset("storage/images/icon-chat.svg") }}" alt="">
                        </div>
                    </h4>
                </div>
                <div style="height: calc(100vh - 200px);">
                    <div class="messages-cont custom-scrollbar" id="scroll-messages">
                        <div
                        v-for="message in messages.slice().reverse()"
                        :class="message.sender_user_id==my_user_id || message.sender_page_id==my_page_id?'my-message-item message-item':'message-item'">
                            <span>@{{message.message}}
                                <small>@{{getDate(message.created_at)}}</small>
                            </span>
                        </div>
                    </div>
                    <div class="messages-footer">
                        <input v-model="message_text" @keyup.enter="sendMessage()" type="text" name="" value="" class="custom-input" placeholder=" {{__('Write a message')}}...">
                        <button type="button" name="button" @click="sendMessage()" class="button-style button-color">{{__('Send')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

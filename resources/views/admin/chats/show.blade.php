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
    <div class="container">
        <div class="item-cont">
            <div class="item-style" v-cloak>
                <div class="header">
                    <h4 class="">
                        <a href="{{$your_user_id?route('admin.users.show',$your_user_id):route('admin.pages.show',$your_page_id)}}" class="text-capitalize text-dark">
                            {{$displayed_name}}
                        </a>
                        <div class="img-cont micro-img">
                            <img src="{{ asset("storage/images/icon-chat.svg") }}" alt="" class="rounded-0">
                        </div>
                    </h4>
                </div>
                <div class="chat-section">
                    <div :class="longtext?'chat-show chat-show-longtext':'chat-show' ">
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
                            {{-- <input v-model="message_text" @keyup.enter="sendMessage()" type="text" name="" value="" class="custom-input-blue" placeholder=" {{__('Write a message')}}..."> --}}
                            <textarea name="name" rows="1" v-model="message_text" type="text" name="" value="" class="custom-input-blue custom-scrollbar" placeholder=" {{__('Write a message')}}..." id="mytextarea" @input="text_wrap()"></textarea>
                            <button type="button" name="button" @click="sendMessage()" class="button-style button-color">{{__('Send')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    my_user_chats = "{{$my_user_chats}}";
    my_pages_chats = "{{$my_pages_chats}}";
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="chat-index">
        <div class="item-cont h-100">
            <div class="item-style h-100">
                <div class="header">
                    <h2>{{__('Chats')}}</h2>
                    <h4 v-if="!is_mobile" class="">
                        <a :href="your_user_id?
                        '/admin/users/' + your_user_id
                        :'/admin/pages/' + your_page_id"
                        class="text-capitalize txt-green" v-cloak>@{{displayed_name}}</a>
                    </h4>
                    <i class="fas fa-comments"></i>
                </div>
                <div class="row">
                    <div class="chat-cont custom-scrollbar col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-capitalize" v-cloak>@{{my_user_chats.name}} @{{my_user_chats.surname}}</h6>
                        <p v-if="!my_user_chats.user_chats" v-cloak>{{__('No conversation started, to start one press message go to the account concerned')}}</p>
                        <a v-else v-for="chat in my_user_chats.user_chats"
                         {{-- :href="'/admin/chats/show/' + chat.id + '/' + 'user'" --}}
                        @click="pressChat(my_user_chats,chat)"
                          class="chat-item" v-cloak>
                            <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                            <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                        </a>
                        <div v-for="page in my_pages_chats" class="" v-cloak>
                            <div v-show="page.page_chats!=''" class="">
                                <h6 class="text-capitalize">@{{page.name}}</h6>
                                <a v-for="chat in page.page_chats" @click="pressChat(page,chat)"
                                {{-- :href="'/admin/chats/show/' + chat.id + '/' + page.id"  --}}
                                class="chat-item">
                                    <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                                    <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="!is_mobile" class="col-sm-12 col-md-9 col-lg-9 col-xl-9" v-cloak>
                        <div v-if="displayed_name" class="chat-show">
                            <div class="messages-cont" id="scroll-messages">
                                <div
                                v-for="message in messages.slice().reverse()"
                                :class="message.sender_user_id==my_user_id || message.sender_page_id==my_page_id?'my-message-item message-item':'message-item'" v-cloak>
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
                        <div v-else class="h-100 d-flex justify-content-center align-items-center">
                            <h4>Seleziona un chat per iniziare</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

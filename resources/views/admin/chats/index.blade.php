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
                    <h4 v-if="!is_mobile" class="text-dark">
                        <a :href="your_user_id?
                        '/admin/users/' + your_user_id
                        :'/admin/pages/' + your_page_id"
                        class="text-capitalize text-dark font-weight-bold" v-cloak>@{{displayed_name}}</a>
                        <i class="fas fa-comment"></i>
                    </h4>
                </div>
                <div class="row" style="height: 85%;">
                    <div class="chat-cont custom-scrollbar col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div v-if="my_user_chats.user_chats && my_user_chats.user_chats.length>0" class="account" v-cloak>
                            <button class="text-dark d-flex justify-content-between align-items-center w-100 pb-2" @click="selectAccount(0,true)" v-cloak>
                              <div>
                                  <span class="text-capitalize font-weight-bold w-100 d-inline-block text-left">
                                      @{{my_user_chats.name}}    @{{my_user_chats.surname}}
                                  </span>
                                  <span v-if="my_user_chats.all_mnr" class="d-block mini-txt">Hai @{{my_user_chats.all_mnr}} @{{my_user_chats.all_mnr<=1?'messaggo non letto':'messaggi non letti'}}
                                      <span class="notread"></span>
                                  </span>
                              </div>
                              <div class="micro-img">
                                  <img src="/storage/images/arrows-black-icon.svg" id="arrow-0" class="p-2 r-90r" alt="">
                              </div>
                            </button>
                            <a v-for="chat in my_user_chats.user_chats"
                            @click="pressChat(my_user_chats,chat,'chat-item-0')"
                              class="active chat-item d-none" id="chat-item-0" v-cloak>
                                <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                                <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                            </a>
                        </div>
                        <div v-for="(page,i) in my_pages_chats"
                        v-show="page.page_chats!=''" class="account" v-cloak>
                            <button class="font-weight-bold text-dark d-flex justify-content-between align-items-center w-100 pb-2" @click="selectAccount(i,false)">
                                <div>
                                    <span class="text-capitalize font-weight-bold text-left w-100 d-inline-block text-left">
                                        @{{page.name}}
                                    </span>
                                    <span v-if="page.all_mnr" class="d-block mini-txt">Hai @{{page.all_mnr}} @{{page.all_mnr<=1?'messaggo non letto':'messaggi non letti'}}
                                        <span class="notread"></span>
                                    </span>
                                </div>
                                <div class="micro-img">
                                    <img src="/storage/images/arrows-black-icon.svg" :id="'arrow-'+(i+1)" class="p-2 r-90r" alt="">
                                </div>
                            </button>
                            <a v-for="chat in page.page_chats" @click="pressChat(page,chat,'chat-item-'+(i+1))"
                            class="chat-item  d-none" :id="'chat-item-'+(i+1)">
                                <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                                <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                            </a>
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
{{-- <p v-if="!my_user_chats.user_chats" v-cloak>{{__('No conversation started, to start one press message go to the account concerned')}}</p> --}}

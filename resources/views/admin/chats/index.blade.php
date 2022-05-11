@extends('layouts.app')

@section('content')
<script type="text/javascript">
    my_user_chats = @json($my_user_chats);
    my_pages_chats = @json($my_pages_chats);
    lang = "{{Auth::user()->language_id}}";
    window.csrf_token = "{{ csrf_token() }}";
</script>
<div id="chat-index">
    <div class="container">
        <div class="item-cont">
            <div class="item-style">
                <div class="header">
                    <div class="">
                        <h2 class="d-inline-block pr-1">{{__('Chats')}}</h2>
                        <div class="img-cont micro-img">
                            <img src="{{ asset("storage/images/icon-chat.svg") }}" alt="" class="rounded-0">
                        </div>
                    </div>
                    <h4 v-if="!is_mobile" class="text-dark">
                        <a :href="your_user_id?
                        '/admin/users/' + your_user_id
                        :'/admin/pages/' + your_page_id"
                        class="text-capitalize text-dark font-weight-bold" v-cloak>@{{displayed_name}}</a>

                    </h4>
                </div>
                <div class="row chat-section">
                    <div class="chat-cont custom-scrollbar col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div v-if="my_user_chats.user_chats && my_user_chats.user_chats.length>0" class="account" v-cloak>
                            <button class="text-dark d-flex justify-content-between align-items-center w-100 pb-2" @click="selectAccount(0,true)" v-cloak>
                              <div>
                                  <span class="text-capitalize font-weight-bold w-100 d-inline-block text-left pl-2">
                                      @{{my_user_chats.name}}    @{{my_user_chats.surname}}
                                  </span>
                                  <span v-if="my_user_chats.all_mnr" class="d-block mini-txt pl-2">Hai @{{my_user_chats.all_mnr}} @{{my_user_chats.all_mnr<=1?'messaggo non letto':'messaggi non letti'}}
                                      <span class="notread"></span>
                                  </span>
                              </div>
                                <i class="fas fa-angle-down mr-2" id="arrow-0"></i>
                              {{-- <div class="micro-img">
                                  <img src="/storage/images/arrows-black-icon.svg" id="arrow-0" class="p-2 r-90r" alt="">

                              </div> --}}
                            </button>
                            <div class="d-none" id="chat-item-0">
                                <a v-for="(chat,i) in my_user_chats.user_chats"
                                @click="pressChat(my_user_chats,chat,'chat-item-0-'+i)" :id="'chat-item-0-'+i" class="chat-item" v-cloak>
                                    <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                                    <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                                </a>
                            </div>
                        </div>
                        <div v-for="(page,index) in my_pages_chats"
                        v-show="page.page_chats!=''" class="account" v-cloak>
                            <button class="font-weight-bold text-dark d-flex justify-content-between align-items-center w-100 pb-2" @click="selectAccount(index,false)">
                                <div>
                                    <span class="text-capitalize font-weight-bold text-left w-100 d-inline-block text-left pl-2">
                                        @{{page.name}}
                                    </span>
                                    <span v-if="page.all_mnr" class="d-block mini-txt">Hai @{{page.all_mnr}} @{{page.all_mnr<=1?'messaggo non letto':'messaggi non letti'}}
                                        <span class="notread"></span>
                                    </span>
                                </div>
                                <i class="fas fa-angle-down mr-2" :id="'arrow-'+(index+1)"></i>
                                {{-- <div class="micro-img">
                                    <img src="/storage/images/arrows-black-icon.svg" :id="'arrow-'+(index+1)" class="p-2 r-90r" alt="">
                                </div> --}}
                            </button>
                            <div class="d-none" :id="'chat-item-'+(index+1)">
                                <a v-for="(chat,i) in page.page_chats" @click="pressChat(page,chat,'chat-item-'+(index+1)+'-'+i)"
                                class="chat-item"
                                :id="'chat-item-'+(index+1)+'-'+i">
                                    <span class="text-capitalize">@{{chat.user_id?chat.name + ' '+ chat.surname : chat.name}}</span>
                                    <span v-if="chat.message_not_read" class="not">@{{chat.message_not_read}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-if="!is_mobile" class="col-sm-12 col-md-9 col-lg-9 col-xl-9 h-100" v-cloak>
                        <div v-if="displayed_name" class="chat-show">
                            <div class="messages-cont custom-scrollbar" id="scroll-messages">
                                <div
                                v-for="message in messages.slice().reverse()"
                                :class="message.sender_user_id==my_user_id || message.sender_page_id==my_page_id?'my-message-item message-item':'message-item'" v-cloak>
                                    <span>@{{message.message}}
                                        <small>@{{getDate(message.created_at)}}</small>
                                    </span>
                                </div>
                            </div>
                            <div class="messages-footer">
                                <textarea name="name" rows="1" v-model="message_text" @keyup.enter="sendMessage()" type="text" name="" value="" class="custom-input-blue custom-scrollbar" placeholder=" {{__('Write a message')}}..."></textarea>
                                {{-- <input v-model="message_text" @keyup.enter="sendMessage()" type="text" name="" value="" class="custom-input-blue" placeholder=" {{__('Write a message')}}..."> --}}
                                <button type="button" name="button" @click="sendMessage()" class="button-style button-color">{{__('Send')}}</button>
                            </div>
                        </div>
                        <div v-else class="h-100 d-flex justify-content-center align-items-center">
                            <div class="text-center">
                                <h4>Seleziona un chat per iniziare</h4>
                                <p class="mini-txt txt-blue">Per avviare una nuova convesazione cerca il profilo interessato e premi sul pulsante "messaggio"</p>
                                <a href="{{route('admin.search')}}" class="button-style button-color-blue">Cerca</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <p v-if="!my_user_chats.user_chats" v-cloak>{{__('No conversation started, to start one press message go to the account concerned')}}</p> --}}

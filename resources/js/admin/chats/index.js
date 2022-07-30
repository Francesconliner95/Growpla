import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#chat-index',
    data: {
        my_user_chats,
        my_pages_chats,
        lang,
        //MESSAGES
        chat_id : '',
        my_user_id : '',
        your_user_id : '',
        my_page_id : '',
        your_page_id : '',
        displayed_name: '',
        message_text: '',
        messages: [],
        messages_qty: 0,
        first_scroll: false,
        is_mobile: false,
        chat_selected_id: '',
        in_load: false,
        longtext: false,
        can_create_coll: false,
    },

    methods: {

        selectAccount(i,user_or_page){
            if(user_or_page){
                if(document.getElementById('chat-item-0').classList.contains('d-none')){
                    document.getElementById('chat-item-0').classList.remove("d-none");
                    document.getElementById('arrow-0').classList.remove("r-0");
                    document.getElementById('arrow-0').classList.add("r-180");
                }else{
                    document.getElementById('chat-item-0').classList.add("d-none");
                    document.getElementById('arrow-0').classList.remove("r-180");
                    document.getElementById('arrow-0').classList.add("r-0");
                }
            }else{
                if(document.getElementById('chat-item-'+(i+1)).classList.contains('d-none')){
                    document.getElementById('chat-item-'+(i+1)).classList.remove("d-none");
                    document.getElementById('arrow-'+(i+1)).classList.remove("r-0");
                    document.getElementById('arrow-'+(i+1)).classList.add("r-180");
                }else{
                    document.getElementById('chat-item-'+(i+1)).classList.add("d-none");
                    document.getElementById('arrow-'+(i+1)).classList.remove("r-180");
                    document.getElementById('arrow-'+(i+1)).classList.add("r-0");
                }
            }
        },

        orderByUpdatedAt(object){
            for (var i=0; i < object.length; i++) {
                for (var j=0; j < object.length-1; j++) {
                    if (new Date(object[j].updated_at)<new Date(object[i].updated_at)) {
                      var tmp=object[j];
                      object[j]=object[i];
                      object[i]=tmp;
                    }
                }
            }
            return object;
        },

        pressChat(account,chat,html_id){
            // console.log(account);
            // console.log(this.my_user_chats);

            // se cambio chat
            if(chat.id!=this.chat_id){
                this.messages = [];
                this.my_user_id = '';
                this.your_user_id = '';
                this.my_page_id = '';
                this.your_page_id = '';

                this.chat_id = chat.id;
                if(account.user_chats){
                    this.my_user_id = account.id;
                }
                if(account.page_chats){
                    this.my_page_id = account.id;
                }
                if(chat.user_id){
                    this.your_user_id = chat.user_id;
                    this.displayed_name = chat.name + ' ' + chat.surname;
                    if(chat.message_not_read>0){
                        this.my_user_chats.user_chats.forEach((user_chat, i) => {
                            if(user_chat.id==chat.id){
                                this.my_user_chats.all_mnr = this.my_user_chats.all_mnr - user_chat.message_not_read;
                                user_chat.message_not_read = 0;
                            }
                        });
                    }
                }
                if(chat.page_id){
                    this.your_page_id = chat.page_id;
                    this.displayed_name = chat.name;
                    //console.log(this.my_pages_chats);
                    this.my_pages_chats.forEach((my_page_chats, i) => {
                        if(chat.message_not_read>0){
                            my_page_chats.page_chats.forEach((page_chat, i) => {
                                if(page_chat.id==chat.id){
                                    my_page_chats.all_mnr = my_page_chats.all_mnr - page_chat.message_not_read;
                                    page_chat.message_not_read = 0;
                                }
                            });
                        }
                    });
                }

                var elements = document.getElementsByClassName('chat-item');
                for (var j = 0; j < elements.length; j++) {
                    elements[j].classList.remove("active");
                }
                document.getElementById(html_id).classList.add('active');


                if(window.innerWidth>=768){
                    // console.log('stai');
                    this.chat_selected_id = chat.id;
                    this.getMessages(true);
                }else{
                    // console.log('esci');
                    if (this.my_page_id) {
                        window.location = '/admin/chats/show/' + chat.id + '/' + this.my_page_id;
                    }else{
                        window.location = '/admin/chats/show/' + chat.id + '/' + 'user';
                    }
                }
            }
        },

        sendMessage(){
            if(this.message_text){
                var message_text = this.message_text;
                this.message_text = '';
                this.longtext = false;
                axios({
                    method: 'post',
                    url: '/admin/newMessage',
                    data: {
                        chat_id: this.chat_id,
                        my_user_id: this.my_user_id,
                        my_page_id: this.my_page_id,
                        message_text: message_text,
                    }
                }).then(response => {
                    this.first_scroll = false;
                    this.can_create_coll = true;
                    this.getMessages();
                });
            }
        },

        getMessages(scroll){
            this.in_load = true;
            axios.get('/admin/getMessages',{
                params: {
                    chat_id: this.chat_id,
                    my_user_id: this.my_user_id,
                    my_page_id: this.my_page_id,
                    messages_qty: this.messages_qty,
                }
            }).then((response) => {
                this.messages = response.data.results.messages;
                this.in_load = false;
                if (!this.first_scroll || scroll) {
                    this.first_scroll = true;
                    this.scroll();
                }
                //creazione della collaborazione se sono stati scambiati più di 1 messaggio e c'è stata una risposta
                if(this.can_create_coll && this.messages.length>1){
                    var first_message_sender = {
                        id: this.messages[0].sender_user_id?
                                    this.messages[0].sender_user_id:
                                    this.messages[0].sender_page_id,
                        user_or_page: this.messages[0].sender_user_id?
                                        'user':'page',
                    };
                    var answer_exist = false;

                    for (var i = 0; i < this.messages.length; i++) {
                        if (first_message_sender.id!=this.messages[i].sender_user_id){
                            answer_exist = true;
                            break;
                        }else{
                            if(first_message_sender.user_or_page=='user'){
                                if(this.messages[i].user_or_page=='page'){
                                    answer_exist = true;
                                    break;
                                }
                            }else{
                                if(this.messages[i].user_or_page=='user'){
                                    answer_exist = true;
                                    break;
                                }
                            }
                        }
                    }

                    if(answer_exist){
                        var message = this.messages[0];
                        if(message.sender_user_id){
                            var sender_id = message.sender_user_id;
                            var sender_user_or_page = 'user';
                        }
                        if(message.sender_page_id){
                            var sender_id = message.sender_page_id;
                            var sender_user_or_page = 'page';
                        }
                        if(message.recipient_user_id){
                            var recipient_id = message.recipient_user_id;
                            var recipient_user_or_page = 'user';
                        }
                        if(message.recipient_page_id){
                            var recipient_id = message.recipient_page_id;
                            var recipient_user_or_page = 'page';
                        }
                        this.addCollaboration(sender_id,sender_user_or_page,recipient_id,recipient_user_or_page);
                    }
                }
                this.can_create_coll = false;

            });
        },
        scroll(){
            setTimeout(()=>{
                var elem = document.getElementById('scroll-messages');
                elem.scrollTop = elem.scrollHeight;
                //console.log('scroll');
            }, 100);
        },
        getDate(created_at){
            const date = new Date(created_at);
            let hours = date.getHours();
            if(hours<10){
                hours = '0'+ hours.toString();
            }
            let minutes = date.getMinutes();
            if(minutes<10){
                minutes = '0'+ minutes.toString();
            }
            const day = String(date.getDate()).padStart(2, '0');
            const month = date.getMonth()+1;
            const year = date.getFullYear();
            const output =   hours +':'+ minutes + ' ' +day + '/' + month + '/' + year;
            return output;
        },

        checkMobile(){
            if(window.innerWidth>=768){
                if(this.is_mobile){
                    this.is_mobile = false;
                }
            }else{
                if(!this.is_mobile){
                    this.is_mobile = true;
                }
            }
        },

        text_wrap(){
            // console.log(document.getElementById("mytextarea").scrollHeight>31);
            if(document.getElementById("mytextarea").scrollHeight>31 && this.message_text.length>0){
                this.longtext = true;
                this.scroll();
            }else{
                this.longtext = false;
            }
        },

        addCollaboration(sender_id,sender_user_or_page,recipient_id,recipient_user_or_page){
            axios({
                method: 'post',
                url: '/admin/collaborations',
                data: {
                    sender_id: sender_id,
                    sender_user_or_page: sender_user_or_page,
                    recipient_id: recipient_id,
                    recipient_user_or_page: recipient_user_or_page,
                    hidden: true,
                }
            }).then(response => {});
        },

    },
    created(){
        if(this.my_user_chats){
            this.my_user_chats['show'] = false;
            this.my_user_chats.user_chats = this.orderByUpdatedAt(this.my_user_chats.user_chats);

            //SOMMA DEI MESSAGGI NON LETTI DELL'UTENTE
            this.my_user_chats['all_mnr'] = 0;
            this.my_user_chats.user_chats.forEach((chat, i) => {
                this.my_user_chats['all_mnr'] = this.my_user_chats['all_mnr'] + chat['message_not_read'];
            });
        }
        //console.log(this.my_user_chats);
        if(this.my_pages_chats){
            this.my_pages_chats.forEach((page, i) => {
                page.page_chats = this.orderByUpdatedAt(page.page_chats);
                page['show'] = false;

                //SOMMA DEI MESSAGGI NON LETTI DELLA PAGINA
                page['all_mnr'] = 0;
                page.page_chats.forEach((chat, i) => {
                    page['all_mnr'] = page['all_mnr'] + chat['message_not_read'];
                });
            });
        }
    },
    mounted() {
        //check if is mobile
        this.checkMobile();
        window.addEventListener('resize', (event)=> {
            this.checkMobile();
        }, true);

        setInterval(()=>{
            if(this.chat_id && this.my_user_id && this.my_page_id){
                this.getMessages();
            }
        }, 10000);
    }

});

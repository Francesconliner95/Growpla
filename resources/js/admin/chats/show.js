import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#chat-show',
    data: {
        chat_id,
        my_user_id,
        your_user_id,
        my_page_id,
        your_page_id,
        displayed_name,
        message_text: '',
        messages: [],
        messages_qty: 0,
        first_scroll: false,
        longtext: false,
        can_create_coll: false,
    },

    methods: {
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

        getMessages(){

            axios.get('/admin/getMessages',{
                params: {
                    chat_id: this.chat_id,
                    my_user_id: this.my_user_id,
                    my_page_id: this.my_page_id,
                    messages_qty: this.messages_qty,
                }
            }).then((response) => {
                this.messages = response.data.results.messages;
                if (!this.first_scroll) {
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

        text_wrap(){
            if(document.getElementById("mytextarea").scrollHeight>31 && this.message_text.length>0){
                this.longtext = true;
                this.scroll();
            }else{
                this.longtext = false;
            }
        },

    },
    mounted() {
        this.getMessages();

        setInterval(()=>{
            this.getMessages();
        }, 10000);


    }

});

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
    },

    methods: {

        // getChats(){
        //     axios.get('/admin/getChats',{
        //
        //     }).then((response) => {
        //         this.chats = response.data.results.chats;
        //     });
        // },
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

        pressChat(account,chat){
            console.log(account);
            console.log(chat);
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
            }
            if(chat.page_id){
                this.your_page_id = chat.page_id;
                this.displayed_name = chat.name;
            }

            console.log(this.my_user_id,this.my_page_id,this.your_user_id,this.your_page_id);
            console.log(this.my_user_id);
            console.log(this.my_page_id);
            console.log(this.your_user_id);
            console.log(this.your_page_id);

            if(window.innerWidth>=768){
                console.log('stai');
            }else{
                console.log('esci');
                if (this.my_page_id) {
                    window.location = '/admin/chats/show/' + chat.id + '/' + this.my_page_id;
                }else{
                    window.location = '/admin/chats/show/' + chat.id + '/' + 'user';
                }
            }
            this.getMessages();

        },

        sendMessage(){

            if(this.message_text){
                var message_text = this.message_text;
                this.message_text = '';
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
                //console.log(this.messages);

                if (!this.first_scroll) {
                    this.first_scroll = true;
                    this.scroll();
                }
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
        }

    },
    mounted() {
        //check if is mobile
        this.checkMobile();
        window.addEventListener('resize', (event)=> {
            this.checkMobile();
        }, true);

        if(this.my_user_chats){
            this.my_user_chats = JSON.parse(this.my_user_chats.replace(/&quot;/g,'"'));
            this.my_user_chats.user_chats = this.orderByUpdatedAt(this.my_user_chats.user_chats);
        }
        if(this.my_pages_chats){
            this.my_pages_chats = JSON.parse(this.my_pages_chats.replace(/&quot;/g,'"'));
            this.my_pages_chats.forEach((page, i) => {
                page.page_chats = this.orderByUpdatedAt(page.page_chats);
            });
        }

        setInterval(()=>{
            if(this.chat_id && this.my_user_id && this.my_page_id){
                this.getMessages();
            }
        }, 10000);
    }

});

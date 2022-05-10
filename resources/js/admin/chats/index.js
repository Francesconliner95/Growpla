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

        getMessages(scroll){
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

                if (!this.first_scroll || scroll) {
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

        setInterval(()=>{
            if(this.chat_id && this.my_user_id && this.my_page_id){
                this.getMessages();
            }
        }, 10000);
    }

});

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
    },

    methods: {
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

        text_wrap(){
            // console.log(document.getElementById("mytextarea").scrollHeight>31);
            // if(document.getElementById("mytextarea").scrollHeight>31){
            //     this.longtext = true;
            // }else{
            //     this.longtext = false;
            // }
            // console.log(document.getElementById("mytextarea").content);
        },

    },
    mounted() {
        this.getMessages();

        setInterval(()=>{
            this.getMessages();
        }, 10000);


    }

});

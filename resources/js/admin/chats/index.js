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
    },

    methods: {

        // getChats(){
        //     axios.get('/admin/getChats',{
        //
        //     }).then((response) => {
        //         this.chats = response.data.results.chats;
        //     });
        // },

    },
    mounted() {
        if(this.my_user_chats){
            this.my_user_chats = JSON.parse(this.my_user_chats.replace(/&quot;/g,'"'));
        }
        if(this.my_pages_chats){
            this.my_pages_chats = JSON.parse(this.my_pages_chats.replace(/&quot;/g,'"'));
        }

        // if(performance.navigation.type == 2){
        //    this.getChats();
        // }
    }

});

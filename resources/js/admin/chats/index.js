import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};




var create = new Vue({
    el: '#chat-index',
    data: {
        chats,
        lang,
    },

    methods: {

        getChats(){
            axios.get('/admin/getChats',{

            }).then((response) => {
                this.chats = response.data.results.chats;
            });
        },

    },
    mounted() {
        //console.log(this.chats);
        //ricarico le chat quando torno indietro
        if(performance.navigation.type == 2){
           this.getChats();
        }
    }

});

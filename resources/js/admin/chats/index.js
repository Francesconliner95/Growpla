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
        }

    },
    mounted() {
        if(this.my_user_chats){
            this.my_user_chats = JSON.parse(this.my_user_chats.replace(/&quot;/g,'"'));
            this.my_user_chats.user_chats = this.orderByUpdatedAt(this.my_user_chats.user_chats);
        }
        console.log(this.my_user_chats);
        if(this.my_pages_chats){
            this.my_pages_chats = JSON.parse(this.my_pages_chats.replace(/&quot;/g,'"'));
            this.my_pages_chats.forEach((page, i) => {
                page.page_chats = this.orderByUpdatedAt(page.page_chats);
            });
        }

      //  console.log(this.my_pages_chats);

        // if(performance.navigation.type == 2){
        //    this.getChats();
        // }
    }

});

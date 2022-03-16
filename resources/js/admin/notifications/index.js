import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

//ricarico la pagina quando torno indietro
if(performance.navigation.type == 2){
   location.reload(true);
}

var create = new Vue({
    el: '#notification-index',
    data: {
        notifications: [],
    },

    methods: {

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
            const output =   hours +':'+ minutes + ' ' +day + '-' + month + '-' + year;
            return output;
        },

        getNotifications(){
            axios.get('/admin/getNotifications',{

            }).then((response) => {
                this.notifications = response.data.results.notifications;
            });
        },
    },
    mounted() {
        this.getNotifications();
        if(performance.navigation.type==2){
           this.getNotifications();
        }
    }

});

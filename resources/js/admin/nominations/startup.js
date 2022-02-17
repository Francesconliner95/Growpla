import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#nomination-startup',
    data: {
        account_id,
        lang,
        nominations: [],
        alert: '',
        delete_alert: false,
        delete_message: '',
        delete_type: '',
        nomination_id: '',
    },

    methods: {

        sendMessage(cofounder_account_id){

            axios.get('/admin/createChat',{
                params: {
                    account_id: cofounder_account_id,
                }
            }).then((response) => {
                var chat_id = response.data.results.chat_id;
                if(!isNaN(chat_id)){
                    location.href = '/admin/chats/' + chat_id;
                }else{
                    this.alert_f(chat_id);
                }
            });

        },
        // nominationStatus(status,nomination_id){
        //     console.log(status);
        //     console.log(nomination_id);
        //     console.log(this.account_id);
        //     axios({
        //         method: 'put',
        //         url: '/admin/updateNomination',
        //         data: {
        //             account_id: account_id,
        //             nomination_id: nomination_id,
        //             status: status,
        //         }
        //     }).then(response => {
        //         this.getNomiantions();
        //     });
        // },

        deleteController(delete_type, nomination_id){
            // console.log(delete_type);
            // console.log(this.lang);
            switch (delete_type) {
                case 1:
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_message = 'Are you really sure you want to reject the following application?';
                        break;
                        case 2:
                            this.delete_message = 'Sei davvero sicuro di voler rifiutare la seguente candidatura?';
                        break;
                        default:
                    }
                break;
                case 2:
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_message = 'Are you really sure you want to delete the following application?';
                        break;
                        case 2:
                            this.delete_message = 'Sei davvero sicuro di voler eliminare la seguente candidatura?';
                        break;
                        default:
                    }
                break;
                default:
            }
            this.delete_alert = true;
            this.delete_type = delete_type;
            this.nomination_id = nomination_id;
        },

        rejectDelete(){
            this.delete_type = '';
            this.nomination_id = '';
            this.delete_alert = false;
            this.delete_message =  '';
        },

        deleteNomination(){
            axios({
                   method: 'delete',
                   url: '/admin/deleteNomination',
                   data: {
                       nomination_id: this.nomination_id,
                       reject_or_delete: this.delete_type,
                    }
               }).then(response => {
                   this.getNomiantions();
                   this.rejectDelete();
               });
        },

        getNomiantions(){
            this.nominations = [];
            axios.get('/admin/getNominations',{
                params: {
                    account_id: this.account_id,
                }
            }).then((response) => {
                var nominations = response.data.results.nominations;
                nominations.forEach((nomination, i) => {
                    nominations.forEach((nomination_2, i) => {
                        if(nomination.role_name==nomination_2.role_name){
                            if(!this.nominations.includes(nomination_2) ){
                                this.nominations.push(nomination_2);
                            }
                        }
                    });
                });

                // nominations.forEach((nomination, i) => {
                //     let role_name = nomination.role_name;
                //     if(!this.nominations[role_name]){
                //         this.nominations[role_name] = [];
                //     }
                //     if(role_name == nomination.role_name){
                //         this.nominations[role_name].push(nomination);
                //     }
                // });

            });
        },
    },
    mounted() {
        this.getNomiantions();
        //console.log(this.nominations);
    }

});

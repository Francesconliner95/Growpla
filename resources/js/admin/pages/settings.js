import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#page-settings',
    data: {
        user_id,
        lang,
        page_id,
        user_name: '',
        users_found: '',
        admins: '',
        error_message: '',
        delete_alert: false,
        case_type: '',
        alert_par: '',
        message: '',
        alert_b1: '',
        alert_b2: '',
    },
    methods: {
        alertMenu(case_type,parameter){
            this.delete_alert = true;
            this.case_type = case_type;
            this.alert_par = parameter;
            switch (this.case_type) {
                case 1:
                    this.message = 'Sei sicuro di voler eliminare la tua pagina?';
                    this.alert_b1 = 'Annulla';
                    this.alert_b2 = 'Elimina';
                break;
                case 2:
                    this.message = 'Sei sicuro di voler eliminare questo amministratore?';
                    this.alert_b1 = 'No';
                    this.alert_b2 = 'Si';
                break;

                default:
            }
        },
        alertCancel(){
            this.delete_alert = false;
            this.case_type = '';
            this.message = '';
            this.alert_b1 = '';
            this.alert_b2 = '';
            this.alert_par = '';
        },
        //bottone positivo
        option1(){
            switch (this.case_type) {
                case 1:
                    //annulla eliminazione pagina
                break;
                case 2:
                    //annulla eliminazione admin
                break;

                default:
            }
            this.alertCancel();

        },
        //bottone negativo
        option2(){
            switch (this.case_type) {
                case 1:
                    //conferma eliminazione pagina
                    console.log('brana');
                    document.deletePage.submit();
                break;
                case 2:
                    //eliminae admin
                    this.removeAdmin(this.alert_par);
                break;

                default:
            }
            this.alertCancel();
        },
      searchUser(){
        if(this.user_name){
            axios.get('/api/searchUser',{
                params: {
                    user_name: this.user_name,
                }
            }).then((response) => {
                this.users_found = response.data.results.users;
                if(!this.user_name){
                    this.users_found = '';
                }
            });
        }else{
            this.users_found = '';
        }
      },

      addAdmin(user_found_id){
        axios({
            method: 'post',
            url: '/admin/addAdmin',
            data: {
                user_id: user_found_id,
                page_id: this.page_id,
            }
        }).then(response => {
          this.user_name = '';
          this.users_found = '';
          this.getAdmin();
          this.message = '';
        });
      },

      getAdmin(){
        axios.get('/admin/getAdmin',{
            params: {
                page_id: this.page_id,
            }
        }).then((response) => {
            this.admins = response.data.results.admins;
        });
      },

      removeAdmin(user_id){
        axios({
            method: 'delete',
            url: '/admin/removeAdmin',
            data: {
                user_id: user_id,
                page_id: this.page_id,
            }
        }).then(response => {
            this.getAdmin();
            this.error_message = response.data.results.message;
            if(this.error_message=='auto-delete'){
              window.location.href = '/admin/users/'+ this.user_id;
            }
        });
      }

    },
    created(){

    },
    mounted() {

      this.getAdmin();

    },
});

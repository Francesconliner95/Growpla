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
        delete_alert: false,
        message: '',
    },
    methods: {

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
            this.message = response.data.results.message;
            if(this.message=='auto-delete'){
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

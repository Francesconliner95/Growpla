import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#page-settings',
    data: {
        lang,
        page_id,
        user_name: '',
        users_found: '',
        admins: '',
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
                console.log(this.users_found);
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
        });
      }

    },
    created(){

    },
    mounted() {

      this.getAdmin();

    },
});

import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#collaboration-create',
    data: {
        account_name: '',
        accounts_found: '',
        account_selected: '',
    },
    methods: {

        searchAccount(){
          if(this.account_name){
              axios.get('/api/searchAccount',{
                  params: {
                      account_name: this.account_name,
                  }
              }).then((response) => {
                  this.accounts_found = response.data.results.accounts;
                  console.log(this.accounts_found);
                  if(!this.account_name){
                      this.accounts_found = '';
                  }
              });
          }else{
              this.accounts_found = '';
          }
        },

        addAccount(account_found){
          this.account_selected = account_found;
          this.account_name = '';
          this.accounts_found = '';
          setTimeout(()=>{ document.collaborationForm.submit() }, 100);
        },


    },
    mounted() {

    },
    // watch: {
    //     account_selected: function(new_val, old_val) {
    //         console.log(new_val, old_val);
    //     }
    // }

});

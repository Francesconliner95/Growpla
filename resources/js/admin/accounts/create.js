import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#account-create',
    data: {
        accountTypes: '',
        account_selected: 2,
        private_association: 1,
    },
    methods: {
        private_selected(){
            this.account_selected = 2;
        },
        association_selected(){
            this.account_selected = 1;
        }
    },
    mounted() {
        axios.get('/api/getAccountTypes',{
        }).then((response) => {
            this.accountTypes = response.data.results.accountTypes;
            console.log(this.accountTypes);
        });

    }

});

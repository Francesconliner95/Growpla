//window.history.forward();

import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#register',
    data: {
        code_verified: false,
        code: '',
        error: false,
    },
    methods: {

        sendCode(){
            if(this.code=='ARVTFD3'){
                this.code_verified = true;
            }else{
                this.error=true;
                console.log(this.error);
            }
        },

    },
    mounted() {

    }

});

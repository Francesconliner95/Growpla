//window.history.forward();

import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#login',
    data: {
        login,
        show_password: false,
        login_btn: true,
        register_btn: true,
    },
    methods: {
        maxbirthdate(){
          return moment().subtract(18, 'years').format('YYYY-MM-DD');
        },
        submitLogin(){
            if(this.login_btn){
                // this.login_btn = false;
                document.getElementById("button-submit-login").click();
                // setTimeout(()=>{
                //     this.login_btn = true;
                // }, 3000);
            }
        },
        submitRegister(){
            if(this.register_btn){
                // this.register_btn = false;
                document.getElementById("button-submit-register").click();
                // setTimeout(()=>{
                //     this.register_btn = true;
                // }, 3000);
            }
        },

        inSubmit(){
            // console.log('in submit');
            this.login_btn = false;
            this.register_btn = false;
        },
    },
    created() {

    },
    mounted() {

        if(window.location.hash.substr(1)=='register'){
            this.login = false;
            document.getElementById('switch-checkbox').checked = true;
        }

        document.getElementById('loginForm').addEventListener("submit", (e)=>{
            this.inSubmit();
        });
        document.getElementById('registerForm').addEventListener("submit", (e)=>{
            this.inSubmit();
        });
    }

});

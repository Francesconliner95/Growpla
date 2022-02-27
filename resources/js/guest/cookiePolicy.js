//window.history.forward();

import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#cookie-policy',
    data: {
        showConsenScreen : false,
        analyticsCookie: getCookie('analyticsCookie')=='accept'?true:false,
        cookieSettings: false,
    },
    methods: {

        getCookie(name) {
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
        },

        showConsentScreen(){
            // console.log(this.getCookie('tecCookie'));
            // console.log(this.getCookie('analyticsCookie'));
            if(!this.getCookie('tecCookie')
            ||  !this.getCookie('analyticsCookie')){
                this.showConsenScreen = true;
                //console.log(this.showConsenScreen);
            }else{
                this.showConsenScreen = false;
            }

        },

        closeConsentScreen(){
            this.showConsenScreen = false;
            document.cookie = /*"tecCookie=accept"; */
            "tecCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
            if(!this.getCookie('analyticsCookie')){
                document.cookie =
                "analyticsCookie"+ "=" +"reject"+ ";" + "expires="+ this.dateUTC() +";path=/";
                this.analyticsCookie = false;
            }
        },

        acceptAll(){
            this.showConsenScreen = false;
            document.cookie = /*"tecCookie=accept"; */
            "tecCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
            document.cookie =
            "analyticsCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
            this.analyticsCookie = true;
        },

        acceptSelected(){
            this.showConsenScreen = false;
            document.cookie = /*"tecCookie=accept"; */
            "tecCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
            if(this.analyticsCookie){
                document.cookie =
                "analyticsCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
                this.analyticsCookie = true;
            }else{
                document.cookie =
                "analyticsCookie"+ "=" +"reject"+ ";" + "expires="+ this.dateUTC() +";path=/";
                this.analyticsCookie = false;
            }
        },

        dateUTC(){
            var d = new Date();
            d.setMonth(d.getMonth() + 6);
            return d.toUTCString();
            //console.log(d.toUTCString());
        }

    },
    mounted() {

        this.showConsentScreen();
        //console.log(this.analyticsCookie);
    }

});
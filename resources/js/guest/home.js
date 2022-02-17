//window.history.forward();

import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#guest-home',
    data: {
        accounts,
        cooperations,
        chats,
        show_password: false,
        show_login: localStorage.getItem("showLog")=='yes'?true:false,
        im_log: false,
        press_reg: false,
        showConsenScreen : false,
        analyticsCookie: getCookie('analyticsCookie')=='accept'?true:false,
        cookieSettings: false,
        user_id: false,
        remember_me: false,
        email: '',
        psw: '',
        code_verified: /*getCookie('codeCookie')?true:*/false,
        code: '',
        error: false,
    },
    methods: {

        sendEmail(){
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(this.email && this.email.match(mailformat)){
                this.error = false;
                axios({
                    method: 'post',
                    url: '/api/sendEmail',
                    data: {
                        email: this.email,
                    }
                }).then(response => {
                    this.code_verified = true;
                });
            }else{
                this.error = true;
            }
        },

        log_reg_switch(value){
            this.show_login = value;
            if(value==true){
                localStorage.setItem("showLog",'yes');
            }else{
                localStorage.setItem("showLog",'no');
            }
        },

        im_log_f(value){
            axios.get('/admin/getUser',{
            }).then((response) => {
                this.user_id = response.data.results.user_id;
            });
            setTimeout(()=>{
                //console.log(this.user_id);
                if(this.user_id){
                    this.im_log = true;
                }else{
                    this.im_log = false;

                    if(this.remember_me){
                        this.setRememberMe();
                    }else{
                        this.deleteRememberMe();
                    }

                    if(value==1){
                        document.getElementById('login-button').click();
                    }else{
                        document.getElementById('register-button').click();
                    }
                }
            }, 1000);
        },

        loading(value){
            this.press_reg = true;
            this.im_log_f(value);
            setTimeout(()=>{
                this.press_reg = false;
            }, 3000);
        },

        // loading(value){
        //     this.press_reg = true;
        //
        //     if(!this.im_log){
        //         console.log(this.im_log);
        //         if(value==1){
        //             document.getElementById('login-button').click();
        //         }else{
        //             document.getElementById('register-button').click();
        //         }
        //     }
        //     setTimeout(()=>{
        //         this.press_reg = false;
        //     }, 3000);
        // },

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
        },

        getRememberMe(){
            let emailCookie = this.getCookie('emailCookie');
            let pswCookie = this.getCookie('pswCookie');

            if(emailCookie || pswCookie){
                this.email = emailCookie;
                this.psw = pswCookie;
                this.remember_me = true;
            }else{
                this.remember_me = false;
            }

            // console.log(this.getCookie('emailCookie'));
            // console.log(this.getCookie('emailCookie'));
        },

        setRememberMe(){
            document.cookie = 'emailCookie='+this.email;
            // document.cookie = 'pswCookie='+this.psw+';secure';
        },

        deleteRememberMe(){
            document.cookie = 'emailCookie=;';
            // document.cookie = 'pswCookie=;';
        },

        sendCode(){
            if(this.code=='ARVTFD3'){
                document.cookie = 'codeCookie=true; expires='+ this.dateUTC() +";path=/";
                this.code_verified = true;
            }else{
                this.error=true;
                console.log(this.error);
            }
        },

    },
    mounted() {
        this.im_log_f();
        this.getRememberMe();
        //aggiorno torno indietro
        if(performance.navigation.type == 2){
            this.im_log_f();
        }
        this.showConsentScreen();

        //FADE ANIMATION
        let elementsArray = document.querySelectorAll(".fade-anim");
        //console.log(elementsArray);
        window.addEventListener('scroll', fadeIn );
        function fadeIn() {
            for (var i = 0; i < elementsArray.length; i++) {
                var elem = elementsArray[i]
                var distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
                if (distInView < 0) {
                    elem.classList.add("inView");
                } else {
                    elem.classList.remove("inView");
                }
            }
        }
        fadeIn();

        //COUNTER ANIMATION
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        const cooperations_obj = document.getElementById("cooperations");
        const chats_obj = document.getElementById("chats");
        const accounts_obj = document.getElementById("profiles");


        const cooperations = parseInt(this.cooperations);
        const chats = parseInt(this.chats);
        const accounts = parseInt(this.accounts);

        let elementsCounter = document.querySelectorAll(".count-anim");
        var count_anim = false;

        window.addEventListener('scroll', counterAnimScroll);
        window.cooperations = cooperations;
        window.cooperations_obj = cooperations_obj;
        window.chats = chats;
        window.chats_obj = chats_obj;
        window.accounts = accounts;
        window.accounts_obj = accounts_obj;
        function counterAnimScroll(evt) {
            for (var i = 0; i < elementsCounter.length; i++) {
                var elem = elementsCounter[i]
                var distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
                if (distInView < 0 && !count_anim) {
                    animateValue(cooperations_obj, 0, evt.currentTarget.cooperations, 2000);
                    animateValue(chats_obj, 0, evt.currentTarget.chats, 2000);
                    animateValue(accounts_obj, 0, evt.currentTarget.accounts, 2000);
                    count_anim = true;
                }
            }
        }

        function counterAnimFirstShow(num,obj) {
            for (var i = 0; i < elementsCounter.length; i++) {
                var elem = elementsCounter[i]
                var distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
                if (distInView < 0 && !count_anim) {
                    animateValue(cooperations_obj, 0, cooperations, 2000);
                    animateValue(chats_obj, 0, chats, 2000);
                    animateValue(accounts_obj, 0, accounts, 2000);
                    count_anim = true;
                }
            }

        }
        counterAnimFirstShow();

    }

});

//SCROLL LENTO
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

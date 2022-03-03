import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#nav-bar',
    data: {
        notifications: [],
        message_not_read: 0,
    },
    methods: {

        getCookie(name){
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
        },
    },
    created(){
        if(this.getCookie("analyticsCookie")=='accept'){
            this.enableAnalytics = true;
        }

    },
    mounted() {

    }

});


var im_in_index = document.getElementById("account-index");
if(im_in_index){
    document.getElementById("nav-bar").style.backgroundColor = "rgb(194,214,215)";
    document.getElementById("nav-bar").style.boxShadow = "none";
    window.onscroll = function() {scrollFunction()};
}

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    document.getElementById("nav-bar").style.backgroundColor = "white";
    document.getElementById("nav-bar").style.boxShadow = "0 0.125rem 0.25rem rgb(0 0 0 / 8%)";
    document.getElementById("nav-bar").style.transition = ".2s";
    } else {
    document.getElementById("nav-bar").style.backgroundColor = "rgb(194,214,215)";
    document.getElementById("nav-bar").style.boxShadow = "none";
    }
}

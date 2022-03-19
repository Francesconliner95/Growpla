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
        user: '',
        pages: '',
        alert: false,
        page_selected_id: '',
    },
    methods: {

        getNotReadNotifications(){
            axios.get('/admin/getNotReadNotifications',{
            }).then((response) => {
                this.notifications = response.data.results.notifications;
            });
        },

        readNotifications(){
            axios({
                method: 'put',
                url: '/admin/readNotifications',
            }).then(response => {});
        },

        switchAccounts(){
            this.alert = true;
            axios.get('/admin/getMyAccounts',{
            }).then((response) => {
                this.user = response.data.results.user;
                this.pages = response.data.results.pages;
                this.page_selected_id = response.data.results.page_selected_id;
                console.log(this.accounts);
            });
        },

        setPageSelected(page_id){
            this.alert = false;
            axios({
                method: 'put',
                url: '/admin/setPageSelected',
                data: {
                    page_id: page_id,
                }
            }).then(response => {

            });
        },

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
        this.getNotReadNotifications();
    }

});


var im_in_index = document.getElementById("search");
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

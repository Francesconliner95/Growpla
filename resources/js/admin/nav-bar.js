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
        message_not_read_qty: 0,
        user: '',
        pages: '',
        alert: false,
    },
    methods: {

        getNotReadNotifications(){
            axios.get('/admin/getNotReadNotifications',{
            }).then((response) => {
                this.notifications = response.data.results.notifications;
            });
        },

        getNotReadMessages(){
            axios.get('/admin/getNotReadMessages',{
            }).then((response) => {
                this.message_not_read_qty = response.data.results.message_not_read_qty;
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
                this.page_selected = response.data.results.page_selected;
            });
        },

        setPageSelected(page_id){
            this.alert = false;
            //console.log(page_id);
            axios({
                method: 'put',
                url: '/admin/setPageSelected',
                data: {
                    page_id: page_id,
                }
            }).then(response => {
                this.page_selected = response.data.results.page_selected;
                //console.log(this.page_selected);
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
        // if (this.page_selected) {
        //     this.page_selected = JSON.parse(this.page_selected.replace(/&quot;/g,'"'));
        // }

    },
    mounted() {
        this.getNotReadNotifications();
        this.getNotReadMessages();

    }

});


var im_in_index = document.getElementById("search");
if(im_in_index){
    document.getElementById("logo-fullsize").src="/storage/images/logo-fullsize-white.svg";
    document.getElementById("logo").src="/storage/images/logo-white.svg";
    document.getElementById("container-nb").classList.add("trasparent-navbar");
    window.onscroll = function() {scrollFunction()};
}

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementById("logo-fullsize").src="/storage/images/logo-fullsize.svg";
        document.getElementById("logo").src="/storage/images/logo.svg";
        document.getElementById("container-nb").classList.remove("trasparent-navbar");
    } else {
        document.getElementById("logo-fullsize").src="/storage/images/logo-fullsize-white.svg";
        document.getElementById("logo").src="/storage/images/logo-white.svg";
        document.getElementById("container-nb").classList.add("trasparent-navbar");
    }
}

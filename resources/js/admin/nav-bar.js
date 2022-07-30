import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#nav-bar',
    data: {
        auth,
        notifications: [],
        message_not_read_qty: 0,
        user: '',
        pages: '',
        alert: false,
        trasparent_navbar: false,
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

        scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                this.trasparent_navbar = false;
            } else {
                this.trasparent_navbar = true;
            }
        }

    },
    created(){
        if(this.getCookie("analyticsCookie")=='accept'){
            this.enableAnalytics = true;
        }
    },
    mounted() {
        if(document.getElementById("search")
        || document.getElementById("guest-home")){
            window.onscroll = ()=>{this.scrollFunction()};
            this.trasparent_navbar = true;
        }
        if(auth){
            this.getNotReadNotifications();
            this.getNotReadMessages();
        }
    }
});

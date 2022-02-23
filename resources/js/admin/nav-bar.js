import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#nav-bar',
    data: {
        user,
        my_accounts: [],
        account_selected: '',
        notifications: [],
        message_not_read: 0,
    },
    methods: {

        getMyAccount(){
            axios.get('/admin/getMyAccounts',{
            }).then((response) => {
                this.my_accounts = response.data.results.my_accounts;
                this.account_selected = response.data.results.account_selected;
            });
        },
        // setAccount(account_id){
        //     axios({
        //         method: 'put',
        //         url: '/admin/setAccount',
        //         data: {
        //             account_selected_id: account_id,
        //         }
        //     }).then(response => {
        //         this.getMyAccount();
        //     });
        // },

        getNotReadNotifications(){
            axios.get('/admin/getNotReadNotifications',{
            }).then((response) => {
                this.notifications = response.data.results.notifications;
            });
        },

        readNotifications(notification){
            axios({
                method: 'put',
                url: '/admin/readNotifications',
                data: {
                    notification_id: notification.id,
                }
            }).then(response => {

            });

            let string = '';
            if(notification.type==1){
                string = "/admin/startup/";
            }else{
                string = "/admin/accounts/";
            }
            window.location.href = string + notification.ref_account_id;
        },

        getMessagesCount(){
            axios.get('/admin/getMessagesCount',{
            }).then((response) => {
                this.message_not_read = response.data.results.message_not_read;
            });
        },

        getCookie(name){
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
        },
    },
    created(){
        //console.log(this.getCookie("analyticsCookie"));
        if(this.getCookie("analyticsCookie")=='accept'){
            // window['ga-disable-G-EX66GGGB3E'] = true;
            // console.log('disabilitato');
            this.enableAnalytics = true;
        }

    },
    mounted() {
        if(this.user){
            this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
        };

        console.log(this.user);

        if(this.user.account_id){
            this.account_selected = this.user.account_id;
            this.getMyAccount();
            this.getNotReadNotifications();
            this.getMessagesCount();
        }

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

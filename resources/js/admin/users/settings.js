import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-settings',
    data: {
      user,
      alert: false,
      confirm_delete_alert: false,
    },
    methods: {
        checkboxToggle(mail_setting_id){
            axios({
                method: 'put',
                url: '/admin/mailSettingToggle',
                data: {
                    mail_setting_id: mail_setting_id,
                }
            }).then(response => {
            });
        },
    },
    created(){
        this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
        console.log(this.user);
    },
    mounted() {


    }

});

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
        login: true,
    },
    methods: {
        maxbirthdate(){
          return moment().subtract(10, 'years').format('YYYY-MM-DD');
        },
    },
    mounted() {
        
    }

});

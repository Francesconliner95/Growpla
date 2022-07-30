import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#page-pagetype',
    data: {
        pagetypes,
        pagetype_id: 1,
    },
    methods: {

    },
    created(){

    },
    mounted() {

    },
});

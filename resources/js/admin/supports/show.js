import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#support-show',
    data: {
        support,
    },

    methods: {
        extensionsType(){
            return this.support.file.split('.').pop();
        },

    },
    mounted() {
        
    }

});

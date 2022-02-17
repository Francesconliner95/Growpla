import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-create',
    data: {
      language_id,
      userTypes,
      pageTypes,
    },
    methods: {

    },
    created(){
      this.userTypes = JSON.parse(this.userTypes.replace(/&quot;/g,'"'))
      this.pageTypes = JSON.parse(this.pageTypes.replace(/&quot;/g,'"'));;
    },
    mounted() {


    }

});

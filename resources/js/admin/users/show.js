import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#user-show',
    data: {
        lang,
        is_my_user,
        user,
    },
    methods: {

      open(filename){
          var newWindow = window.open();
          newWindow.document.write('<iframe src="/storage/'+ filename +'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">');
      },

    },
    created(){
      this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
    },
    mounted() {

    },

});
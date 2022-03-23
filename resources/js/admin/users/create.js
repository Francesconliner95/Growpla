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
      isChecked(id){
        if (document.getElementById(id).checked) {
          return true;
        } else {
          return false;
        }
      },
      checkboxToggle(id){
        if(document.getElementById(id).checked){
          document.getElementById(id).checked = false;
          document.getElementById(id+'-b').classList.remove("button-active-multichoise");
        }else{
          document.getElementById(id).checked = true;
          document.getElementById(id+'-b').classList.add("button-active-multichoise");
        }
      }

    },
    created(){
      this.userTypes = JSON.parse(this.userTypes.replace(/&quot;/g,'"'));
      this.pageTypes = JSON.parse(this.pageTypes.replace(/&quot;/g,'"'));
    },
    mounted() {


    }

});

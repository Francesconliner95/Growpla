import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#page-sectors',
    data: {
      language_id,
      sectors,
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
          document.getElementById(id+'-b').classList.remove("button-active-orange");
        }else{
          document.getElementById(id).checked = true;
          document.getElementById(id+'-b').classList.add("button-active-orange");
        }
      }

    },
    created(){
      this.sectors = JSON.parse(this.sectors.replace(/&quot;/g,'"'));
    },
    mounted() {


    }

});

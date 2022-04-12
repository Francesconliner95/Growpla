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
      display_message: '',
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
              document.getElementById(id+'-b').classList.remove("active");
          }else if($('div.checkbox-group.required :checkbox:checked').length<3){
              document.getElementById(id).checked = true;
              document.getElementById(id+'-b').classList.add("active");
          }
      },
      submitForm(){
          if($('div.checkbox-group.required :checkbox:checked').length>0){
              document.getElementById('page-sectors-form').submit();
          }else{
              this.display_message = 'Seleziona almeno una delle precedenti opzioni';
          }
      },
    },
    created(){
      this.sectors = JSON.parse(this.sectors.replace(/&quot;/g,'"'));
    },
    mounted() {

    }

});

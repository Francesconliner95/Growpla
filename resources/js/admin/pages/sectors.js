import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#sectors',
    data: {
      language_id,
      sectors,
      max_sector_number,
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
            }else if($('div.checkbox-group.required :checkbox:checked').length<this.max_sector_number){
                document.getElementById(id).checked = true;
                document.getElementById(id+'-b').classList.add("active");
            }else{
                this.display_message = 'Puoi selezionare massimo ' + this.max_sector_number + ' settori';
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
      // this.sectors = JSON.parse(this.sectors.replace(/&quot;/g,'"'));
    },
    mounted() {

    }

});

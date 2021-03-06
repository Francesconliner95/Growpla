import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-accounts',
    data: {
      language_id,
      // userTypes,
      // pageTypes,
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
        }else{
          document.getElementById(id).checked = true;
          document.getElementById(id+'-b').classList.add("active");
        }
        this.display_message = '';
      },

      submitForm(){
        if($('div.checkbox-group.required :checkbox:checked').length>0){
            document.getElementById('user-create-form').submit();
        }else{
            this.display_message = 'Seleziona almeno una delle precedenti opzioni';
        }

      },

    },
    created(){
      // this.userTypes = JSON.parse(this.userTypes.replace(/&quot;/g,'"'));
      // this.pageTypes = JSON.parse(this.pageTypes.replace(/&quot;/g,'"'));
      // console.log(this.userTypes);
      // console.log(this.pageTypes);
    },
    mounted() {

    }

});

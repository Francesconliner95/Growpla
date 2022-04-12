import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
}; //in caso di problemi togliere

var create = new Vue({
    el: '#lifecycle-edit',
    data: {
        lang,
        lifecycles,
        lifecycle_id,
        lifecycle_selected: '',
        description: '',
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
            if(id=="u-1") {
                this.usertype_selected=!this.usertype_selected;
            }
        },
        radioToggle(id){
            var elems = document.querySelectorAll(".lifecycle-item.active");
            [].forEach.call(elems, function(el) {
                el.classList.remove("active");
            });

            document.getElementById('l-' + id).checked = true;
            document.getElementById('l-' + id + '-b').classList.add("active");
            this.lifecycle_selected = id;
            this.description = this.lifecycles[this.lifecycle_selected-1].description_it;
        }
    },
    created(){

    },
    mounted() {
        this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:'';
        //ONLY STARTUP
        if(this.lifecycle_id){
            this.lifecycle_id = parseInt(this.lifecycle_id);
            this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:'';
            this.radioToggle(this.lifecycle_selected);
        }
    }

});

import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-background',
    data: {
        backgrounds,
        user_backgrounds,
        background_selected: '',
    },
    methods: {

        addBackground(){
            //console.log(this.background_selected);
            var already_exist = false;
            this.user_backgrounds.forEach((background, i) => {
                if(background.id == this.background_selected.id){
                    already_exist = true;
                }
            });
            if(!already_exist){
                this.user_backgrounds.push(this.background_selected);
            }
        },

        removeBackground(i){
            this.user_backgrounds.splice(i,1);
        }

    },
    created() {

    },
    mounted() {

    }
});

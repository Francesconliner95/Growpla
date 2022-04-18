//window.history.forward();

import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#incubators',
    data: {
        incubators,
        incubators_show: [],
        region_id : '',
        region_id_selected: '',
    },
    methods: {
        filterByRegion(){
            if(!this.region_id_selected){
                this.incubators_show = this.incubators;
            }else{
                this.incubators_show = [];
                this.incubators.forEach((incubator, i) => {
                    if(incubator.region_id==this.region_id_selected){
                        this.incubators_show.push(incubator);
                    }
                });
            }
        },
    },
    created(){
        if(this.incubators){
            this.incubators = JSON.parse(this.incubators.replace(/&quot;/g,'"'));
        }
        this.incubators_show = this.incubators;
        console.log(this.incubators_show);
    },
    mounted() {

    }

});

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
        incubators: [],
        incubators_show: [],
        region_id : '',
        region_id_selected: '',
        name: '',
        in_load: false,
    },
    methods: {
        searchByName(){
            this.region_id_selected = '';
            this.incubators_show = [];
            if(this.name){
                this.incubators.forEach((incubator, i) => {
                    if (incubator.name.toLowerCase().match(this.name.toLowerCase())){
                      this.incubators_show.push(incubator);
                    }
                });
                this.incubators_show = this.firstPageId(this.incubators_show);
            }else{
              this.incubators_show = this.incubators;
            }
        },

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
                this.incubators_show = this.firstPageId(this.incubators_show);
            }
        },

        getAllIncubators(){
            this.in_load = true;
            axios.get('/api/getAllIncubators',{
            }).then((response) => {
                this.incubators = response.data.results.incubators;
                this.incubators = this.firstPageId(this.incubators);
                this.incubators_show = this.incubators
                this.in_load = false;
            });
        },

        firstPageId(incubators){
            incubators.forEach((incubator, i) => {
                if(incubator.page_id){
                    incubators.splice(incubators.indexOf(incubator), 1);
                    incubators.unshift(incubator);
                }
            });
            return incubators;
        },
    },
    created(){
        this.getAllIncubators();
    },
    mounted() {

    }

});

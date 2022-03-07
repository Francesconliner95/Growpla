import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#service-edit',
    data: {
        services,
        service_name: '',
        services_found: '',
    },
    methods: {
        searchService(){
            if(this.service_name){
              axios.get('/api/searchService',{
                  params: {
                      service_name: this.service_name,
                  }
              }).then((response) => {
                  this.services_found = response.data.results.services;
                  if(!this.service_name){
                      this.services_found = '';
                  }
              });
            }else{
              this.services_found = '';
            }
        },

        addService(service_found){

            var exist = false;
            this.services.forEach((service, i) => {
                if(service.pivot.service_id==service_found.id){
                  exist = true;
                }
            });

            if(!exist){

              let new_service = {
                "name":service_found.name,
                "pivot":{
                  "service_id": service_found.id,
                },
              };

              this.services.push(new_service);
            }

            this.services_found = '';
            this.service_name = '';
        },

        addManualService(){

            var exist = false;
            this.services.forEach((service, i) => {
                if(service.name==this.service_name){
                  exist = true;
                }
            });

            if(!exist && this.service_name){

              let new_service = {
                "name":this.service_name,
                // "pivot":{
                //   "service_id": service_found.id,
                // },
              };
              this.services.push(new_service);
            }

            this.services_found = '';
            this.service_name = '';
        },

        removeService(i){
            this.services.splice(i, 1);
        },

    },
    created() {
        if(this.services){
            this.services = JSON.parse(this.services.replace(/&quot;/g,'"'));
        }

    },
    mounted() {

    }
});

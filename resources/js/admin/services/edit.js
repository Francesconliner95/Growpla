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
        r_services,
        //ONLY STARTUP
        lifecycles,
        lifecycle_id,
        skills,
        //END ONLY STARTUP
        r_services_show: [],
        service_name: '',
        services_found: '',
        main_services: [],
        sub_services: [],
        sub_services_show: [],
        main_service_selected: '',
        sub_service_selected: '',
        //ONLY STARTUP
        show_services: false,
        lifecycle_selected: '1',
        usertype_selected: '',
        cofounders: '',
        userRecommended: [],
        pageRecommended: [],
        serviceRecommended: [],
        skill_name: '',
        skills_found: '',
        //END ONLY STARTUP

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
                "id":service_found.id,
                "name":service_found.name,
                "pivot":{
                  "service_id": service_found.id,
                },
              };

              this.services.push(new_service);
              this.removeRservice(new_service);
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
                "id":service_found.id,
                "name":this.service_name,
                // "pivot":{
                //   "service_id": service_found.id,
                // },
              };
              this.services.push(new_service);
              this.removeRservice(new_service);
            }

            this.services_found = '';
            this.service_name = '';
        },

        removeService(i){
            var service = this.services[i];
            this.services.splice(i, 1);
            this.addRservice(service);
        },

        removeRservice(service){
            this.r_services_show.forEach((r_service, i) => {
                if(r_service.id==service.id){
                    this.r_services_show.splice(i, 1);
                }
            });
        },

        addRservice(service){
            this.r_services_show.push(service);
        },

        serviceExist(r_service){
            var not_exist = true;
            this.services.forEach((service, i) => {
                if(service.id==r_service.id) {
                    not_exist = false;
                }
            });
            return not_exist;
        },

        getAllServices(){
            axios.get('/api/getAllServices',{
            }).then((response) => {
                this.main_services = response.data.results.main_services;
                this.sub_services = response.data.results.sub_services;
                this.main_service_selected = this.main_services[0].id;
                this.changeMainService();
            });
        },

        changeMainService(){
            this.sub_services_show = [];
            this.sub_services.forEach((sub_service, i) => {
                if(sub_service.main_service_id==this.main_service_selected){
                    this.sub_services_show.push(sub_service);
                }
            });
            this.sub_service_selected = this.sub_services_show[0].id;
        },

        addServiceSelected(service_id){
            console.log(service_id);
            console.log(this.sub_services_show);
            this.sub_services_show.forEach((sub_service, i) => {
                if(sub_service.id==service_id){
                    this.addService(sub_service);
                }
            });
        },

        //ONLY STARTUP
        recommended(){
            switch (this.lifecycle_selected) {
                case 1:
                    this.userRecommended = [1];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [39,40,41,42,43,44];
                break;
                case 2:
                    this.userRecommended = [2];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [39,40,43,44];
                break;
                case 3:
                    this.userRecommended = [];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [40,43,44];
                break;
                case 4:
                    this.userRecommended = [];
                    this.pageRecommended = [5];
                    this.serviceRecommended = [40,44];
                break;
                case 5:
                    this.userRecommended = [];
                    this.pageRecommended = [5,8];
                    this.serviceRecommended = [40,44];
                break;
                case 6:
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [40,44];
                break;
                case 7:
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [38];
                break;
                default:
            }
            console.log(this.serviceRecommended);
        },

        searchSkill(){
            if(this.skill_name){
              axios.get('/api/searchSkill',{
                  params: {
                      skill_name: this.skill_name,
                  }
              }).then((response) => {
                  this.skills_found = response.data.results.skills;
                  if(!this.skill_name){
                      this.skills_found = '';
                  }
              });
            }else{
              this.skills_found = '';
            }
        },

        addSkill(skill_found){

            var exist = false;
            this.skills.forEach((skill, i) => {
                if(skill.pivot.skill_id==skill_found.id){
                  exist = true;
                }
            });

            if(!exist){

              let new_skill = {
                "name":skill_found.name,
                "pivot":{
                  "skill_id": skill_found.id,
                },
              };

              this.skills.push(new_skill);
            }

            this.skills_found = '';
            this.skill_name = '';
        },

        addManualSkill(){

            var exist = false;
            this.skills.forEach((skill, i) => {
                if(skill.name==this.skill_name){
                  exist = true;
                }
            });

            if(!exist && this.skill_name){

              let new_skill = {
                "name":this.skill_name,
                // "pivot":{
                //   "skill_id": skill_found.id,
                // },
              };
              this.skills.push(new_skill);
            }

            this.skills_found = '';
            this.skill_name = '';
        },

        removeSkill(i){
            this.skills.splice(i, 1);
        },

        serviceToggle(service){

            if(document.getElementById('s-'+service.id).checked){
                document.getElementById('s-'+service.id).checked = false;
                document.getElementById('s-'+service.id+'-b').classList.remove("active");
                this.services.forEach((service_i, i) => {
                    if (service_i.id==service.id) {
                        this.removeService(i);
                    }
                });
            }else{
                document.getElementById('s-'+service.id).checked = true;
                document.getElementById('s-'+service.id+'-b').classList.add("active");
                this.addService(service);
            }
        },

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
            this.recommended();
        }
        //END ONLY STARTUP
    },
    created() {
        if(this.services){
            this.services = JSON.parse(this.services.replace(/&quot;/g,'"'));
        }
        if(this.r_services){
            this.r_services = JSON.parse(this.r_services.replace(/&quot;/g,'"'));
            this.r_services.forEach((r_service, i) => {
                if(this.serviceExist(r_service) && !r_service.hidden){
                    this.r_services_show.push(r_service);
                }
            });
        }
        //ONLY STARTUP
        if(this.skills){
            this.skills = JSON.parse(this.skills.replace(/&quot;/g,'"'));
        }
        //END ONLY STARTUP

    },
    mounted() {
        this.getAllServices();
        //ONLY STARTUP
        if(this.lifecycle_id){
            this.lifecycle_id = parseInt(this.lifecycle_id);
            this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:1;
            this.radioToggle(this.lifecycle_selected);
        }
        if(this.lifecycles){
            if(document.getElementById('u-1').checked) {
                this.usertype_selected=true;
            }
        }
        //END ONLY STARTUP

    }
});

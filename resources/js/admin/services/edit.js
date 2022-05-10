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
        pagetype_id,
        services,
        r_services,
        //ONLY STARTUP
        lifecycles,
        lifecycle_id,
        cofounder_services,
        //skills,
        //END ONLY STARTUP
        r_services_show: [],
        service_name: '',
        services_found: '',
        main_services: [],
        sub_services: [],
        sub_services_show: [],
        main_service_selected: '',
        sub_service_selected: '',
        main_cofounder_services: [],
        sub_cofounder_services: [],
        sub_cofounder_services_show: [],
        main_cofounder_service_selected: '',
        sub_cofounder_service_selected: '',
        //ONLY STARTUP
        show_services: false,
        lifecycle_selected: '1',
        usertype_selected: '',
        cofounders: '',
        userRecommended: [],
        pageRecommended: [],
        serviceRecommended: [],
        cofounder_service_name: '',
        cofounsder_services_found: '',
        // skill_name: '',
        // skills_found: '',
        //END ONLY STARTUP
        is_mobile: false,

    },
    methods: {

        submitForm(){
          //document.getElementById('serviceForm').submit();
        },

        changeMainCofounderService(){
            this.sub_cofounder_services_show = [];
            this.sub_cofounder_services.forEach((sub_service, i) => {
                if(sub_service.main_service_id==this.main_cofounder_service_selected){
                    this.sub_cofounder_services_show.push(sub_service);
                }
            });
            this.sub_cofounder_service_selected = "";
            // this.sub_service_selected = this.sub_services_show[0].id;
        },

        addCofounderServiceSelected(service_id){
            this.sub_cofounder_services_show.forEach((sub_service, i) => {
                if(sub_service.id==service_id){
                    var exist = false;
                    this.cofounder_services.forEach((service, i) => {
                        if(service.id==sub_service.id){
                          exist = true;
                        }
                    });
                    if(!exist){
                        this.cofounder_services.push(sub_service);
                        //console.log(this.cofounder_services);
                    }
                }
            });
        },

        // findServiceById(services_array,service_id){
        //     services_array.forEach((service, i) => {
        //         if(service.id==service_id){
        //             return {'object': service, 'position': i};
        //         }
        //     });
        //     return null;
        // },

        removeCofounderService(i){
            this.cofounder_services.splice(i, 1);
        },

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
              this.fullRight(1);
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
              this.fullRight(1);
            }

            this.services_found = '';
            this.service_name = '';
        },

        removeService(i){
            var service = this.services[i];
            this.services.splice(i, 1);
            this.arrowVisibility(1);
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
                // this.main_service_selected = this.main_services[0].id;
                this.changeMainService();

                this.main_cofounder_services = response.data.results.main_services;
                this.sub_cofounder_services = response.data.results.sub_services;
                this.changeMainCofounderService();
            });
        },

        changeMainService(){
            this.sub_services_show = [];
            this.sub_services.forEach((sub_service, i) => {
                if(sub_service.main_service_id==this.main_service_selected){
                    this.sub_services_show.push(sub_service);
                }
            });
            this.sub_service_selected = "";
            // this.sub_service_selected = this.sub_services_show[0].id;
        },

        addServiceSelected(service_id){
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
        },

        // searchSkill(){
        //     if(this.skill_name){
        //       axios.get('/api/searchSkill',{
        //           params: {
        //               skill_name: this.skill_name,
        //           }
        //       }).then((response) => {
        //           this.skills_found = response.data.results.skills;
        //           if(!this.skill_name){
        //               this.skills_found = '';
        //           }
        //       });
        //     }else{
        //       this.skills_found = '';
        //     }
        // },
        //
        // addSkill(skill_found){
        //
        //     var exist = false;
        //     this.skills.forEach((skill, i) => {
        //         if(skill.pivot.skill_id==skill_found.id){
        //           exist = true;
        //         }
        //     });
        //
        //     if(!exist){
        //
        //       let new_skill = {
        //         "name":skill_found.name,
        //         "pivot":{
        //           "skill_id": skill_found.id,
        //         },
        //       };
        //
        //       this.skills.push(new_skill);
        //     }
        //
        //     this.skills_found = '';
        //     this.skill_name = '';
        // },
        //
        // addManualSkill(){
        //
        //     var exist = false;
        //     this.skills.forEach((skill, i) => {
        //         if(skill.name==this.skill_name){
        //           exist = true;
        //         }
        //     });
        //
        //     if(!exist && this.skill_name){
        //
        //       let new_skill = {
        //         "name":this.skill_name,
        //         // "pivot":{
        //         //   "skill_id": skill_found.id,
        //         // },
        //       };
        //       this.skills.push(new_skill);
        //     }
        //
        //     this.skills_found = '';
        //     this.skill_name = '';
        // },
        //
        // removeSkill(i){
        //     this.skills.splice(i, 1);
        // },



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
        // radioToggle(id){
        //     var elems = document.querySelectorAll(".lifecycle-item.active");
        //     [].forEach.call(elems, function(el) {
        //         el.classList.remove("active");
        //     });
        //
        //     document.getElementById('l-' + id).checked = true;
        //     document.getElementById('l-' + id + '-b').classList.add("active");
        //     this.lifecycle_selected = id;
        //     this.recommended();
        // }
        //END ONLY STARTUP
        scrollLeft(slider_id){
            var content =
            document.getElementById('multi-slider-cont-' + slider_id);
            const content_scroll_width = content.scrollWidth;
            let content_scoll_left = content.scrollLeft;
            content_scoll_left -= 10;
            if (content_scoll_left <= 0) {
                content_scoll_left = 0;
            }
            content.scrollLeft = content_scoll_left;
            this.arrowVisibility(slider_id);
        },

        scrollRight(slider_id){
            var content =
            document.getElementById('multi-slider-cont-' + slider_id);
            const content_scroll_width = content.scrollWidth;
            let content_scoll_left = content.scrollLeft;
            content_scoll_left += 10;
            if (content_scoll_left >= content_scroll_width) {
                content_scoll_left = content_scroll_width;
            }
            content.scrollLeft = content_scoll_left;
            this.arrowVisibility(slider_id);
        },

        fullRight(slider_id){
            if(!this.interval){
                this.interval = setInterval(()=>{
                    this.scrollRight(slider_id);
                }, 2);
            }
        },

        start(slider_id,direction){
            if(!this.interval){
                this.interval = setInterval(()=>{
                    if(direction=='right'){
                        this.scrollRight(slider_id);
                    }else{
                        this.scrollLeft(slider_id);
                    }
                }, 10);
            }
        },

        stop(){
            clearInterval(this.interval);
            this.interval = false;
        },

        arrowVisibility(slider_id){
            var content =
            document.getElementById('multi-slider-cont-' + slider_id);
            let content_scroll_width = content.scrollWidth;
            let content_scoll_left = content.scrollLeft;
            let content_offset_width = content.offsetWidth;
            // console.log(content_scroll_width,content_scoll_left,content_offset_width);
            if(content_offset_width + content_scoll_left >= content_scroll_width){
                // console.log('nascondi freccia a destra');
                document.getElementById('button-right-' + slider_id).classList.remove("visible");
                document.getElementById('button-right-' + slider_id).classList.add("invisible");
                this.stop();
            }else{
                // console.log('mostra freccia a destra');
                document.getElementById('button-right-' + slider_id).classList.remove("invisible");
                document.getElementById('button-right-' + slider_id).classList.add("visible");
            }
            if(content_scoll_left<=0){
                // console.log('nascondi freccia a sinistra');
                document.getElementById('button-left-' + slider_id).classList.remove("visible");
                document.getElementById('button-left-' + slider_id).classList.add("invisible");
                this.stop();
            }else{
                // console.log('mostra freccia a sinistra');
                document.getElementById('button-left-' + slider_id).classList.remove("invisible");
                document.getElementById('button-left-' + slider_id).classList.add("visible");
            }
        },

        delay(slider_id){
            setTimeout(()=>{
                this.arrowVisibility(slider_id);
            }, 1000);
        },
    },
    created() {
        // if(this.services){
        //     this.services = JSON.parse(this.services.replace(/&quot;/g,'"'));
        // }
        if(this.r_services){
            // this.r_services = JSON.parse(this.r_services.replace(/&quot;/g,'"'));
            this.r_services.forEach((r_service, i) => {
                if(this.serviceExist(r_service) && !r_service.hidden){
                    this.r_services_show.push(r_service);
                }
            });
        }
        //ONLY STARTUP
        // if(this.cofounder_services){
        //     this.cofounder_services = JSON.parse(this.cofounder_services.replace(/&quot;/g,'"'));
        // }
        //END ONLY STARTUP

    },
    mounted() {
        this.getAllServices();
        //ONLY STARTUP
        if(this.lifecycle_id){
            this.lifecycle_id = parseInt(this.lifecycle_id);
            this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:1;
            // this.radioToggle(this.lifecycle_selected);
            this.recommended();
        }
        if(this.lifecycles  && this.pagetype_id==1){
            if(document.getElementById('u-1').checked) {
                this.usertype_selected=true;
            }
        }
        //END ONLY STARTUP

    }
});

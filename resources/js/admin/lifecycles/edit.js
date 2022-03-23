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
        skills,
        show_services: false,
        lifecycle_selected: '1',
        cofounders: '',
        userRecommended: [],
        pageRecommended: [],
        serviceRecommended: [],
        skill_name: '',
        skills_found: '',
    },

    methods: {

        recommended(){
          console.log(this.lifecycle_selected);
            switch (this.lifecycle_selected) {
                case '1':
                    this.userRecommended = [1];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [2,3,4,5,6,8];
                break;
                case '2':
                    this.userRecommended = [2];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [2,4,6,8];
                break;
                case '3':
                    this.userRecommended = [];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [2,6,8];
                break;
                case '4':
                    this.userRecommended = [];
                    this.pageRecommended = [5];
                    this.serviceRecommended = [2,8];
                break;
                case '5':
                    this.userRecommended = [];
                    this.pageRecommended = [5,8];
                    this.serviceRecommended = [2,8];
                break;
                case '6':
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [2,8];
                break;
                case '7':
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [1];
                break;
                default:
            }
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
        }

    },
    created(){
        if(this.skills){
            this.skills = JSON.parse(this.skills.replace(/&quot;/g,'"'));
        }
    },
    mounted() {
        this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:'1';
        this.recommended();
    }

});

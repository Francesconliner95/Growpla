import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#skill-edit',
    data: {
        skills,
        skill_name: '',
        skills_found: '',
    },
    methods: {

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
    created() {
        if(this.skills){
            this.skills = JSON.parse(this.skills.replace(/&quot;/g,'"'));
        }

    },
    mounted() {

    }
});

document.addEventListener('keypress', function (e) {
    if (e.keyCode === 13 || e.which === 13) {
        e.preventDefault();
        return false;
    }
});

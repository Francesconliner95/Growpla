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
        skill,
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
            this.skill_name = skill_found.name;
            this.skills_found='';
        }

    },
    created() {
        if(this.skill){
            this.skill = JSON.parse(this.skill.replace(/&quot;/g,'"'));
            this.skill_name = this.skill.name;
        }

    },
    mounted() {
    }
});

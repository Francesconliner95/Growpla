import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#page-show',
    data: {
        id,
        lang,
        is_my_page,
        page,
        team_members,
        team_num,
        following,
        collaborations: [],
    },
    methods: {

      open(filename){
          var newWindow = window.open();
          newWindow.document.write('<iframe src="/storage/'+ filename +'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">');
      },

      toggleFollow(){
        axios({
            method: 'post',
            url: '/admin/toggleFollowing',
            data: {
                follow_type: 2,//1 utente 2 pagina
                follow_id: this.page.id,
            }
        }).then(response => {
            this.following = response.data.results.following;
        });
      },

      teamToggle(){
          this.show_all_team = !this.show_all_team;
          if(this.show_all_team){
              this.getTeamMembers();
          }else{
              this.team_members = this.team_members.slice(0, 3);
          }
      },

      getTeamMembers(){
          axios.get('/api/getTeamMembers',{
              params: {
                  page_id: this.page.id,
              }
          }).then((response) => {
              this.team_members = response.data.results.team_members;
          });
      },

        changeTeamPosition(member_id,value){
            axios({
                method: 'put',
                url: '/admin/changeTeamPosition',
                data: {
                    team_id: member_id,
                    up_down: value,
                }
            }).then(response => {
                this.getTeamMembers();
            });
        },

        getCollaborations(){

            axios.get('/admin/getCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: 'page',
                }
            }).then((response) => {
                this.collaborations = response.data.results.collaborations;
                console.log(this.collaborations);
            });
        }

    },
    created(){
      this.page = JSON.parse(this.page.replace(/&quot;/g,'"'));
      if(this.team_members){
          this.team_members = JSON.parse(this.team_members.replace(/&quot;/g,'"'));
          console.log(this.team_members);
      }

    },
    mounted() {
        this.getCollaborations();
    },

});

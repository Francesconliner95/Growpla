import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#page-show',
    data: {
        lang,
        is_my_page,
        page,
        team_members,
        team_num,
    },
    methods: {

      open(filename){
          var newWindow = window.open();
          newWindow.document.write('<iframe src="/storage/'+ filename +'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">');
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
                  account_id: this.account.id,
                  // get_all: this.show_all_team?'yes':'no',
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
                  member_id: member_id,
                  up_down: value,
              }
          }).then(response => {
              this.getTeamMembers();
          });
      },

      delete_member(member_id){
          axios({
              method: 'delete',
              url: '/admin/deleteMember',
              data: {
                  member_id: member_id,
              }
          }).then(response => {
              this.team_num = response.data.results.team_num;
              this.getTeamMembers();
          });
      },

    },
    created(){
      this.page = JSON.parse(this.page.replace(/&quot;/g,'"'));
    },
    mounted() {

    },

});

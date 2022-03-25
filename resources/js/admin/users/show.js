import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};
var create = new Vue({
    el: '#user-show',
    data: {
        id,
        lang,
        is_my_user,
        //user,
        following,
        collaborations: [],
    },
    methods: {

        open(filename){
          var newWindow = window.open();
          newWindow.document.write('<iframe src="/storage/'+ filename +'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">');
        },

        toggleFollow(user_id){
        axios({
            method: 'post',
            url: '/admin/toggleFollowing',
            data: {
                follow_type: 1,//1 utente 2 pagina
                follow_id: user_id,
            }
        }).then(response => {
            this.following = response.data.results.following;
        });
        },

        getCollaborations(){
            
            axios.get('/admin/getCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: 'user',
                }
            }).then((response) => {
                this.collaborations = response.data.results.collaborations;
                console.log(this.collaborations);
            });
        }

    },
    created(){
      // console.log(this.user);
      // this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
      // console.log(this.user);
    },
    mounted() {
        this.getCollaborations();
    },

});

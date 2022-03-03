import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#follows-index',
    data: {
        followed,
    },
    methods: {

        getFollowed(){
            axios.get('/admin/getFollowed',{
            }).then((response) => {
                this.followed = response.data.results.followed;
            });
        },

        toggleFollow(following_id,follow_type){
          axios({
              method: 'post',
              url: '/admin/toggleFollowing',
              data: {
                  follow_type: follow_type,//1 utente 2 pagina
                  follow_id: following_id,
              }
          }).then(response => {
              this.getFollowed();
          });
        },

    },
    created(){
      if(this.followed){
          this.followed = JSON.parse(this.followed.replace(/&quot;/g,'"'));
      }
    },
    mounted() {
        //console.log(this.my_follows);
    }

});

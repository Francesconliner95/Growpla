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
        list_user: '',
        list_pages: '',
        alert: false,
        interval:false,
        is_mobile: false,
    },
    methods: {
        switchAccounts(){
            this.alert = true;
            axios.get('/admin/getMyAccounts',{
            }).then((response) => {
                this.list_user = response.data.results.user;
                this.list_pages = response.data.results.pages;
            });
        },

        startChat(page_id){
            axios({
                method: 'post',
                url: '/admin/createChat',
                data: {
                    recipient_id: id,
                    recipient_user_or_page: 'page',
                    page_selected_id: page_id,
                }
            }).then(response => {
                var route = response.data.results.route;
                window.location.href = route;
            });
        },

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
        },

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
            }else{
                // console.log('mostra freccia a destra');
                document.getElementById('button-right-' + slider_id).classList.remove("invisible");
                document.getElementById('button-right-' + slider_id).classList.add("visible");
            }
            if(content_scoll_left<=0){
                // console.log('nascondi freccia a sinistra');
                document.getElementById('button-left-' + slider_id).classList.remove("visible");
                document.getElementById('button-left-' + slider_id).classList.add("invisible");
            }else{
                // console.log('mostra freccia a sinistra');
                document.getElementById('button-left-' + slider_id).classList.remove("invisible");
                document.getElementById('button-left-' + slider_id).classList.add("visible");
            }
        },

        stop(slider_id,direction){
            clearInterval(this.interval);
            this.interval = false;
        },

        delay(slider_id){
            setTimeout(()=>{
                this.arrowVisibility(slider_id);
            }, 1000);
        },

        checkMobile(){
            if(window.innerWidth>=768){
                if(this.is_mobile){
                    this.is_mobile = false;
                }
            }else{
                if(!this.is_mobile){
                    this.is_mobile = true;
                }
            }
        },

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
        this.checkMobile();
        window.addEventListener('resize', (event)=> {
            this.checkMobile();
        }, true);

        if(document.getElementById('multi-slider-cont-1')){
            this.arrowVisibility(1);
        }
        if(document.getElementById('multi-slider-cont-2')){
            this.arrowVisibility(2);
        }

    },

});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

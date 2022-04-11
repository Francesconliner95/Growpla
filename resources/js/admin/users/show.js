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
                    recipient_user_or_page: 'user',
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
                // console.log(this.collaborations);
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
        }

    },
    created(){
      // console.log(this.user);
      // this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
      // console.log(this.user);
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
        if(document.getElementById('multi-slider-cont-3')){
            this.arrowVisibility(3);
        }
        if(document.getElementById('multi-slider-cont-4')){
            this.arrowVisibility(4);
        }
        if(document.getElementById('multi-slider-cont-5')){
            this.arrowVisibility(5);
        }
        if(document.getElementById('multi-slider-cont-6')){
            this.arrowVisibility(6);
        }
        if(document.getElementById('multi-slider-cont-7')){
            this.arrowVisibility(7);
        }
        if(document.getElementById('multi-slider-cont-8')){
            this.arrowVisibility(8);
        }
        if(document.getElementById('multi-slider-cont-9')){
            this.arrowVisibility(9);
        }

        // var elements = document.getElementsByClassName('multi-slider-cont');
        // for (var i = 0; i < elements.length; i++) {
        //     this.arrowVisibility(i+1);
        //     console.log(i+1);
        // }

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

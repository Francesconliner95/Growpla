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
        user,
        is_my_user,
        following,
        give_have_user_service,
        skills_count,
        default_images,
        page_creation,
        collaborations: [],
        r_collaborations: [],
        list_user: '',
        list_pages: '',
        alert: false,
        alert_type: 1,
        alert_var_1: '',
        interval:false,
        is_mobile: false,
        profile_check: '',
    },
    methods: {

        switchAccounts(){
            this.alert = true;
            this.alert_type = 1;
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

        alert_2(collaboration){
            this.alert = true;
            this.alert_type = 2;
            this.alert_var_1 = collaboration;
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

        getRecommendedCollaborations(){

            axios.get('/admin/getRecommendedCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: 'user',
                }
            }).then((response) => {
                this.r_collaborations = response.data.results.collaborations;
                //console.log(this.r_collaborations);
            });
        },

        confirmCollaboration(collaboration){
            axios({
                method: 'put',
                url: '/admin/confirmCollaboration',
                data: {
                    collaboration_id: collaboration.id,
                    account_id: this.id,
                    user_or_page: 'user',
                }
            }).then(response => {
                this.getCollaborations();
                this.getRecommendedCollaborations();
            });
        },

        deleteCollaboration(collaboration){
            axios({
                method: 'delete',
                url: '/admin/deleteCollaboration',
                data: {
                    collaboration_id: collaboration.id,
                    account_id: this.id,
                    user_or_page: 'user',
                }
            }).then(response => {
                this.getRecommendedCollaborations();
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

        profile_check_f(){
            if(this.is_my_user){
                this.profile_check = [
                    {
                        name: 'Inserire un\'immagine di profilo aumenta la fiducia degli altri utenti nei tuoi confronti e moltiplica le possibilità di instaurare collaborazioni',
                        check: this.default_images.includes(this.user.image)?false:true,
                    },
                    {
                        name: 'Presentati agli altri utenti: racconta di te, delle tue capacità ed attività e molto altro',
                        check: this.user.description?true:false,
                    },
                    {
                        name: 'Inserisci almeno uno tra CV, collegamento a LinkedIn o sito web in modo da certificare tue competenze',
                        check: this.user.linkedin
                                || this.user.website
                                || this.user.cv?true:false,
                    },
                    {
                        name: 'Fai sapere agli altri utenti quali servizi offri/cerchi',
                        check: this.give_have_user_service?true:false,
                    },
                    {
                        name: 'Inserisci competenze correlate a ciò che sai fare (SW utilizzati, linguaggi di programmazione, soft skill, aree di conoscenza e competenza e molto altro)',
                        check: this.skills_count?true:false,
                    },
                ];
                if(this.page_creation){
                    var array = [
                            {
                                name: 'Crea la pagina dell\'attività di cui sei founder, co-founder o socio <div class="py-2"><a href="/admin/pagetype" class="button-style button-color-blue">Crea pagina</a></div>',
                                check: this.page_creation==1?true:false,
                            },
                        ];
                    this.profile_check.push(...array);
                }
                this.profile_check.sort(function(a, b) {
                    return b.check - a.check
                })
                var profile_complete = true;
                this.profile_check.forEach((check, i) => {
                    if(check.check==false){
                        profile_complete = false;
                    }
                });
                if(profile_complete){
                    this.profile_check = false;
                }

            }

        }

    },
    created(){

    },
    mounted() {
        this.profile_check_f();
        this.getCollaborations();
        this.getRecommendedCollaborations();
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

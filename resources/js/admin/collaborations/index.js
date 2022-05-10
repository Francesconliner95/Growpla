import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#collaboration-index',
    data: {
        lang,
        collaborations,
        collaborations_show: [],
        page: 1,
        show_prev: false,
        show_next: false,
        in_load: false,
        showScrollTop: false,
        colls: [],
    },
    methods: {
        scrollTop(){
            window.scrollTo({top: 0, behavior: 'smooth'});
        },
        showMore(){
            var collaborations_qty = this.colls.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(collaborations_qty/items_qty)){
                var new_collaborations_show = this.colls.slice(items_qty*this.page-items_qty,items_qty*this.page);
                this.loadNeedInfo(new_collaborations_show);
                this.page++;
            }
        },
        loadNeedInfo(new_collaborations){
            if(new_collaborations){
                this.in_load = true;
                axios.get('/admin/loadCollaborationsInfo',{
                    params: {
                        collaborations: new_collaborations,
                    }
                }).then((response) => {
                    this.collaborations_show.push(...response.data.results.collaborations);
                    this.in_load = false;
                });
            }
        },
        scrollFunction(){
            // console.log(window.innerHeight + window.scrollY);
            // console.log(document.body.offsetHeight+2);
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight-2) {
                this.showMore();
            }
            if(window.scrollY>0){
                this.showScrollTop = true;
            }else{
                this.showScrollTop = false;
            }
        },

        already_exist(collaboration){

            var sender_user_id = collaboration.sender_user_id;
            var sender_page_id = collaboration.sender_page_id;
            var recipient_user_id = collaboration.recipient_user_id;
            var recipient_page_id = collaboration.recipient_page_id;
            var exist = false;

            this.colls.forEach((coll, i) => {
                if(sender_user_id){
                    if(sender_user_id==coll.sender_user_id){
                        if(coll.recipient_user_id==recipient_user_id){
                            exist = true;
                        }
                        if(coll.recipient_page_id==recipient_page_id){
                            exist = true;
                        }
                    }
                    if(sender_user_id==coll.recipient_user_id){
                        if(coll.sender_user_id==recipient_user_id){
                            exist = true;
                        }
                        if(coll.sender_page_id==recipient_user_id){
                            exist = true;
                        }
                    }
                }
                if(sender_page_id){
                    if(sender_page_id==coll.sender_page_id){
                        if(coll.recipient_user_id==recipient_user_id){
                            exist = true;
                        }
                        if(coll.recipient_page_id==recipient_page_id){
                            exist = true;
                        }
                    }
                    if(sender_page_id==coll.recipient_page_id){
                        if(coll.sender_user_id==recipient_user_id){
                            exist = true;
                        }
                        if(coll.sender_page_id==recipient_user_id){
                            exist = true;
                        }
                    }

                }
            });

            if(exist){
                return true;
            }else{
                return false;
            }

        },

    },
    created(){
        console.log(this.collaborations);
        if(this.collaborations){
            this.collaborations.forEach((collaboration, i) => {
                if(!this.already_exist(collaboration)){
                    this.colls.push(collaboration);
                }
            });
            console.log(this.colls);
        }
        this.showMore();
    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

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
    },
    methods: {
        scrollTop(){
            window.scrollTo({top: 0, behavior: 'smooth'});
        },
        showMore(){
            var collaborations_qty = this.collaborations.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(collaborations_qty/items_qty)){
                var new_collaborations_show = this.collaborations.slice(items_qty*this.page-items_qty,items_qty*this.page);
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


    },
    created(){

        if(this.collaborations){
            this.collaborations = JSON.parse(this.collaborations.replace(/&quot;/g,'"'));
        }
        this.showMore();

    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

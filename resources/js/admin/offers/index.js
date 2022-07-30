import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#offers',
    data: {
        lang,
        offers,
        offers_show: [],
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

        orderByDate(offers){
            //ordinamento per data
            for (var i=0; i < offers.length; i++) {
                for (var j=0; j < offers.length-1; j++) {
                    if (offers[j].updated_at<offers[i].updated_at) {
                        var tmp=offers[j];
                        offers[j]=offers[i];
                        offers[i]=tmp;
                    }
                }
            }
            this.offers = offers;
            this.showMore();
        },

        showMore(){
            var offers_qty = this.offers.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(offers_qty/items_qty)){
                var new_offers_show = this.offers.slice(items_qty*this.page-items_qty,items_qty*this.page);
                this.loadNeedInfo(new_offers_show);
                this.page++;
            }
        },

        loadNeedInfo(new_offers){
            // console.log(new_offers);
            if(new_offers){
                this.in_load = true;
                axios.get('/admin/loadNeedInfo',{
                    params: {
                        needs: new_offers,
                    }
                }).then((response) => {
                    this.offers_show.push(...response.data.results.needs);
                    this.in_load = false;

                });
            }
        },
        scrollFunction(){
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
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
        this.orderByDate(this.offers);
    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

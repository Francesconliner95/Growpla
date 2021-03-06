import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#needs',
    data: {
        lang,
        needs,
        needs_show: [],
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

        orderByDate(needs){
            //ordinamento per date
            for (var i=0; i < needs.length; i++) {
                for (var j=0; j < needs.length-1; j++) {
                    if (needs[j].updated_at<needs[i].updated_at) {
                      var tmp=needs[j];
                      needs[j]=needs[i];
                      needs[i]=tmp;
                    }
                }
            }
            this.needs = needs;
            this.showMore();
        },

        showMore(){
            var needs_qty = this.needs.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(needs_qty/items_qty)){
                var new_needs_show = this.needs.slice(items_qty*this.page-items_qty,items_qty*this.page);
                this.loadNeedInfo(new_needs_show);
                this.page++;
            }

        },

        loadNeedInfo(new_needs){
            // console.log(new_needs);
            if(new_needs){
                this.in_load = true;
                axios.get('/admin/loadNeedInfo',{
                    params: {
                        needs: new_needs,
                    }
                }).then((response) => {
                    this.needs_show.push(...response.data.results.needs);
                    // console.log(this.needs_show);
                    this.in_load = false;
                });
            }
        },
        scrollFunction(){
            // console.log(window.innerHeight + window.scrollY);
            // console.log(document.body.offsetHeight);
            // console.log((window.innerHeight + window.scrollY) >= document.body.offsetHeight);
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
        this.orderByDate(this.needs);
    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

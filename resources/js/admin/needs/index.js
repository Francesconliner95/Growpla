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
    },
    methods: {

        orderById(needs){
            //ordinamento per id
            for (var i=0; i < needs.length; i++) {
                for (var j=0; j < needs.length-1; j++) {
                    if (needs[j].id>needs[i].id) {
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
            console.log(new_needs);
            if(new_needs){
                axios.get('/admin/loadNeedInfo',{
                    params: {
                        needs: new_needs,
                    }
                }).then((response) => {
                    this.needs_show.push(...response.data.results.needs);
                    console.log(this.needs_show);
                });
            }
        },
        scrollFunction(){
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                this.showMore();
            }
        },

    },
    created(){

        if(this.needs){
            this.needs = JSON.parse(this.needs.replace(/&quot;/g,'"'));
        }
        this.orderById(this.needs);

    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

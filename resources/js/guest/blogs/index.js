import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#blog-index',
    data: {
        blogs,
        blogs_show: [],
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
            var blogs_qty = this.blogs.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(blogs_qty/items_qty)){
                var new_blogs_show = this.blogs.slice(items_qty*this.page-items_qty,items_qty*this.page);
                this.loadBlogInfo(new_blogs_show);
                this.page++;
            }
        },

        loadBlogInfo(new_blogs){
            if(new_blogs){
                this.in_load = true;
                axios.get('/api/loadBlogInfo',{
                    params: {
                        blogs: new_blogs,
                    }
                }).then((response) => {
                    this.blogs_show.push(...response.data.results.blogs);
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

        getDate(created_at){
            return moment(created_at).format("DD/MM/YY")
        },

    },
    created(){
        this.showMore();
    },
    mounted() {
        window.onscroll = ()=>{this.scrollFunction()};
    }

});

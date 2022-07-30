import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#blog-show',
    data: {
        blogs: [],
    },
    methods: {
        getBlogs(){
            axios.get('/api/getLatestBlogs',{
            }).then((response) => {
                this.blogs = response.data.results.blogs;
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

        delay(slider_id){
            setTimeout(()=>{
                this.arrowVisibility(slider_id);
            }, 1000);
        },

        stop(slider_id,direction){
        	clearInterval(this.interval);
            this.interval = false;
        },

        getDate(created_at){
            return moment(created_at).format("DD/MM/YY")
        }
    },
    created(){

    },
    mounted() {
        this.getBlogs();
    }
});

// $('.carousel').carousel();
// $('.carousel').carousel('prev');
// $('.carousel').carousel('next');

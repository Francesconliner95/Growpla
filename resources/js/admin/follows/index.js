import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#follows-index',
    data: {
        my_follows,
    },
    methods: {

        getfollows(){
            axios.get('/admin/getFollows',{
            }).then((response) => {
                this.my_follows = response.data.results.my_follows;
                //console.log(this.my_follows);
            });
        },

        setFollow(account_id){
            axios({
                method: 'post',
                url: '/admin/addFollow',
                data: {
                    follow_id: account_id,
                }
            }).then(response => {
                this.getfollows();
            });

        },

    },
    mounted() {
        //console.log(this.my_follows);
    }

});

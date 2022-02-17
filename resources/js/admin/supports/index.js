import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

//ricarico la pagina quando torno indietro
if(performance.navigation.type == 2){
   location.reload(true);
}

var create = new Vue({
    el: '#support-index',
    data: {
        supportTypes,
        supports: '',
    },

    methods: {
        getAllSupports(){
            axios.get('/admin/getAllSupports',{
            }).then((response) => {
                this.supports = response.data.results.supports;
            });
        },

    },
    mounted() {
        this.getAllSupports();
    }

});

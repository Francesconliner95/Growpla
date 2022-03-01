import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
}; //in caso di problemi togliere

var create = new Vue({
    el: '#lifecycle-edit',
    data: {
        lang,
        lifecycles,
        lifecycle_id,
        show_services: false,
        lifecycle_selected: '1',
        cofounders: '',
        search_role: '',
        roles_found: '',
        userRecommended: [],
        pageRecommended: [],
        serviceRecommended: [],
    },

    methods: {

        recommended(){
          console.log(this.lifecycle_selected);
            switch (this.lifecycle_selected) {
                case '1':
                    this.userRecommended = [1];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [1,2,4,5,6,7,10];
                break;
                case '2':
                    this.userRecommended = [2];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [2,5,7,10];
                break;
                case '3':
                    this.userRecommended = [];
                    this.pageRecommended = [3];
                    this.serviceRecommended = [2,7,10];
                break;
                case '4':
                    this.userRecommended = [];
                    this.pageRecommended = [5];
                    this.serviceRecommended = [2,10];
                break;
                case '5':
                    this.userRecommended = [];
                    this.pageRecommended = [5,8];
                    this.serviceRecommended = [2,10];
                break;
                case '6':
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [2,10];
                break;
                case '7':
                    this.userRecommended = [];
                    this.pageRecommended = [];
                    this.serviceRecommended = [1];
                break;
                default:
            }
        },

    },
    mounted() {
        this.lifecycle_selected = this.lifecycle_id?this.lifecycle_id:'1';
        this.recommended();
    }

});

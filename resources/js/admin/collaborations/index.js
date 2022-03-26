import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#collaboration-index',
    data: {
        id,
        user_or_page,
        collaborations: [],
        prop_collaborations: [],
    },
    methods: {

        getCollaborations(){
            axios.get('/admin/getCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: this.user_or_page,
                }
            }).then((response) => {
                this.collaborations = response.data.results.collaborations;
            });
        },

        getProposalCollaborations(){
            axios.get('/admin/getProposalCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: this.user_or_page,
                }
            }).then((response) => {
                this.prop_collaborations = response.data.results.collaborations;
            });
        },

        deleteCooperation(collaboration_id){
            axios({
                method: 'delete',
                url: '/admin/deleteCollaboration',
                data: {
                    collaboration_id: collaboration_id,
                }
            }).then(response => {
                this.getCollaborations();
                this.getProposalCollaborations();
            });
        },

        confirmCooperation(collaboration_id){
            axios({
                method: 'put',
                url: '/admin/confirmCollaboration',
                data: {
                    collaboration_id: collaboration_id,
                }
            }).then(response => {
                this.getProposalCollaborations();
            });
        },

    },
    mounted() {
        this.getCollaborations();
        this.getProposalCollaborations();
    },
    // watch: {
    //     account_selected: function(new_val, old_val) {
    //         console.log(new_val, old_val);
    //     }
    // }

});

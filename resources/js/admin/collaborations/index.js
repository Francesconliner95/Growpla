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
        delete_alert: false,
        case_type: '',
        alert_par: '',
        message: '',
        alert_b1: '',
        alert_b2: '',
    },
    methods: {

        alertMenu(case_type,parameter){
            this.delete_alert = true;
            this.case_type = case_type;
            this.alert_par = parameter;
            switch (this.case_type) {
                case 1:
                    this.message = 'Sei sicuro di voler eliminare la collaborazione?';
                    this.alert_b1 = 'Annulla';
                    this.alert_b2 = 'Elimina';
                break;
                case 2:
                    this.message = 'Vuoi aggiungerla anche tra le tue collaborazioni?';
                    this.alert_b1 = 'Si';
                    this.alert_b2 = 'No';
                break;

                default:
            }
        },
        alertCancel(){
            this.delete_alert = false;
            this.case_type = '';
            this.message = '';
            this.alert_b1 = '';
            this.alert_b2 = '';
            this.alert_par = '';
        },
        //bottone positivo
        option1(){
            switch (this.case_type) {
                case 1:
                    //annulla eliminazione
                break;
                case 2:
                    //conferma collaborazione ed aggiungila alle mie
                    this.confirmCollaboration(this.alert_par);
                    this.addCollaboration(this.alert_par)
                break;

                default:
            }
            this.alertCancel();

        },
        //bottone negativo
        option2(){
            switch (this.case_type) {
                case 1:
                    //conferma eliminazione
                    this.deleteCollaboration(this.alert_par);
                break;
                case 2:
                    //conferma collaborazione
                    this.confirmCollaboration(this.alert_par);
                break;

                default:
            }
            this.alertCancel();
        },
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

        deleteCollaboration(collaboration){
            axios({
                method: 'delete',
                url: '/admin/deleteCollaboration',
                data: {
                    collaboration_id: collaboration.id,
                }
            }).then(response => {
                this.getCollaborations();
                this.getProposalCollaborations();
            });
        },

        confirmCollaboration(collaboration){
            axios({
                method: 'put',
                url: '/admin/confirmCollaboration',
                data: {
                    collaboration_id: collaboration.id,
                }
            }).then(response => {
                this.getProposalCollaborations();
            });
        },

        addCollaboration(collaboration){

            if(collaboration.sender_user_id){
                var recipient_id = collaboration.sender_user_id;
                var recipient_user_or_page = 'user';
            }
            if(collaboration.recipient_user_id){
                var sender_id = collaboration.recipient_user_id;
                var sender_user_or_page = 'user';
            }
            if(collaboration.sender_page_id){
                var recipient_id = collaboration.sender_page_id;
                var recipient_user_or_page = 'page';
            }
            if(collaboration.recipient_page_id){
                var sender_id = collaboration.recipient_page_id;
                var sender_user_or_page = 'page';
            }
            axios({
                method: 'post',
                url: '/admin/collaborations',
                data: {
                    sender_id: sender_id,
                    sender_user_or_page: sender_user_or_page,
                    recipient_id: recipient_id,
                    recipient_user_or_page: recipient_user_or_page,
                }
            }).then(response => {
                this.getCollaborations();
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

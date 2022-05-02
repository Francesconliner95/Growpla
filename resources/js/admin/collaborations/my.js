import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#my-collaboration',
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
        account_name: '',
        accounts_found: '',
        in_load_1: false,
        in_load_2: false,
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
                    this.addCollaboration(this.alert_par);
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
            this.in_load_1 = true;
            axios.get('/admin/getCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: this.user_or_page,
                }
            }).then((response) => {
                this.collaborations = response.data.results.collaborations;
                this.in_load_1 = false;
            });
        },

        getProposalCollaborations(){
            this.in_load_2 = true;
            axios.get('/admin/getProposalCollaborations',{
                params: {
                    account_id: this.id,
                    user_or_page: this.user_or_page,
                }
            }).then((response) => {
                this.prop_collaborations = response.data.results.collaborations;
                this.in_load_2 = false;
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
            console.log(collaboration.id);
            axios({
                method: 'post',
                url: '/admin/collaborations',
                data: {
                    sender_id: sender_id,
                    sender_user_or_page: sender_user_or_page,
                    recipient_id: recipient_id,
                    recipient_user_or_page: recipient_user_or_page,
                    old_collaboration_id: collaboration.id,
                }
            }).then(response => {
                this.getCollaborations();
            });
        },

        searchAccount(){
          if(this.account_name){
              axios.get('/api/searchAccount',{
                  params: {
                      account_name: this.account_name,
                  }
              }).then((response) => {
                  this.accounts_found = response.data.results.accounts;
                  console.log(this.accounts_found);
                  if(!this.account_name){
                      this.accounts_found = '';
                  }
              });
          }else{
              this.accounts_found = '';
          }
        },

        addAccount(account_found){
            this.accounts_found = '';
            this.account_name = '';
            axios({
                method: 'post',
                url: '/admin/collaborations',
                data: {
                    sender_id: this.id,
                    sender_user_or_page: this.user_or_page,
                    recipient_id: account_found.id,
                    recipient_user_or_page: account_found.user_or_page,
                }
            }).then(response => {
                this.getCollaborations();
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

        stop(slider_id,direction){
            clearInterval(this.interval);
            this.interval = false;
        },

        delay(slider_id){
            setTimeout(()=>{
                this.arrowVisibility(slider_id);
            }, 1000);
        },

    },
    mounted() {
        this.getCollaborations();
        this.getProposalCollaborations();
    },

});

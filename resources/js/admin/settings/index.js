import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
}; //in caso di problemi togliere

var create = new Vue({
    el: '#settings-index',
    data: {
        account,
        accountTypes,
        startupStates,
        filter_messages,
        filter_mails,
        filter_notfs,
        lang,
        selected_lang: lang,
        delete_alert: false,
        filterTypes: [
                        {
                            id:1,
                            name_it: 'ricevo messaggi',
                            name_en: 'i get messages',
                            checked:false,
                            show: true,
                        },
                        {
                            id:2,
                            name_it: 'una startup necessita dei servizi che offro',
                            name_en: 'a startup needs the services I offer',
                            checked:false,
                            show: true,
                        },
                        {
                            id:3,
                            name_it: 'ricevo candidature per il ruolo di Cofounder',
                            name_en: 'i get nominations for the role of Cofounder',
                            checked:false,
                            show: true,
                        },
                    ],
        filterNotTypes: [
                            {
                                id:1,
                                name_it: 'le startup che seguo entrano in una nuova fase del ciclo di vita',
                                name_en: 'the startups I follow enter a new phase of the life cycle',
                                checked:false,
                                show: true,
                            },
                            {
                                id:2,
                                name_it: 'una startup necessita dei servizi che offro',
                                name_en: 'a startup needs the services I offer',
                                checked:false,
                                show: true,
                            },
                            {
                                id:3,
                                name_it: 'ricevo condidature per il ruolo di Cofounder',
                                name_en: 'i get nominations for the role of Cofounder',
                                checked:false,
                                show: true,
                            },
                            {
                                id:4,
                                name_it: 'gli account che seguo aggiungono nuovi contenuti ',
                                name_en: 'the accounts I follow add new content',
                                checked:false,
                                show: true,
                            },
                        ],
    },

    methods: {
        changeLang(){
            console.log(this.selected_lang);
            axios({
                method: 'put',
                url: '/admin/changeLang',
                data: {
                    lang_id: this.selected_lang,
                }
            }).then(response => {
                location.reload();
            });
        },

        setFilterMessage(accountType_id,startup_state_id){
            //console.log(accountType_id,startup_state_id);
            axios({
                method: 'put',
                url: '/admin/setFilterMessage',
                data: {
                    account_id: this.account.id,
                    account_type_id: accountType_id,
                    startup_state_id: startup_state_id,
                }
            }).then(response => {
                this.getFilterMessage();
            });
        },

        getFilterMessage(){
            // axios.get('/admin/getFilterMessage',{
            //     params: {
            //         account_id: this.account.id,
            //     }
            // }).then((response) => {
            //     var accounts_deactivate = response.data.results.filter_message;
            //     this.syncFilterMessage(accounts_deactivate);
            // });
        },

        syncFilterMessage(accounts_deactivate){
            this.accountTypes.forEach((accountType, i) => {
                var is_deactivate = false;
                accounts_deactivate.forEach((account_deac, i) => {
                    if(accountType.id==account_deac.account_type_id){
                        is_deactivate = true;
                    }
                });
                if(is_deactivate){
                    accountType['checked'] = false;
                }else{
                    accountType['checked'] = true;
                }
            });

            this.startupStates.forEach((startupState, i) => {
                var is_deactivate = false;
                accounts_deactivate.forEach((account_deac, i) => {
                    if(account_deac.account_type_id==1){
                        if(startupState.id==account_deac.startup_state_id){
                            is_deactivate = true;
                        }
                    }
                });
                if(is_deactivate){
                    startupState['checked'] = false;
                }else{
                    startupState['checked'] = true;
                }
            });
        },

        setFilterMail(filter_type_id){
            axios({
                method: 'put',
                url: '/admin/setFilterMail',
                data: {
                    account_id: this.account.id,
                    filter_type_id: filter_type_id,
                }
            }).then(response => {
                this.getFilterMail();
            });
        },

        getFilterMail(){
            // axios.get('/admin/getFilterMail',{
            //     params: {
            //         account_id: this.account.id,
            //     }
            // }).then((response) => {
            //     filters_deactivate = response.data.results.filter_mails;
            //     this.syncFilterMail(filters_deactivate);
            // });
        },

        syncFilterMail(filters_deactivate){
            //console.log(filters_deactivate);
            this.filterTypes.forEach((filterType, index) => {
                var is_deactivate = false;
                filters_deactivate.forEach((filter_deac, i) => {
                    if(filterType.id==filter_deac.filter_type_id){
                        is_deactivate = true;
                    }
                });
                if(is_deactivate){
                    filterType['checked'] = false;
                }else{
                    filterType['checked'] = true;
                }
                //console.log(filterType.id);
                //console.log(this.account.account_type_id);

                if (filterType.id==2 && this.account.account_type_id==1) {

                    filterType.show = false;

                }else if (filterType.id==3 && this.account.account_type_id!=1) {

                    filterType.show = false;

                }
            });
        },

        setFilterNotf(filter_not_type_id){
            axios({
                method: 'put',
                url: '/admin/setFilterNotf',
                data: {
                    account_id: this.account.id,
                    filter_not_type_id: filter_not_type_id,
                }
            }).then(response => {
                this.getFilterNotf();
            });
        },

        getFilterNotf(){
            // axios.get('/admin/getFilterNotf',{
            //     params: {
            //         account_id: this.account.id,
            //     }
            // }).then((response) => {
            //     console.log(response.data.results.filter_mails);
            //     filters_deactivate = response.data.results.filter_notf;
            //     this.syncFilterNotf(filters_deactivate);
            // });
        },

        syncFilterNotf(filters_deactivate){
            //console.log(filters_deactivate);
            this.filterNotTypes.forEach((filterType, index) => {
                var is_deactivate = false;
                filters_deactivate.forEach((filter_deac, i) => {
                    if(filterType.id==filter_deac.filter_not_type_id){
                        is_deactivate = true;
                    }
                });
                if(is_deactivate){
                    filterType['checked'] = false;
                }else{
                    filterType['checked'] = true;
                }

                if (filterType.id==2 && this.account.account_type_id==1) {

                    filterType.show = false;

                }else if (filterType.id==3 && this.account.account_type_id!=1) {

                    filterType.show = false;

                }
            });
        },

    },
    mounted() {
        this.syncFilterMessage(this.filter_messages);
        this.syncFilterMail(this.filter_mails);
        this.syncFilterNotf(this.filter_notfs);
    }

});

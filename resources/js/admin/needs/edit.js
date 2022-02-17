import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
}; //in caso di problemi togliere

var create = new Vue({
    el: '#need-edit',
    data: {
        lang,
        account,
        startupStates,
        accountNeeds,
        account_types,
        startupservice_types,
        show_ss_types: false,
        startup_state: '',
        cofounders: '',
        search_role: '',
        roles_found: '',
    },

    methods: {
        updateNeed(){

            // console.log(this.account.id);
            // console.log(this.getAccountTypesId());
            // console.log(this.getStartupServiceTypesId());

            axios({
                method: 'post',
                url: '/admin/updateNeed',
                data: {
                    account_id: this.account.id,
                    startup_state: this.startup_state,
                    accountTypesId: this.getAccountTypesId(),
                    startupServiceTypesId: this.getStartupServiceTypesId(),
                }
            }).then(response => {
                window.location.href = '/admin/accounts/'+ this.account.id;
            });
        },

        getAccountTypesId(){
            var needs_id = [];
            this.account_types.forEach((account_type, i) => {
                if(account_type.checked==true && account_type.id!=7){
                    needs_id.push(account_type.id);
                }
            });
            return needs_id;
        },

        getStartupServiceTypesId(){
            var needs_id = [];
            this.startupservice_types.forEach((ss_type, i) => {
                if(ss_type.checked==true){
                    needs_id.push(ss_type.id);
                }
            });
            return needs_id;
        },

        active(account_type_id){
            var class_v = '';
            switch (this.startup_state) {
                case 1:
                    if(account_type_id==2 || account_type_id==3 ){
                        class_v = 'active';
                    }
                break;
                case 2:
                    if(account_type_id==3 || account_type_id==4 ){
                        class_v = 'active';
                    }
                break;
                case 3:
                    if(account_type_id==3){
                        class_v = 'active';
                    }
                break;
                case 4:
                    if(account_type_id==6){
                        class_v = 'active';
                    }
                break;
                case 5:
                    if(account_type_id==5 || account_type_id==6 ){
                        class_v = 'active';
                    }
                break;
                default:

            }

            return class_v;
        },

        active_ss(ss_type_id){
            var class_v = '';
            switch (this.startup_state) {
                case 1:
                    if(ss_type_id==4 || ss_type_id==5 || ss_type_id==6 || ss_type_id==7 || ss_type_id==2 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 2:
                    if(ss_type_id==7 || ss_type_id==2 || ss_type_id==5 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 3:
                    if(ss_type_id==7 || ss_type_id==2 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 4:
                    if(ss_type_id==2 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 5:
                    if(ss_type_id==2 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 6:
                    if(ss_type_id==2 || ss_type_id==10){
                        class_v = 'active';
                    }
                break;
                case 7:
                    if(ss_type_id==1){
                        class_v = 'active';
                    }
                break;
                default:

            }

            return class_v;
        },

        getCofounder(){
            axios.get('/api/getCofounder',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.cofounders = response.data.results.cofounders;
                //console.log(this.cofounders);
            });
        },

        searchRole(){
            //console.log(this.search_role);
            if(this.search_role){
                axios.get('/api/searchRole',{
                    params: {
                        role_name: this.search_role,
                    }
                }).then((response) => {
                    this.roles_found = response.data.results.roles;
                    if(!this.search_role){
                        this.roles_found = '';
                    }
                });

            }else{
                this.roles_found = '';
            }
        },

        createRole(){
            axios({
                method: 'post',
                url: '/admin/createRole',
                data: {
                    role_name: this.search_role,
                }
            }).then(response => {
                var role_id = response.data.results.role_id;
                this.addCofounder(role_id);
            });
        },

        addCofounder(role_id){
            // console.log(role_id);
            // console.log(this.account.id);

            this.search_role = '';
            this.roles_found = '';
            axios({
                method: 'post',
                url: '/admin/addCofounder',
                data: {
                    role_id: role_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getCofounder();
            });
        },

        deleteCofounder(cofounder_id){
            //console.log(cofounder_id);
            axios({
                method: 'delete',
                url: '/admin/deleteCofounder',
                data: {
                    cofounder_id: cofounder_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getCofounder();
            });
        }


    },
    mounted() {
        this.startup_state = this.account.startup_status_id;
        this.getCofounder();
        //console.log(this.startup_state);
        console.log(this.lang);
    }

});

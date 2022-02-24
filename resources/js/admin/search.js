import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#search',
    data: {
        lang,
        search_type: false,
        accountTypes: [],
        account_selected: '',
        startupStates: [],
        startupState_selected: '',
        all_needs: [],
        serviceTypes: [],
        need_selected: '',
        region_selected: '',
        search_tag: '',
        tags_found: '',
        tags: [],
        account_name: '',
        accounts: [],
        accounts_show: [],
        page: 1,
        search_role: '',
        roles_found: '',
        startupserviceType: [],
        startupserviceType_selected: '',
        last_accounts: [],
        last_accounts_show: [],
        page_last_accounts: 1,
        is_in_search: false,
        first_search: false,
        new_subs_over: false,
        search_page: 0,
    },
    methods: {

        search_type_f(){
            this.accounts = [];
            if(!this.search_type){
                this.account_name = '';
            }else{
                this.account_selected = '';
                this.startupState_selected = '';
                this.need_selected = '';
                this.region_selected = '';
                this.tags = [];
                this.startupserviceType_selected = '';
                this.search_role = '';
            }
        },

        getAccountTypes(){
            axios.get('/api/getAccountTypes',{
            }).then((response) => {
                this.accountTypes = response.data.results.accountTypes;
            });
        },

        getStartupStatus(){
            axios.get('/api/getStartupStates',{
            }).then((response) => {
                this.startupStates = response.data.results.startupStates;
            });
        },

        getAllNeeds(){
            axios.get('/api/getNeeds',{
            }).then((response) => {
                this.all_needs = response.data.results.needs;
                this.getNeeds();
            });
        },

        getNeeds(){
            this.need_selected = '';
            this.serviceTypes = [];
            if(!this.startupState_selected){
                this.all_needs.forEach((all_need, i) => {
                    var already_exist = false;
                    this.serviceTypes.forEach((need, i) => {
                        if(all_need.name==need.name){
                            already_exist = true;
                        }
                    });
                    if(already_exist==false){
                        this.serviceTypes.push(all_need);
                    }
                });
            }else{
                this.all_needs.forEach((all_need, i) => {
                    if(this.startupState_selected==all_need.startup_state_id){
                        this.serviceTypes.push(all_need);
                    }
                });
            }
        },

        getRegions(){
            axios.get('/api/getRegions',{
            }).then((response) => {
                this.regions = response.data.results.regions;
            });
        },

        searchTag(){
            if(this.search_tag){
                axios.get('/api/searchTag',{
                    params: {
                        tag_name: this.search_tag,
                    }
                }).then((response) => {
                    this.tags_found = response.data.results.tags;
                    if(!this.search_tag){
                        this.tags_found = '';
                    }
                });

            }else{
                this.tags_found = '';
            }
        },

        addTag(tag){
            //console.log(tag);
            //console.log(this.tags);
            var already_exist=false;
            this.tags.forEach((old_tag, i) => {
                if(old_tag.name==tag.name){
                    already_exist=true;
                }
            });

            if(!already_exist){
                this.tags.push(tag);
            }

            this.tags_found = '';
            this.search_tag = '';

        },

        deleteTag(index){
            this.tags.splice(index,index+1);
        },

        setNeeds(accountType,serviceType){
            return {
                accountType: accountType,
                serviceType: serviceType,
            };
        },

        show(){
            //console.log(this.need_selected);
        },

        search(){
            this.first_search = true;
            this.is_in_search = true;
            // console.log('COSA CERCARE');
            // console.log('account_selected: '+this.account_selected);
            // console.log('startupState_selected: '+this.startupState_selected);
            // console.log('need_selected: '+this.need_selected);
            // console.log('region_selected: '+this.region_selected);
            // console.log('tags: '+this.tags);
            // console.log('account_name: '+ this.account_name);
            // console.log('startupserviceType_selected: '+this.startupserviceType_selected);
            // console.log('ruolo: '+this.search_role);

            var tags_id = [];
            this.tags.forEach((tag, i) => {
                tags_id.push(tag.id)
            });

            if(!this.search_type || this.search_type && this.account_name){
                axios.get('/admin/advancedSearch',{
                    params: {
                        accountType_id_selected: this.account_selected,
                        startupState_id_selected: this.startupState_selected,
                        need_id_selected: this.need_selected,
                        region_id_selected: this.region_selected,
                        tags: tags_id,
                        account_name: this.account_name,
                        role: this.search_role,
                        startupserviceType_selected: this.startupserviceType_selected,
                        search_page: 0,
                    }
                }).then((response) => {
                    this.accounts = response.data.results.accounts;
                    this.is_in_search = false;
                    this.changePage(0);
                    this.search_page = 0;
                });
            }else{
                this.is_in_search = false;
            }

        },

        changePage(val){

            var accounts_qty = this.accounts.length;
            var items_qty = 6;

            if(val==-1 && this.page>1){

                this.page--;

            }else if(val==1 && this.page<Math.ceil(accounts_qty/items_qty)){

                this.page++;
                //this.loadPage();


            }else if(val==0){

                this.page = 1;

            }

            this.accounts_show = this.accounts.slice(items_qty*this.page-items_qty,items_qty*this.page);
        },

        loadPage(){
            if(this.page>this.search_page){
                var tags_id = [];
                this.tags.forEach((tag, i) => {
                    tags_id.push(tag.id)
                });
                this.search_page++;
                axios.get('/admin/advancedSearch',{
                    params: {
                        accountType_id_selected: this.account_selected,
                        startupState_id_selected: this.startupState_selected,
                        need_id_selected: this.need_selected,
                        region_id_selected: this.region_selected,
                        tags: tags_id,
                        account_name: this.account_name,
                        role: this.search_role,
                        startupserviceType_selected: this.startupserviceType_selected,
                        search_page: this.search_page,
                    }
                }).then((response) => {
                    this.accounts.push(...response.data.results.accounts);
                });
            }
        },

        arrowClass(direction){

            if(direction=='left'){
                if(this.page>1){
                    return 'activate';
                }
            }else if (direction=='right') {
                if(this.page<Math.ceil(this.accounts.length/6)){
                    return 'activate';
                }
            }

        },

        searchRole(){
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

        setRole(roleName){
            this.search_role = roleName;
            this.roles_found = '';
        },

        getStartupserviceType(){
            axios.get('/api/getStartupserviceType',{
            }).then((response) => {
                this.startupserviceType = response.data.results.startupserviceType;
            });
        },

        getLastAccounts(){
            axios.get('/api/getLastAccounts',{
            }).then((response) => {
                this.last_accounts = response.data.results.last_accounts;
                this.last_accounts_show = this.last_accounts.slice(0,7);
                //console.log(this.last_accounts);
            });
        },

        getCookie(name){
          const value = `; ${document.cookie}`;
          const parts = value.split(`; ${name}=`);
          if (parts.length === 2) return parts.pop().split(';').shift();
        },

        dateUTC(){
            var d = new Date();
            d.setMonth(d.getMonth() + 6);
            return d.toUTCString();
        },

    },
    mounted() {

        this.getAccountTypes();
        this.getStartupStatus();
        this.getStartupserviceType();
        this.getAllNeeds();
        this.getRegions();
        this.getLastAccounts();

        if(this.needs){
            this.needs = JSON.parse(this.needs.replace(/&quot;/g,'"'));
        };

        if(!this.getCookie("tecCookie")){
            document.cookie = "tecCookie"+ "=" +"accept"+ ";" + "expires="+ this.dateUTC() +";path=/";
        }
        if(!this.getCookie("analyticsCookie")){
            document.cookie =
            "analyticsCookie"+ "=" +"reject"+ ";" + "expires="+ this.dateUTC() +";path=/";
        }

        //FADE ANIMATION
        let elementsArray = document.querySelectorAll(".fade-anim");
        window.addEventListener('scroll', fadeIn );
        function fadeIn() {
            for (var i = 0; i < elementsArray.length; i++) {
                var elem = elementsArray[i]
                var distInView = elem.getBoundingClientRect().top - window.innerHeight + 20;
                if (distInView < 0) {
                    elem.classList.add("inView");
                } else {
                    elem.classList.remove("inView");
                }
            }
        }
        fadeIn();

    }

});

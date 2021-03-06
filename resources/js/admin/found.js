import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#found',
    data: {
        lang,
        pages_id,
        users_id,
        my_user_id,
        my_pages_id,
        accounts: '',
        accounts_show: [],
        page: 1,
        show_prev: false,
        show_next: false,
        list_user: '',
        list_pages: '',
        alert: false,
        account_index_selected: '',
        in_load: false,
        showScrollTop: false,
        //ricerca
        search_type: false,
        category_selected: '',
        usertypes_id: [],
        pagetypes_id: [],
        investors_selected: false,
        services_selected: false,
        regions: '',
        name: '',
        skillsToggle: false,
        skills: [],
        skill_name: '',
        skills_found: '',
        investor_selected: '',
        services: [],
        service_name: '',
        services_found: '',
        need_selected: '',
        serviceToggle: false, //false=cerco true=offro
        serviceOrAndToggle: false, //false=uno true=tutti
        country_id_selected: 1,
        region_id_selected: '',
        sector_selected: '',
        lifecycle_id_selected: '',
        sectors: [],
        sector_selected: '',
        sectorToggle: false,
        button: false,
        //fine ricerca
    },
    methods: {
        scrollTop(){
            window.scrollTo({top: 0, behavior: 'smooth'});
        },
        switchAccounts(i){
            this.account_index_selected = i;
            //console.log(i);
            this.alert = true;
            axios.get('/admin/getMyAccounts',{
            }).then((response) => {
                this.list_user = response.data.results.user;
                this.list_pages = response.data.results.pages;
            });
        },

        startChat(page_id){
            // console.log(page_id);
            var account_selected = this.accounts_show[this.account_index_selected];
            // console.log(this.accounts_show[this.account_index_selected]);
            var user_or_page = account_selected.user_or_page?'user':'page';
            axios({
                method: 'post',
                url: '/admin/createChat',
                data: {
                    recipient_id: account_selected.id,
                    recipient_user_or_page: user_or_page,
                    page_selected_id: page_id,
                }
            }).then(response => {
                var route = response.data.results.route;
                window.location.href = route;
                // window.open(
                //   route,
                //   '_blank'
                // );
                // this.alert = false;
            });
        },

        search_type_f(){
            if(!this.search_type){
                this.name = '';
            }else{
                this.category_selected = '';
                this.change_category();
            }
        },

        change_category(){
            this.need_selected = '';
            this.serviceToggle = false;

            switch (this.category_selected) {
            case '1':
              //startup
              this.usertypes_id = [];
              this.pagetypes_id = [1];
              this.investors_selected = false;
              this.services_selected = false;
            break;
            case '2':
              //aspirante-cofounder
              this.usertypes_id = [1];
              this.pagetypes_id = [];
              this.investors_selected = false;
              this.services_selected = false;
            break;
            case '3':
              //incubatore-acc
              this.usertypes_id = [];
              this.pagetypes_id = [3];
              this.investors_selected = false;
              this.services_selected = false;
            break;
            case '4':
              //investitori
              this.usertypes_id = [2];
              this.pagetypes_id = [5,8];
              this.investors_selected = true;
              this.services_selected = false;
            break;
            case '5':
              //enti e associazioni
              this.usertypes_id = [];
              this.pagetypes_id = [7];
              this.investors_selected = false;
              this.services_selected = false;
            break;
            case '6':
              //servizi
              this.usertypes_id = [];
              this.pagetypes_id = [];
              this.investors_selected = false;
              this.services_selected = true;
            break;
            default:
              this.usertypes_id = [];
              this.pagetypes_id = [];
              this.investors_selected = false;
              this.services_selected = false;
            }
        },

        getRegionsByCountry(){
            if(this.country_id_selected){

                this.regions = '';

                axios.get('/api/regionsByCountry',{
                    params: {
                        country_id: this.country_id_selected,
                    }
                }).then((response) => {
                    this.regions = response.data.results.regions;
                });
            }else{
                this.regions = '';
            }
        },

        searchSkill(){
            if(this.skill_name.length>2){
              axios.get('/api/searchSkill',{
                  params: {
                      skill_name: this.skill_name,
                  }
              }).then((response) => {
                  this.skills_found = response.data.results.skills;
                  if(!this.skill_name){
                      this.skills_found = '';
                  }
              });
            }else{
              this.skills_found = '';
            }
        },

        addSkill(skill_found){

            var exist = false;
            this.skills.forEach((skill, i) => {
                if(skill.pivot.skill_id==skill_found.id){
                  exist = true;
                }
            });

            if(!exist){

              let new_skill = {
                "name":skill_found.name,
                "pivot":{
                  "skill_id": skill_found.id,
                },
              };

              this.skills.push(new_skill);
            }

            this.skills_found = '';
            this.skill_name = '';
        },

        removeSkill(i){
            this.skills.splice(i, 1);
        },

        investorType(){
            switch (this.investor_selected) {
              case '1':
                //business angel
                this.usertypes_id = [2];
                this.pagetypes_id = [];
                this.investors_selected = true;
                this.services_selected = false;
              break;
              case '2':
                //venture capital
                this.usertypes_id = [];
                this.pagetypes_id = [5];
                this.investors_selected = true;
                this.services_selected = false;
              break;
              case '3':
                //private equity
                this.usertypes_id = [];
                this.pagetypes_id = [8];
                this.investors_selected = true;
                this.services_selected = false;
              break;
              default:
                this.usertypes_id = [];
                this.pagetypes_id = [];
                this.investors_selected = true;
                this.services_selected = false;

              }
        },

        searchService(){
            if(this.service_name){
              axios.get('/api/searchService',{
                  params: {
                      service_name: this.service_name,
                  }
              }).then((response) => {
                  this.services_found = response.data.results.services;

                  //console.log(this.services_found);
                  if(!this.service_name){
                      this.services_found = '';
                  }
              });
            }else{
              this.services_found = '';
            }
        },

        addService(service_found){

            var exist = false;
            this.services.forEach((service, i) => {
                if(service.pivot.service_id==service_found.id){
                  exist = true;
                }
            });

            if(!exist){

              let new_service = {
                "name":service_found.name,
                "pivot":{
                  "service_id": service_found.id,
                },
              };

              this.services.push(new_service);
            }

            this.services_found = '';
            this.service_name = '';
        },

        removeService(i){
            this.services.splice(i, 1);
        },

        addSector(){
            if(this.sector_selected){
              var exist = false;
              this.sectors.forEach((sector, i) => {
                  if(sector.id==this.sector_selected.id){
                    exist = true;
                  }
              });

              if(!exist){

                let new_sector = {
                  "name_it": this.sector_selected.name_it,
                  "id": this.sector_selected.id,
                };

                this.sectors.push(new_sector);
              }

              this.sector_selected = '';
            }
        },

        removeSector(i){
            this.sectors.splice(i, 1);
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

        mergePagesUsers(){

            var accounts = this.pages_id.concat(this.users_id);
            //ordinamento per id
            for (var i=0; i < accounts.length; i++) {
                for (var j=0; j < accounts.length-1; j++) {
                    if (accounts[j].created_at>accounts[i].created_at) {
                        var tmp=accounts[j];
                        accounts[j]=accounts[i];
                        accounts[i]=tmp;
                    }
                }
            }
            this.accounts = accounts;
            this.showMore();
        },

        showMore(){
            var accounts_qty = this.accounts.length;
            var items_qty = 6;
            if(this.page<=Math.ceil(accounts_qty/items_qty)){
                var new_accounts_show = this.accounts.slice(items_qty*this.page-items_qty,items_qty*this.page);
                this.loadInfo(new_accounts_show);
                this.page++;
            }
        },

        // showAccounts(prev_next){
        //     var accounts_qty = this.accounts.length;
        //     var items_qty = 6;
        //
        //     if(prev_next==-1 && this.page>1){
        //         this.page--;
        //     }else if(prev_next==1  && this.page<Math.ceil(accounts_qty/items_qty)){
        //         this.page++;
        //     }
        //
        //     this.accounts_show =
        //     this.accounts.slice(items_qty*this.page-items_qty,items_qty*this.page);
        //
        //     this.checkPrevNextButton(accounts_qty,items_qty);
        //     this.moreInfo(this.accounts_show);
        // },

        // checkPrevNextButton(accounts_qty,items_qty){
        //
        //     this.page>1 ? this.show_prev = true : this.show_prev = false;
        //     this.page<Math.ceil(accounts_qty/items_qty) ? this.show_next = true : this.show_next = false;
        //
        // },

        loadInfo(new_accounts){
            if(new_accounts){
                this.in_load=true;
                axios.get('/admin/loadInfo',{
                    params: {
                        accounts: new_accounts,
                    }
                }).then((response) => {
                    this.accounts_show.push(...response.data.results.accounts);
                    // console.log(this.accounts_show);
                    this.in_load=false;
                });
            }
        },
        scrollFunction(){
          // console.log(window.innerHeight,window.scrollY,document.body.offsetHeight);
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                this.showMore();
            }
            if(window.scrollY>0){
                this.showScrollTop = true;
            }else{
                this.showScrollTop = false;
            }
        },

    },
    created(){

        // if(this.pages_id){
        //     this.pages_id = JSON.parse(this.pages_id.replace(/&quot;/g,'"'));
        // }
        // if(this.users_id){
        //     this.users_id = JSON.parse(this.users_id.replace(/&quot;/g,'"'));
        // }
        this.mergePagesUsers();

    },
    mounted() {

        this.getRegionsByCountry();
        window.onscroll = ()=>{this.scrollFunction()};

    }

});

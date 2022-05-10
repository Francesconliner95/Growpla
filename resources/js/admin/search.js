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
        main_services: [],
        sub_services: [],
        sub_services_show: [],
        main_service_selected: '',
        sub_service_selected: '',
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
        background_selected: '',
        myLatestViews: [],
        mostViewedAccounts: [],
        needs: [],
        offers: [],
        collaborations: [],
        interval:false,
        is_mobile: false,
        button: false,
    },
    methods: {
        search_type_f(){
            if(!this.search_type){
                this.name = '';
            }else{
                this.category_selected = '';
                this.change_category();
            }
        },

        buttonsToggle(index){
            if(this.button && this.button==index || !index){
                this.button = false;
            }else{
                this.button = index;
            }
            //console.log(this.button);
        },

        change_category(){
            this.need_selected = '';
            this.serviceToggle = false;
            this.buttonsToggle();

            switch (this.category_selected) {
            case '1':
              //startup
              this.usertypes_id = [];
              this.pagetypes_id = [1];
              this.investors_selected = false;
              this.services_selected = false;
              this.serviceToggle = 'true';//utile solo per il cambio colore
            break;
            case '2':
              //aspirante-cofounder
              this.usertypes_id = [1];
              this.pagetypes_id = [];
              this.investors_selected = false;
              this.services_selected = true;
              this.serviceToggle = 'false';//utile solo per il cambio colore
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

        submitForm(){
            document.getElementById('searchForm').submit();
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

        getAllServices(){
            axios.get('/api/getAllServices',{
            }).then((response) => {
                this.main_services = response.data.results.main_services;
                this.sub_services = response.data.results.sub_services;
                // this.main_service_selected = this.main_services[0].id;
                this.changeMainService();
            });
        },

        changeMainService(){
            this.sub_services_show = [];
            this.sub_services.forEach((sub_service, i) => {
                if(sub_service.main_service_id==this.main_service_selected){
                    this.sub_services_show.push(sub_service);
                }
            });
            this.sub_service_selected = "";
            // this.sub_service_selected = this.sub_services_show[0].id;
        },

        addServiceSelected(service_id){
            this.sub_services_show.forEach((sub_service, i) => {
                if(sub_service.id==service_id){
                    this.addService(sub_service);
                }
            });
        },

        searchService(){
            if(this.service_name){
              axios.get('/api/searchService',{
                  params: {
                      service_name: this.service_name,
                  }
              }).then((response) => {
                  this.services_found = response.data.results.services;
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
            //console.log('rimuovi'+i);
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

        getLastHave(){
            axios.get('/admin/needs',{
                params: {
                    api_or_route: true,
                }
            }).then((response) => {
                var needs = response.data.results.needs;
                //ordinamento per id
                for (var i=0; i < needs.length; i++) {
                    for (var j=0; j < needs.length-1; j++) {
                        if (needs[j].id<needs[i].id) {
                          var tmp=needs[j];
                          needs[j]=needs[i];
                          needs[i]=tmp;
                        }
                    }
                }

                needs = needs.slice(0,8);
                if(needs){
                    axios.get('/admin/loadNeedInfo',{
                        params: {
                            needs: needs,
                        }
                    }).then((response) => {
                        this.needs.push(...response.data.results.needs);
                    });
                }
            });
        },

        getLastOffer(){
            axios.get('/admin/offers',{
                params: {
                    api_or_route: true,
                }
            }).then((response) => {
                var offers = response.data.results.offers;
                //ordinamento per id
                for (var i=0; i < offers.length; i++) {
                    for (var j=0; j < offers.length-1; j++) {
                        if (offers[j].id<offers[i].id) {
                          var tmp=offers[j];
                          offers[j]=offers[i];
                          offers[i]=tmp;
                        }
                    }
                }
                offers = offers.slice(0,8);
                if(offers){
                    axios.get('/admin/loadNeedInfo',{
                        params: {
                            needs: offers,
                        }
                    }).then((response) => {
                        this.offers.push(...response.data.results.needs);
                    });
                }
            });
        },

        myLatestViews_f(){
            axios.get('/admin/myLatestViews',{
            }).then((response) => {
              this.myLatestViews = response.data.results.accounts;
            });
        },

        mostViewedAccounts_f(){
            axios.get('/admin/mostViewedAccounts',{
            }).then((response) => {
                var accounts = response.data.results.accounts;

                for (var i=0; i < accounts.length; i++) {
                   for (var j=0; j < accounts.length-1; j++) {
                        if (accounts[j].views<accounts[i].views) {
                            var tmp=accounts[j];
                            accounts[j]=accounts[i];
                            accounts[i]=tmp;
                        }
                   }
                }
                this.mostViewedAccounts = accounts.slice(0,4);
            });
        },

        latestCollaborations(){
            axios.get('/admin/latestCollaborations',{
            }).then((response) => {
                this.collaborations = response.data.results.collaborations;
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

        delay(slider_id){
            setTimeout(()=>{
                this.arrowVisibility(slider_id);
            }, 1000);
        },

        stop(slider_id,direction){
        	clearInterval(this.interval);
            this.interval = false;
        },

        checkMobile(){
            if(window.innerWidth>=992){
                if(this.is_mobile){
                    this.is_mobile = false;
                }
            }else{
                if(!this.is_mobile){
                    this.is_mobile = true;
                }
            }
        }

    },
    mounted() {


        // setInterval(()=>{console.log(this.search_type);}, 1000);
        //console.log(document.getElementById('search-type-checkbox').checked);
        // if(performance.navigation.type==2){
        //    this.search_type = !this.search_type;
        // }

        this.getLastHave();
        this.getLastOffer();
        this.getRegionsByCountry();
        this.myLatestViews_f();
        this.mostViewedAccounts_f();
        this.getAllServices();
        this.latestCollaborations();

        //se clicco fuori dal div 'search-main'
        window.addEventListener('click', (e)=>{
            if (!document.getElementById('search-main').contains(e.target)){
                this.button = false;
            }
        })

        //check if is mobile
        this.checkMobile();
        window.addEventListener('resize', (event)=> {
            this.checkMobile();
        }, true);

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

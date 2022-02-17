import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#account-edit',
    data: {
        lang,
        account,
        company,
        account_type_id,
        accountNeeds,
        startupStates,
        startup_states: '',
        search_role: account.role,
        roles_found: '',
        service_selected: '',
        services: '',
        incorporated_switch: account.incorporated ?1:0,
        incorporated: account.incorporated,
        private_association: account.private_association,
        nation_region: account.nation_region,
        search_company: company.company_name,
        companies_found: '',
        investor: account.investor,
        p_services: account.services,
        cofounder: account.cofounder,
        subcategory: account.subcategory?account.subcategory:1,
        // PRIVATO freelance=1 employee=2
        // AZIENDA company=1 startup=2
    },
    methods: {

        remove_file(value){
            axios({
                method: 'put',
                url: '/admin/removeFile',
                data: {
                    account_id: this.account.id,
                    file_type: value,
                }
            }).then(response => {

            });

            switch (value) {
                case 'img':
                    this.account.image = 'accounts_images/default_account_image.png';
                break;
                case 'cover_img':
                    this.account.cover_image = 'accounts_cover_images/default_account_cover_image.jpg';
                break;
                case 'pitch':
                    this.account.pitch = '';
                break;
                case 'roadmap':
                    this.account.roadmap = '';
                break;
                case 'cv':
                    this.account.curriculum_vitae = '';
                break;
                default:
            }
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

        addRole(role_found_id){
            this.roles_found.forEach((role, i) => {
                if(role.id==role_found_id){
                    this.search_role = role.name;
                    this.roles_found = '';
                }
            });
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

        searchCompany(){

            if(this.search_company){
                axios.get('/api/searchCompany',{
                    params: {
                        company_name: this.search_company,
                    }
                }).then((response) => {
                    this.companies_found = response.data.results.companies;
                    //console.log(this.companies_found);
                    if(!this.search_company){
                        this.companies_found = '';
                    }
                });

            }else{
                this.companies_found = '';
            }
        },

        addCompany(company_found_id){
            this.companies_found.forEach((company, i) => {
                if(company.id==company_found_id){
                    this.search_company = company.company_name;
                    this.companies_found = '';
                }
            });
        },

        addService(){
            //console.log(this.service_selected);
            if(this.service_selected){
                axios({
                    method: 'post',
                    url: '/admin/addService',
                    data: {
                        service_id: this.service_selected,
                        account_id: this.account.id,
                    }
                }).then(response => {
                    this.getServices();
                    this.service_selected = '';
                });
            }
        },

        deleteService(service_id){
            axios({
                method: 'delete',
                url: '/admin/deleteService',
                data: {
                    service_id: service_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getServices();
            });

        },

        getServices(){
            axios.get('/api/getAccountServices',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.services = response.data.results.services;
                //console.log(this.services);
            });
        },

        getTodayDate(){
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
               dd = '0' + dd;
            }

            if (mm < 10) {
               mm = '0' + mm;
            }

            return yyyy + '-' + mm + '-' + dd;
        },

    },
    mounted() {
        this.getServices();

        if(this.company){
            this.company = JSON.parse(this.company.replace(/&quot;/g,'"'));
            this.search_company = this.company.company_name;
        };

        //DRAG & DROP
        document.querySelectorAll(".drop-zone__input").forEach(inputElement =>{

            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", e =>{
                inputElement.click();
            });

            dropZoneElement.addEventListener("change", e =>{
                if(inputElement.files.length){
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener("dragover", e =>{
                e.preventDefault();
                dropZoneElement.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach(type => {
                dropZoneElement.addEventListener(type, e =>{
                    dropZoneElement.classList.remove('drop-zone--over');
                });
            });

            dropZoneElement.addEventListener("drop", e =>{
                e.preventDefault();

                if(e.dataTransfer.files.length){
                    inputElement.files = e.dataTransfer.files;
                    //console.log(inputElement.files);
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");

            });

        });

        function updateThumbnail(dropZoneElement, file){
            //console.log(dropZoneElement);
            //console.log(file);
            let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

            if(dropZoneElement.querySelector(".drop-zone__prompt")){
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }

            //add file in drop-area
            if(!thumbnailElement){
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
                var imgTag = document.createElement("img");
                thumbnailElement.appendChild(imgTag);
            }else{
                dropZoneElement.removeChild(thumbnailElement);
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
                var imgTag = document.createElement("img");
                thumbnailElement.appendChild(imgTag);
            }

            //show file name
            thumbnailElement.dataset.label = file.name;

            //show image
            if(file.type.startsWith("image/")){
                var reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload=()=>{

                    imgTag.src = reader.result;

                };

            }else{
                imgTag.src = null;
            }

        }
        //END DRAG & DROP

    }

});

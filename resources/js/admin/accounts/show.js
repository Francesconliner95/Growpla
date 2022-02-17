import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#account-show',
    data: {
        lang,
        is_my_account,
        account,
        account_type_id,
        my_accounts_id,
        team_members,
        team_num,
        multipleSections,
        my_account_selected,
        startup_states,
        needs:[],
        tags: '',
        services: '',
        already_follow: false,
        cooperation_name: '',
        cooperations_found: '',
        show_all_team: false,
        cooperations: [],
        search_tag: '',
        tags_found: [],
        tag_message: '',
        openMultipleSection: false,
        section_name: '',
        //multipleSections: [],
        alert: '',
        myTimer: '',
        delete_alert: false,
        delete_alert_message: '',
        delete_type: '',
        delete_item_id: '',
    },
    methods: {

        deleteController(deleteType,id){
            switch (deleteType) {
                case 1:
                    //TEAM
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_alert_message= 'Are you sure you want to delete the following team member?';
                        break;
                        case 2:
                            this.delete_alert_message= 'Sei sicuro di voler eliminare il seguente membro del team?';
                        break;
                        default:
                    }
                break;
                case 2:
                    //MAIN SECTION
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_alert_message= 'Are you sure you want to delete the following section with all its subsections?';
                        break;
                        case 2:
                            this.delete_alert_message= 'Sei sicuro di voler eliminare la seguente sezione con tutte le relative sottosezioni?';
                        break;
                        default:
                    }
                break;
                case 3:
                    //SECTION
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_alert_message= 'Are you sure you want to delete the following subsection?';
                        break;
                        case 2:
                            this.delete_alert_message= 'Sei sicuro di voler eliminare la seguente sottosezione?';
                        break;
                        default:
                    }
                break;
                case 4:
                    //COOPERATION
                    switch (parseInt(this.lang)) {
                        case 1:
                            this.delete_alert_message= 'Are you sure you want to delete the following collaboration?';
                        break;
                        case 2:
                            this.delete_alert_message= 'Sei sicuro di voler eliminare la seguente collaborazione?';
                        break;
                        default:
                    }
                break;
                default:
            }
            this.delete_type= deleteType;
            this.delete_item_id = id;
            this.delete_alert = true;
        },

        confirmDelete(){
            switch (this.delete_type) {
                case 1:
                    //TEAM
                    this.delete_member(this.delete_item_id);
                break;
                case 2:
                    //MAIN SECTION
                    this.delete_multiple_other(this.delete_item_id);
                break;
                case 3:
                    //SECTION
                    this.delete_other(this.delete_item_id.other_id,this.delete_item_id.section_id);
                break;
                case 4:
                    //COOPERATION
                    this.deleteCooperation(this.delete_item_id);
                break;
                default:
            }
            this.rejectDelete();
        },

        rejectDelete(){
            this.delete_alert_message= '';
            this.delete_alert=false;
            this.delete_type='';
            this.delete_item_id='';
        },

        setFollow(){
            axios({
                method: 'post',
                url: '/admin/addFollow',
                data: {
                    follow_id: this.account.id,
                }
            }).then(response => {
                this.getFollow();
            });

        },

        getFollow(){
            axios.get('/admin/getFollow',{
                params: {
                    follow_id: this.account.id,
                }
            }).then((response) => {
                this.already_follow = response.data.results.already_follow;
            });
        },

        open(filename){
            var newWindow = window.open();
            newWindow.document.write('<iframe src="/storage/'+ filename +'" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">');
        },

        getServices(){
            axios.get('/api/getAccountServices',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.services = response.data.results.services;
                // console.log(this.services);
            });
        },

        teamToggle(){
            this.show_all_team = !this.show_all_team;
            if(this.show_all_team){
                this.getTeamMembers();
            }else{
                this.team_members = this.team_members.slice(0, 3);
            }
        },

        getTeamMembers(){
            axios.get('/api/getTeamMembers',{
                params: {
                    account_id: this.account.id,
                    // get_all: this.show_all_team?'yes':'no',
                }
            }).then((response) => {
                this.team_members = response.data.results.team_members;
            });
        },

        changeTeamPosition(member_id,value){
            axios({
                method: 'put',
                url: '/admin/changeTeamPosition',
                data: {
                    member_id: member_id,
                    up_down: value,
                }
            }).then(response => {
                this.getTeamMembers();
            });
        },

        delete_member(member_id){
            axios({
                method: 'delete',
                url: '/admin/deleteMember',
                data: {
                    member_id: member_id,
                }
            }).then(response => {
                this.team_num = response.data.results.team_num;
                this.getTeamMembers();
            });
        },

        getCooperation(){
            axios.get('/api/getCooperation',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.cooperations = response.data.results.cooperations;
            });
        },

        getAccountNeeds(){
            axios.get('/api/getAccountNeeds',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.needs = response.data.results.needs;
                //console.log('needs');
                //console.log(this.needs);
            });
        },

        searchCooperation(){

            if(this.cooperation_name){

                axios.get('/api/getAccount',{
                    params: {
                        account_id: this.account.id,
                        account_name: this.cooperation_name,
                    }
                }).then((response) => {
                    this.cooperations_found = response.data.results.accounts;
                    if(!this.cooperation_name){
                        this.cooperations_found = '';
                    }
                });

            }else{
                this.cooperations_found = '';
            }
        },

        addCooperation(cooperation_id){
            //console.log(startup_id);
            this.cooperation_name = '';
            this.cooperations_found = '';
            axios({
                method: 'post',
                url: '/admin/addCooperation',
                data: {
                    cooperation_id: cooperation_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getCooperation();
            });
        },

        deleteCooperation(cooperation_id){
            axios({
                method: 'delete',
                url: '/admin/deleteCooperation',
                data: {
                    cooperation_id: cooperation_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getCooperation();
            });
        },

        is_my_startup(supportedStartup_id){
            var is_my_startup = false;
            this.my_accounts_id.forEach((account, i) => {
                if(supportedStartup_id==account.id){
                    is_my_startup = true;
                }
            });
            //console.log(is_my_startup);
            return is_my_startup;

        },

        confirmCooperation(cooperation_id){
            axios({
                method: 'put',
                url: '/admin/confirmCooperation',
                data: {
                    recipient_id: cooperation_id,
                    sender_id: this.account.id,
                }
            }).then(response => {
                this.getCooperation();
                //console.log(response.data.results);
            });
        },

        getTag(){
            axios.get('/api/getTag',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.tags = response.data.results.tags;
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
                        this.tags_found = [];
                    }
                });

            }else{
                this.tags_found = [];
            }
        },

        addTag(tag_id){
            this.search_tag = '';
            this.tags_found = [];
            if(this.tags.length<5){
                axios({
                    method: 'post',
                    url: '/admin/addTag',
                    data: {
                        tag_id: tag_id,
                        account_id: this.account.id,
                    }
                }).then(response => {
                    this.getTag();
                });
            }else{

                this.tag_message = 'Puoi aggiungere massimo 5 keyword';
                setTimeout(()=> {
                    this.tag_message = '';
                }, 3000);

            }
        },

        deleteTag(tag_id){
            axios({
                method: 'delete',
                url: '/admin/deleteTag',
                data: {
                    tag_id: tag_id,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getTag();
            });
        },

        createTag(){
            axios({
                method: 'post',
                url: '/admin/createTag',
                data: {
                    tag_name: this.search_tag,
                }
            }).then(response => {
                var tag_id = response.data.results.tag_id;
                this.addTag(tag_id);
                this.search_tag = '';
            });
        },

        alreadyTagExist(){
            let already_exist = false;
            this.tags_found.forEach((tag_found, i) => {
                if(tag_found.name.toLowerCase()
                ==this.search_tag.toLowerCase()){
                    already_exist = true;
                }
            });
            return already_exist;

        },

        addMultipleSection(){
            axios({
                method: 'post',
                url: '/admin/addMultipleSection',
                data: {
                    section_name: this.section_name,
                    account_id: this.account.id,
                }
            }).then(response => {
                this.getMultipleSections();
                this.section_name = '';
                this.openMultipleSection = false;
            });
        },

        getMultipleSections(){
            axios.get('/api/getMultipleSections',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                var multipleSections = response.data.results.multipleSections;
                multipleSections.forEach((section, i) => {
                    section.edit = false;
                });
                this.multipleSections = multipleSections;
                //console.log(this.multipleSections);
            });
        },

        changeMultipleOtherPosition(section_id,value){

            axios({
                method: 'put',
                url: '/admin/changeMultipleOtherPosition',
                data: {
                    section_id: section_id,
                    up_down: value,
                }
            }).then(response => {
                this.getMultipleSections();
            });

        },

        otherToggle(section_id,section_action){
            //console.log(section_action);

            if(section_action=='open'){
                this.getSectionOthers(section_id);
            }else{
                this.multipleSections.forEach((section, i) => {
                    if(section.id==section_id){
                        section.others = section.others.slice(0,1);
                        ///console.log('sliciato');
                    }
                });
            }

        },

        getSectionOthers(section_id){
            axios.get('/api/getSectionOthers',{
                params: {
                    section_id: section_id,
                }
            }).then((response) => {
                var others = response.data.results.others;
                this.multipleSections.forEach((section, i) => {
                    section.edit = false;
                    if(section.id==section_id){
                        section.others = others;
                    }
                });
            });
        },

        changename(s_index,section_name){

            this.multipleSections.forEach((section, i) => {
                section.edit = false;
            });

            this.multipleSections[s_index].edit=!this.multipleSections[s_index].edit;
            if(this.multipleSections[s_index].edit){
                this.section_name = section_name;
            }else {
                this.section_name = '';
            }

        },

        updateMultipleSections(multiple_other_id){

            axios({
                method: 'put',
                url: '/admin/updateMultipleOther',
                data: {
                    multiple_other_id: multiple_other_id,
                    section_name: this.section_name,
                }
            }).then(response => {
                this.getMultipleSections();
                this.section_name='';
            });
        },

        delete_multiple_other(multiple_other_id){
            axios({
                method: 'delete',
                url: '/admin/deleteMultipleOther',
                data: {
                    multiple_other_id: multiple_other_id,
                }
            }).then(response => {
                this.getMultipleSections();
            });
        },

        changeOtherPosition(section_id,other_id,value){
            // console.log(other_id);
            // console.log(value);
            axios({
                method: 'put',
                url: '/admin/changeOtherPosition',
                data: {
                    other_id: other_id,
                    up_down: value,
                }
            }).then(response => {
                this.getSectionOthers(section_id);
            });
        },

        delete_other(other_id,section_id){
            axios({
                method: 'delete',
                url: '/admin/deleteOther',
                data: {
                    other_id: other_id,
                }
            }).then(response => {
                this.getSectionOthers(section_id);
            });
        },

        getNeedsAndNomination(){
            axios.get('/admin/getNeedsAndNomination',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                this.needs = response.data.results.needs;
            });
        },

        sendNomination(cofounder_id){
            axios({
                method: 'post',
                url: '/admin/addNomination',
                data: {
                    cofounder_id: cofounder_id,
                }
            }).then(response => {
                this.getNeedsAndNomination();
            });
        },

        sendMessage(){

            axios.get('/admin/createChat',{
                params: {
                    account_id: this.account.id,
                }
            }).then((response) => {
                var chat_id = response.data.results.chat_id;
                if(!isNaN(chat_id)){
                    location.href = '/admin/chats/' + chat_id;
                }else{
                    this.alert_f(chat_id);
                }
            });

        },

        alert_f(message){
            this.alert = message;

            clearTimeout(this.myTimer);

            this.myTimer = setTimeout(()=>{

                this.alert='';

            }, 5000);
        },

    },
    mounted() {

        if(this.my_account_selected){
            this.my_account_selected = JSON.parse(this.my_account_selected.replace(/&quot;/g,'"'));
        }

        this.getTag();
        this.getServices();
        this.getFollow();
        this.getCooperation();
        this.getNeedsAndNomination();
    }

});

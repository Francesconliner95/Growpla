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
        usertype_id: '',
        pagetype_id: '',
        investors_selected: false,
        organizzations_selected: false,
        services_selected: false,
        name: '',
    },
    methods: {

      search_type_f(){
          // if(!this.search_type){
          //     this.name = '';
          // }else{
          //     this.account_selected = '';
          // }
      },

      change_category(){
          switch (this.category_selected) {
            case '1':
              //startup
              this.usertype_id = '';
              this.pagetype_id = 1;
              this.investors_selected = false;
              this.organizzations_selected = false;
              this.services_selected = false;
            break;
            case '2':
              //aspirante-cofounder
              this.usertype_id = 1;
              this.pagetype_id = '';
              this.investors_selected = false;
              this.organizzations_selected = false;
              this.services_selected = false;
            break;
            case '3':
              //incubatore-acc
              this.usertype_id = '';
              this.pagetype_id = 3;
              this.investors_selected = false;
              this.organizzations_selected = false;
              this.services_selected = false;
            break;
            case '4':
              //investitori
              this.usertype_id = '';
              this.pagetype_id = '';
              this.investors_selected = true;
              this.organizzations_selected = false;
              this.services_selected = false;
            break;
            case '5':
              //enti e associazioni
              this.usertype_id = '';
              this.pagetype_id = '';
              this.investors_selected = false;
              this.organizzations_selected = true;
              this.services_selected = false;
            break;
            case '6':
              //servizi
              this.usertype_id = '';
              this.pagetype_id = '';
              this.investors_selected = false;
              this.organizzations_selected = false;
              this.services_selected = true;
            break;
            default:
              this.usertype_id = '';
              this.pagetype_id = '';
              this.investors_selected = false;
              this.organizzations_selected = false;
              this.services_selected = false;

          }
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

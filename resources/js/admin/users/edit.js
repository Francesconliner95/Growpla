import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-edit',
    data: {
      user,
      regions: '',
      registered_page: true,
      page_name: '',
      pages_found: '',
      page_selected: '',
      region_id_selected: '',
      country_id_selected: '',
    },
    methods: {

        searchPage(){
          if(this.page_name){
              axios.get('/api/searchPage',{
                  params: {
                      page_name: this.page_name,
                  }
              }).then((response) => {
                  this.pages_found = response.data.results.pages;
                  if(!this.page_name){
                      this.pages_found = '';
                  }
              });
          }else{
              this.pages_found = '';
          }
        },

        addPage(page_found){
          this.page_selected = page_found;
          this.page_name = '';
          this.pages_found = '';
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
          }
        },

        // remove_file(value){
        //     axios({
        //         method: 'put',
        //         url: '/admin/removeFile',
        //         data: {
        //             account_id: this.account.id,
        //             file_type: value,
        //         }
        //     }).then(response => {
        //
        //     });
        //
        //     switch (value) {
        //         case 'img':
        //             this.account.image = 'accounts_images/default_account_image.png';
        //         break;
        //         case 'cover_img':
        //             this.account.cover_image = 'accounts_cover_images/default_account_cover_image.jpg';
        //         break;
        //         case 'pitch':
        //             this.account.pitch = '';
        //         break;
        //         case 'roadmap':
        //             this.account.roadmap = '';
        //         break;
        //         case 'cv':
        //             this.account.curriculum_vitae = '';
        //         break;
        //         default:
        //     }
        // },
    },
    created(){
      this.user = JSON.parse(this.user.replace(/&quot;/g,'"'));
      if(this.regions){
          this.regions = JSON.parse(this.regions.replace(/&quot;/g,'"'));
      }

      this.country_id_selected = this.user.country_id?this.user.country_id:1;
      this.region_id_selected = this.user.region_id;
      this.getRegionsByCountry();
    },
    mounted() {

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

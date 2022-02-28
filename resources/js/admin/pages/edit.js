import Vue from 'vue';
import axios from 'axios';
import tt from '@tomtom-international/web-sdk-services';
//npm i @tomtom-international/web-sdk-services
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#page-edit',
    data: {
      page,
      streetName: '',
      streetNumber: null,
      municipality: '',
      latitude: null,
      longitude: null,
      address: '',
      noAdressFound: false,
    },
    methods: {

      // submitForm(){
      //   tt.services.structuredGeocode({
      //         key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
      //         countryCode: 'IT',
      //         bestResult: true,
      //         streetName: this.streetName,
      //         streetNumber: this.streetNumber,
      //         municipality: this.municipality
      //     }).then(response => {
      //         this.noAdressFound = false;
      //         this.latitude = response.position.lat;
      //         this.longitude = response.position.lng;
      //
      //         tt.services.reverseGeocode({
      //             key: 'wSHLIGhfBYex4WI2gWpiUlecXvt3TOKC',
      //             position: {
      //                 longitude: this.longitude,
      //                 latitude: this.latitude
      //             }
      //         }).then(response => {
      //             var streetName = response.addresses[0].address.streetName;
      //             var streetNumber = response.addresses[0].address.streetNumber;
      //             var municipality = response.addresses[0].address.municipality;
      //             // this.address = `${streetName} ${streetNumber}, ${municipality}`;
      //
      //             this.address = streetName + ' ' + streetNumber + ', '+ municipality;
      //
      //             setTimeout(() => {
      //               document.getElementById("editPageForm").submit();
      //             }, 500);
      //         });
      //
      //     }).catch(error => {
      //         this.noAdressFound = true;
      //     });
      // }

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
      this.page = JSON.parse(this.page.replace(/&quot;/g,'"'));
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

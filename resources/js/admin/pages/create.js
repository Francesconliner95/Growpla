import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#page-create',
    data: {
        step: 1,
        max_step: document.getElementsByClassName('step').length,
        regions: '',
        region_id_selected: '',
        name: '',
        summary: '',
    },
    methods: {

        prev(){
            if(this.step>1){
                this.step--;
            }
        },

        next(){
            if(this.step<this.max_step){
                this.step++;
            }else if (this.step==this.max_step) {
                document.getElementById('formPageCreate').submit();
            }
        },

        prev_arrow(){
            if(this.step<=1){
                return 'invisible';
            }else{
                return 'button-style button-color-blue';
            }
        },

        next_arrow(){
            if(this.step<this.max_step){
                if(this.step==1 && this.name.length<3){
                    return 'invisible';
                }
                if(this.step==2 && this.summary.length<50){
                    return 'invisible';
                }
                return 'button-style button-color-blue';
            }else if (this.step==this.max_step) {
                return 'button-style button-color-green';
            }
        },

        getRegionsByCountry(){
            this.regions = '';
            axios.get('/api/regionsByCountry',{
                params: {
                    country_id: 1,
                }
            }).then((response) => {
                this.regions = response.data.results.regions;
                if(!this.region_id_selected){
                    this.region_id_selected = '';
                }
            });
        },


    },
    created(){

    },
    mounted() {
        this.getRegionsByCountry();
        
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

import Vue from 'vue';
import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#user-create',
    data: {
        summary,
        presentation,
        city,
        region_id_selected,
        step,
        max_step: '',
        regions: '',
    },
    methods: {

        prev(){
            if(parseInt(this.step)>1){
                this.step--;
            }
        },

        next(){
            if(parseInt(this.step)<this.max_step){
                this.step++;
            }else if (parseInt(this.step)==this.max_step) {
                document.getElementById('formUserCreate').submit();
            }
        },

        prev_arrow(){
            if(parseInt(this.step)<=1){
                return 'invisible';
            }else{
                return 'button-style button-color-blue';
            }
        },

        next_arrow(){
            if(parseInt(this.step)==1 && this.summary.length<50){
                return 'invisible';
            }
            if(parseInt(this.step)==4){
                if(!this.region_id_selected || !this.city){
                    return 'invisible';
                }
            }
            return 'button-style button-color-blue';
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
        if(!this.step){
            this.step = "1";
        }

        this.max_step = document.getElementsByClassName('step').length;

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

import Vue from 'vue';
import axios from 'axios';
import Croppr from 'croppr';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#company-create',
    data: {
        image: '',
        image_src: '/storage/' + app.image,
        x: 0,
        y: 0,
        width: 300,
        height: 300,
        registered_company: true,
        page_name: '',
        pages_found: '',
        page_selected: '',
    },
    methods: {
        submitForm(){
            document.getElementById('formCreateCompany').submit();
        },
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
        createCrop(){
            var croppr = new Croppr('#croppr', {
                // options
                aspectRatio: 1,
                // maxSize: [300, 300, 'px'],
                startSize: [100, 100, '%'],
                onCropEnd: (value)=> {
                    console.log(value.x, value.y, value.width, value.height);
                    console.log(croppr.getValue());
                    this.x = value.x;
                    this.y =  value.y;
                    this.width =  value.width;
                    this.height = value.height;
                    //console.log(this.x,this.y,this.width,this.height);
                },
            });
            this.x = croppr.getValue().x;
            this.y =  croppr.getValue().y;
            this.width =  croppr.getValue().width;
            this.height = croppr.getValue().height;
        },

        newFile(){
            const [file] = imgInp.files
            if (file) {
                //CREO IL NUOVO src
                this.image_src = URL.createObjectURL(file);
                //DISTRUGGI VECCHIA IMMAGINE
                const myNode = document.getElementById("copper-main");
                myNode.innerHTML = '';
                //CREA NUOVA IMMAGINE
                var img = document.createElement("img");
                img.src = this.image_src;
                img.id = "croppr";
                document.getElementById('copper-main').appendChild(img);
                //CREA IL NUOVO CROPPER
                img.onload = ()=>{
                    this.createCrop();
                }
            }
        },

        updateThumbnail(dropZoneElement, file){
            this.newFile();
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

    },
    mounted() {
      console.log('qua');

        if(this.image){
            this.createCrop();
        }

        //DRAG & DROP
        document.querySelectorAll(".drop-zone__input").forEach(inputElement =>{

            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", e =>{
                inputElement.click();
            });

            dropZoneElement.addEventListener("change", e =>{
                if(inputElement.files.length){
                    this.updateThumbnail(dropZoneElement, inputElement.files[0]);
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
                    this.updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");

            });

        });

    }

});

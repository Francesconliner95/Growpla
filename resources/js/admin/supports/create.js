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
    // console.log(dropZoneElement);
    // console.log(file);
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

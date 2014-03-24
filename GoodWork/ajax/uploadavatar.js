(function () {
    var input = document.getElementById("images");
        formdata = false;

    if (window.FormData) {
        formdata = new FormData();
        document.getElementById("btn").style.display = "none";
    }
    
    input.addEventListener("change", function (evt) {
        var i = 0, len = this.files.length, img, reader, file;
    
        for (i ; i < len; i++ ) {
            file = this.files[i];

            /*if (!!file.type.match(/video.)) {*/
            if (!!file.type.match(/image.*/)) { 
                if ( window.FileReader ) {
                    reader = new FileReader();
                    reader.onloadend = function (e) { 
                        /* On limite à 1Mo l'image */
                        if(file.size < (1024 * 1024) ){
                            showUploadedItem(e.target.result, file.fileName);
                        }else{
                            alert('Le fichier est trop gros');
                        }
                    };
                    reader.readAsDataURL(file);
                }
                if (formdata) {
                    formdata.append("images[]", file);
                }
            }else{
                alert('Le format de l\'image est incorrect');
            }   
        }
        if (formdata) {
            $.ajax({
                /*url: "/Ergro/protected/components/upload/upload.php",*/
                url: "ajax/uploadavatar.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (res) {
                    //On split le resultat
                    //Puisque si on change d'image apres avoir change d'image au moins, une fois, 'res' concatenera l'ancien URL avec le nouveau qui sont les meme
                    //Il faut donc utiliser que le premier
                    var resfinal = res.split(" ");
                    /*On met la nouvelle image dans circle*/
                    alert(res);
                    $("#profile-avatar").attr("src",resfinal[1]);
                }
            });
        }
    }, false);
}());

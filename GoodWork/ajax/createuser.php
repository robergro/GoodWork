<?php 
    session_start();

$AEnvoyer = "";

foreach ($_FILES["images"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {

        $taille_maxi = (1024*1024); // On limite à 1Mo la taille de l'image
        $taille = filesize($_FILES['images']['tmp_name'][$key]);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.ico');
        $extension = strrchr($_FILES['images']['name'][$key], '.');

        if($taille <= $taille_maxi){
            $name = $_FILES["images"]["name"][$key];
            


            $target_path = dirname(__FILE__) . '/upload/avatar/99998.png';

            move_uploaded_file( $_FILES["images"]["tmp_name"][$key], dirname(__FILE__)."/../upload/avatar/99955.png"); // .. pour revenir en arrière même dans un chemin !!!!!

            $typeupload = $extension;

            //Espace imperatif pour le cast de la chaine cote javascript
            $AEnvoyer = " upload/avatar/99955.png";
            echo $AEnvoyer;
        }
    }
}

//Supression des autres avatar du meme nom (s'il y en a un) (et d'une autre extension)
if(isset($filetitle)){
    for($i=0 ; $i<count($extensions) ; $i++){
        //On ne peut supprimer que SI l'extension est différente de celle du fichier uploader
        if($typeupload != $extensions[$i]){
            unlink($_SERVER["DOCUMENT_ROOT"]."/Ergro/upload/avatar/".$code.''.$extensions[$i]);
        }
    }
}

?>

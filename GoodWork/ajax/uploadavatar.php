<?php 
    session_start();

    $AEnvoyer = "";

    //On entre que si une personne est connectee
    if(isset($_SESSION['Goodwork_id'])){

        //Id de l'user
        //Le nom de chaque image sera modifie et aura pour valeur l'id de l'utilisateur
        $idusrCo = $_SESSION['Goodwork_id'];

        foreach ($_FILES["images"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {

                    $taille_maxi = (1024*1024); // On limite à 1Mo la taille de l'image
                    $taille = filesize($_FILES['images']['tmp_name'][$key]);
                    $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.ico');
                    $extension = strrchr($_FILES['images']['name'][$key], '.');

                    if($taille <= $taille_maxi){
                        $name = $_FILES["images"]["name"][$key];
                            

                        $idusrCo = $_SESSION['Goodwork_id'];
                        $filetitle = $idusrCo.$extension;


                        move_uploaded_file( $_FILES["images"]["tmp_name"][$key], dirname(__FILE__)."/../upload/avatar/".$filetitle); // .. pour revenir en arrière même dans un chemin !!!!!

                        $typeupload = $extension;

                        //Espace imperatif pour le cast de la chaine cote javascript
                        $AEnvoyer = " upload/avatar/".$filetitle;
                        echo $AEnvoyer;
                    }
                }
            }

            //Supression des autres avatar du meme nom (s'il y en a un) (et d'une autre extension)
            if(isset($filetitle)){
                for($i=0 ; $i<count($extensions) ; $i++){
                    //On ne peut supprimer que SI l'extension est différente de celle du fichier uploader
                    if($typeupload != $extensions[$i]){
                        unlink($_SERVER["DOCUMENT_ROOT"]."/Ergro/upload/avatar/".$idusrCo.''.$extensions[$i]);
                    }
                }
            }
    }
        

?>

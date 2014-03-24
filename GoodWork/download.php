<?php 
    if(!empty($_POST['fichier']))
    {
        $fichier = $_POST['fichier'];
        header('Content-disposition: attachment; filename="monfichier.txt"');
        print $fichier;
               
    } 

?>

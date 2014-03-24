<?php

    $connection=Yii::app()->db; 

    if($_GET['type'] == 'country'){
    {
        $sql="SELECT Usr.usr_id, Usr.usr_login, Usr.usr_nom, Usr.usr_prenom from gw_usr as Usr WHERE Usr.usr_login LIKE '".strtoupper($_GET['name_startsWith'])."%'";

        $rows=$connection->createCommand($sql)->query();

        $rows->bindColumn(1,$usr_id);
        $rows->bindColumn(2,$usr_login);
        $rows->bindColumn(3,$usr_nom);
        $rows->bindColumn(4,$usr_prenom);

        // Parcourt les résultats
        $data = array();
        foreach($rows as $row){ 
            array_push($data, $usr_nom);    
        }   
        echo json_encode($data);

    }
?>
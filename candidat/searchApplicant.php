<?php

include_once '../functions/connection_db.php';

$compteur = 1; //Compter le nombre de résultat pour le tableau de la vue

try{
    $sql = "SELECT id, nom, salaire "
         . "FROM carousel";    
    $resultats = $db->prepare($sql);
    $resultats->execute();

    
} catch (PDOException $e) {
    header('Location:homePageCarousel.php');
}

?>
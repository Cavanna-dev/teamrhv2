<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `poste`"
            . "(`CLIENT`, `TITRE`, `DIPLOME`, `EXPERIENCE`, `LIBELLE`,`CONTRAT`, `DUREE`, `LIEUX`, "
            . "`SALAIRE`, `HORAIRES`, `DATE_DEB`, `VITESSE`, `COMMUNICATION`, "
            . "`AUTRE_APPLI1`, `AUTRE_APPLI2`, `NIVEAU_FR`, `NIVEAU_EN`, "
            . "`POURVU`, `POURCENTAGE`, "
            . "`GARANTIE`, `FORFAIT`, `FORMULE`, `CONSULTANT`, `SIGNATURE`, `CREATION`) "
            . "VALUES "
            . "(:input_customer,:input_title,:input_diplome,:input_exp,"
            . ":input_name,:input_contrat,"
            . ":input_period,:input_place,:input_salary,:input_schedule,"
            . ":input_starting_date,:input_speed,:input_communication,:input_appli_1,:input_appli_2,"
            . ":input_fr,:input_an,:input_pourvu,:input_percent,:input_garantie,"
            . ":input_forfait,:input_formule,:input_contact,:input_signature,'"
            . date('Y-m-d')."')";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();
    
    header('Location:../client/upd_job.php?id='.$lastId.'&new');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
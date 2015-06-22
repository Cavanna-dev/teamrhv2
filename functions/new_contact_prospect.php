<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `contact_prospect`"
            . "(`PROSPECT`, `INACTIF`, `CIVILITE`, `NOM`, `PRENOM`, `FONCTION`, "
            . "`TEL`, `EMAIL`, `TYPE`, `REMARQUE`) "
            . "VALUES "
            . "(:prospect,:input_statut,:input_civil,:input_name,:input_last,"
            . ":input_fonction,:input_tel,:input_mail,:input_type,:input_remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();
    
header('Location:../prospect/upd_prospect.php?id='.$array_value[':prospect'].'&contactsuccess');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
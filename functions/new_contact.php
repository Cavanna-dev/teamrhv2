<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `contact`"
            . "(`CLIENT`, `INACTIF`, `CIVILITE`, `NOM`, `PRENOM`, `FONCTION`, "
            . "`TEL`, `EMAIL`, `TYPE`, `REMARQUE`) "
            . "VALUES "
            . "(:client,:input_statut,:input_civil,:input_name,:input_last,"
            . ":input_fonction,:input_tel,:input_mail,:input_type,:input_remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();
    
header('Location:../client/upd_client.php?id='.$array_value[':client'].'&contactsuccess');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
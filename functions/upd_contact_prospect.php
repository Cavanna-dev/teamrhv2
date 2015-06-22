<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE `contact_prospect` SET "
            . "`INACTIF`=:input_statut,"
            . "`CIVILITE`=:input_civil,"
            . "`NOM`=:input_name,"
            . "`PRENOM`=:input_last,"
            . "`FONCTION`=:input_fonction,"
            . "`TEL`=:input_tel,"
            . "`EMAIL`=:input_mail,"
            . "`TYPE`=:input_type,"
            . "`REMARQUE`=:input_remarque "
            . "WHERE "
            . "id=:id";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../prospect/upd_contact.php?id=' . $array_value[':id'] . '&updsuccess');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE `fournisseur` SET "
            . "`NOM`=:input_name,"
            . "`SECTEUR`=:input_zone,"
            . "`ADRESSE1`=:input_name,"
            . "`VILLE`=:input_town,"
            . "`POSTAL`=:input_postal,"
            . "`COUNTRY_FK`=:input_country,"
            . "`TEL_STD`=:input_tel,"
            . "`URL`=:input_url,"
            . "`METRO`=:input_metro,"
            . "`REMARQUE`=:input_remarque "
            . "WHERE id=:input_id";

    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../fournisseur/upd_fournisseur.php?id=' . $array_value[':input_id']);
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
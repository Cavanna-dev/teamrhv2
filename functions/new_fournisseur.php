<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
    $array_key[] = ':' . $key;
endforeach;
//var_dump($array_value);die;

//var_dump(implode(', ', $array_key));die;

try {
    $sql = "INSERT INTO `fournisseur`"
            . "(`REMARQUE`, `NOM`, `ADRESSE1`, `VILLE`, `TEL_STD`, `URL`, "
            . "`SECTEUR`, `POSTAL`, `COUNTRY_FK`, `METRO`, `CREATION`)"
            . "VALUES "
            . "(".implode(', ', $array_key) . ", CURDATE())";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();

    header('Location:../fournisseur/upd_fournisseur.php?id=' . $lastId);
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
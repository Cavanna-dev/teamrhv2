<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    if($key != 'spec')
        $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `client`"
            . "(`NOM`, `SECTEUR`, `ADRESSE1`, `VILLE`, `POSTAL`, "
            . "`COUNTRY_FK`, `NATIONALITE`, `TEL_STD`, `URL`, `METRO`, "
            . "`REMARQUE`, `MNGT_LAW`, `MNGT_SUPP`, `STATUS_FK`) "
            . "VALUES "
            . "(:input_name,:input_zone,:input_addr,:input_town,:input_postal,"
            . ":input_country,:input_nation,:input_tel,:input_url,:input_metro,"
            . ":input_remarque,:input_contact_law,:input_contact_supp,:input_status)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();
    
    header('Location:../client/upd_client.php?id='.$lastId.'&newsuccess');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
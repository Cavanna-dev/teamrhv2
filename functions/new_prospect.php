<?php

include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `prospect`"
            . "(`NOM`, `SECTEUR`, `ADRESSE1`, `VILLE`, `POSTAL`, "
            . "`COUNTRY_FK`, `NATIONALITE`, `TEL_STD`, `URL`, `METRO`, "
            . "`STATUS_FK`, `MNGT_LAW`, `MNGT_SUPP`, `REMARQUE`) "
            . "VALUES "
            . "(:input_name,:input_zone,:input_addr,:input_town,:input_postal,"
            . ":input_country,:input_nation,:input_tel,:input_url,:input_metro,"
            . ":input_status,:input_contact_law,:input_contact_supp,:input_remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();
    
    header('Location:../prospect/upd_prospect.php?id='.$lastId.'&success=newpros');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
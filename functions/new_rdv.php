<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `resa_salle`"
            . "(`ID`, `CONSULTANT1`, `CONSULTANT2`, `NUMSALLE`, `TYPE`, `CLIENT`, "
            . "`POSTE`, `CIVILITE`, `NOM`, `PRENOM`, `JOUR`, `HEURE_DEB`, `MINUTE_DEB`, "
            . "`HEURE_FIN`, `MINUTE_FIN`) "
            . "VALUES "
            . "(null,:input_consult1,:input_consult2,:input_salle,:input_type_rdv,"
            . ":input_customer,:input_title,:input_civil,:input_name,:input_last,"
            . ":input_date,:input_hdeb,:input_mdeb,:input_hfin,:input_mfin)";		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../index.php?newRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
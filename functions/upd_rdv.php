<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE `resa_salle` SET "
            . "`CONSULTANT1`=:input_consult1, "
            . "`CONSULTANT2`=:input_consult2, "
            . "`NUMSALLE`=:input_salle, "
            . "`TYPE`=:input_type_rdv, "
            . "`CLIENT`=:input_customer, "
            . "`POSTE`=:input_title, "
            . "`CIVILITE`=:input_civil, "
            . "`NOM`=:input_name, "
            . "`PRENOM`=:input_last, "
            . "`JOUR`=:input_date, "
            . "`HEURE_DEB`=:input_hdeb, "
            . "`MINUTE_DEB`=:input_mdeb, "
            . "`HEURE_FIN`=:input_hfin, "
            . "`MINUTE_FIN`=:input_mfin "
            . "WHERE id=:input_id";		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../index.php?updRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
<?php
include './connection_db.php';

//var_dump($_POST);die;

$array_post = array();
foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;

try {
    $sql = "UPDATE `encaisse` "
            . "SET `PLACEMENT`=:input_placement,`CLIENT`=:input_customer,"
            . "`DATE_ENVOI`=:input_date_send,`DATE_PAIEMENT`=:input_date_pay,`REF_FACTURE`=:input_ref_fac,"
            . "`MODE_PAIEMENT`=:input_mode_paiement,`REF_PAIEMENT`=:input_ref_pay,`MONTANT`=:input_ht,"
            . "`TVA`=:input_tva,`ENC_TTC_TOT_AMOUNT`=:input_ttc,`ENC_TVA_TOT_AMOUNT`=:input_amount_tva,`DESCRIPTION`=:input_description "
            . "WHERE id = :input_id";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../comptabilite/upd_encaisse.php?id='.$array_value[':input_id'].'&success=n');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
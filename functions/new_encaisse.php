<?php
include './connection_db.php';

//var_dump($_POST);die;

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;

try {
    $sql = "INSERT INTO `encaisse`"
            . "(`PLACEMENT`, `CLIENT`, `DATE_ENVOI`, `DATE_PAIEMENT`, `REF_FACTURE`, "
            . "`MODE_PAIEMENT`, `REF_PAIEMENT`, `MONTANT`, `TVA`, `ENC_TTC_TOT_AMOUNT`, "
            . "`ENC_TVA_TOT_AMOUNT`, `DESCRIPTION`) "
            . "VALUES "
            . "(:input_placement, :input_customer, :input_date_send, :input_date_pay,"
            . ":input_ref_fac, :input_mode_paiement, :input_ref_pay, :input_ht, "
            . ":input_tva, :input_ttc, :input_amount_tva, :input_description)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../client/upd_placement.php?id='.$array_value[':input_placement'].'&success=n');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
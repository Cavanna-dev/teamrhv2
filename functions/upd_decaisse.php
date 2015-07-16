<?php
error_reporting(0);
include './connection_db.php';
include './bootstrap.php';

$id_decaisse = isset($_POST['input_id']) ? $_POST['input_id'] : '';
$fourn = isset($_POST['input_fournisseur']) ? $_POST['input_fournisseur'] : '';
$dc = isset($_POST['input_date_compta']) ? $_POST['input_date_compta'] : '';
$mp = isset($_POST['input_mode_paiement']) ? $_POST['input_mode_paiement'] : '';
$rf = isset($_POST['input_ref_fac']) ? $_POST['input_ref_fac'] : '';
$dp = isset($_POST['input_date_paiement']) ? $_POST['input_date_paiement'] : '';
$rp = isset($_POST['input_ref_pai']) ? $_POST['input_ref_pai'] : '';
$d = isset($_POST['input_description']) ? $_POST['input_description'] : '';

$dd = getAllDDByDecaisseId($db, $id_decaisse);
foreach ($dd as $value):
    $sql = "DELETE FROM `decaisse_detail` WHERE id='" . $value->ID . "'";    
    $stmt = $db->prepare($sql);
    $stmt->execute();
endforeach;

if(isset($_POST['input_line1']) && $_POST['input_line1'] == 'on'){
    $line1_ht = $_POST['input_line1_ht'];
    $line1_tva = $_POST['input_line1_tva'];
    $line1_ttc = $_POST['input_line1_ttc'];
}
if(isset($_POST['input_line2']) && $_POST['input_line2'] == 'on'){
    $line2_ht = $_POST['input_line2_ht'];
    $line2_tva = $_POST['input_line2_tva'];
    $line2_ttc = $_POST['input_line2_ttc'];
}
if(isset($_POST['input_line3']) && $_POST['input_line3'] == 'on'){
    $line3_ht = $_POST['input_line3_ht'];
    $line3_tva = $_POST['input_line3_tva'];
    $line3_ttc = $_POST['input_line3_ttc'];
}
if(isset($_POST['input_line4']) && $_POST['input_line4'] == 'on'){
    $line4_ht = $_POST['input_line4_ht'];
    $line4_tva = $_POST['input_line4_tva'];
    $line4_ttc = $_POST['input_line4_ttc'];
}

$total_ht = $line1_ht + $line2_ht + $line3_ht + $line4_ht;
$total_tva = $line1_tva + $line2_tva + $line3_tva + $line4_tva;
$total_ttc = $line1_ttc + $line2_ttc + $line3_ttc + $line4_ttc;


try {
    $sql = "UPDATE `decaisse` "
            . "SET "
            . "`FOURNISSEUR`='".$fourn."',`DATE_COMPTA`='".$dc."',"
            . "`DATE_PAIEMENT`='".$dp."',`REF_FACTURE`='".$rf."',"
            . "`MODE_PAIEMENT`='".$mp."',`REF_PAIEMENT`='".$rp."',"
            . "`DEC_HT_TOT_AMOUNT`='".$total_ht."',`DEC_TVA_TOT_AMOUNT`='".$total_tva."',"
            . "`DEC_TTC_TOT_AMOUNT`='".$total_ttc."',`DESCRIPTION`='".$d."' WHERE id='".$id_decaisse."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    if (isset($_POST['input_line1']) && $_POST['input_line1'] == 'on') {
        $sql = "INSERT INTO `decaisse_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                . " VALUES "
                . "('" . $line1_ht . "','".$_POST['input_line1_percent']."','" . $line1_tva . "','" . $line1_ttc . "','" . $id_decaisse . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line2']) && $_POST['input_line2'] == 'on') {
        $sql = "INSERT INTO `decaisse_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                . " VALUES "
                . "('" . $line2_ht . "','".$_POST['input_line2_percent']."','" . $line2_tva . "','" . $line2_ttc . "','" . $id_decaisse . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line3']) && $_POST['input_line3'] == 'on') {
        $sql = "INSERT INTO `decaisse_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                . " VALUES "
                . "('" . $line3_ht . "','".$_POST['input_line3_percent']."','" . $line3_tva . "','" . $line3_ttc . "','" . $id_decaisse . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line4']) && $_POST['input_line4'] == 'on') {
        $sql = "INSERT INTO `decaisse_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                . " VALUES "
                . "('" . $line4_ht . "','".$_POST['input_line4_percent']."','" . $line4_tva . "','" . $line4_ttc . "','" . $id_decaisse . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    
    header('Location:../facturation/upd_decaisse.php?id='.$id_decaisse.'&success=upd');
} catch (Exception $ex) {
    
}
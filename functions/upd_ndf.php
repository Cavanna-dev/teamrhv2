<?php
error_reporting(0);
include './connection_db.php';
include './bootstrap.php';

$id_ndf = isset($_POST['input_id']) ? $_POST['input_id'] : '';
$month = $_POST['input_month'] ? htmlspecialchars($_POST['input_month']) : '';
$year = $_POST['input_year'] ? htmlspecialchars($_POST['input_year']) : '';
$d = isset($_POST['input_description']) ? $_POST['input_description'] : '';

$dd = getAllNdfDByNdfId($db, $id_ndf);
foreach ($dd as $value):
    $sql = "DELETE FROM `notesfrais_detail` WHERE id='" . $value->ID . "'";    
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
    $sql = "UPDATE `notesfrais` "
            . "SET "
            . "`MOIS`='".$month."',`ANNEE`='".$year."',"
            . "`HT_TOT_AMOUNT`='".$total_ht."',`TVA_TOT_AMOUNT`='".$total_tva."',"
            . "`TTC_TOT_AMOUNT`='".$total_ttc."',`DESCRIPTION`='".$d."' WHERE id='".$id_ndf."'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    if (isset($_POST['input_line1']) && $_POST['input_line1'] == 'on') {
        $sql = "INSERT INTO `notesfrais_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                . " VALUES "
                . "('" . $line1_ht . "','".$_POST['input_line1_percent']."','" . $line1_tva . "','" . $line1_ttc . "','" . $id_ndf . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line2']) && $_POST['input_line2'] == 'on') {
        $sql = "INSERT INTO `notesfrais_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                . " VALUES "
                . "('" . $line2_ht . "','".$_POST['input_line2_percent']."','" . $line2_tva . "','" . $line2_ttc . "','" . $id_ndf . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line3']) && $_POST['input_line3'] == 'on') {
        $sql = "INSERT INTO `notesfrais_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                . " VALUES "
                . "('" . $line3_ht . "','".$_POST['input_line3_percent']."','" . $line3_tva . "','" . $line3_ttc . "','" . $id_ndf . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    if (isset($_POST['input_line4']) && $_POST['input_line4'] == 'on') {
        $sql = "INSERT INTO `notesfrais_detail`"
                . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                . " VALUES "
                . "('" . $line4_ht . "','".$_POST['input_line4_percent']."','" . $line4_tva . "','" . $line4_ttc . "','" . $id_ndf . "')";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    }
    
    header('Location:../comptabilite/upd_ndf.php?id='.$id_ndf.'&success=upd');
} catch (Exception $ex) {
    
}
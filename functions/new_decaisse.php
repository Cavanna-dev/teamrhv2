<?php
include './connection_db.php';
error_reporting(0);
//var_dump($_POST);die;

$fourn = isset($_POST['input_fournisseur']) ? $_POST['input_fournisseur'] : '';
$dc = isset($_POST['input_date_compta']) ? $_POST['input_date_compta'] : '';
$mp = isset($_POST['input_mode_paiement']) ? $_POST['input_mode_paiement'] : '';
$rf = isset($_POST['input_ref_fac']) ? $_POST['input_ref_fac'] : '';
$dp = isset($_POST['input_date_paiement']) ? $_POST['input_date_paiement'] : '';
$rp = isset($_POST['input_ref_pai']) ? $_POST['input_ref_pai'] : '';
$d = isset($_POST['input_description']) ? $_POST['input_description'] : '';

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

//$total_ht = $line1_ht + $line2_ht + $line3_ht + $line4_ht;
//$total_tva = $line1_tva + $line2_tva + $line3_tva + $line4_tva;
//$total_ttc = $line1_ttc + $line2_ttc + $line3_ttc + $line4_ttc;
$total_ht = $_POST['input_amount_lines_ht'];
$total_tva = $_POST['input_amount_lines_tva'];
$total_ttc = $_POST['input_amount_lines_ttc'];

try {
    $sql = "INSERT INTO `decaisse`(`FOURNISSEUR`, `DATE_COMPTA`, `DATE_PAIEMENT`, "
            . "`REF_FACTURE`, `MODE_PAIEMENT`, `REF_PAIEMENT`, "
            . "`DEC_HT_TOT_AMOUNT`, `DEC_TVA_TOT_AMOUNT`, `DEC_TTC_TOT_AMOUNT`, "
            . "`DESCRIPTION`) "
            . "VALUES('".$fourn."','".$dc."','".$dp."','".$rf."','".$mp."','".$rp."',"
            . "'".$total_ht."','".$total_tva."','".$total_ttc."','".$d."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $lastId = $db->lastInsertId();
    
    if(isset($_POST['input_line1']) && $_POST['input_line1'] == 'on'){
            $sql = "INSERT INTO `decaisse_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                    . " VALUES "
                    . "('".$line1_ht."','20','".$line1_tva."','".$line1_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line2']) && $_POST['input_line2'] == 'on'){
            $sql = "INSERT INTO `decaisse_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                    . " VALUES "
                    . "('".$line2_ht."','10','".$line2_tva."','".$line2_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line3']) && $_POST['input_line3'] == 'on'){
            $sql = "INSERT INTO `decaisse_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                    . " VALUES "
                    . "('".$line3_ht."','5.5','".$line3_tva."','".$line3_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line4']) && $_POST['input_line4'] == 'on'){
            $sql = "INSERT INTO `decaisse_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_DECAISSE_ID`)"
                    . " VALUES "
                    . "('".$line4_ht."','0','".$line4_tva."','".$line4_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    
    header('Location:../comptabilite/decaisse.php?success=upd');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
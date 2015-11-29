<?php
include './connection_db.php';
error_reporting(0);
//var_dump($_POST);die;

$month = $_POST['input_month'] ? htmlspecialchars($_POST['input_month']) : '';
$year = $_POST['input_year'] ? htmlspecialchars($_POST['input_year']) : '';
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

$total_ht = $line1_ht + $line2_ht + $line3_ht + $line4_ht;
$total_tva = $line1_tva + $line2_tva + $line3_tva + $line4_tva;
$total_ttc = $line1_ttc + $line2_ttc + $line3_ttc + $line4_ttc;

try {
    $sql = "INSERT INTO `notesfrais`"
            . "(`UTILISATEUR`, `MOIS`, `ANNEE`, `HT_TOT_AMOUNT`, "
            . "`TVA_TOT_AMOUNT`, `TTC_TOT_AMOUNT`, `DESCRIPTION`) "
            . "VALUES "
            . "(2,'".$month."','".$year."','".$total_ht."','".$total_tva."',"
            . "'".$total_ttc."','".$d."')";
    //var_dump($sql);die;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $lastId = $db->lastInsertId();
    
    if(isset($_POST['input_line1']) && $_POST['input_line1'] == 'on'){
            $sql = "INSERT INTO `notesfrais_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                    . " VALUES "
                    . "('".$line1_ht."','20','".$line1_tva."','".$line1_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line2']) && $_POST['input_line2'] == 'on'){
            $sql = "INSERT INTO `notesfrais_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                    . " VALUES "
                    . "('".$line2_ht."','10','".$line2_tva."','".$line2_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line3']) && $_POST['input_line3'] == 'on'){
            $sql = "INSERT INTO `notesfrais_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                    . " VALUES "
                    . "('".$line3_ht."','5.5','".$line3_tva."','".$line3_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    if(isset($_POST['input_line4']) && $_POST['input_line4'] == 'on'){
            $sql = "INSERT INTO `notesfrais_detail`"
                    . "(`HT_AMOUNT`, `TVA_PERCENT`, `TVA_AMOUNT`, `TTC_AMOUNT`, `FK_NOTESFRAIS_ID`)"
                    . " VALUES "
                    . "('".$line4_ht."','0','".$line4_tva."','".$line4_ttc."','".$lastId."')";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    }
    
    header('Location:../facturation/ndf.php?tab=new');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
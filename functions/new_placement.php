<?php

include './connection_db.php';

$description = isset($_POST['input_description']) ? $_POST['input_description'] : '';
$remarque = isset($_POST['input_remarque']) ? $_POST['input_remarque'] : '' ;
$customer = isset($_POST['input_customer']) ? htmlspecialchars($_POST['input_customer']) : '';
$applicant = isset($_POST['input_applicant']) ? htmlspecialchars($_POST['input_applicant']) : '';
$consultant = isset($_POST['input_consult']) ? htmlspecialchars($_POST['input_consult']) : '';
$month = isset($_POST['input_month']) ? htmlspecialchars($_POST['input_month']) : '';
$year = isset($_POST['input_year']) ? htmlspecialchars($_POST['input_year']) : '';
$contrat = isset($_POST['input_contrat']) ? htmlspecialchars($_POST['input_contrat']) : '';
$lieux = isset($_POST['input_lieux']) ? htmlspecialchars($_POST['input_lieux']) : '';
$percent = isset($_POST['input_pourcent']) ? htmlspecialchars($_POST['input_pourcent']) : '';
$dateDeb = isset($_POST['input_deb']) ? htmlspecialchars($_POST['input_deb']) : '';
$job = isset($_POST['input_job']) ? htmlspecialchars($_POST['input_job']) : '';
$title = isset($_POST['input_title']) ? htmlspecialchars($_POST['input_title']) : '';
$apporteur = isset($_POST['input_apporteur']) ? htmlspecialchars($_POST['input_apporteur']) : '';
$duree = isset($_POST['input_duree']) ? htmlspecialchars($_POST['input_duree']) : '';
$salaire = isset($_POST['input_salaire']) ? htmlspecialchars($_POST['input_salaire']) : '';
$remise = isset($_POST['input_remise']) ? htmlspecialchars($_POST['input_remise']) : '';
$isFacture = isset($_POST['input_facture']) ? htmlspecialchars($_POST['input_facture']) : '';
$isEncaisse = isset($_POST['input_encaisse']) ? htmlspecialchars($_POST['input_encaisse']) : '';
$isReglement = isset($_POST['input_reglement']) ? htmlspecialchars($_POST['input_reglement']) : '';

try {
    $sql = "INSERT INTO `placement`(`CLIENT`, `POSTE`, `CANDIDAT`, "
            . "`CONSULTANT`, `APPORTEUR`, `MOIS_PLACEMENT`, `ANNEE_PLACEMENT`, "
            . "`TITRE`, `DESCRIPTION`, `CONTRAT`, `DUREE`, `LIEUX`, `SALAIRE`, "
            . "`DATE_DEB`, `REMISE`, `REMARQUE`, `FACTURE`, `ENCAISSE`, "
            . "`REGLEMENT`, `CREATION`) "
            . "VALUES ("
            . ":client, :poste, :candidat, :consultant, :apporteur, :mois_placement, "
            . ":annee_placement, :titre, :description, :contrat, :duree, :lieux, "
            . ":salaire, :date_deb, :remise, :remarque, :facture, :encaisse, :reglement, NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':client', $customer, PDO::PARAM_STR);
    $stmt->bindParam(':poste', $job, PDO::PARAM_STR);
    $stmt->bindParam(':candidat', $applicant, PDO::PARAM_STR);
    $stmt->bindParam(':consultant', $consultant, PDO::PARAM_STR);
    $stmt->bindParam(':apporteur', $apporteur, PDO::PARAM_STR);
    $stmt->bindParam(':mois_placement', $month, PDO::PARAM_STR);
    $stmt->bindParam(':annee_placement', $year, PDO::PARAM_STR);
    $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':remarque', $remarque, PDO::PARAM_STR);
    $stmt->bindParam(':contrat', $contrat, PDO::PARAM_STR);
    $stmt->bindParam(':duree', $duree, PDO::PARAM_STR);
    $stmt->bindParam(':lieux', $lieux, PDO::PARAM_STR);
    $stmt->bindParam(':salaire', $salaire, PDO::PARAM_STR);
    $stmt->bindParam(':date_deb', $dateDeb, PDO::PARAM_STR);
    $stmt->bindParam(':remise', $remise, PDO::PARAM_STR);
    $stmt->bindParam(':facture', $isFacture, PDO::PARAM_STR);
    $stmt->bindParam(':encaisse', $isEncaisse, PDO::PARAM_STR);
    $stmt->bindParam(':reglement', $isReglement, PDO::PARAM_STR);
    $stmt->execute();
    $input_id = $db->lastInsertId();

    $p1_pourcentage = isset($_POST['input_p1_pourcentage']) ? $_POST['input_p1_pourcentage'] : '';
    $p1_date = isset($_POST['input_p1_date']) ? $_POST['input_p1_date'] : '';
    $p1_tva = isset($_POST['input_p1_tva']) ? $_POST['input_p1_tva'] : '';
    $p1_montant = isset($_POST['input_p1_montant']) ? $_POST['input_p1_montant'] : '';
    $p1_facture = isset($_POST['input_p1_facture']) ? $_POST['input_p1_facture'] : '';
    $p1_encaisse = isset($_POST['input_p1_encaisse']) ? $_POST['input_p1_encaisse'] : '';
    $p2_pourcentage = isset($_POST['input_p2_pourcentage']) ? $_POST['input_p2_pourcentage'] : '';
    $p2_date = isset($_POST['input_p2_date']) ? $_POST['input_p2_date'] : '';
    $p2_tva = isset($_POST['input_p2_tva']) ? $_POST['input_p2_tva'] : '';
    $p2_montant = isset($_POST['input_p2_montant']) ? $_POST['input_p2_montant'] : '';
    $p2_facture = isset($_POST['input_p2_facture']) ? $_POST['input_p2_facture'] : '';
    $p2_encaisse = isset($_POST['input_p2_encaisse']) ? $_POST['input_p2_encaisse'] : '';
    $p3_pourcentage = isset($_POST['input_p3_pourcentage']) ? $_POST['input_p3_pourcentage'] : '';
    $p3_date = isset($_POST['input_p3_date']) ? $_POST['input_p3_date'] : '';
    $p3_tva = isset($_POST['input_p3_tva']) ? $_POST['input_p3_tva'] : '';
    $p3_montant = isset($_POST['input_p3_montant']) ? $_POST['input_p3_montant'] : '';
    $p3_facture = isset($_POST['input_p3_facture']) ? $_POST['input_p3_facture'] : '';
    $p3_encaisse = isset($_POST['input_p3_encaisse']) ? $_POST['input_p3_encaisse'] : '';

    $f1_date = isset($_POST['input_f1_date']) ? $_POST['input_f1_date'] : '';
    $f1_tva = isset($_POST['input_f1_tva']) ? $_POST['input_f1_tva'] : '';
    $f1_montant = isset($_POST['input_f1_montant']) ? $_POST['input_f1_montant'] : '';
    $f1_facture = isset($_POST['input_f1_facture']) ? $_POST['input_f1_facture'] : '';
    $f1_encaisse = isset($_POST['input_f1_encaisse']) ? $_POST['input_f1_encaisse'] : '';
    $f2_date = isset($_POST['input_f2_date']) ? $_POST['input_f2_date'] : '';
    $f2_tva = isset($_POST['input_f2_tva']) ? $_POST['input_f2_tva'] : '';
    $f2_montant = isset($_POST['input_f2_montant']) ? $_POST['input_f2_montant'] : '';
    $f2_facture = isset($_POST['input_f2_facture']) ? $_POST['input_f2_facture'] : '';
    $f2_encaisse = isset($_POST['input_f2_encaisse']) ? $_POST['input_f2_encaisse'] : '';
    $f3_date = isset($_POST['input_f3_date']) ? $_POST['input_f3_date'] : '';
    $f3_tva = isset($_POST['input_f3_tva']) ? $_POST['input_f3_tva'] : '';
    $f3_montant = isset($_POST['input_f3_montant']) ? $_POST['input_f3_montant'] : '';
    $f3_facture = isset($_POST['input_f3_facture']) ? $_POST['input_f3_facture'] : '';
    $f3_encaisse = isset($_POST['input_f3_encaisse']) ? $_POST['input_f3_encaisse'] : '';
    
    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('P', '1', '" . $p1_pourcentage . "', '" . $p1_date . "', '" . $p1_tva . "', "
            . "'" . $p1_montant . "', '" . $p1_facture . "', '" . $p1_encaisse . "', "
            . "'" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('P', '2', '" . $p2_pourcentage . "', '" . $p2_date . "', '" . $p2_tva . "', "
            . "'" . $p2_montant . "', '" . $p2_facture . "', '" . $p2_encaisse . "', "
            . "'" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('P', '3', '" . $p3_pourcentage . "', '" . $p3_date . "', '" . $p3_tva . "', "
            . "'" . $p3_montant . "', '" . $p3_facture . "', '" . $p3_encaisse . "', "
            . "'" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('F', '1', null, '" . $f1_date . "', '" . $f1_tva . "', '" . $f1_montant . "', "
            . "'" . $f1_facture . "', '" . $f1_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('F', '2', null, '" . $f2_date . "', '" . $f2_tva . "', '" . $f2_montant . "', "
            . "'" . $f2_facture . "', '" . $f2_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('F', '3', null, '" . $f3_date . "', '" . $f3_tva . "', '" . $f3_montant . "', "
            . "'" . $f3_facture . "', '" . $f3_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>

<SCRIPT type="text/javascript">
document.location.href="../client/placement.php"
</SCRIPT>
<?php

include './connection_db.php';

$input_id = htmlspecialchars($_POST['input_id']);
$customer = htmlspecialchars($_POST['input_customer']);
$applicant = htmlspecialchars($_POST['input_applicant']);
$consultant = htmlspecialchars($_POST['input_consult']);
$month = htmlspecialchars($_POST['input_month']);
$year = htmlspecialchars($_POST['input_year']);
$contrat = htmlspecialchars($_POST['input_contrat']);
$lieux = htmlspecialchars($_POST['input_lieux']);
$percent = htmlspecialchars($_POST['input_pourcent']);
$dateDeb = htmlspecialchars($_POST['input_deb']);
$job = htmlspecialchars($_POST['input_job']);
$title = htmlspecialchars($_POST['input_title']);
$apporteur = htmlspecialchars($_POST['input_apporteur']);
$duree = htmlspecialchars($_POST['input_duree']);
$salaire = htmlspecialchars($_POST['input_salaire']);
$remise = htmlspecialchars($_POST['input_remise']);
$forfait = htmlspecialchars($_POST['input_forfait']);
$isFacture = htmlspecialchars($_POST['input_facture']);
$isEncaisse = htmlspecialchars($_POST['input_encaisse']);
$isReglement = htmlspecialchars($_POST['input_reglement']);

try {
    $sql = "UPDATE placement SET "
            . "client = :client, "
            . "poste = :poste, "
            . "candidat = :candidat, "
            . "consultant = :consultant, "
            . "apporteur = :apporteur, "
            . "mois_placement = :mois_placement, "
            . "annee_placement = :annee_placement, "
            . "titre = :titre, "
            . "contrat = :contrat, "
            . "duree = :duree, "
            . "lieux = :lieux, "
            . "pourcentage = :pourcentage, "
            . "salaire = :salaire, "
            . "date_deb = :date_deb, "
            . "remise = :remise, "
            . "forfait = :forfait, "
            . "facture = :facture, "
            . "encaisse = :encaisse, "
            . "reglement = :reglement "
            . "WHERE id = :id_placement";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':client', $customer, PDO::PARAM_STR);
    $stmt->bindParam(':poste', $job, PDO::PARAM_STR);
    $stmt->bindParam(':candidat', $applicant, PDO::PARAM_STR);
    $stmt->bindParam(':consultant', $consultant, PDO::PARAM_STR);
    $stmt->bindParam(':apporteur', $apporteur, PDO::PARAM_STR);
    $stmt->bindParam(':mois_placement', $month, PDO::PARAM_STR);
    $stmt->bindParam(':annee_placement', $year, PDO::PARAM_STR);
    $stmt->bindParam(':titre', $title, PDO::PARAM_STR);
    $stmt->bindParam(':contrat', $contrat, PDO::PARAM_STR);
    $stmt->bindParam(':duree', $duree, PDO::PARAM_INT);
    $stmt->bindParam(':lieux', $lieux, PDO::PARAM_STR);
    $stmt->bindParam(':pourcentage', $percent, PDO::PARAM_INT);
    $stmt->bindParam(':salaire', $salaire, PDO::PARAM_STR);
    $stmt->bindParam(':date_deb', $dateDeb, PDO::PARAM_STR);
    $stmt->bindParam(':remise', $remise, PDO::PARAM_STR);
    $stmt->bindParam(':forfait', $forfait, PDO::PARAM_STR);
    $stmt->bindParam(':facture', $isFacture, PDO::PARAM_STR);
    $stmt->bindParam(':encaisse', $isEncaisse, PDO::PARAM_STR);
    $stmt->bindParam(':reglement', $isReglement, PDO::PARAM_STR);
    $stmt->bindParam(':id_placement', $input_id, PDO::PARAM_INT);
    $stmt->execute();

    $p1_pourcentage = $_POST['input_p1_pourcentage'];
    $p1_date = $_POST['input_p1_date'];
    $p1_tva = $_POST['input_p1_tva'];
    $p1_montant = $_POST['input_p1_montant'];
    $p1_facture = $_POST['input_p1_facture'];
    $p1_encaisse = $_POST['input_p1_encaisse'];
    $p2_pourcentage = $_POST['input_p2_pourcentage'];
    $p2_date = $_POST['input_p2_date'];
    $p2_tva = $_POST['input_p2_tva'];
    $p2_montant = $_POST['input_p2_montant'];
    $p2_facture = $_POST['input_p2_facture'];
    $p2_encaisse = $_POST['input_p2_encaisse'];
    $p3_pourcentage = $_POST['input_p3_pourcentage'];
    $p3_date = $_POST['input_p3_date'];
    $p3_tva = $_POST['input_p3_tva'];
    $p3_montant = $_POST['input_p3_montant'];
    $p3_facture = $_POST['input_p3_facture'];
    $p3_encaisse = $_POST['input_p3_encaisse'];

    $f1_pourcentage = $_POST['input_f1_pourcentage'];
    $f1_date = $_POST['input_f1_date'];
    $f1_tva = $_POST['input_f1_tva'];
    $f1_montant = $_POST['input_f1_montant'];
    $f1_facture = $_POST['input_f1_facture'];
    $f1_encaisse = $_POST['input_f1_encaisse'];
    $f2_pourcentage = $_POST['input_f2_pourcentage'];
    $f2_date = $_POST['input_f2_date'];
    $f2_tva = $_POST['input_f2_tva'];
    $f2_montant = $_POST['input_f2_montant'];
    $f2_facture = $_POST['input_f2_facture'];
    $f2_encaisse = $_POST['input_f2_encaisse'];
    $f3_pourcentage = $_POST['input_f3_pourcentage'];
    $f3_date = $_POST['input_f3_date'];
    $f3_tva = $_POST['input_f3_tva'];
    $f3_montant = $_POST['input_f3_montant'];
    $f3_facture = $_POST['input_f3_facture'];
    $f3_encaisse = $_POST['input_f3_encaisse'];

    $sql = "DELETE FROM REGLEMENTS WHERE fk_placement_id = " . $input_id;
    $stmt = $db->prepare($sql);
    $stmt->execute();

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
    $sql .= "('F', '1', '" . $f1_pourcentage . "', '" . $f1_date . "', '" . $f1_tva . "', '" . $f1_montant . "', "
            . "'" . $f1_facture . "', '" . $f1_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('F', '2', '" . $f2_pourcentage . "', '" . $f2_date . "', '" . $f2_tva . "', '" . $f2_montant . "', "
            . "'" . $f2_facture . "', '" . $f2_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    $sql = "INSERT INTO REGLEMENTS";
    $sql .= " (type, number, pourcentage, date, tva, montant, isFacture, isEncaisse, "
            . "fk_placement_id) ";
    $sql .= " values ";
    $sql .= "('F', '3', '" . $f3_pourcentage . "', '" . $f3_date . "', '" . $f3_tva . "', '" . $f3_montant . "', "
            . "'" . $f3_facture . "', '" . $f3_encaisse . "', '" . $input_id . "') ";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    header('Location:../client/upd_placement.php?id=' . $input_id . '&success');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
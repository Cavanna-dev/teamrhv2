<?php

function getAllPlacements($db)
{
    $sql = "SELECT id, nom "
            . "FROM placement "
            . "ORDER BY nom";

    $r_placement = $db->prepare($sql);
    $r_placement->execute();

    return $r_placement;
}

function getPlacementDetailById($db, $id, $type, $n)
{
    $sql = "SELECT id, type, pourcentage, date, tva, montant, isFacture, "
            . "isEncaisse "
            . "FROM reglements "
            . "WHERE type = '".$type."' AND number = '".$n."' AND fk_placement_id = " . $id;

    $r_placement = $db->prepare($sql);
    $r_placement->execute();
    $r = $r_placement->fetch(PDO::FETCH_OBJ);
    return $r;
}

function getTotalByPlacementId($db, $id, $facture)
{
    $sql = "SELECT round(sum(montant), 2) as total "
            . "FROM reglements "
            . "WHERE isEncaisse = '".$facture."' AND isFacture = 'Y' AND fk_placement_id = " . $id;
    
    $r_placement = $db->prepare($sql);
    $r_placement->execute();
    $r = $r_placement->fetch(PDO::FETCH_OBJ);
    return $r;
}
function getTotalFactureByPlacementId($db, $id)
{
    $sql = "SELECT round(sum(montant), 2) as total "
            . "FROM reglements "
            . "WHERE isFacture = 'N' AND fk_placement_id = " . $id;
    
    $r_placement = $db->prepare($sql);
    $r_placement->execute();
    $r = $r_placement->fetch(PDO::FETCH_OBJ);
    return $r;
}

function getOnePlacementById($db, $id)
{
    $sql = "SELECT id, client, poste, candidat, consultant, apporteur, mois_placement, "
            . "annee_placement, titre, description, contrat, duree, lieux, salaire, "
            . "horaires, date_deb, pourcentage, remise, forfait, remarque, facture, "
            . "encaisse, reglement "
            . "FROM placement "
            . "WHERE id='" . $id . "'";

    $r_placement = $db->prepare($sql);
    $r_placement->execute();
    $r = $r_placement->fetch(PDO::FETCH_OBJ);
    return $r;
}

function getOnePlacementDetailById($db, $id)
{
    $sql = "SELECT id, type, pourcentage, date, tva, montant, isFacture, "
            . "isEncaisse "
            . "FROM reglements "
            . "WHERE id=" . $id;

    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetch(PDO::FETCH_OBJ);
    return $r;
}

function searchPlacements($db)
{
    $consult = htmlspecialchars($_GET['input_consult']);
    $customer = isset($_GET['input_customer']) ? htmlspecialchars($_GET['input_customer']) : '';
    $job = isset($_GET['input_job']) ? htmlspecialchars($_GET['input_job']) : '';
    $applicant = isset($_GET['input_applicant']) ? htmlspecialchars($_GET['input_applicant']) : '';
    $month = htmlspecialchars($_GET['input_month']);
    $year = htmlspecialchars($_GET['input_year']);

    $sql = "SELECT pl.id, pl.poste, pl.candidat, pl.mois_placement, pl.annee_placement, "
            . "pl.consultant, pl.salaire, pl.pourcentage, cl.id as idclient, cl.nom as client, "
            . "s.libelle as secteur "
            . "FROM placement pl "
            . "LEFT JOIN client cl ON pl.client = cl.id "
            . "LEFT JOIN secteur s ON cl.secteur = s.id "
            . "LEFT JOIN poste po ON pl.poste = po.id "
            . "LEFT JOIN candidat ca ON pl.candidat = ca.id ";

    if (!empty($customer) || !empty($job) || !empty($applicant) || !empty($month)
             || !empty($year) || !empty($consult))
        $sql .= "WHERE ";
    if (!empty($customer))
        $sql .= "cl.id = '" . $customer . "' ";
    if (!empty($customer) && (!empty($job) || !empty($applicant) || !empty($month)
             || !empty($year) || !empty($consult)))
        $sql .= "AND ";
    if (!empty($job))
        $sql .= "po.id = '" . $job . "' ";
    if (!empty($job) && (!empty($applicant) || !empty($month)
             || !empty($year) || !empty($consult)))
        $sql .= "AND ";
    if (!empty($applicant))
        $sql .= "ca.id = '" . $applicant . "' ";
    if (!empty($applicant) && (!empty($month)
             || !empty($year) || !empty($consult)))
        $sql .= "AND ";
    if (!empty($month))
        $sql .= "pl.mois_placement = '" . $month . "' ";
    if (!empty($month) && (!empty($year) || !empty($consult)))
        $sql .= "AND ";
    if (!empty($year))
        $sql .= "pl.annee_placement = '" . $year . "' ";
    if (!empty($year) && (!empty($consult)))
        $sql .= "AND ";
    if (!empty($consult))
        $sql .= "pl.consultant = '" . $consult . "' ";
    
    $sql .= "ORDER BY pl.id";
    //var_dump($sql);die;
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

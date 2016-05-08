<?php

function searchEncaisse($db)
{

    $customer = isset($_GET['input_customer']) ? htmlspecialchars($_GET['input_customer']) : '';
    $ht = $_GET['input_ht'] ? htmlspecialchars($_GET['input_ht']) : '';
    $amount = $_GET['input_amount'] ? htmlspecialchars($_GET['input_amount']) : '';
    $ref_fac = $_GET['input_ref_fac'] ? htmlspecialchars($_GET['input_ref_fac']) : '';
    $ref_paie = $_GET['input_ref_paie'] ? htmlspecialchars($_GET['input_ref_paie']) : '';
    $compta_min = $_GET['input_date_compta_mini'] ? htmlspecialchars($_GET['input_date_compta_mini']) : '';
    $compta_max = $_GET['input_date_compta_maxi'] ? htmlspecialchars($_GET['input_date_compta_maxi']) : '';
    $paie_min = $_GET['input_date_paie_mini'] ? htmlspecialchars($_GET['input_date_paie_mini']) : '';
    $paie_max = $_GET['input_date_paie_maxi'] ? htmlspecialchars($_GET['input_date_paie_maxi']) : '';

    $sql = "SELECT e.id, c.id as idClient, c.nom, e.montant, e.enc_ttc_tot_amount ttc, e.ref_facture, e.ref_paiement, "
            . "e.date_envoi, e.date_paiement, e.placement, e.enc_tva_tot_amount amountTva, e.tva "
            . "FROM encaisse e "
            . "LEFT JOIN client c ON e.client = c.id ";

    if (!empty($customer) || !empty($ht) || !empty($amount) || !empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max) || !empty($paie_min) || !empty($paie_max))
        $sql .= "WHERE ";
    if (!empty($customer))
        $sql .= "client = '" . $customer . "'";
    if (!empty($customer) && (!empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max) || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ref_fac))
        $sql .= "ref_facture like '%" . $ref_fac . "%'";
    if (!empty($ref_fac) && (!empty($ref_paie) || !empty($compta_min) || !empty($compta_max) || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ref_paie))
        $sql .= "ref_paiement like '%" . $ref_paie . "%'";
    if (!empty($ref_paie) && (!empty($compta_min) || !empty($compta_max) || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($compta_min) || !empty($compta_max))
        $sql .= "date_envoi BETWEEN '" . $compta_min . "' AND '" . $compta_max . "'";
    if ((!empty($compta_min) || !empty($compta_max)) && (!empty($amount) || !empty($ht) || !empty($paie_min) || !empty($paie_max)))
        $sql .= " AND ";
    if (!empty($paie_min) || !empty($paie_max))
        $sql .= "date_paiement BETWEEN '" . $paie_min . "' AND '" . $paie_max . "'";
    if ((!empty($paie_min) || !empty($paie_max)) && (!empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ht))
        $sql .= "montant = " . $ht;
    if (!empty($ht) && !empty($amount))
        $sql .= " AND ";
    if (!empty($amount))
        $sql .= "enc_ttc_tot_amount = " . $amount;

    $sql .= " ORDER BY id ";
    //var_dump($sql);die;
    $r_decaisse = $db->prepare($sql);
    $r_decaisse->execute();
    $r = $r_decaisse->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getOneEncaisseById($db, $id)
{
    $sql = "SELECT e.id, c.id idClient, c.nom nomClient, pla.id idPlacement, "
            . "pos.libelle, can.nom nomCandidat, can.prenom prenomCandidat, e.date_envoi, "
            . "e.date_paiement, e.ref_facture, e.ref_paiement, e.mode_paiement, e.montant, "
            . "e.tva, e.enc_ttc_tot_amount, e.enc_tva_tot_amount, e.description "
            . "FROM encaisse e "
            . "LEFT JOIN client c ON c.id = e.client "
            . "LEFT JOIN placement pla ON pla.id = e.placement "
            . "LEFT JOIN poste pos ON pla.poste = pos.id "
            . "LEFT JOIN candidat can ON pla.candidat = can.id "
            . "WHERE e.id='" . $id . "'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetch(PDO::FETCH_OBJ);

    return $r;
}

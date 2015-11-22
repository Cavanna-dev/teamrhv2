<?php

function searchDecaisse($db)
{
    
    //var_dump($_GET);die;
    
    $fourn = $_GET['input_fournisseur'] ? htmlspecialchars($_GET['input_fournisseur']) : '';
    $ht = $_GET['input_ht'] ? htmlspecialchars($_GET['input_ht']) : '';
    $amount = $_GET['input_amount'] ? htmlspecialchars($_GET['input_amount']) : '';
    $ref_fac   = $_GET['input_ref_fac'] ? htmlspecialchars($_GET['input_ref_fac']) : '';
    $ref_paie   = $_GET['input_ref_paie'] ? htmlspecialchars($_GET['input_ref_paie']) : '';
    $compta_min = $_GET['input_date_compta_mini'] ? htmlspecialchars($_GET['input_date_compta_mini']) : '';
    $compta_max = $_GET['input_date_compta_maxi'] ? htmlspecialchars($_GET['input_date_compta_maxi']) : '';
    $paie_min = $_GET['input_date_paie_mini'] ? htmlspecialchars($_GET['input_date_paie_mini']) : '';
    $paie_max = $_GET['input_date_paie_maxi'] ? htmlspecialchars($_GET['input_date_paie_maxi']) : '';
    
    $sql = "SELECT d.id, f.id as idFourn, f.nom, d.ref_facture, d.ref_paiement, d.date_compta, d.date_paiement, "
            . "dec_ht_tot_amount, dec_tva_tot_amount, dec_ttc_tot_amount "
            . "FROM decaisse d "
            . "LEFT JOIN fournisseur f ON d.fournisseur = f.id ";

    if (!empty($fourn) || !empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max)
             || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht))
        $sql .= "WHERE ";
    if (!empty($fourn))
        $sql .= "fournisseur = '".$fourn."'";
    if (!empty($fourn) && (!empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ref_fac))
        $sql .= "ref_facture like '%".$ref_fac."%'";
    if (!empty($ref_fac) && (!empty($ref_paie) || !empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max) || !empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ref_paie))
        $sql .= "ref_paiement like '%".$ref_paie."%'";
    if (!empty($ref_paie) && (!empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max) || !empty($amount)
            || !empty($ht)))
        $sql .= " AND ";
    if (!empty($compta_min) || !empty($compta_max))
        $sql .= "date_compta BETWEEN '".$compta_min."' AND '".$compta_max."'";
    if ((!empty($compta_min) || !empty($compta_max)) 
            && (!empty($amount) || !empty($ht)))
        $sql .= " AND ";
    if (!empty($ht))
        $sql .= "dec_ht_tot_amount = ".$ht;
    if (!empty($ht) && !empty($amount))
        $sql .= " AND ";
    if (!empty($amount))
        $sql .= "dec_ttc_tot_amount = ".$amount;

    $sql .= " ORDER BY date_compta ";
    //var_dump($sql);die;
    $r_decaisse = $db->prepare($sql);
    $r_decaisse->execute();
    $r = $r_decaisse->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getOneDecaisseById($db, $id)
{
    $sql = "SELECT * "
            . "FROM decaisse d "
            . "WHERE d.id='".$id."'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllDDByDecaisseId($db, $id)
{
    $sql = "SELECT * "
            . "FROM decaisse_detail "
            . "WHERE fk_decaisse_id='".$id."'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetchAll(PDO::FETCH_OBJ);

    return $r;
}
<?php

function searchDecaisse($db)
{
    
    //var_dump($_GET);die;
    
    $fourn = $_GET['input_fournisseur'] ? htmlspecialchars($_GET['input_fournisseur']) : '';
    $ref_fac   = $_GET['input_ref_fac'] ? htmlspecialchars($_GET['input_ref_fac']) : '';
    $ref_paie   = $_GET['input_ref_paie'] ? htmlspecialchars($_GET['input_ref_paie']) : '';
    $compta_min = $_GET['input_date_compta_mini'] ? htmlspecialchars($_GET['input_date_compta_mini']) : '';
    $compta_max = $_GET['input_date_compta_maxi'] ? htmlspecialchars($_GET['input_date_compta_maxi']) : '';
    $paie_min = $_GET['input_date_paie_mini'] ? htmlspecialchars($_GET['input_date_paie_mini']) : '';
    $paie_max = $_GET['input_date_paie_maxi'] ? htmlspecialchars($_GET['input_date_paie_maxi']) : '';
    
    $sql = "SELECT d.id, f.nom, d.ref_facture, d.ref_paiement, d.date_compta, d.date_paiement, "
            . "dd.ht_amount, dd.tva_amount, dd.ttc_amount "
            . "FROM decaisse d "
            . "LEFT JOIN fournisseur f ON d.fournisseur = f.id "
            . "INNER JOIN decaisse_detail dd ON d.id = dd.fk_decaisse_id ";

    if (!empty($fourn) || !empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max)
             || !empty($paie_min) || !empty($paie_max))
        $sql .= "WHERE ";
    if (!empty($fourn))
        $sql .= "fournisseur = '".$fourn."'";
    if (!empty($fourn) && (!empty($ref_fac) || !empty($ref_paie) || !empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max)))
        $sql .= " AND ";
    if (!empty($ref_fac))
        $sql .= "ref_facture like '%".$ref_fac."%'";
    if (!empty($ref_fac) && (!empty($ref_paie) || !empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max)))
        $sql .= " AND ";
    if (!empty($ref_paie))
        $sql .= "ref_paiement like '%".$ref_paie."%'";
    if (!empty($ref_paie) && (!empty($compta_min) || !empty($compta_max) 
            || !empty($paie_min) || !empty($paie_max)))
        $sql .= " AND ";
    if (!empty($compta_min) || !empty($compta_max))
        $sql .= "date_compta BETWEEN '".$compta_min."' AND '".$compta_max."'";
    if ((!empty($compta_min) || !empty($compta_max)) && (!empty($paie_min) || !empty($paie_max)))
        $sql .= " AND ";
    if (!empty($paie_min) || !empty($paie_max))
        $sql .= "date_paiement BETWEEN '".$paie_min."' AND '".$paie_max."'";

    $sql .= " ORDER BY date_compta desc";

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
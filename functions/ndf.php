<?php

function searchNdf($db)
{
    
    //var_dump($_GET);die;
    
    $id = $_GET['input_id'] ? htmlspecialchars($_GET['input_id']) : '';
    $month = $_GET['input_month'] ? htmlspecialchars($_GET['input_month']) : '';
    $year = $_GET['input_year'] ? htmlspecialchars($_GET['input_year']) : '';
    $ht = $_GET['input_ht'] ? htmlspecialchars($_GET['input_ht']) : '';
    $ttc = $_GET['input_ttc'] ? htmlspecialchars($_GET['input_ttc']) : '';
    
    $sql = "SELECT ndf.id, ndf.description, ndf.ht_tot_amount, ndf.tva_tot_amount,"
            . "ndf.ttc_tot_amount "
            . "FROM notesfrais ndf ";

    if (!empty($month) || !empty($year) || !empty($id) || !empty($ht) 
            || !empty($ttc))
        $sql .= "WHERE ";
    if (!empty($month))
        $sql .= "mois = '".$month."'";
    if (!empty($month) && (!empty($year) || !empty($id) || !empty($ht) 
            || !empty($ttc) ))
        $sql .= " AND ";
    if (!empty($year))
        $sql .= "annee = '".$year."'";
    if (!empty($year) && (!empty($id) || !empty($ht) 
            || !empty($ttc) ))
        $sql .= " AND ";
    if (!empty($id))
        $sql .= "id = '".$id."'";
    if (!empty($id) && (!empty($ht) || !empty($ttc) ))
        $sql .= " AND ";
    if (!empty($ht))
        $sql .= "ht_tot_amount = '".$ht."'";
    if (!empty($ht) && (!empty($ttc) ))
        $sql .= " AND ";
    if (!empty($ttc))
        $sql .= "ttc_tot_amount = '".$ttc."'";

    $sql .= " GROUP BY id ORDER BY id";
    //var_dump($sql);die;
    $r_decaisse = $db->prepare($sql);
    $r_decaisse->execute();
    $r = $r_decaisse->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getOneNdfById($db, $id)
{
    $sql = "SELECT * "
            . "FROM notesfrais d "
            . "WHERE d.id='".$id."'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllNdfDByNdfId($db, $id)
{
    $sql = "SELECT * "
            . "FROM notesfrais_detail "
            . "WHERE fk_notesfrais_id='".$id."'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetchAll(PDO::FETCH_OBJ);

    return $r;
}
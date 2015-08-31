<?php

function searchNdf($db)
{
    
    //var_dump($_GET);die;
    
    $month = $_GET['input_month'] ? htmlspecialchars($_GET['input_month']) : '';
    $year = $_GET['input_year'] ? htmlspecialchars($_GET['input_year']) : '';
    
    $sql = "SELECT ndf.id, ndf.description, ndf.ht_tot_amount, ndf.tva_tot_amount,"
            . "ndf.ttc_tot_amount "
            . "FROM notesfrais ndf "
            . "LEFT JOIN notesfrais_detail ndfd ON ndf.id = ndfd.fk_notesfrais_id ";

    if (!empty($month) || !empty($year))
        $sql .= "WHERE ";
    if (!empty($month))
        $sql .= "mois = '".$month."'";
    if (!empty($month) && !empty($year))
        $sql .= " AND ";
    if (!empty($year))
        $sql .= "annee like '".$year."'";

    $sql .= " GROUP BY ndf.id ORDER BY ndf.id";
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
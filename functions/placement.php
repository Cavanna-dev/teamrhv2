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

function searchPlacements($db)
{
    $customer = htmlspecialchars($_GET['input_customer']);
    $job = htmlspecialchars($_GET['input_job']);
    $applicant = htmlspecialchars($_GET['input_applicant']);

    $sql = "SELECT pl.id, pl.poste, pl.candidat "
            . "FROM placement pl "
            . "LEFT JOIN client cl ON pl.client = cl.id "
            . "LEFT JOIN poste po ON pl.poste = po.id "
            . "LEFT JOIN candidat ca ON pl.candidat = ca.id ";

    if (!empty($customer) || !empty($job) || !empty($applicant))
        $sql .= "WHERE ";
    if (!empty($customer))
        $sql .= "cl.id = '" . $customer . "' ";
    if (!empty($customer) && (!empty($job) || !empty($applicant)))
        $sql .= "AND ";
    if (!empty($job))
        $sql .= "po.id = '" . $job . "' ";
    if (!empty($job) && !empty($applicant))
        $sql .= "AND ";
    if (!empty($applicant))
        $sql .= "ca.id = '" . $applicant . "' ";
    
    $sql .= "ORDER BY pl.id";
    //var_dump($sql);die;
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

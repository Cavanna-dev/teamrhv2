<?php

function getAllProspect($db)
{
    $sql = "SELECT id, nom "
            . "FROM prospect "
            . "ORDER BY nom";

    $r_prospect = $db->prepare($sql);
    $r_prospect->execute();
    $r = $r_prospect->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getOneProspectById($db, $id)
{
    $sql = "SELECT id, nom, secteur, adresse1, ville, postal, "
            . "country_fk, nationalite, tel_std, url, metro, remarque, "
            . "mngt_law, mngt_supp, status_fk "
            . "FROM prospect "
            . "WHERE id=" . $id;
    $r_prospect = $db->prepare($sql);
    $r_prospect->execute();
    $r = $r_prospect->fetch(PDO::FETCH_OBJ);

    return $r;
}

function searchProspect($db)
{
    $name = htmlspecialchars($_GET['input_name']);
    $zone = htmlspecialchars($_GET['input_zone']);
    $contact_s = htmlspecialchars($_GET['input_contact_supp']);
    $contact_l = htmlspecialchars($_GET['input_contact_law']);
    $nation = htmlspecialchars($_GET['input_nation']);
    $statut = htmlspecialchars($_GET['input_status']);
    $contactName = htmlspecialchars($_GET['input_contact_name']);

    $sql = "SELECT p.id, p.nom, p.secteur, p.mngt_law, p.mngt_supp "
            . "FROM prospect p "
            . "LEFT JOIN contact_prospect cp ON p.id = cp.prospect ";

    if (!empty($name) || !empty($zone) || !empty($nation) || !empty($contact_s) 
            || !empty($contact_l) || !empty($statut) || !empty($contactName))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "p.nom like '%" . $name . "%' ";
    if (!empty($name) && (!empty($zone) || !empty($nation) || !empty($contact_s) || !empty($contact_l) 
            || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($nation))
        $sql .= "p.nationalite = '" . $nation . "' ";
    if (!empty($nation) && (!empty($zone) || !empty($contact_s) || !empty($contact_l) || !empty($statut)
            || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($zone))
        $sql .= "p.secteur = '" . $zone . "' ";
    if (!empty($zone) && (!empty($contact_s) || !empty($contact_l) || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($contact_s))
        $sql .= "p.mngt_supp = '" . $contact_s . "' ";
    if (!empty($contact_s) && (!empty($contact_l) || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($contact_l))
        $sql .= "p.mngt_law = '" . $contact_l . "' ";
    if (!empty($contact_l) && (!empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($statut))
        $sql .= "p.status_fk = '" . $statut . "' ";
    if (!empty($statut) && !empty($contactName))
        $sql .= " AND ";
    if (!empty($contactName)){
        $sql .= "(cp.nom like '%" . $contactName . "%' OR ";
        $sql .= "cp.prenom like '%" . $contactName . "%') ";
    }

    $sql .= "ORDER BY p.nom";

    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getProspectSendCv($db, $candidat, $date)
{
    $sql = "SELECT prospect.id, prospect.nom ";
    $sql .= " FROM prospect, cv_envoye  ";
    $sql .= " WHERE prospect.id = cv_envoye.prospect ";
    $sql .= "   and cv_envoye.date_envoi = '$date' ";
    $sql .= "   and cv_envoye.candidat   = $candidat ";
    $sql .= " ORDER BY 2";

    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

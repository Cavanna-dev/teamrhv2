<?php

function getOneProspectById($db, $id)
{
    $sql = "SELECT id, nom, secteur, adresse1, ville, postal, "
            . "country_fk, nationalite, tel_std, url, metro, remarque, "
            . "mngt_law, mngt_supp, niveau, status_fk "
            . "FROM prospect "
            . "WHERE id=" . $id;
    $r_prospect = $db->prepare($sql);
    $r_prospect->execute();
    $r = $r_prospect->fetch(PDO::FETCH_OBJ);

    return $r;
}

function searchProspect($db)
{
    $name = htmlspecialchars($_POST['input_name']);
    $zone = htmlspecialchars($_POST['input_zone']);
    $contact_s = htmlspecialchars($_POST['input_contact_supp']);
    $contact_l = htmlspecialchars($_POST['input_contact_law']);

    $sql = "SELECT id, nom, secteur, mngt_law, mngt_supp "
            . "FROM prospect ";

    if (!empty($name) || !empty($zone) ||  !empty($contact_s) || !empty($contact_l))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "nom like '%" . $name . "%' ";
    if (!empty($name) && (!empty($zone) || !empty($contact_s) || !empty($contact_l)))
        $sql .= " AND ";
    if (!empty($zone))
        $sql .= "secteur = '" . $zone . "' ";
    if (!empty($zone) && !empty($contact_s))
        $sql .= " AND ";
    if (!empty($contact_s))
        $sql .= "mngt_supp = '" . $contact_s . "' ";
    if (!empty($contact_s) && !empty($contact_l))
        $sql .= " AND ";
    if (!empty($contact_l))
        $sql .= "mngt_law = '" . $contact_l . "' ";

    $sql .= "ORDER BY nom";
    
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

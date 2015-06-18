<?php

function getAllCustomers($db)
{
    $sql = "SELECT id, nom "
            . "FROM client "
            . "ORDER BY nom";

    $r_customer = $db->prepare($sql);
    $r_customer->execute();
    
    return $r_customer;
}

function getOneCustomerById($db, $id)
{
    $sql = "SELECT id, nom, secteur, adresse1, ville, postal, "
            . "country_fk, nationalite, tel_std, url, metro, remarque, "
            . "mngt_law, mngt_supp, status_fk "
            . "FROM client "
            . "WHERE id=" . $id;
    $r_customer = $db->prepare($sql);
    $r_customer->execute();
    $r = $r_customer->fetch(PDO::FETCH_OBJ);

    return $r;
}

function searchCustomers($db)
{
    $name = htmlspecialchars($_GET['input_name']);
    $zone = htmlspecialchars($_GET['input_zone']);
    $nation = htmlspecialchars($_GET['input_nation']);
    $contact_s = htmlspecialchars($_GET['input_contact_supp']);
    $contact_l = htmlspecialchars($_GET['input_contact_law']);

    $sql = "SELECT id, nom, secteur, mngt_law, mngt_supp, tel_std "
            . "FROM client ";

    if (!empty($name) || !empty($zone) || !empty($nation) || !empty($contact_s) || !empty($contact_l))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "nom like '%" . $name . "%' ";
    if (!empty($name) && (!empty($zone) || !empty($nation) || !empty($contact_s) || !empty($contact_l)))
        $sql .= " AND ";
    if (!empty($nation))
        $sql .= "nationalite = '" . $nation . "' ";
    if (!empty($nation) && (!empty($zone) || !empty($contact_s) || !empty($contact_l)))
        $sql .= " AND ";
    if (!empty($zone))
        $sql .= "secteur = '" . $zone . "' ";
    if (!empty($zone) && (!empty($contact_s) || !empty($contact_l)))
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

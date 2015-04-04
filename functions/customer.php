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
            . "country_fk, nationalite, tel_std, fax, url, metro, remarque, "
            . "mngt_law, mngt_supp, status_fk, raison_factu, civilite_factu, nom_factu, prenom_factu, "
            . "titre_factu, adr1_factu, ville_factu, postal_factu, country_factu_fk, tel_factu, fax_factu, email_factu "
            . "FROM client "
            . "WHERE id=" . $id;
    $r_customer = $db->prepare($sql);
    $r_customer->execute();
    $r = $r_customer->fetch(PDO::FETCH_OBJ);

    return $r;
}

function searchCustomers($db)
{
    $name = htmlspecialchars($_POST['input_name']);
    $zone = htmlspecialchars($_POST['input_zone']);
    $nation = htmlspecialchars($_POST['input_nation']);
    $contact_s = htmlspecialchars($_POST['input_contact_supp']);
    $contact_l = htmlspecialchars($_POST['input_contact_law']);

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
    if (!empty($nation) && !empty($zone))
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

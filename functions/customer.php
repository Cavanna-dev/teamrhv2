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
    $statut = htmlspecialchars($_GET['input_statut']);
    $contact_s = htmlspecialchars($_GET['input_contact_supp']);
    $contact_l = htmlspecialchars($_GET['input_contact_law']);
    $contactName = htmlspecialchars($_GET['input_contact_name']);

    $sql = "SELECT c.id, c.nom, c.secteur, c.mngt_law, c.mngt_supp, c.tel_std "
            . "FROM client c "
            . "LEFT JOIN contact co ON co.client = c.id ";

    if (!empty($name) || !empty($zone) || !empty($nation) || !empty($contact_s) 
            || !empty($contact_l) || !empty($statut) || !empty($contactName))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "c.nom like '%" . $name . "%' ";
    if (!empty($name) && (!empty($zone) || !empty($nation) || !empty($contact_s) 
            || !empty($contact_l) || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($nation))
        $sql .= "c.nationalite = '" . $nation . "' ";
    if (!empty($nation) && (!empty($zone) || !empty($contact_s) || !empty($contact_l) 
            || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($zone))
        $sql .= "c.secteur = '" . $zone . "' ";
    if (!empty($zone) && (!empty($contact_s) || !empty($contact_l) 
            || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($contact_s))
        $sql .= "c.mngt_supp = '" . $contact_s . "' ";
    if (!empty($contact_s) && (!empty($contact_l) || !empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($contact_l))
        $sql .= "c.mngt_law = '" . $contact_l . "' ";
    if (!empty($contact_l) && (!empty($statut) || !empty($contactName)))
        $sql .= " AND ";
    if (!empty($statut))
        $sql .= "c.status_fk = '" . $statut . "' ";
    if (!empty($statut) && !empty($contactName))
        $sql .= " AND ";
    if (!empty($contactName)){
        $sql .= "(co.nom like '%" . $contactName . "%' OR ";
        $sql .= "co.prenom like '%" . $contactName . "%') ";
    }
        
    $sql .= "GROUP BY c.id ORDER BY c.nom";
    //var_dump($sql);die;
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getCustomersBySendCvs($db, $applicant, $date)
{
    $sql = " SELECT client.id, client.nom";
    $sql .= " FROM client, cv_envoye ";
    $sql .= " WHERE client.id = cv_envoye.client ";
    $sql .= " and cv_envoye.candidat   = " . $applicant;
    $sql .= " and cv_envoye.date_envoi = '" .$date . "'";
    $sql .= " ORDER BY client.nom";

    $r_customer = $db->prepare($sql);
    $r_customer->execute();

    return $r_customer;
}

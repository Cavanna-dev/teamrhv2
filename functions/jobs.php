<?php

function getAllJobs($db)
{
    $sql = "SELECT p.id, p.libelle, c.nom as 'client' "
            . "FROM poste p "
            . "LEFT JOIN client c ON p.client = c.id "
            . "ORDER BY client";

    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetchAll(PDO::FETCH_OBJ);
    return $r;
    
}

function getJobById($db, $id)
{
    $sql = "SELECT id, client, titre, diplome, experience, libelle, description, "
            . "commentaire, contrat, duree, lieux, salaire, horaires, "
            . "date_deb, vitesse, communication, word, excel, powerpoint, "
            . "internet, autre_appli1, autre_appli2, niveau_fr, niveau_en, "
            . "pourvu, pourcentage, garantie, forfait, formule, consultant, signature "
            . "FROM poste "
            . "WHERE id='" . $id . "'";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getOneJobById($db, $id)
{
    $sql = "SELECT id, client, titre, diplome, experience, libelle, description, "
            . "commentaire, contrat, duree, lieux, salaire, horaires, "
            . "date_deb, vitesse, communication, word, excel, powerpoint, "
            . "internet, autre_appli1, autre_appli2, niveau_fr, niveau_en, "
            . "pourvu, pourcentage, garantie, forfait, formule, consultant, signature "
            . "FROM poste "
            . "WHERE id='" . $id . "'";

    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetch(PDO::FETCH_OBJ);
    return $r;
}

function getJobByCustomer($db, $id)
{
    $sql = "SELECT poste.ID, poste.libelle, candidat.id 'candidat', candidat.prenom, candidat.nom, date_format(date_rdv, '%d/%m/%Y') 'date_rdv'  "
            . "FROM poste "
            . "LEFT JOIN entretien on poste.id = entretien.poste "
            . "LEFT join candidat on entretien.candidat = candidat.id "
            . "WHERE pourvu != 'Y' and poste.client = " .$id. " "
            . "ORDER BY poste.ID, candidat.nom, date_rdv ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function searchJobs($db)
{
    $name = htmlspecialchars($_GET['input_name']);
    $customer = htmlspecialchars($_GET['input_customer']);
    $contact = htmlspecialchars($_GET['input_contact']);

    $sql = "SELECT id, client, titre, libelle, consultant "
            . "FROM poste ";

    if (!empty($name) || !empty($customer) || !empty($contact))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "libelle like '%" . $name . "%' ";
    if (!empty($name) && (!empty($customer) || !empty($contact)))
        $sql .= " AND ";
    if (!empty($customer))
        $sql .= "client = '" . $zone . "' ";
    if (!empty($customer) && !empty($contact))
        $sql .= " AND ";
    if (!empty($contact))
        $sql .= "consultant = '" . $contact . "' ";
    
    $sql .= "ORDER BY libelle";

    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
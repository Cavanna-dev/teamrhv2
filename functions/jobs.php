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
            . "WHERE pourvu != 'Y' and poste.client = " . $id . " "
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
    $statut = htmlspecialchars($_GET['input_pourvu']);

    $sql = "SELECT p.id, p.client as client, c.nom as nom, t.libelle as titre, "
            . "p.libelle as libelle, p.consultant, p.communication as comm "
            . "FROM poste p "
            . "LEFT JOIN client c ON p.client = c.id "
            . "LEFT JOIN titre t ON p.titre = t.id ";

    if (!empty($name) || !empty($customer) || !empty($contact) || !empty($statut))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "libelle like '%" . $name . "%' ";
    if (!empty($name) && (!empty($customer) || !empty($contact) || !empty($statut)))
        $sql .= " AND ";
    if (!empty($customer))
        $sql .= "p.client = '" . $customer . "' ";
    if (!empty($customer) && (!empty($contact) || !empty($statut)))
        $sql .= " AND ";
    if (!empty($contact))
        $sql .= "p.consultant = '" . $contact . "' ";
    if (!empty($contact) && !empty($statut))
        $sql .= " AND ";
    if (!empty($statut))
        $sql .= "p.pourvu = '" . $statut . "' ";

    $sql .= "ORDER BY nom, libelle, titre";
    //var_dump($sql);die;
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getAllJobsSendCv($db)
{
    $sql = " SELECT poste.id, concat(mid(client.nom, 1, 15) , concat(' - ', poste.libelle)) 'nom' ";
    $sql .= " FROM poste, client ";
    $sql .= " WHERE pourvu != 'Y' and client.id = poste.client ";
    $sql .= " ORDER BY 2";

    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getJobSendCv($db, $candidat, $date)
{
    $sql = "SELECT poste.id, concat(mid(client.nom, 1, 15) , concat(' - ', poste.libelle)) 'nom' ";
    $sql .= " FROM poste, client, cv_envoye ";
    $sql .= " WHERE poste.id = cv_envoye.poste and poste.client = client.id ";
    $sql .= "   and cv_envoye.candidat   = $candidat ";
    $sql .= "   and cv_envoye.date_envoi = '$date' ";
    $sql .= " ORDER BY 2";
    
    $r_job = $db->prepare($sql);
    $r_job->execute();
    $r = $r_job->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

?>
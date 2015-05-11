<?php

function searchApplicant($db)
{
    $name = $_GET['input_name'] ? htmlspecialchars($_GET['input_name']) : '';
    $first = $_GET['input_first'] ? htmlspecialchars($_GET['input_first']) : '';

    $sql = "SELECT c.id as id, c.nom as nom, c.prenom as prenom, c.email as email, e.id as eval_id "
            . "FROM candidat c "
            . "LEFT JOIN evaluation e ON e.candidat = c.id ";

    if (!empty($name) || !empty($first))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "c.NOM LIKE '%" . $name . "%'";
    if (!empty($name) && !empty($first))
        $sql .= " AND ";
    if (!empty($first))
        $sql .= "c.prenom LIKE '%" . $first . "%'";

    $sql .= " ORDER BY nom";
    
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getAllApplicants($db)
{
    $sql = "SELECT c.id as id, c.nom as nom, c.nom as prenom, e.id as eval_id "
            . "FROM `candidat` c "
            . "LEFT JOIN evaluation e ON e.candidat = c.id";

    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    
    return $r_applicant;
}

function getOneApplicantById($db, $id)
{
    $sql = "SELECT c.id, c.nom, c.prenom, c.naissance, c.sexe, c.statut, c.nationalite, c.adresse1, c.ville, c.postal, "
            . "c.country_fk, c.metro, c.tel_bureau, c.tel_perso, c.tel_port, c.email, c.media, c.refus, c.motif, c.anniversaire, e.id as eval_id "
            . "FROM candidat c "
            . "LEFT JOIN evaluation e ON e.candidat = c.id "
            . "WHERE c.id='" . $id . "'";
    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    $r = $r_applicant->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>
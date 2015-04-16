<?php

function searchApplicant($db)
{
    $name = htmlspecialchars($_GET['input_name']) ? htmlspecialchars($_GET['input_name']) : '';
    $first = htmlspecialchars($_GET['input_first']) ? htmlspecialchars($_GET['input_first']) : '';

    $sql = "SELECT c.id as id, c.nom as nom, c.prenom as prenom, c.email as email, e.id as eval_id "
            . "FROM candidat c "
            . "LEFT JOIN evaluation e ON e.candidat = c.id ";

    if (!empty($name) || !empty($first))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "c.nom like '%" . $name . "%'";
    if (!empty($name) && !empty($first))
        $sql .= " AND ";
    if (!empty($first))
        $sql .= "c.prenom like '%" . $first . "%'";

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
    $sql = "SELECT id, nom, prenom, naissance, sexe, statut, nationalite, adresse1, ville, postal, "
            . "country_fk, metro, tel_bureau, tel_perso, tel_port, email, media, refus, motif, anniversaire "
            . "FROM candidat "
            . "WHERE id='" . $id . "'";
    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    $r = $r_applicant->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>
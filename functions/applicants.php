<?php

function searchApplicant($db)
{
    $name = htmlspecialchars($_POST['input_name']);
    $mail = htmlspecialchars($_POST['input_email']);

    $sql = "SELECT id, nom, prenom, email "
            . "FROM candidat ";

    if (!empty($name) || !empty($mail))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "nom like '%" . $name . "%'";
    if (!empty($name) && !empty($mail))
        $sql .= " AND ";
    if (!empty($mail))
        $sql .= "email like '%" . $mail . "%'";

    $sql .= " ORDER BY nom";
    //var_dump($sql);die;
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getOneApplicantById($db, $id)
{
    $sql = "SELECT id, nom, prenom, naissance, sexe, statut, nationalite, adresse1, ville, postal, "
            . "country_fk, metro, tel_bureau, tel_perso, tel_port, email, media, refus, motif "
            . "FROM candidat "
            . "WHERE id='" . $id . "'";
    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    $r = $r_applicant->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>
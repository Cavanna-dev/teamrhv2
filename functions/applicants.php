<?php

function searchApplicant($db)
{
    $name = $_GET['input_name'] ? htmlspecialchars($_GET['input_name']) : '';
    $first = $_GET['input_first'] ? htmlspecialchars($_GET['input_first']) : '';

    $sql = "SELECT c.id as id, c.nom as nom, c.prenom as prenom, c.naissance as naissance, "
            . "c.email as email, e.id as eval_id, e.remarque 'remarque_eval',"
            . "e.sal_min_rech salaire, e.langue langue "
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

function getAllBirthdaysApplicants($db)
{
    $sql = "SELECT id, nom, prenom, anniversaire, email "
            . "FROM `candidat` "
            . "WHERE dayofyear(naissance) - dayofyear(NOW()) = 0 "
            . "OR dayofyear(naissance) + 365 - dayofyear(NOW()) = 0";

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

function getRdvsByApplicant($db, $id)
{
    $sql = " SELECT entretien.ID 'ID',  date_rdv, numero_rdv, client.nom 'societe', client.id 'id_client'";
    $sql .= " FROM entretien, candidat, client";
    $sql .= " WHERE entretien.candidat  = " . $id;
    $sql .= "   and entretien.candidat =  candidat.id";
    $sql .= "   and entretien.client = client.id";
    $sql .= "   and date_rdv > date_sub(now(), interval 6 month)";
    $sql .= " ORDER BY date_rdv DESC, client.nom";

    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    $r = $r_applicant->fetchAll(PDO::FETCH_OBJ);

    return $r;
}

function getComByApplicant($db, $id)
{
    $sql = " SELECT id, CANDIDAT, MID(remarque, 1, 200) 'remarque', CREATION, DATE_FORMAT(CREATION,'%d/%m/%Y') 'creation_format'";
    $sql .= " FROM COMMENTAIRE";
    $sql .= " WHERE CANDIDAT = " . $id;
    $sql .= " ORDER BY CREATION DESC";

    $r_coms = $db->prepare($sql);
    $r_coms->execute();
    $r = $r_coms->fetchAll(PDO::FETCH_OBJ);
    return $r;
}

function getOneApplicantComById($db, $id)
{
    $sql = "SELECT id, candidat, remarque, creation "
            . "FROM commentaire "
            . "WHERE id=" . $id;
    $r_com = $db->prepare($sql);
    $r_com->execute();
    $r = $r_com->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getCvsSendByApplicant($db, $id)
{
    $sql = "SELECT 1, cv_envoye.ID, cv_envoye.DATE_ENVOI 'date_ordre', DATE_FORMAT(cv_envoye.DATE_ENVOI,'%d/%m/%Y') 'date_envoi', ";
    $sql .= "  client.nom 'nom_client', client.id 'id_client', null 'libelle_poste', null 'id_poste',  null 'nom_prospect', ";
    $sql .= "  null 'id_prospect' ";
    $sql .= "FROM cv_envoye, client ";
    $sql .= "WHERE cv_envoye.candidat = " . $id;
    $sql .= "  and cv_envoye.client = client.id ";
    $sql .= "  and cv_envoye.poste is null ";
    $sql .= "  and cv_envoye.prospect is null ";
    $sql .= "UNION ";
    $sql .= "SELECT 2, cv_envoye.ID, cv_envoye.DATE_ENVOI 'date_ordre', DATE_FORMAT(cv_envoye.DATE_ENVOI,'%d/%m/%Y') 'date_envoi', ";
    $sql .= "  client.nom 'nom_client', client.id 'id_client', poste.libelle 'libelle_poste', poste.id 'id_poste', ";
    $sql .= "  null 'nom_prospect', null 'id_prospect' ";
    $sql .= "FROM cv_envoye, poste, client ";
    $sql .= "WHERE cv_envoye.poste = poste.id ";
    $sql .= "  and cv_envoye.candidat = " . $id;
    $sql .= "  and poste.client = client.id ";
    $sql .= "UNION ";
    $sql .= "SELECT 3, cv_envoye.ID, cv_envoye.DATE_ENVOI 'date_ordre', DATE_FORMAT(cv_envoye.DATE_ENVOI,'%d/%m/%Y') 'date_envoi', ";
    $sql .= "  null 'nom_client', null 'id_client', null 'libelle_poste', null 'id_poste', prospect.nom 'nom_prospect',";
    $sql .= "  prospect.id'id_prospect' ";
    $sql .= "FROM cv_envoye, prospect ";
    $sql .= "WHERE cv_envoye.candidat = " . $id;
    $sql .= "  and cv_envoye.prospect = prospect.id ";
    $sql .= "  and cv_envoye.poste is null ";
    $sql .= "  and cv_envoye.client is null ";
    $sql .= "ORDER BY 3 DESC, 1";
    
    $r_applicant = $db->prepare($sql);
    $r_applicant->execute();
    $r = $r_applicant->fetchAll(PDO::FETCH_ASSOC);

    return $r;
}

?>
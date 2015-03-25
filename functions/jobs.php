<?php

function getJobById($db, $id)
{
    $sql = "SELECT id, client, titre, diplome, libelle, description, "
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

?>
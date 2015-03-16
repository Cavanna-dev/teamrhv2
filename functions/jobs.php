<?php

function getJobById($db, $id)
{
    $sql = "SELECT id, client, titre, diplome, libelle, description, "
            . "commentaire, contrat, duree, lieux, salaire, horaires, "
            . "date_deb, vitesse, communication, word, excel, powerpoint, "
            . "internet, autre_appli1, autre_appli2, niveau_fr, niveau_en, "
            . "pourvu, pourcentage, garantie, forfait, formule, consultant, signature "
            . "FROM poste "
            . "WHERE id='".$id."'";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
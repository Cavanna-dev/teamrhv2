<?php

function getOneDiplomeById($db, $id)
{
    $sql = "SELECT id, libelle "
            . "FROM diplome "
            . "WHERE id='" . $id . "'";
    $r_zone = $db->prepare($sql);
    $r_zone->execute();
    $r = $r_zone->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllDiplomes($db)
{
    $sql = "SELECT id, libelle, groupe, niveau, ordre "
            . "FROM diplome";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
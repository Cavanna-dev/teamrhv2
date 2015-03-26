<?php

function getOneZoneById($db, $id)
{
    $sql = "SELECT id, libelle "
            . "FROM secteur "
            . "WHERE id='" . $id . "'";
    $r_zone = $db->prepare($sql);
    $r_zone->execute();
    $r = $r_zone->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllZones($db)
{
    $sql = "SELECT id, libelle "
            . "FROM secteur";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
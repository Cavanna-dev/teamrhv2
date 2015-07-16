<?php

function getOneFournById($db, $id)
{
    $sql = "SELECT id, nom "
            . "FROM fournisseur "
            . "WHERE id='" . $id . "'";
    $r_zone = $db->prepare($sql);
    $r_zone->execute();
    $r = $r_zone->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllFourns($db)
{
    $sql = "SELECT id, nom "
            . "FROM fournisseur "
            . "ORDER BY nom";
    $r_fourn = $db->prepare($sql);
    $r_fourn->execute();
    $r = $r_fourn->fetchAll(PDO::FETCH_OBJ);

    return $r;
}
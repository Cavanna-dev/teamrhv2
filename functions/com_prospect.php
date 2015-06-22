<?php

function getComByProspect($db, $id)
{
    $sql = "SELECT id, prospect, mid(remarque, 1, 100) 'remarque', creation "
            . "FROM commentaire_prospect "
            . "WHERE prospect = " . $id . " "
            . "ORDER BY creation DESC";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getAllComByProspect($db, $id)
{
    $sql = "SELECT id, prospect, remarque, creation "
            . "FROM commentaire_prospect "
            . "WHERE prospect = " . $id . " "
            . "ORDER BY creation DESC";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getOneProspectComById($db, $id)
{
    $sql = "SELECT id, prospect, remarque, creation "
            . "FROM commentaire_prospect "
            . "WHERE id=" . $id;
    $r_com_prospect = $db->prepare($sql);
    $r_com_prospect->execute();
    $r = $r_com_prospect->fetch(PDO::FETCH_OBJ);

    return $r;
}

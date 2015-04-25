<?php

function getOneTitleById($db, $id)
{
    $sql = "SELECT id, libelle "
            . "FROM titre "
            . "WHERE id='" . $id . "'";
    $r_title = $db->prepare($sql);
    $r_title->execute();
    $r = $r_title->fetch(PDO::FETCH_OBJ);

    return $r;
}

function getAllTitles($db)
{
    $sql = "SELECT id, libelle "
            . "FROM titre " 
            . "ORDER BY libelle";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
<?php


function getOneRdvById($db, $id)
{
    $sql = "SELECT * "
            . "FROM resa_salle "
            . "WHERE id='".$id."'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetch(PDO::FETCH_OBJ);

    return $r;
}
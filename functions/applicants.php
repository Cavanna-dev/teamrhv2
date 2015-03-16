<?php

function getApplicantById($db, $id)
{
    $sql = "SELECT id, nom, prenom "
            . "FROM candidat "
            . "WHERE id='".$id."'";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
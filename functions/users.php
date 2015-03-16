<?php

function getAllUsers($db)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE actif='Y' AND (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC')";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getUserById($db, $id)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC') AND id='" . $id . "'";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

?>
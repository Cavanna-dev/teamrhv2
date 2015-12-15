<?php

function getAllUsers($db)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE actif='Y' AND (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC'"
            . "or type = 'ASSIST')"
            . "ORDER BY sorting";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getAllConsults($db)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE type IN ('CONSULT','ADMIN','ASSOC')"
            . "ORDER BY sorting";
    $r = $db->prepare($sql);
    $r->execute();
    $tmp = $r->fetchAll(PDO::FETCH_OBJ);

    return $tmp;
}

function getUserById($db, $id)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC') AND id='" . $id . "'";
    $r_user = $db->prepare($sql);
    $r_user->execute();
    $r = $r_user->fetch(PDO::FETCH_OBJ);

    return $r;
}


function getAllImportantUsers($db)
{
    $sql = "SELECT id, nom, prenom, login, pwd, type, actif, color, arrival, sorting, initiale "
            . "FROM utilisateur "
            . "WHERE actif='Y' AND (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC')"
            . "ORDER BY sorting";
    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}


?>
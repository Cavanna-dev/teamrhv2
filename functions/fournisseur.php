<?php

function getOneFournById($db, $id)
{
    $sql = "SELECT id, nom, secteur, url, remarque, adresse1, postal, ville, "
            . "country_fk, metro, tel_std "
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

function searchFourn($db)
{
    $name = htmlspecialchars($_GET['input_name']);
    $zone = htmlspecialchars($_GET['input_zone']);
    $remarque = htmlspecialchars($_GET['input_remarque']);

    $sql = "SELECT f.id, f.nom, f.secteur, f.url, f.remarque "
            . "FROM fournisseur f ";

    if (!empty($name) || !empty($zone) || !empty($remarque))
        $sql .= "WHERE ";
    if (!empty($name))
        $sql .= "f.nom like '%" . $name . "%' ";
    if (!empty($name) && (!empty($zone) || !empty($remarque)))
        $sql .= " AND ";
    if (!empty($zone))
        $sql .= "f.secteur = '" . $zone . "' ";
    if (!empty($zone) && (!empty($remarque)))
        $sql .= " AND ";
    if (!empty($remarque))
        $sql .= "f.remarque like '%" . $remarque . "%' ";

    $sql .= "ORDER BY f.nom";

    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

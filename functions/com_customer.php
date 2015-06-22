<?php

function getComByCustomer($db, $id)
{
    $sql = "SELECT id, client, mid(remarque, 1, 100) 'remarque', creation "
            . "FROM commentaire_client "
            . "WHERE client = " . $id . " "
            . "ORDER BY creation desc";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}

function getOneCustomerComById($db, $id)
{
    $sql = "SELECT id, client, remarque, creation "
            . "FROM commentaire_client "
            . "WHERE id=" . $id;
    $r_com_prospect = $db->prepare($sql);
    $r_com_prospect->execute();
    $r = $r_com_prospect->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>
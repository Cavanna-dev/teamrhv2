<?php

function getContactByClientId($db, $type, $id)
{
    $sql = "SELECT ID, civilite, nom, prenom, tel, fonction, type, email "
            . "FROM contact "
            . "WHERE client = '".$id."' and type = '".$type."' and ifnull(inactif, 'N') <> 'Y' "
            . "ORDER BY nom ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}


?>
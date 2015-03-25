<?php

function getContactByClientId($db, $type, $id)
{
    $sql = "SELECT ID, civilite, nom, prenom, tel, fonction, type, email "
            . "from contact "
            . "where client = '".$id."' and type = '".$type."' and ifnull(inactif, 'N') <> 'Y' "
            . "order by nom ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}


?>
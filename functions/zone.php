<?php

function getAllZones($db)
{
    $sql = "SELECT id, libelle "
            . "FROM secteur";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

?>
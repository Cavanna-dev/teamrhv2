<?php

function getAllMedias($db)
{
    $sql = "SELECT id, libelle "
            . "FROM media "
            . "ORDER BY libelle";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

 ?>

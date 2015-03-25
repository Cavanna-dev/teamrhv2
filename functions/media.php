<?php

function getAllMedias($db)
{
    $sql = "SELECT id, libelle "
            . "FROM media";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}
 ?>

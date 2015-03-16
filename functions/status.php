<?php

function getAllStatus($db)
{
    $sql = "SELECT id, status "
            . "FROM status";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

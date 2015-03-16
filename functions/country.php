<?php

function getAllCountries($db)
{
    $sql = "SELECT CNT_ID_PK id, CNTL_NAME name "
            . "FROM vw_countries_fr";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

<?php

function getSendCvByCustomer($db, $id){
    $sql = "SELECT id, consultant, date_envoi, candidat, client, poste "
            . "FROM cv_envoye "
            . "WHERE client='".$id."' AND date_envoi >= date_sub(now(), interval 6 month)";

    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

?>
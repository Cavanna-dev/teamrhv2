<?php

function getSendCvByCustomer($db, $id){
    $sql = "SELECT id, consultant, date_envoi, candidat, client, poste "
            . "FROM cv_envoye "
            . "WHERE client='".$id."' AND date_envoi BETWEEN '".date('Y-m-d', strtotime('-4 MONTH'))."' AND '".date('Y-m-d')."'";

    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

?>
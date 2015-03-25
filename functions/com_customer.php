<?php

function getComByCustomer($db, $id)
{
    $sql = "SELECT ID, client, mid(remarque, 1, 200) 'remarque', creation, DATE_FORMAT(CREATION,'%d/%m/%Y') 'creation_format' "
	."FROM commentaire_client "
	."WHERE client = " . $id  . " "
        ."ORDER BY creation desc ";

    $r = $db->prepare($sql);
    $r->execute();
    return $r;
}
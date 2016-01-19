<?php

include '../functions/connection_db.php';

$sql = "SELECT c.id, CONCAT(c.nom, ' ', c.prenom) as text "
        . "FROM candidat c ";
$sql .= "WHERE ";
$sql .= "c.nom like '%" . $_GET["q"] . "%' ";
$sql .= "ORDER BY c.nom";
$r = $db->prepare($sql);
$r->execute();
$result_search = $r->fetchAll(PDO::FETCH_ASSOC);

$tmp = array();
foreach ($result_search as $v) {
    $tmp[] = $v;
}

echo json_encode($tmp);
?>
<?php

include '../functions/connection_db.php';

$sql = "SELECT p.id, p.libelle as text "
        . "FROM poste p ";
$sql .= "WHERE ";
$sql .= "p.libelle like '%" . $_GET["q"] . "%' ";
$sql .= "ORDER BY p.libelle";
$r = $db->prepare($sql);
$r->execute();
$result_search = $r->fetchAll(PDO::FETCH_ASSOC);

$tmp = array();
foreach ($result_search as $v) {
    $tmp[] = $v;
}

echo json_encode($tmp);
?>
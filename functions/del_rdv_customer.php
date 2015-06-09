<?php

include './connection_db.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    $sql = "DELETE FROM `entretien` WHERE id=".$id;		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../client/agenda.php?delRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
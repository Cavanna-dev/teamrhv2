<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "DELETE FROM `resa_salle` WHERE id=:input_id";		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../index.php?delRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
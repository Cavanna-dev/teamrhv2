<?php

include './connection_db.php';

$id = htmlspecialchars($_POST['input_id']);
$remarque = $_POST['remarque'];
$prospect_id = htmlspecialchars($_POST['input_id_prospect']);

try{
$sql = "UPDATE commentaire_prospect SET "
        . "remarque = :remarque "
        . "WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':remarque', $remarque, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location:../prospect/upd_prospect.php?id='.$prospect_id.'&success');

} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
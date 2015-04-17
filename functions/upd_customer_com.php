<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE commentaire_client SET "
            . "remarque = :remarque "
            . "WHERE id = :input_id "
            . "AND client = :input_id_customer";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../client/upd_client.php?id=' . $array_value[':input_id_customer'] . '&success');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
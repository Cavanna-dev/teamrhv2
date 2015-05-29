<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `commentaire_client` "
            . "(`ID`, `CLIENT`, `REMARQUE`) "
            . "VALUES (NULL,:input_id_client,:remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../client/upd_client.php?id=' . $array_value[':input_id_client'] . '&success=newcom');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
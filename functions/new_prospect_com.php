<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `commentaire_prospect` "
            . "(`ID`, `PROSPECT`, `REMARQUE`) "
            . "VALUES (NULL,:input_id_prospect,:remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../prospect/upd_prospect.php?id=' . $array_value[':input_id_prospect'] . '&success=newcom');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
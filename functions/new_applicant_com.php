<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `commentaire` "
            . "(`CANDIDAT`, `REMARQUE`) "
            . "VALUES (:input_id_applicant,:remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../candidat/upd_applicant.php?id=' . $array_value[':input_id_applicant'] . '&newcom');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
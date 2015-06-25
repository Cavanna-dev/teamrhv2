<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE commentaire SET "
            . "remarque = :remarque "
            . "WHERE id = :input_id "
            . "AND candidat = :input_id_applicant";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../candidat/upd_applicant.php?id=' . $array_value[':input_id_applicant'] . '&comupd');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
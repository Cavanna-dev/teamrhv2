<?php

try {
    $sql = "SELECT id, status "
            . "FROM status";
    $r_status = $db->prepare($sql);
    $r_status->execute();
} catch (PDOException $e) {
    header('Location:index.php');
}
?>
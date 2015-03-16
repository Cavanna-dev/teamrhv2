<?php

try {
    $sql = "SELECT id, libelle "
            . "FROM secteur";
    $r_zones = $db->prepare($sql);
    $r_zones->execute();
} catch (PDOException $e) {
    header('Location:index.php');
}
?>
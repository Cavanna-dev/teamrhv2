<?php

try {
    $sql = "SELECT id, nom, prenom "
            . "FROM utilisateur "
            . "WHERE (type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC') AND actif='Y'";
    $users_r = $db->prepare($sql);
    $users_r->execute();
} catch (PDOException $e) {
    header('Location:homePageCarousel.php');
}
?>
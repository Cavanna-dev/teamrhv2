<?php

try {
    $sql = "SELECT CNT_ID_PK id, CNTL_NAME name "
            . "FROM vw_countries_fr";
    $countries_r = $db->prepare($sql);
    $countries_r->execute();
} catch (PDOException $e) {
    header('Location:homePageCarousel.php');
}
?>
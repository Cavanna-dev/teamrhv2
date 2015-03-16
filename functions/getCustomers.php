<?php

$name = htmlspecialchars($_POST['inputName']);
$country = htmlspecialchars($_POST['inputCountry']);
$contact_s = htmlspecialchars($_POST['inputContactSupp']);
$contact_l = htmlspecialchars($_POST['inputContactLaw']);

try {
    $sql = "SELECT id, nom, mngt_law, mngt_supp, tel_std "
            . "FROM client ";
    
    if(!empty($name) || !empty($country) || !empty($contact_s) || !empty($contact_l)) $sql .= "WHERE ";
    if(!empty($name)) $sql .= "nom like '".$name."%' ";
    if(!empty($name)) $sql .= " AND ";
    if(!empty($country)) $sql .= "country_fk = '".$country."' ";
    if(!empty($country) && !empty($contact_s)) $sql .= " AND ";
    if(!empty($contact_s)) $sql .= "mngt_supp = '".$contact_s."' ";    
    if(!empty($contact_l)) $sql .= "AND mngt_law = '".$contact_l."' ";    

    $sql .= "ORDER BY nom";
    
    $customers_r = $db->prepare($sql);
    $customers_r->execute();
} catch (PDOException $e) {
    header('Location:homePageCarousel.php');
}
?>
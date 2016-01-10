<?php

include './connection_db.php';

$array_post = array();
foreach($_POST as $key => $value):
    $array_post[":".$key] = $value;
endforeach;
//var_dump($array_post);die;

try{
$sql = "UPDATE poste SET "
        . "client = :input_customer, " 
        . "titre = :input_title, " 
        . "diplome = :input_diplome, " 
        . "experience = :input_exp, " 
        . "libelle = :input_name, " 
        . "description = :input_description, " 
        . "commentaire = :input_commentaire, " 
        . "contrat = :input_contrat, " 
        . "duree = :input_period, " 
        . "lieux = :input_place, " 
        . "salaire = :input_salary, " 
        . "horaires = :input_schedule, " 
        . "date_deb = :input_starting_date, "
        . "vitesse = :input_speed, " 
        . "communication = :input_communication, "
        . "autre_appli1 = :input_appli_1, " 
        . "autre_appli2 = :input_appli_2, " 
        . "niveau_fr = :input_fr, " 
        . "niveau_en = :input_an, " 
        . "pourvu = :input_pourvu, " 
        . "pourcentage = :input_percent, " 
        . "garantie = :input_garantie, " 
        . "forfait = :input_forfait, " 
        . "forfait2 = :input_forfait2, " 
        . "forfait3 = :input_forfait3, " 
        . "formule = :input_formule, " 
        . "consultant = :input_contact, " 
        . "signature = :input_signature " 
        . "WHERE id = :input_id"; 
$stmt = $db->prepare($sql);

$r = $stmt->execute($array_post);

header('Location:../client/upd_job.php?id='.$array_post[':input_id'].'&success');

} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
<?php

include './connection_db.php';

$name = htmlspecialchars($_POST['input_name']);
$last = htmlspecialchars($_POST['input_last']);
$birthday = htmlspecialchars($_POST['input_birthday']);
$sexe = htmlspecialchars($_POST['input_sexe']);
$statut = htmlspecialchars($_POST['input_civil']);
$nationalite = htmlspecialchars($_POST['input_nation']);
$adresse1 = htmlspecialchars($_POST['input_address']);
$ville = htmlspecialchars($_POST['input_town']);
$postal = htmlspecialchars($_POST['input_postal']);
$country_fk = htmlspecialchars($_POST['input_country']);
$metro = htmlspecialchars($_POST['input_subway']);
$tel_bureau = htmlspecialchars($_POST['input_phone_work']);
$tel_perso = htmlspecialchars($_POST['input_phone_home']);
$tel_port = htmlspecialchars($_POST['input_phone_port']);
$email = htmlspecialchars($_POST['input_email']);
$media = htmlspecialchars($_POST['input_media']);
$refus = htmlspecialchars($_POST['input_refusal']);
$motif = htmlspecialchars($_POST['input_why_refusal']);
$mail_birthday = htmlspecialchars($_POST['input_mail_birthday']);

try {
    $sql = "INSERT INTO `candidat`"
            . "(`ID`, `NOM`, `PRENOM`, `NAISSANCE`, `SEXE`, `STATUT`, `NATIONALITE`, "
            . "`ADRESSE1`, `ADRESSE2`, `VILLE`, `POSTAL`, `COUNTRY_FK`, `METRO`, "
            . "`TEL_BUREAU`, `TEL_PERSO`, `TEL_PORT`, `EMAIL`, `MEDIA`, "
            . "`REFUS`, `MOTIF`, `ANNIVERSAIRE`, `CREATION`) "
            . "VALUES "
            . "(null, :name, :last, :birthday, :sexe, :statut, :nation, :addr, '', :town, :postal, "
            . ":country_fk, :metro, :phone_work, :phone_home, :phone_port, :email, :media, "
            . ":refus, :motif, :anniversaire, ".date('Y-m-d').")";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':last', $last, PDO::PARAM_STR);
    $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $stmt->bindParam(':sexe', $sexe, PDO::PARAM_STR);
    $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindParam(':nation', $nationalite, PDO::PARAM_STR);
    $stmt->bindParam(':addr', $adresse1, PDO::PARAM_STR);
    $stmt->bindParam(':town', $ville, PDO::PARAM_STR);
    $stmt->bindParam(':postal', $postal, PDO::PARAM_STR);
    $stmt->bindParam(':country_fk', $country_fk, PDO::PARAM_INT);
    $stmt->bindParam(':metro', $metro, PDO::PARAM_STR);
    $stmt->bindParam(':phone_work', $tel_bureau, PDO::PARAM_STR);
    $stmt->bindParam(':phone_home', $tel_perso, PDO::PARAM_STR);
    $stmt->bindParam(':phone_port', $tel_port, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':media', $media, PDO::PARAM_INT);
    $stmt->bindParam(':refus', $refus, PDO::PARAM_STR);
    $stmt->bindParam(':motif', $motif, PDO::PARAM_STR);
    $stmt->bindParam(':anniversaire', $mail_birthday, PDO::PARAM_STR);
    $stmt->execute();
    
    header('Location:../candidat/applicant.php');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
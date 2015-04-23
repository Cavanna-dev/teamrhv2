<?php

include './connection_db.php';

$name = isset($_POST['input_name']) ? htmlspecialchars($_POST['input_name']) : '';
$last = isset($_POST['input_last']) ? htmlspecialchars($_POST['input_last']) : '';
$birthday = isset($_POST['input_birthday']) ? htmlspecialchars($_POST['input_birthday']) : '';
$sexe = isset($_POST['input_sexe']) ? htmlspecialchars($_POST['input_sexe']) : '';
$statut = isset($_POST['input_civil']) ? htmlspecialchars($_POST['input_civil']) : '';
$nationalite = isset($_POST['input_nation']) ? htmlspecialchars($_POST['input_nation']) : '';
$adresse1 = isset($_POST['input_address']) ? htmlspecialchars($_POST['input_address']) : '';
$ville = isset($_POST['input_town']) ? htmlspecialchars($_POST['input_town']) : '';
$postal = isset($_POST['input_postal']) ? htmlspecialchars($_POST['input_postal']) : '';
$country_fk = isset($_POST['input_country']) ? htmlspecialchars($_POST['input_country']) : '';
$metro = isset($_POST['input_subway']) ? htmlspecialchars($_POST['input_subway']) : '';
$tel_bureau = isset($_POST['input_phone_work']) ? htmlspecialchars($_POST['input_phone_work']) : '';
$tel_perso = isset($_POST['input_phone_home']) ? htmlspecialchars($_POST['input_phone_home']) : '';
$tel_port = isset($_POST['input_phone_port']) ? htmlspecialchars($_POST['input_phone_port']) : '';
$email = isset($_POST['input_email']) ? htmlspecialchars($_POST['input_email']) : '';
$media = isset($_POST['input_media']) ? htmlspecialchars($_POST['input_media']) : '';
$refus = isset($_POST['input_refusal']) ? htmlspecialchars($_POST['input_refusal']) : '';
$motif = isset($_POST['input_why_refusal']) ? htmlspecialchars($_POST['input_why_refusal']) : '';
$mail_birthday = isset($_POST['input_mail_birthday']) ? htmlspecialchars($_POST['input_mail_birthday']) : '';

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
    
    header('Location:../candidat/applicant.php?success=c');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
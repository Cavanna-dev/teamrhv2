<?php

include './connection_db.php';

$id_applicant = htmlspecialchars($_POST['input_id']);

//var_dump($_FILES);die;
/**
 * Traitement de sauvegarde des CVs Perso
 */
if ($_FILES['input_cv_perso']['error'] == 0) {
    $uploaddir = 'Perso/';
    $uploadfile_perso = $uploaddir . 'Perso' . $id_applicant . '.doc';
    $real_path = 'C:/T/Candidat/';
    
    if (move_uploaded_file($_FILES['input_cv_perso']['tmp_name'], $real_path . $uploadfile_perso)) {
        echo "Le fichier CV_Perso est valide, et a été téléchargé avec succès.\n";
    } else {
        die('Problème de transfert avec le CV_Perso. Veuillez réessayez plus tard.\n');
    }
}
/**
 * Traitement de sauvegarde des CVs TeamRH
 */
if ($_FILES['input_cv_teamrh']['error'] == 0) {
    $uploaddir = 'Teamrh/';
    $uploadfile_teamrh = $uploaddir . 'Teamrh' . $id_applicant . '.doc';
    $real_path = 'C:/T/Candidat/';
        
    if (move_uploaded_file($_FILES['input_cv_teamrh']['tmp_name'], $real_path . $uploadfile_teamrh)) {
        echo "Le fichier CV_TEAMRH est valide, et a été téléchargé
           avec succès.\n";
    } else {
        die('Problème de transfert avec le CV_TeamRH. Veuillez réessayez plus tard.\n');
    }
}

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
    $sql = "UPDATE candidat SET "
            . "nom = :name, "
            . "prenom = :last, "
            . "naissance = :birthday, "
            . "sexe = :sexe, "
            . "statut = :statut, "
            . "nationalite = :nation, "
            . "adresse1 = :addr, "
            . "ville = :town, "
            . "postal = :postal, "
            . "country_fk = :country_fk, "
            . "metro = :metro, "
            . "tel_bureau = :phone_work, "
            . "tel_perso = :phone_home, "
            . "tel_port = :phone_port, "
            . "email = :email, "
            . "media = :media, "
            . "refus = :refus, "
            . "motif = :motif, "
            . "path_cv_perso = '" . $uploadfile_perso . "', "
            . "path_cv_teamrh = '" . $uploadfile_teamrh . "', "
            . "anniversaire = :anniversaire "
            . "WHERE id = :id_applicant";
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
    $stmt->bindParam(':id_applicant', $id_applicant, PDO::PARAM_INT);
    $stmt->execute();

    header('Location:../candidat/upd_applicant.php?id=' . $_POST['input_id'] . '');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
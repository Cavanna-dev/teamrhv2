<?php

include './connection_db.php';

try{
$sql = "UPDATE client SET "
        . "nom = :name, "
        . "secteur = :zone, "
        . "adresse1 = :addr, "
        . "ville = :town, "
        . "postal = :postal, "
        . "country_fk = :country, "
        . "nationalite = :nation, "
        . "tel_std = :tel, "
        . "fax = :fax, "
        . "url = :url, "
        . "metro = :metro, "
        . "remarque = :remarque, "
        . "mngt_law = :contact_law, "
        . "mngt_supp = :contact_supp, "
        . "status_fk = :status, "
        . "raison_factu = :factu_social, "
        . "nom_factu = :factu_last, "
        . "prenom_factu = :factu_first, "
        . "titre_factu = :factu_titre, "
        . "civilite_factu = :factu_civil, "
        . "adr1_factu = :factu_addr, "
        . "ville_factu = :factu_town, "
        . "postal_factu = :factu_postal, "
        . "country_factu_fk = :factu_country, "
        . "tel_factu = :factu_tel, "
        . "fax_factu = :factu_fax, "
        . "email_factu = :factu_email "
        . "WHERE id = :id_client";
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', htmlspecialchars($_POST['input_name']), PDO::PARAM_STR);
$stmt->bindParam(':zone', htmlspecialchars($_POST['input_zone']), PDO::PARAM_STR);
$stmt->bindParam(':addr', htmlspecialchars($_POST['input_addr']), PDO::PARAM_STR);
$stmt->bindParam(':town', htmlspecialchars($_POST['input_town']), PDO::PARAM_STR);
$stmt->bindParam(':postal', htmlspecialchars($_POST['input_postal']), PDO::PARAM_STR);
$stmt->bindParam(':country', htmlspecialchars($_POST['input_country']), PDO::PARAM_STR);
$stmt->bindParam(':tel', htmlspecialchars($_POST['input_tel']), PDO::PARAM_STR);
$stmt->bindParam(':fax', htmlspecialchars($_POST['input_fax']), PDO::PARAM_STR);
$stmt->bindParam(':contact_supp', htmlspecialchars($_POST['input_contact_supp']), PDO::PARAM_STR);
$stmt->bindParam(':url', htmlspecialchars($_POST['input_url']), PDO::PARAM_STR);
$stmt->bindParam(':remarque', $_POST['input_remarque'], PDO::PARAM_STR);
$stmt->bindParam(':nation', htmlspecialchars($_POST['input_nation']), PDO::PARAM_STR);
$stmt->bindParam(':status', htmlspecialchars($_POST['input_status']), PDO::PARAM_STR);
$stmt->bindParam(':contact_law', htmlspecialchars($_POST['input_contact_law']), PDO::PARAM_STR);
$stmt->bindParam(':metro', htmlspecialchars($_POST['input_metro']), PDO::PARAM_STR);
$stmt->bindParam(':factu_social', htmlspecialchars($_POST['input_factu_social']), PDO::PARAM_STR);
$stmt->bindParam(':factu_last', htmlspecialchars($_POST['input_factu_last']), PDO::PARAM_STR);
$stmt->bindParam(':factu_first', htmlspecialchars($_POST['input_factu_first']), PDO::PARAM_STR);
$stmt->bindParam(':factu_titre', htmlspecialchars($_POST['input_factu_titre']), PDO::PARAM_STR);
$stmt->bindParam(':factu_civil', htmlspecialchars($_POST['input_factu_civil']), PDO::PARAM_STR);
$stmt->bindParam(':factu_addr', htmlspecialchars($_POST['input_factu_addr']), PDO::PARAM_STR);
$stmt->bindParam(':factu_town', htmlspecialchars($_POST['input_factu_town']), PDO::PARAM_STR);
$stmt->bindParam(':factu_postal', htmlspecialchars($_POST['input_factu_postal']), PDO::PARAM_STR);
$stmt->bindParam(':factu_country', htmlspecialchars($_POST['input_factu_country']), PDO::PARAM_STR);
$stmt->bindParam(':factu_tel', htmlspecialchars($_POST['input_factu_tel']), PDO::PARAM_STR);
$stmt->bindParam(':factu_fax', htmlspecialchars($_POST['input_factu_fax']), PDO::PARAM_STR);
$stmt->bindParam(':factu_email', htmlspecialchars($_POST['input_factu_email']), PDO::PARAM_STR);
$stmt->bindParam(':id_client', htmlspecialchars($_POST['input_id']), PDO::PARAM_INT);
$stmt->execute();

header('Location:../client/upd_client.php?id='.$_POST['input_id'].'');

} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
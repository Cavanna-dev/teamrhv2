<?php

include './connection_db.php';

$name = htmlspecialchars($_POST['input_name']);
$zone = htmlspecialchars($_POST['input_zone']);
$addr = htmlspecialchars($_POST['input_addr']);
$town = htmlspecialchars($_POST['input_town']);
$postal = htmlspecialchars($_POST['input_postal']);
$country = htmlspecialchars($_POST['input_country']);
$nation = htmlspecialchars($_POST['input_nation']);
$tel = htmlspecialchars($_POST['input_tel']);
$status_fk = htmlspecialchars($_POST['input_status']);
$url = htmlspecialchars($_POST['input_url']);
$metro = htmlspecialchars($_POST['input_metro']);
$remarque = $_POST['input_remarque'];
$mngt_law = htmlspecialchars($_POST['input_contact_law']);
$mngt_supp = htmlspecialchars($_POST['input_contact_supp']);
$id = htmlspecialchars($_POST['input_id']);

try {
    $sql = "UPDATE prospect SET "
            . "nom = :name, "
            . "secteur = :zone, "
            . "adresse1 = :addr, "
            . "ville = :town, "
            . "postal = :postal, "
            . "country_fk = :country, "
            . "nationalite = :nation, "
            . "tel_std = :tel, "
            . "url = :url, "
            . "metro = :metro, "
            . "remarque = :remarque, "
            . "mngt_law = :contact_law, "
            . "mngt_supp = :contact_supp, "
            . "status_fk = :status "
            . "WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':zone', $zone, PDO::PARAM_STR);
    $stmt->bindParam(':addr', $addr, PDO::PARAM_STR);
    $stmt->bindParam(':town', $town, PDO::PARAM_STR);
    $stmt->bindParam(':postal', $postal, PDO::PARAM_STR);
    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
    $stmt->bindParam(':nation', $nation, PDO::PARAM_STR);
    $stmt->bindParam(':tel', $tel, PDO::PARAM_STR);
    $stmt->bindParam(':url', $url, PDO::PARAM_STR);
    $stmt->bindParam(':metro', $metro, PDO::PARAM_STR);
    $stmt->bindParam(':remarque', $remarque, PDO::PARAM_STR);
    $stmt->bindParam(':contact_law', $mngt_law, PDO::PARAM_STR);
    $stmt->bindParam(':contact_supp', $mngt_supp, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status_fk, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location:../prospect/upd_prospect.php?id=' . $_POST['input_id'] . '');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
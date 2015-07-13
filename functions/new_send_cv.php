<?php

session_start();

include './connection_db.php';
include './bootstrap.php';

error_reporting(0);

$array_value = array(
    'consult' => $_SESSION['user']['id'],
    'candidat' => $_POST['candidat'],
    'date_envoi' => $_POST['date_envoi'],
);

foreach ($_POST['customers'] as $customer) :
    try {
        $sql = "INSERT INTO CV_ENVOYE";
        $sql .= " (consultant, candidat, client, date_envoi) ";
        $sql .= " values ";
        $sql .= "('" . $array_value['consult'] . "', '" . $array_value['candidat'] . "', '" . $customer . "', '" . $array_value['date_envoi'] . "') ";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Error : " . $e->getMessage());
    }
endforeach;

foreach ($_POST['jobs'] as $job) :
    $job_obj = getOneJobById($db, $job);
    try {
        $sql = "INSERT INTO CV_ENVOYE";
        $sql .= " (consultant, candidat, client, poste, date_envoi) ";
        $sql .= " values ";
        $sql .= "('" . $array_value['consult'] . "', '" . $array_value['candidat'] . "', '" . $job_obj->client . "', '" . $job . "', '" . $array_value['date_envoi'] . "') ";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Error : " . $e->getMessage());
    }
endforeach;

foreach ($_POST['prospects'] as $prospect) :
    try {
        $sql = "INSERT INTO CV_ENVOYE";
        $sql .= " (consultant, candidat, prospect, date_envoi) ";
        $sql .= " values ";
        $sql .= "('" . $array_value['consult'] . "', '" . $array_value['candidat'] . "', '" . $prospect . "', '" . $array_value['date_envoi'] . "') ";

        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Error : " . $e->getMessage());
    }
endforeach;

header('Location:../candidat/upd_applicant.php?id='.$array_value['candidat'].'&sendCv');
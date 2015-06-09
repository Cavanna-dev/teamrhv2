<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "INSERT INTO `entretien`"
            . "(`CLIENT`, `CONTACT`, `CANDIDAT`, `CONSULTANT`, `DATE_RDV`, "
            . "`HORAIRE`, `NUMERO_RDV`, `POSTE`, `RMQ_CLIENT`, `RMQ_CANDI`, "
            . "`RMQ_TEAMRH`) "
            . "VALUES "
            . "(:input_customer,:input_contact,:input_applicant,:input_consult,"
            . ":input_date,:input_hours,:input_n_rdv,:input_job,"
            . ":input_rmq_customer,:input_rmq_applicant,:input_rmq_teamrh)";		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../client/agenda.php?newRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
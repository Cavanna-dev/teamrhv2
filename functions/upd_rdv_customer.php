<?php

include './connection_db.php';

foreach ($_POST as $key => $value):
    $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE `entretien` "
            . "SET "
            . "`CLIENT`=:input_customer,"
            . "`CONTACT`=:input_contact,"
            . "`CANDIDAT`=:input_applicant,"
            . "`CONSULTANT`=:input_consult,"
            . "`DATE_RDV`=:input_date,"
            . "`HORAIRE`=:input_hours,"
            . "`NUMERO_RDV`=:input_n_rdv,"
            . "`POSTE`=:input_job,"
            . "`RMQ_CLIENT`=:input_rmq_customer,"
            . "`RMQ_CANDI`=:input_rmq_applicant,"
            . "`RMQ_TEAMRH`=:input_rmq_teamrh "
            . "WHERE id=:input_id";		
    
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../client/agenda.php?updRDV');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
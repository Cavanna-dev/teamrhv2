<?php

include './connection_db.php';
include '../functions/bootstrap.php';

$cust = getOneCustomerById($db, $_GET['id']);
//var_dump($cust);die;
foreach ($cust as $key => $value):
    if ($key != 'id')
        $customer[":" . $key] = $value;
endforeach;
//var_dump($customer);die;
$r_coms = getComByCustomer($db, $_GET['id']);
$coms = $r_coms->fetchAll(PDO::FETCH_OBJ);
//var_dump($coms);die;
$contacts = getContactByClient($db, $_GET['id']);
//var_dump($contacts);die;

try {
    $sql = "INSERT INTO `prospect`(`NOM`, `SECTEUR`, `ADRESSE1`, `VILLE`, "
            . "`POSTAL`, `COUNTRY_FK`, `NATIONALITE`, `TEL_STD`, `URL`, `METRO`, "
            . "`STATUS_FK`, `MNGT_LAW`, `MNGT_SUPP`, `REMARQUE`) "
            . "VALUES "
            . "(:nom, :secteur, :adresse1, :ville, :postal, :country_fk, "
            . ":nationalite, :tel_std, :url, :metro, :status_fk, :mngt_law, "
            . ":mngt_supp, :remarque)";
    $stmt = $db->prepare($sql);
    $stmt->execute($customer);
    $prospect_id = $db->lastInsertId();

    foreach ($coms as $v):
        foreach ($v as $key => $value):
            if ($key != 'client' && $key != 'id')
                $commentaire[":" . $key] = $value;
        endforeach;
        //var_dump($commentaire);die;
        
        $sql = "INSERT INTO `commentaire_prospect`(`PROSPECT`, `REMARQUE`, `CREATION`) "
                . "VALUES ('" . $prospect_id . "', :remarque, :creation)";
        $stmt = $db->prepare($sql);
        $stmt->execute($commentaire);

        $sql = "DELETE FROM `commentaire_client` WHERE id=" . $v->id;
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    foreach ($contacts as $v):
        foreach ($v as $key => $value):
            if ($key != 'client' && $key != 'id')
                $contact[":" . $key] = $value;
        endforeach;
        //var_dump($contact);die;
        
        $sql = "INSERT INTO `contact_prospect`(`PROSPECT`, `INACTIF`, `CIVILITE`, `NOM`, "
                . "`PRENOM`, `FONCTION`, `TEL`, `EMAIL`, `TYPE`, `REMARQUE`, `CREATION`) "
                . "VALUES "
                . "('" . $prospect_id . "', :inactif, :civilite, :nom, :prenom, "
                . ":fonction, :tel, :email, :type, :remarque, :creation)";
        $stmt = $db->prepare($sql);
        $stmt->execute($contact);

        $sql = "DELETE FROM `contact` WHERE id=" . $v->id;
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    $sql = "DELETE FROM `client` WHERE id=" . $cust->id;
    $stmt = $db->prepare($sql);
    $stmt->execute();

    header('Location:../prospect/upd_prospect.php?id=' . $prospect_id . '&transform');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
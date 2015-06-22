<?php

include './connection_db.php';
include '../functions/bootstrap.php';

$prosp = getOneProspectById($db, $_GET['id']);
//var_dump($prosp);die;
foreach ($prosp as $key => $value):
    if ($key != 'id')
        $prospect[":" . $key] = $value;
endforeach;
//var_dump($prospect);die;
$r_coms = getAllComByProspect($db, $_GET['id']);
$coms = $r_coms->fetchAll(PDO::FETCH_OBJ);
//var_dump($coms);die;
$contacts = getContactProspectById($db, $_GET['id']);
//var_dump($contacts);die;

try {
    $sql = "INSERT INTO `client`(`NOM`, `SECTEUR`, `ADRESSE1`, "
            . "`VILLE`, `POSTAL`, `COUNTRY_FK`, `NATIONALITE`, `TEL_STD`, "
            . "`URL`, `METRO`, `REMARQUE`, `MNGT_LAW`, "
            . "`MNGT_SUPP`, `STATUS_FK`) "
            . "VALUES "
            . "(:nom, :secteur, :adresse1, :ville, :postal, :country_fk, "
            . ":nationalite, :tel_std, :url, :metro, :remarque, :mngt_law, "
            . ":mngt_supp, :status_fk)";
    $stmt = $db->prepare($sql);
    $stmt->execute($prospect);
    $client_id = $db->lastInsertId();

    foreach ($coms as $v):
        foreach ($v as $key => $value):
            if ($key != 'prospect' && $key != 'id')
                $commentaire[":" . $key] = $value;
        endforeach;
        //var_dump($commentaire);die;
        
        $sql = "INSERT INTO `commentaire_client`(`CLIENT`, `REMARQUE`, `CREATION`) "
                . "VALUES ('" . $client_id . "', :remarque, :creation)";
        $stmt = $db->prepare($sql);
        $stmt->execute($commentaire);

        $sql = "DELETE FROM `commentaire_prospect` WHERE id=" . $v->id;
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    foreach ($contacts as $v):
        foreach ($v as $key => $value):
            if ($key != 'prospect' && $key != 'id')
                $contact[":" . $key] = $value;
        endforeach;
        //var_dump($contact);die;
        
        $sql = "INSERT INTO `contact`(`CLIENT`, `INACTIF`, `CIVILITE`, `NOM`, "
                . "`PRENOM`, `FONCTION`, `TEL`, `EMAIL`, `TYPE`, `REMARQUE`, `CREATION`) "
                . "VALUES "
                . "('" . $client_id . "', :inactif, :civilite, :nom, :prenom, "
                . ":fonction, :tel, :email, :type, :remarque, :creation)";
        $stmt = $db->prepare($sql);
        $stmt->execute($contact);

        $sql = "DELETE FROM `contact_prospect` WHERE id=" . $v->id;
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    $sql = "DELETE FROM `prospect` WHERE id=" . $prosp->id;
    $stmt = $db->prepare($sql);
    $stmt->execute();

    header('Location:../client/upd_client.php?id=' . $client_id . '&transform');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
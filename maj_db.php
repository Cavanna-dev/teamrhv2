<?php

include './functions/connection_db.php';

$sql = "SELECT p.id, p.contrat, p.duree, p.pourcentage, p.salaire, p.remise, p.forfait, p.date_deb "
        . "FROM placement p "
        . "LEFT JOIN reglements r ON p.id = r.fk_placement_id "
        . "WHERE r.id IS NULL";

$r_placement = $db->prepare($sql);
$r_placement->execute();
$r = $r_placement->fetchAll(PDO::FETCH_OBJ);

var_dump($r);
die;

foreach ($r as $placement) {
    if ($placement->forfait == "" || $placement->forfait == 0)
        if ($placement->contrat == 'CDI')
            $montant = ($placement->salaire * $placement->pourcentage / 100) - $placement->remise;
        else
            $montant = ($placement->salaire * $placement->pourcentage * $placement->duree / (12 * 100)) - $placement->remise;
    else
        $montant = $placement->forfait;

    $sql_reg = "INSERT INTO `reglements`"
            . "(`type`, `number`, `pourcentage`, `date`, `tva`, `montant`, `isFacture`, `isEncaisse`, `fk_placement_id`) "
            . "VALUES ('F','1','100','" . $placement->date_deb . "','20','" . $montant . "','Y','Y','" . $placement->id . "')";

    $new_reg = $db->prepare($sql_reg);
    $new_reg->execute();
}



                
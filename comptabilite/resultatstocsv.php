<?php
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');
include '../functions/connection_db.php';
error_reporting(0);
if (isset($_GET['month'])) {
    $months = array(
        $_GET['numberMonth'] => $_GET['month']
    );
} else {
    $months = array(
        '01' => "Janvier",
        '02' => "Fevrier",
        '03' => 'Mars',
        '04' => 'Avril',
        '05' => 'Mail',
        '06' => 'Juin',
        '07' => 'Juillet',
        '08' => 'Aout',
        '09' => 'Septembre',
        '10' => 'Octobre',
        '11' => 'Novembre',
        '12' => 'Decembre'
    );
}
$param = $_GET['param'];
$tva = $_GET['tva'];
?>
"Decaisses";"";"Encaisses";""
"Description";"Montant";"Description";"Montant"
<?php
foreach ($months as $numberMonth => $month) {
    echo '"' . $month . '"' . PHP_EOL;

    $requete1 = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'description', ";
    $requete1 .= "  ENCAISSE.MONTANT 'ht', ENCAISSE.ENC_TTC_TOT_AMOUNT 'ttc', TVA 'tva', DATE_FORMAT(ENCAISSE.DATE_ENVOI,'%d/%m/%Y') 'date_paiement',  ";
    $requete1 .= "  DATE_FORMAT(DATE_ENVOI,'%Y/%m/%d') 'date_ordre' ";
    $requete1 .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
    $requete1 .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
    $requete1 .= " left join POSTE on                           ";
    $requete1 .= " POSTE.id = PLACEMENT.poste                   ";
    $requete1 .= " left join CANDIDAT on                        ";
    $requete1 .= " CANDIDAT.ID = PLACEMENT.candidat             ";
    $requete1 .= " where ENCAISSE.client = CLIENT.id and mid(DATE_ENVOI, 6, 2) = '$numberMonth' and mid(DATE_ENVOI, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
    $resultat1 = $db->prepare($requete1);
    $resultat1->execute();


    $requete2 = " select ID, mid(description, 1, 30)  'description', DEC_TTC_TOT_AMOUNT 'ttc', DATE_FORMAT(date_compta,'%d/%m/%Y') 'date_paiement', ";
    $requete2 .= " DEC_HT_TOT_AMOUNT 'ht', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
    $requete2 .= " from   DECAISSE                               ";
    $requete2 .= " where mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '$numberMonth' order by DATE_PAIEMENT, DESCRIPTION desc              ";
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();

    $tmp = array();
    $pointer = 0;
    $total_dec = 0;
    $total_enc = 0;
    foreach ($resultat2->fetchAll(PDO::FETCH_OBJ) as $k => $data) {
        $tmp[$pointer][1] = $data->description;
        if ($tva == "Y") {
            $tmp[$pointer][2] = $data->ttc;
        } else {
            $tmp[$pointer][2] = $data->ht;
        }
        $total_enc = $total_enc + $tmp[$pointer][2];
        $pointer++;
    }
    $pointer = 0;
    foreach ($resultat1->fetchAll(PDO::FETCH_OBJ) as $k => $data) {
        $tmp[$pointer][3] = $data->description;
        if ($tva == "Y") {
            $tmp[$pointer][4] = $data->ttc;
        } else {
            $tmp[$pointer][4] = $data->ht;
        }
        $total_dec = $total_dec + $tmp[$pointer][4];
        $pointer++;
    }
    foreach ($tmp as $data) {
        echo '"' . utf8_decode($data[1]) . '";"' . $data[2] . '";"' . utf8_decode($data[3]) . '";"' . $data[4] . '"' . PHP_EOL;
    }
    ?>"Total du mois de <?= $month ?>";"<?= $total_enc ?>";"Total du mois de <?= $month ?>";"<?= $total_dec ?>"
<?php } ?>
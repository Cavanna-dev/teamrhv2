<?php
header('content-type: text/html; charset=utf-8');

/* CONSTANTES  */
define('CONST_PROJECT_NAME', 'TeamRH');
define('CONST_HOST', 'localhost');
define('CONST_SALT_PRE', 'aze123wxc456');
define('CONST_SALT_SUF', '987poi321mlk');
define('CONST_DATABASE_NAME', 'teamrh');
define('CONST_DATABASE_USER', 'root');
define('CONST_DATABASE_PWD', '');
define('CONST_URI', $_SERVER['DOCUMENT_ROOT'] . '\\' . CONST_PROJECT_NAME);

try {
    $db = new PDO('mysql:host=' . CONST_HOST . ';dbname=' . CONST_DATABASE_NAME, CONST_DATABASE_USER, CONST_DATABASE_PWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$clause = " 1 = 1 ";
if (isset($_GET['month']) && $_GET['month'] != '')
    $clause .= " and  DATE_FORMAT(date_paiement,'%m') = '" . $_GET['month'] . "' ";
if (isset($_GET['year']) && $_GET['year'] != '')
    $clause .= " and  DATE_FORMAT(date_paiement,'%Y') = '" . $_GET['year'] . "' ";

$requete1 = "SELECT ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 20),'.')  'DESCRIPTION', ENCAISSE.MONTANT 'HT', " . PHP_EOL;
$requete1 .= "  ENCAISSE.ENC_TTC_TOT_AMOUNT 'TTC_AMOUNT_ENC', ENCAISSE.ENC_TVA_TOT_AMOUNT 'TVA_AMOUNT_ENC', " . PHP_EOL;
$requete1 .= "  ENCAISSE.TVA 'TVA_ENC', DATE_FORMAT(ENCAISSE.date_paiement,'%d/%m/%Y') 'DATE_PAIEMENT', " . PHP_EOL;
$requete1 .= "  DATE_FORMAT(date_paiement,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1 .= "FROM CLIENT, ENCAISSE ";
$requete1 .= "WHERE " . $clause . " AND ENCAISSE.client = CLIENT.id ORDER BY DATE_PAIEMENT, DESCRIPTION DESC";

$requete2 = " select DECAISSE.ID, mid(DECAISSE.DESCRIPTION, 1, 20)  'DESCRIPTION', DECAISSE.DEC_TTC_TOT_AMOUNT 'TTC'," . PHP_EOL;
$requete2 .= " DECAISSE.DEC_HT_TOT_AMOUNT 'HT_AMOUNT_DEC', " . PHP_EOL;
$requete2 .= " DECAISSE.DEC_TVA_TOT_AMOUNT 'TVA_AMOUNT_DEC', DATE_FORMAT(DECAISSE.date_paiement,'%d/%m/%Y') 'DATE_PAIEMENT', " . PHP_EOL;
$requete2 .= " DATE_FORMAT(DECAISSE.DATE_PAIEMENT,'%Y/%m/%d') 'DATE_ORDRE' " . PHP_EOL;
$requete2 .= " from DECAISSE ";
$requete2 .= " where $clause ORDER BY DATE_PAIEMENT, DESCRIPTION desc";
$totalHtDec = 0;
$totalTvaDec = 0;
$totalTtcDec = 0;
$totalHtEnc = 0;
$totalTvaEnc = 0;
$totalTtcEnc = 0;
?>
<html lang="fr">

    <body style="width:1200px;margin: auto;">
        <h1>TVA Factures - 
            <?= isset($_GET['month']) && $_GET['month'] != '' ? $_GET['month'] : '' ?>
            <?= isset($_GET['month']) && $_GET['month'] != '' && isset($_GET['year']) && $_GET['year'] != '' ? '/' : '' ?>
            <?= isset($_GET['year']) && $_GET['year'] != '' ? $_GET['year'] : ''; ?>
        </h1>
        <div>
            <table border="1" style="width:100%">
                <thead>
                    <tr>
                        <th align="middle" colspan="4">
                            Decaissés
                        </th>
                        <th align="middle" colspan="4">
                            Encaissés
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Description
                        </th>
                        <th>
                            HT en euro
                        </th>
                        <th>
                            TVA en euro
                        </th>
                        <th>
                            TTC en euro
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            HT en euro
                        </th>
                        <th>
                            TVA en euro
                        </th>
                        <th>
                            TTC en euro
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                            $resultat2 = $db->prepare($requete2);
                            $resultat2->execute();
                            foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                echo "&nbsp;&nbsp;";
                                echo $enregistrement2['DESCRIPTION'];
                                echo "&nbsp;&nbsp;";
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td style="text-align: right">
                            <?php
                            $resultat2 = $db->prepare($requete2);
                            $resultat2->execute();
                            foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                $totalHtDec += $enregistrement2['HT_AMOUNT_DEC'];
                                echo number_format($enregistrement2['HT_AMOUNT_DEC'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td style="text-align: right">
                            <?php
                            $resultat2 = $db->prepare($requete2);
                            $resultat2->execute();
                            foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                $totalTvaDec += $enregistrement2['TVA_AMOUNT_DEC'];
                                echo number_format($enregistrement2['TVA_AMOUNT_DEC'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td style="text-align: right">
                            <?php
                            $resultat2 = $db->prepare($requete2);
                            $resultat2->execute();
                            foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                $totalTtcDec += $enregistrement2['TTC'];
                                echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td valign="top">
                            <?php
                            $resultat1 = $db->prepare($requete1);
                            $resultat1->execute();
                            foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                echo "&nbsp;&nbsp;";
                                echo ucfirst(strtolower($enregistrement1['DESCRIPTION']));
                                echo "&nbsp;&nbsp;";
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td valign="top" style="text-align: right">
                            <?php
                            $resultat1 = $db->prepare($requete1);
                            $resultat1->execute();
                            foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                $totalHtEnc += $enregistrement1['HT'];

                                echo number_format($enregistrement1['HT'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td valign="top" style="text-align: right">
                            <?php
                            $resultat1 = $db->prepare($requete1);
                            $resultat1->execute();
                            foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                $totalTvaEnc += $enregistrement1['TVA_AMOUNT_ENC'];
                                echo number_format($enregistrement1['TVA_AMOUNT_ENC'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                        <td valign="top" style="text-align: right">
                            <?php
                            $resultat1 = $db->prepare($requete1);
                            $resultat1->execute();
                            foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                $totalTtcEnc += $enregistrement1['TTC_AMOUNT_ENC'];
                                echo number_format($enregistrement1['TTC_AMOUNT_ENC'], 2, ',', ' ');
                                echo "<BR>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Total Décaissés</td>
                        <td style="text-align: right"><?= number_format($totalHtDec, 2, ',', ' ') ?></td>
                        <td style="text-align: right"><?= number_format($totalTvaDec, 2, ',', ' ') ?></td>
                        <td style="text-align: right"><?= number_format($totalTtcDec, 2, ',', ' ') ?></td>
                        <td>Total Encaissés</td>
                        <td style="text-align: right"><?= number_format($totalHtEnc, 2, ',', ' ') ?></td>
                        <td style="text-align: right"><?= number_format($totalTvaEnc, 2, ',', ' ') ?></td>
                        <td style="text-align: right"><?= number_format($totalTtcEnc, 2, ',', ' ') ?></td>
                    </tr>
                    <tr>
                        <td>Total TVA a déclarer</td>
                        <td style="text-align: right"><?= number_format($totalTvaEnc - $totalTvaDec, 2, ',', ' ') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
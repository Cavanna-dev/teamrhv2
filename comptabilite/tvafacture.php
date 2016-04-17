<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    echo $START_JAVASCRIPT;
    echo "	top.location.replace('../index.php'); ";
    echo $END_JAVASCRIPT;
}


error_reporting(0);
foreach ($_POST as $key => $value) {
    $$key = $value;
}
/**
 * Search Function
 */
if ($Rechercher == "Rechercher") {

    $clause = " 1 = 1 ";
    $clause1 = " 1 = 1 ";
    if ($mois_facture != '')
        $clause .= " and  DATE_FORMAT(date_paiement,'%m')   = '$mois_facture'    ";
    if ($annee_facture != '')
        $clause .= " and  DATE_FORMAT(date_paiement,'%Y')   = '$annee_facture'   ";


    if ($mois_facture == '01')
        $clause1 .= " and  mois = 'janvier'   ";
    if ($mois_facture == '02')
        $clause1 .= " and  mois = 'février'   ";
    if ($mois_facture == '03')
        $clause1 .= " and  mois = 'mars'      ";
    if ($mois_facture == '04')
        $clause1 .= " and  mois = 'avril'     ";
    if ($mois_facture == '05')
        $clause1 .= " and  mois = 'mai'       ";
    if ($mois_facture == '06')
        $clause1 .= " and  mois = 'juin'      ";
    if ($mois_facture == '07')
        $clause1 .= " and  mois = 'juillet'   ";
    if ($mois_facture == '08')
        $clause1 .= " and  mois = 'août'      ";
    if ($mois_facture == '09')
        $clause1 .= " and  mois = 'septembre' ";
    if ($mois_facture == '10')
        $clause1 .= " and  mois = 'octobre'   ";
    if ($mois_facture == '11')
        $clause1 .= " and  mois = 'novembre'  ";
    if ($mois_facture == '12')
        $clause1 .= " and  mois = 'décembre'  ";
    if ($annee_facture != '')
        $clause1 .= " and  annee   = '$annee_facture'   ";

    $requete1 = "SELECT ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 20),'.')  'DESCRIPTION', ENCAISSE.MONTANT 'HT', " . PHP_EOL;
    $requete1 .= "  ENCAISSE.ENC_TTC_TOT_AMOUNT 'TTC_AMOUNT_ENC', ENCAISSE.ENC_TVA_TOT_AMOUNT 'TVA_AMOUNT_ENC', " . PHP_EOL;
    $requete1 .= "  ENCAISSE.TVA 'TVA_ENC', DATE_FORMAT(ENCAISSE.date_paiement,'%d/%m/%Y') 'DATE_PAIEMENT', " . PHP_EOL;
    $requete1 .= "  DATE_FORMAT(date_paiement,'%Y/%m/%d') 'DATE_ORDRE' ";
    $requete1 .= "FROM CLIENT, ENCAISSE ";
    $requete1 .= "WHERE " . $clause . " AND ENCAISSE.client = CLIENT.id ORDER BY DATE_PAIEMENT, DESCRIPTION DESC";

    $requete2 = " select DECAISSE.ID, mid(DECAISSE.DESCRIPTION, 1, 20)  'DESCRIPTION', DECAISSE_DETAIL.TTC_AMOUNT 'TTC'," . PHP_EOL;
    $requete2 .= " DECAISSE_DETAIL.TVA_PERCENT 'TVA_DEC', DECAISSE_DETAIL.HT_AMOUNT 'HT_AMOUNT_DEC', " . PHP_EOL;
    $requete2 .= " DECAISSE_DETAIL.TVA_AMOUNT 'TVA_AMOUNT_DEC', DATE_FORMAT(DECAISSE.date_paiement,'%d/%m/%Y') 'DATE_PAIEMENT', " . PHP_EOL;
    $requete2 .= " DATE_FORMAT(DECAISSE.DATE_PAIEMENT,'%Y/%m/%d') 'DATE_ORDRE' " . PHP_EOL;
    $requete2 .= " from DECAISSE, DECAISSE_DETAIL" . PHP_EOL;
    $requete2 .= " where DECAISSE.ID = DECAISSE_DETAIL.FK_DECAISSE_ID and " . $clause . " ORDER BY DATE_PAIEMENT, DESCRIPTION DESC";
    //$resultat2 = mysql_query($requete2);
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();

    //$resultat1 = mysql_query($requete1);
    $resultat1 = $db->prepare($requete1);
    $resultat1->execute();

    if (!$resultat1 || !$resultat2) {
        $msg = mysql_error();
        $msg = strtr($msg, "'", "\'");
        echo $START_JAVASCRIPT . "	alert('$msg');" . $END_JAVASCRIPT;
    } else {
        if ($resultat1->rowCount() == 0 && $resultat2->rowCount() == 0) {
            echo $START_JAVASCRIPT . "	alert('Aucun enregistrement sélectionné.');" . $END_JAVASCRIPT;
        } else {
            
        }
    }

    $rq_totaux = "SELECT DECAISSE_DETAIL.TVA_PERCENT 'TVA_PERCENT', SUM( TVA_AMOUNT ) 'TVA_AMOUNT', SUM( HT_AMOUNT ) 'HT_AMOUNT', " . PHP_EOL;
    $rq_totaux .= "  SUM( TTC_AMOUNT ) 'TTC_AMOUNT' " . PHP_EOL;
    $rq_totaux .= "FROM DECAISSE_DETAIL, DECAISSE " . PHP_EOL;
    $rq_totaux .= "WHERE " . $clause . " " . PHP_EOL;
    $rq_totaux .= "AND DECAISSE.ID = DECAISSE_DETAIL.FK_DECAISSE_ID " . PHP_EOL;
    $rq_totaux .= "GROUP BY DECAISSE_DETAIL.TVA_PERCENT";

    //$res_totaux = mysql_query($rq_totaux);
    $res_totaux = $db->prepare($rq_totaux);
    $res_totaux->execute();

    foreach ($res_totaux->fetchAll(PDO::FETCH_ASSOC) as $enregistrement_totaux) {
        //while ($enregistrement_totaux = mysql_fetch_array($res_totaux)) {
        $total_ht_amount_dec = $total_ht_amount_dec + $enregistrement_totaux[HT_AMOUNT];

        $total_ttc_amount_dec = $total_ttc_amount_dec + $enregistrement_totaux[TTC_AMOUNT];

        if ($enregistrement_totaux['TVA_PERCENT'] == '20.00') {
            $total_tva_vingt_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '19.60') {
            $total_tva_dix_neuf_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '10.00') {
            $total_tva_dix_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '7.00') {
            $total_tva_sept_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '5.50') {
            $total_tva_cinq_cinq_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '5.00') {
            $total_tva_cinq_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } elseif ($enregistrement_totaux['TVA_PERCENT'] == '0.00') {
            $total_tva_zero_amount_dec = $enregistrement_totaux['TVA_AMOUNT'];
        } else {
            $total_tva_unknown_amount_dec = $total_tva_unknown_amount_dec + $enregistrement_totaux['TVA_AMOUNT'];
        }

        $total_tva_amount_dec = $total_tva_amount_dec + $enregistrement_totaux['TVA_AMOUNT'];
    }
}
?>

<div class="container">
    <?php
    if ($Rechercher != "Rechercher") {
        ?>	    
        <form action="" method="POST">
            <TABLE class="table table-bordered">
                <TR>
                    <TD colspan="4" class="titre" align="middle">
                        <BR>Rapport de TVA pour les factures
                    </TD>
                </TR>
                <TR>
                    <TD colspan="4">
                        &nbsp;
                    </TD>
                </TR>
                <TR>
                    <TD colspan="4" class="normal">
                        S&eacute;lectionnez vos crit&egrave;res pour visualiser le rapport de TVA:
                    </TD>
                </TR>
                <TR>
                    <TD colspan="4">
                        &nbsp;
                    </TD>
                </TR>
                <TR>
                    <TD colspan="4">
                        &nbsp;
                    </TD>
                </TR>
                <TR>
                    <TD align="right" class="normal">
                        Mois:
                    </TD>
                    <TD align="right" class="normal">
                        <select name="mois_facture" size="1" >
                            <option <?php if ($mois_facture == "") echo "selected" ?> value=""   >         </option>
                            <option <?php if ($mois_facture == "01") echo "selected" ?> value="01" >janvier  </option>
                            <option <?php if ($mois_facture == "02") echo "selected" ?> value="02" >f&eacute;vrier  </option>
                            <option <?php if ($mois_facture == "03") echo "selected" ?> value="03" >mars     </option>
                            <option <?php if ($mois_facture == "04") echo "selected" ?> value="04" >avril    </option>
                            <option <?php if ($mois_facture == "05") echo "selected" ?> value="05" >mai      </option>
                            <option <?php if ($mois_facture == "06") echo "selected" ?> value="06" >juin     </option>
                            <option <?php if ($mois_facture == "07") echo "selected" ?> value="07" >juillet  </option>
                            <option <?php if ($mois_facture == "08") echo "selected" ?> value="08" >ao&ucirc;t     </option>
                            <option <?php if ($mois_facture == "09") echo "selected" ?> value="09" >septembre</option>
                            <option <?php if ($mois_facture == "10") echo "selected" ?> value="10" >octobre  </option>
                            <option <?php if ($mois_facture == "11") echo "selected" ?> value="11" >novembre </option>
                            <option <?php if ($mois_facture == "12") echo "selected" ?> value="12" >d&eacute;cembre </option>
                        </select>
                    </TD>
                </TR>
                <TR>
                    <TD align="right" class="normal">
                        Ann&eacute;e:
                    </TD>
                    <TD align="right" class="normal">
                        <select name="annee_facture" size="1" >
                            <option <?php if ($annee_facture == "") echo "selected" ?> value=""     >    </option>
                            <?php
                            for ($i = date("Y"); $i >= 2002; $i--) {
                                ?>
                                <option <?php if ($annee_facture == $i) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>

                                <?php
                            }
                            ?>
                        </select>
                    </TD>
                </TR>
                <TR>
                    <TD align="right" colspan=2>
                        <input type="submit" name="Rechercher" value="Rechercher">
                    </TD>
                </TR>
        </form>
    </TABLE>
    <?php
}
else {
    ?>
    <TABLE class="table table-bordered">
        <TR>
            <TD colspan="8" class="titre" align="middle">
                <BR>Rapport de TVA </TD>
        </TR>
        <TR>
            <?php
            if ($erreur == "oui") {
                ?>
                <TD align="left">
                    &nbsp;&nbsp;&nbsp;
                </TD>
                <TD class="titre"  align="middle" colspan=3">
                    <B>Connexion impossible &agrave; notre base de donn&eacute;es. Renouveller votre recherche ult&eacute;rieurement.<B>
                            </TD>
                            </TR>
                            <?php
                        } else {
                            ?>
                            <TD colspan="5">
                                &nbsp;
                            </TD>
                            </TR>

                            <?php
                            $i = 0;
                            if ($resultat1->rowCount() == 0 && $resultat2->rowCount() == 0) {
                                ?>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8" class="normal">
                                        Aucune facture n'a &eacute;t&eacute; pay&eacute;e ou encaiss&eacute;e pour ce mois.
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>			
                                <?php
                            } else {
                                ?>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>

                                <TR>
                                    <TD colspan="8" class="normal" align="middle">
                                        <?php
                                        $i = 1;
                                        echo "TVA pour les factures du $mois_facture/$annee_facture";
                                        ?>

                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <TR bordercolor="#FF9640">
                                    <TD class="normal" align="middle" colspan="4">
                                        Factures d&eacute;caiss&eacute;es
                                    </TD>
                                    <TD class="normal" align="middle" colspan="4">
                                        Factures encaiss&eacute;es
                                    </TD>
                                </TR>
                                <TR bordercolor="#FF9640">
                                    <TD class="normal" align="middle">
                                        Description
                                    </TD>
                                    <TD class="normal" align="right">
                                        HT en euro
                                    </TD>
                                    <TD class="normal" align="right">
                                        TVA en euro
                                    </TD>
                                    <TD class="normal" align="right">
                                        TTC en euro
                                    </TD>
                                    <TD class="normal" align="middle">
                                        Description
                                    </TD>
                                    <TD class="normal" align="right">
                                        HT en euro
                                    </TD>
                                    <TD class="normal" align="right">
                                        TVA en euro
                                    </TD>
                                    <TD class="normal" align="right">
                                        TTC en euro
                                    </TD>
                                </TR>
                                <?php
                                if ($resultat2->rowCOunt() == 0) {
                                    ?>
                                    <TR bordercolor="#FF9640">
                                        <TD align="left"  class="normal" colspan=4>
                                            &nbsp;
                                        </TD>
                                        <?php
                                    } else {
                                        ?>
                                    <TR bordercolor="#FF9640">
                                        <TD align="left"  class="normal">
                                            <?php
                                            //$resultat2 = mysql_query($requete2);
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();
    foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                            //while ($enregistrement2 = mysql_fetch_array($resultat2)) {
                                                echo "&nbsp;&nbsp;";
                                                echo $enregistrement2['DESCRIPTION'];
                                                echo "&nbsp;&nbsp;";
                                                echo "<BR>";
                                            }
                                            ?>
                                        </TD>
                                        <TD align="right"  class="normal">
                                            <?php
//                                            $resultat2 = mysql_query($requete2);
//                                            while ($enregistrement2 = mysql_fetch_array($resultat2)) {
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();
    foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                                $total_ht_dec = $total_ht_dec + $enregistrement2['HT_AMOUNT_DEC'];
                                                echo number_format($enregistrement2['HT_AMOUNT_DEC'], 2, ',', ' ');
                                                echo "<BR>";
                                            }
                                            ?>
                                        </TD>
                                        <TD align="right"  class="normal">
                                            <?php
//                                            $resultat2 = mysql_query($requete2);
//                                            while ($enregistrement2 = mysql_fetch_array($resultat2)) {
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();
    foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                                $total_tva_dec = $total_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                echo number_format($enregistrement2['TVA_AMOUNT_DEC'], 2, ',', ' ');
                                                echo "<BR>";

                                                if ($enregistrement2['TVA_DEC'] == "0.00") {
                                                    $total_zero_tva_dec = $total_zero_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "20.00") {
                                                    $total_vingt_tva_dec = $total_vingt_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "19.60") {
                                                    $total_dix_neuf_tva_dec = $total_dix_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "10.00") {
                                                    $total_dix_tva_dec = $total_dix_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "7.00") {
                                                    $total_sept_tva_dec = $total_sept_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "5.50") {
                                                    $total_cinq_cinq_tva_dec = $total_cinq_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } elseif ($enregistrement2['TVA_DEC'] == "5.00") {
                                                    $total_cinq_tva_dec = $total_dix_tva_dec + $enregistrement2['TVA_AMOUNT_DEC'];
                                                } else {
                                                    $total_unknown = $total_unknown + $enregistrement2['TVA_AMOUNT_DEC'];
                                                }
                                            }
                                            ?>
                                        </TD>
                                        <TD align="right"  class="normal">
                                            <?php
//                                            $resultat2 = mysql_query($requete2);
//                                            while ($enregistrement2 = mysql_fetch_array($resultat2)) {
    $resultat2 = $db->prepare($requete2);
    $resultat2->execute();
    foreach ($resultat2->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                                                $total_ttc_dec = $total_ttc_dec + $enregistrement2['TTC'];
                                                echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                                                echo "<BR>";
                                            }
                                            ?>
                                        </TD>
                                        <?php
                                    }

                                    if ($resultat1->rowCOunt() == 0) {
                                        ?>
                                        <TD align="left"  class="normal" colspan=4>
                                            &nbsp;
                                        </TD>
                                    </TR>
                                    <?php
                                } else {
                                    ?>

                                    <TD align="left"  class="normal">
                                        <?php
                                        //while ($enregistrement1 = mysql_fetch_array($resultat1)) {
    foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                            echo "&nbsp;&nbsp;";
                                            echo ucfirst(strtolower($enregistrement1['DESCRIPTION']));
                                            echo "&nbsp;&nbsp;";
                                            echo "<BR>";
                                        }
                                        ?>
                                    </TD>
                                    <TD align="right"  class="normal">
                                        <?php
//                                        $resultat1 = mysql_query($requete1);
//                                        while ($enregistrement1 = mysql_fetch_array($resultat1)) {
    $resultat1 = $db->prepare($requete1);
    $resultat1->execute();
    foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                            if ($enregistrement1['TVA_ENC'] != "0" && $enregistrement1['TVA_ENC'] != "")
                                                $total_ht_enc = $total_ht_enc + $enregistrement1['HT'];
                                            else
                                                $total_ht_enc_sans_tva = $total_ht_enc_sans_tva + $enregistrement1['HT'];

                                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                                            echo "<BR>";
                                        }
                                        ?>
                                    </TD>
                                    <TD align="right"  class="normal">
                                        <?php
//                                        $resultat1 = mysql_query($requete1);
//                                        while ($enregistrement1 = mysql_fetch_array($resultat1)) {
    $resultat1 = $db->prepare($requete1);
    $resultat1->execute();
    foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                            $total_tva_enc = $total_tva_enc + $enregistrement1['TVA_AMOUNT_ENC'];
                                            echo number_format($enregistrement1['TVA_AMOUNT_ENC'], 2, ',', ' ');
                                            echo "<BR>";

                                            if ($enregistrement1['TVA_ENC'] == "0.00") {
                                                $total_zero_tva_enc = $total_zero_tva_enc + $enregistrement1['TVA_AMOUNT_ENC'];
                                            }
                                            if ($enregistrement1['TVA_ENC'] == "19.60") {
                                                $total_dix_neuf_tva_enc = $total_dix_neuf_tva_enc + $enregistrement1['TVA_AMOUNT_ENC'];
                                            }
                                            if ($enregistrement1['TVA_ENC'] == "20.00") {
                                                $total_vingt_tva_enc = $total_vingt_tva_enc + $enregistrement1['TVA_AMOUNT_ENC'];
                                            }
                                        }
                                        ?>
                                    </TD>
                                    <TD align="right"  class="normal">
                                        <?php
//                                        $resultat1 = mysql_query($requete1);
//                                        while ($enregistrement1 = mysql_fetch_array($resultat1)) {
    $resultat1 = $db->prepare($requete1);
    $resultat1->execute();
    foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                                            $total_ttc_enc = $total_ttc_enc + $enregistrement1['TTC_AMOUNT_ENC'];
                                            echo number_format($enregistrement1['TTC_AMOUNT_ENC'], 2, ',', ' ');
                                            echo "<BR>";
                                        }
                                        ?>
                                    </TD>
                                    </TR>
                                    <?php
                                }
                                ?>

                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8" class="normal">
                                        Le montant total HT des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_ht_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR><BR>
                                        Le montant total de la TVA des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 20% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_vingt_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 19,6% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_dix_neuf_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 10% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_dix_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 7% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_sept_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 5,5% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_cinq_cinq_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA à 5% des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_cinq_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;Le montant de la TVA, pour les taux de TVA inconnus, des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_tva_unknown_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR><BR>
                                        Le montant total TTC des factures s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_ttc_amount_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8" class="normal">
                                        Le montant total HT des factures encaissées s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_ht_enc, 2, ',', ' '); ?> euros.
                                        <BR><BR>
                                        Le montant de la TVA à 19,6% des factures encaissées s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_dix_neuf_tva_enc, 2, ',', ' '); ?> euros.
                                        <BR>
                                        Le montant de la TVA à 20% des factures encaissées s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_vingt_tva_enc, 2, ',', ' '); ?> euros.
                                        <BR><BR>
                                        Le montant total TTC des factures encaissées s&eacute;lectionn&eacute;es s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total_ttc_enc, 2, ',', ' '); ?> euros.

                                        <BR><BR>
                                        <BR>
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8" class="normal">

                                        Le montant total de la TVA &agrave; verser est de <?php echo number_format($total_tva_enc - $total_tva_dec, 2, ',', ' '); ?> euros.
                                        <BR>
                                        <?php
                                        if ($alerte == "Y")
                                            echo "<font color=red><B>Attention !!! Le montant HT d&eacute;clar&eacute; comprend une ou plusieurs factures sans TVA</B></font> ";
                                        ?>
                                    </TD>
                                </TR>
                                <TR>
                                    <TD colspan="8">
                                        &nbsp;
                                    </TD>
                                </TR>
                                <?php
                            }
                            ?>
                            <TR>
                                <TD colspan="8" align="middle">
                                    <a href="tvafacture.php">Nouveau Rapport</a>
                                </TD>
                            </TR>
                            </TABLE>
                            <?php
                        }
                    }
                    $Rechercher = "";
                    ?>
                    </div>
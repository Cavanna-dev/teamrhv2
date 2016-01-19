<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$param = isset($_GET['param']) ? $_GET['param'] : '';
$tva = isset($_GET['tva']) ? $_GET['tva'] : '';
$mois_facture = isset($_GET['mois_facture']) ? $_GET['mois_facture'] : '';
$annee_facture = isset($_GET['annee_facture']) ? $_GET['annee_facture'] : '';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    echo "<script>";
    echo "	top.location.replace('../index.php'); ";
    echo "</script>";
}


// Par défaut on prend le rapport de l'annee.
if ($param == "") {
    $param = date("Y");
}

if ($tva == "")
    $tva = "Y";

// Factures encaiss&eacute;es
$clause = " 1 = 1 ";
if ($mois_facture != '')
    $clause .= " and  DATE_FORMAT(date_envoi,'%m')   = '$mois_facture'    ";
if ($annee_facture != '')
    $clause .= " and  DATE_FORMAT(date_envoi,'%Y')   = '$annee_facture'   ";

// Factures d&eacute;caiss&eacute;es
$clause1 = " 1 = 1 ";
if ($mois_facture != '')
    $clause1 .= " and  DATE_FORMAT(date_compta,'%m')   = '$mois_facture'    ";
if ($annee_facture != '')
    $clause1 .= " and  DATE_FORMAT(date_compta,'%Y')   = '$annee_facture'   ";
if ($tva != "Y")
    $clause1 .= " and  fournisseur != 37 ";

/* * ***************************************************************************
 *                     Serie de requete des factures encaissees               *
 * *************************************************************************** */
$requete1 = " select ID, mid(DESCRIPTION, 1, 30)  'DESCRIPTION', MONTANT 'HT', ENC_TTC_TOT_AMOUNT 'TTC', TVA , DATE_FORMAT(DATE_ENVOI,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete1 .= " DATE_FORMAT(DATE_ENVOI,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1 .= " from   ENCAISSE                                    ";
$requete1 .= " where $clause and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1 = $db->prepare($requete1);
$resultat1->execute();

$requete1_jan = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_jan .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.ENC_TTC_TOT_AMOUNT 'TTC', TVA , DATE_FORMAT(ENCAISSE.DATE_ENVOI,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_jan .= "  DATE_FORMAT(DATE_ENVOI,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_jan .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_jan .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_jan .= " left join POSTE on                           ";
$requete1_jan .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_jan .= " left join CANDIDAT on                        ";
$requete1_jan .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_jan .= " where $clause and ENCAISSE.client = CLIENT.id and mid(DATE_ENVOI, 6, 2) = '01' and mid(DATE_ENVOI, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_jan = $db->prepare($requete1_jan);
$resultat1_jan->execute();

$requete1_fev = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_fev .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.ENC_TTC_TOT_AMOUNT 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_fev .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_fev .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_fev .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_fev .= " left join POSTE on                           ";
$requete1_fev .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_fev .= " left join CANDIDAT on                        ";
$requete1_fev .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_fev .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '02' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_fev = $db->prepare($requete1_fev);
$resultat1_fev->execute();

$requete1_mar = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_mar .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_mar .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_mar .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_mar .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_mar .= " left join POSTE on                           ";
$requete1_mar .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_mar .= " left join CANDIDAT on                        ";
$requete1_mar .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_mar .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '03' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_mar = $db->prepare($requete1_mar);
$resultat1_mar->execute();

$requete1_avr = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_avr .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_avr .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_avr .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_avr .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_avr .= " left join POSTE on                           ";
$requete1_avr .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_avr .= " left join CANDIDAT on                        ";
$requete1_avr .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_avr .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '04' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_avr = $db->prepare($requete1_avr);
$resultat1_avr->execute();

$requete1_mai = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_mai .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_mai .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_mai .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_mai .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_mai .= " left join POSTE on                           ";
$requete1_mai .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_mai .= " left join CANDIDAT on                        ";
$requete1_mai .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_mai .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '05' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_mai = $db->prepare($requete1_mai);
$resultat1_mai->execute();

$requete1_jun = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_jun .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_jun .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_jun .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_jun .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_jun .= " left join POSTE on                           ";
$requete1_jun .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_jun .= " left join CANDIDAT on                        ";
$requete1_jun .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_jun .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '06' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_jun = $db->prepare($requete1_jun);
$resultat1_jun->execute();

$requete1_jui = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_jui .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_jui .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_jui .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_jui .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_jui .= " left join POSTE on                           ";
$requete1_jui .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_jui .= " left join CANDIDAT on                        ";
$requete1_jui .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_jui .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '07' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_jui = $db->prepare($requete1_jui);
$resultat1_jui->execute();


$requete1_aou = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_aou .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_aou .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_aou .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_aou .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_aou .= " left join POSTE on                           ";
$requete1_aou .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_aou .= " left join CANDIDAT on                        ";
$requete1_aou .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_aou .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '08' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_aou = $db->prepare($requete1_aou);
$resultat1_aou->execute();

$requete1_sep = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_sep .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_sep .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_sep .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_sep .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_sep .= " left join POSTE on                           ";
$requete1_sep .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_sep .= " left join CANDIDAT on                        ";
$requete1_sep .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_sep .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '09' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_sep = $db->prepare($requete1_sep);
$resultat1_sep->execute();

$requete1_oct = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_oct .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_oct .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_oct .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_oct .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_oct .= " left join POSTE on                           ";
$requete1_oct .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_oct .= " left join CANDIDAT on                        ";
$requete1_oct .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_oct .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '10' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_oct = $db->prepare($requete1_oct);
$resultat1_oct->execute();

$requete1_nov = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_nov .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_nov .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_nov .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_nov .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_nov .= " left join POSTE on                           ";
$requete1_nov .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_nov .= " left join CANDIDAT on                        ";
$requete1_nov .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_nov .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '11' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_nov = $db->prepare($requete1_nov);
$resultat1_nov->execute();

$requete1_dec = " select ENCAISSE.ID, concat(mid(CLIENT.NOM, 1, 15), '-', mid(CANDIDAT.NOM, 1, 10), '-', mid(POSTE.LIBELLE, 1, 10))  'DESCRIPTION', ";
$requete1_dec .= "  ENCAISSE.MONTANT 'HT', ENCAISSE.MONTANT * (1 + ENCAISSE.TVA/100) 'TTC', TVA , DATE_FORMAT(ENCAISSE.date_envoi,'%d/%m/%Y') 'DATE_PAIEMENT',  ";
$requete1_dec .= "  DATE_FORMAT(date_envoi,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete1_dec .= " from CLIENT, ENCAISSE left join PLACEMENT on ";
$requete1_dec .= " ENCAISSE.PLACEMENT = PLACEMENT.ID            ";
$requete1_dec .= " left join POSTE on                           ";
$requete1_dec .= " POSTE.id = PLACEMENT.poste                   ";
$requete1_dec .= " left join CANDIDAT on                        ";
$requete1_dec .= " CANDIDAT.ID = PLACEMENT.candidat             ";
$requete1_dec .= " where $clause and ENCAISSE.client = CLIENT.id and mid(date_envoi, 6, 2) = '12' and mid(date_envoi, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat1_dec = $db->prepare($requete1_dec);
$resultat1_dec->execute();

/* * ***************************************************************************
 *                     Serie de requete des factures payees                   *
 * *************************************************************************** */
$requete2 = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2 .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2 .= " from   DECAISSE                               ";
$requete2 .= " where $clause1 and mid(date_compta, 1, 4) = '$param' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2 = $db->prepare($requete2);
$resultat2->execute();

$requete2_jan = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_jan .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_jan .= " from   DECAISSE                               ";
$requete2_jan .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '01' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_jan = $db->prepare($requete2_jan);
$resultat2_jan->execute();

$requete2_fev = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_fev .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_fev .= " from   DECAISSE                               ";
$requete2_fev .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '02' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_fev = $db->prepare($requete2_fev);
$resultat2_fev->execute();

$requete2_mar = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_mar .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_mar .= " from   DECAISSE                               ";
$requete2_mar .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '03' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_mar = $db->prepare($requete2_mar);
$resultat2_mar->execute();

$requete2_avr = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_avr .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_avr .= " from   DECAISSE                               ";
$requete2_avr .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '04' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_avr = $db->prepare($requete2_avr);
$resultat2_avr->execute();

$requete2_mai = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_mai .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_mai .= " from   DECAISSE                               ";
$requete2_mai .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '05' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_mai = $db->prepare($requete2_mai);
$resultat2_mai->execute();

$requete2_jun = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_jun .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_jun .= " from   DECAISSE                               ";
$requete2_jun .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '06' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_jun = $db->prepare($requete2_jun);
$resultat2_jun->execute();

$requete2_jui = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_jui .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_jui .= " from   DECAISSE                               ";
$requete2_jui .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '07' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_jui = $db->prepare($requete2_jui);
$resultat2_jui->execute();

$requete2_aou = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_aou .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_aou .= " from   DECAISSE                               ";
$requete2_aou .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '08' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_aou = $db->prepare($requete2_aou);
$resultat2_aou->execute();

$requete2_sep = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_sep .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_sep .= " from   DECAISSE                               ";
$requete2_sep .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '09' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_sep = $db->prepare($requete2_sep);
$resultat2_sep->execute();

$requete2_oct = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_oct .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_oct .= " from   DECAISSE                               ";
$requete2_oct .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '10' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_oct = $db->prepare($requete2_oct);
$resultat2_oct->execute();

$requete2_nov = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_nov .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_nov .= " from   DECAISSE                               ";
$requete2_nov .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '11' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_nov = $db->prepare($requete2_nov);
$resultat2_nov->execute();

$requete2_dec = " select ID, mid(description, 1, 30)  'DESCRIPTION', DEC_TTC_TOT_AMOUNT 'TTC', DATE_FORMAT(date_compta,'%d/%m/%Y') 'DATE_PAIEMENT', ";
$requete2_dec .= " DEC_HT_TOT_AMOUNT 'HT', DATE_FORMAT(date_compta,'%Y/%m/%d') 'DATE_ORDRE' ";
$requete2_dec .= " from   DECAISSE                               ";
$requete2_dec .= " where $clause1 and mid(date_compta, 1, 4) = '$param' and mid(date_compta, 6, 2) = '12' order by DATE_PAIEMENT, DESCRIPTION desc              ";
$resultat2_dec = $db->prepare($requete2_dec);
$resultat2_dec->execute();


if (isset($annuler) && $Annuler == "Annuler") {
    $utilisateur = "";
    $mois_placement = "";
    $annee_placement = "";
    $ht = "";
    $tva = "";
    $ttc = "";
    $date_paiement = "";
    $date_ordre = "";
}
?>
<div class="container">
    <TABLE cellpadding="0" cellspacing="0" border="1" bordercolor="white">
        <TR>
            <TD colspan="4" class="titre" align="middle">
                <BR>Compte de r&eacute;sultat simplifi&eacute; pour l'ann&eacute;e <?php echo $param ?>.
            </TD>
        </TR>
        <TR>
            <TD colspan="4">
                &nbsp;
            </TD>
        </TR>
        <TR>
            <TD class="titre"  align="middle" colspan="4">
                <?php
                if ($resultat1->rowCount() == 0 && $resultat2->rowCount() == 0)
                    echo "Aucune facture n'a été payée ou encaissée pour l'année $param.";
                ?>
            </TD>
        </TR>
        <TR>
            <TD colspan="4">
                &nbsp;
            </TD>
        </TR>
        <TR>
            <TD align="left"  class="normal">
                <?php
                $tmp1 = $param - 1;
                ?>
                &nbsp;&nbsp;&nbsp;<A class="lien"  href="#" onclick="location.href = 'resultats.php?&param=<?php echo $tmp1 ?>';">Ann&eacute;e pr&eacute;c&eacute;dente</A>
            </TD>
            <TD colspan="2" align="center">
                <select name="tva"  onchange="window.location.href = 'resultats.php?tva=<?= $tva == 'Y' ? 'N' : 'Y' ?>&param=<?php echo $param; ?>'">
                    <option value="Y" <?php if ($tva == "Y") echo "selected"; ?> >Avec TVA</option>
                    <option value="N" <?php if ($tva == "N") echo "selected"; ?> >Sans TVA</option>
                </select>				
            </TD>
            <TD align="right" class="normal">
                <?php
                $tmp2 = $param + 1;
                ?>
                <A class="lien" href="#" onclick="location.href = 'resultats.php?&param=<?php echo $tmp2 ?>';">Ann&eacute;e suivante</A>&nbsp;&nbsp;&nbsp;
            </TD>
        </TR>
        <TR>
            <TD colspan="4">
                &nbsp;
            </TD>
        </TR>
        <?php
        if ($resultat1->rowCount() != 0 || $resultat2->rowCount() != 0) {
            ?>
            <TR bordercolor="#FF9640">
                <TD class="normal" align="middle" colspan="2">
                    D&eacute;bit
                </TD>
                <TD class="normal" align="middle" colspan="2">
                    Cr&eacute;dit
                </TD>
            </TR>
            <TR bordercolor="#FF9640">
                <TD class="normal" align="middle">
                    Description
                </TD>
                <TD class="normal" align="middle">
                    &nbsp; Montant TTC en euro &nbsp;
                </TD>
                <TD class="normal" align="middle">
                    Description
                </TD>
                <TD class="normal" align="middle">
                    &nbsp; Montant TTC en euro &nbsp;
                </TD>
            </TR>
            <?php
            /*             * *************************************************************
             *                           Janvier                            *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Janvier</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_jan->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de janvier
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_jan = $db->prepare($requete2_jan);
                    $resultat2_jan->execute();
                    $total_dec_jan = 0;
                    foreach ($resultat2_jan->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_jan = $total_dec_jan + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_jan = $total_dec_jan + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_jan, 2, ',', ' ');
                    ?>
                </TD>


                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_jan->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de janvier
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_jan = $db->prepare($requete1_jan);
                    $resultat1_jan->execute();
                    $total_enc_jan = 0;
                    foreach ($resultat1_jan->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_jan = $total_enc_jan + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_jan = $total_enc_jan + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_jan, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Fevrier                            *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>F&eacute;vrier</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_fev->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de f&eacute;vrier
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_fev = $db->prepare($requete2_fev);
                    $resultat2_fev->execute();
                    $total_dec_fev = 0;
                    foreach ($resultat2_fev->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_fev = $total_dec_fev + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_fev = $total_dec_fev + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_fev, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_fev->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de f&eacute;vrier
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_fev = $db->prepare($requete1_fev);
                    $resultat1_fev->execute();
                    $total_enc_fev = 0;
                    foreach ($resultat1_fev->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_fev = $total_enc_fev + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_fev = $total_enc_fev + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_fev, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Mars                            *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Mars</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_mar->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de mars
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_mar = $db->prepare($requete2_mar);
                    $resultat2_mar->execute();
                    $total_dec_mar = 0;
                    foreach ($resultat2_mar->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_mar = $total_dec_mar + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_mar = $total_dec_mar + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_mar, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_mar->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de mars
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_mar = $db->prepare($requete1_mar);
                    $resultat1_mar->execute();
                    $total_enc_mar = 0;
                    foreach ($resultat1_mar->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_mar = $total_enc_mar + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_mar = $total_enc_mar + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_mar, 2, ',', ' ');
                    ?>

                </TD>
            </TR>


            <?php
            /*             * *************************************************************
             *                           Avril                              *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Avril</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_avr->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de avril
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_avr = $db->prepare($requete2_avr);
                    $resultat2_avr->execute();
                    $total_dec_avr = 0;
                    foreach ($resultat2_avr->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_avr = $total_dec_avr + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_avr = $total_dec_avr + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_avr, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_avr->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de avril
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_avr = $db->prepare($requete1_avr);
                    $resultat1_avr->execute();
                    $total_enc_avr = 0;
                    foreach ($resultat1_avr->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_avr = $total_enc_avr + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_avr = $total_enc_avr + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_avr, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Mai                                *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Mai</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_mai->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de mai
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_mai = $db->prepare($requete2_mai);
                    $resultat2_mai->execute();
                    $total_dec_mai = 0;
                    foreach ($resultat2_mai->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_mai = $total_dec_mai + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_mai = $total_dec_mai + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_mai, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_mai->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de mai
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_mai = $db->prepare($requete1_mai);
                    $resultat1_mai->execute();
                    $total_enc_mai = 0;
                    foreach ($resultat1_mai->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_mai = $total_enc_mai + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_mai = $total_enc_mai + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_mai, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Juin                               *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Juin</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_jun->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de juin
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_jun = $db->prepare($requete2_jun);
                    $resultat2_jun->execute();
                    $total_dec_jun = 0;
                    foreach ($resultat2_jun->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_jun = $total_dec_jun + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_jun = $total_dec_jun + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_jun, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_jun->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de juin
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_jun = $db->prepare($requete1_jun);
                    $resultat1_jun->execute();
                    $total_enc_jun = 0;
                    foreach ($resultat1_jun->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_jun = $total_enc_jun + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_jun = $total_enc_jun + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_jun, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Juillet                            *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Juillet</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_jui->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de juillet
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_jui = $db->prepare($requete2_jui);
                    $resultat2_jui->execute();
                    $total_dec_jui = 0;
                    foreach ($resultat2_jui->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_jui = $total_dec_jui + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_jui = $total_dec_jui + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_jui, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_jui->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de juillet
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_jui = $db->prepare($requete1_jun);
                    $resultat1_jui->execute();
                    $total_enc_jui = 0;
                    foreach ($resultat1_jui->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_jui = $total_enc_jui + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_jui = $total_enc_jui + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_jui, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Aout                               *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Ao&ucirc;t</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_aou->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de ao&ucirc;t
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_aou = $db->prepare($requete2_aou);
                    $resultat2_aou->execute();
                    $total_dec_aou = 0;
                    foreach ($resultat2_aou->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_aou = $total_dec_aou + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_aou = $total_dec_aou + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_aou, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_aou->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de ao&ucirc;t
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_aou = $db->prepare($requete1_aou);
                    $resultat1_aou->execute();
                    $total_enc_aou = 0;
                    foreach ($resultat1_aou->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_aou = $total_enc_aou + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_aou = $total_enc_aou + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_aou, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Septembre                          *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Septembre</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_sep->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de septembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_sep = $db->prepare($requete2_sep);
                    $resultat2_sep->execute();
                    $total_dec_sep = 0;
                    foreach ($resultat2_sep->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_sep = $total_dec_sep + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_sep = $total_dec_sep + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_sep, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_sep->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de septembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_sep = $db->prepare($requete1_sep);
                    $resultat1_sep->execute();
                    $total_enc_sep = 0;
                    foreach ($resultat1_sep->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_sep = $total_enc_sep + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_sep = $total_enc_sep + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_sep, 2, ',', ' ');
                    ?>

                </TD>
            </TR>


            <?php
            /*             * *************************************************************
             *                           Octobre                            *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Octobre</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_oct->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de octobre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_oct = $db->prepare($requete2_oct);
                    $resultat2_oct->execute();
                    $total_dec_oct = 0;
                    foreach ($resultat2_oct->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_oct = $total_dec_oct + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_oct = $total_dec_oct + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_oct, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_oct->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de octobre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_oct = $db->prepare($requete1_oct);
                    $resultat1_oct->execute();
                    $total_enc_oct = 0;
                    foreach ($resultat1_oct->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_oct = $total_enc_oct + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_oct = $total_enc_oct + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_oct, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Novembre                           *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Novembre</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_nov->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de novembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_nov = $db->prepare($requete2_nov);
                    $resultat2_nov->execute();
                    $total_dec_nov = 0;
                    foreach ($resultat2_nov->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_nov = $total_dec_nov + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_nov = $total_dec_nov + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_nov, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_nov->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de novembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_nov = $db->prepare($requete1_nov);
                    $resultat1_nov->execute();
                    $total_enc_nov = 0;
                    foreach ($resultat1_nov->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_nov = $total_enc_nov + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_nov = $total_enc_nov + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_nov, 2, ',', ' ');
                    ?>

                </TD>
            </TR>

            <?php
            /*             * *************************************************************
             *                           Décembre                           *
             * ************************************************************* */
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>D&eacute;cembre</I></font>
                </TD>
            <TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat2_dec->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement2['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de d&eacute;cembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat2_dec = $db->prepare($requete2_dec);
                    $resultat2_dec->execute();
                    $total_dec_dec = 0;
                    foreach ($resultat2_dec->fetchAll(PDO::FETCH_ASSOC) as $enregistrement2) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement2['TTC'], 2, ',', ' ');
                            $total_dec_dec = $total_dec_dec + $enregistrement2['TTC'];
                        } else {
                            echo number_format($enregistrement2['HT'], 2, ',', ' ');
                            $total_dec_dec = $total_dec_dec + $enregistrement2['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_dec_dec, 2, ',', ' ');
                    ?>
                </TD>

                <TD align="left"  class="normal">
                    <?php
                    foreach ($resultat1_dec->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        echo "&nbsp;&nbsp;";
                        echo $enregistrement1['DESCRIPTION'];
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                    <BR>&nbsp;&nbsp;Total du mois de d&eacute;cembre
                </TD>
                <TD align="right"  class="normal">
                    <?php
                    $resultat1_dec = $db->prepare($requete1_dec);
                    $resultat1_dec->execute();
                    $total_enc_dec = 0;
                    foreach ($resultat1_dec->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                        if ($tva == "Y") {
                            echo number_format($enregistrement1['TTC'], 2, ',', ' ');
                            $total_enc_dec = $total_enc_dec + $enregistrement1['TTC'];
                        } else {
                            echo number_format($enregistrement1['HT'], 2, ',', ' ');
                            $total_enc_dec = $total_enc_dec + $enregistrement1['HT'];
                        }
                        echo "<BR>";
                    }
                    echo "<BR>";
                    echo number_format($total_enc_dec, 2, ',', ' ');
                    ?>

                </TD>
            </TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD class="normal" align="left">
                    <BR>&nbsp;&nbsp;Total d&eacute;bit
                </TD>
                <TD class="normal" align="right">
                    <BR>
                    <?php
                    $total_dec = $total_dec_jan + $total_dec_fev + $total_dec_mar + $total_dec_avr + $total_dec_mai + $total_dec_jun;
                    $total_dec = $total_dec + $total_dec_jui + $total_dec_aou + $total_dec_sep + $total_dec_oct + $total_dec_nov + $total_dec_dec;
                    echo number_format($total_dec, 2, ',', ' ');
                    ?>
                </TD>
                <TD class="normal" align="left">
                    <BR>&nbsp;&nbsp;Total cr&eacute;dit
                </TD>
                <TD class="normal" align="right">
                    <BR>
                    <?php
                    $total_enc = $total_enc_jan + $total_enc_fev + $total_enc_mar + $total_enc_avr + $total_enc_mai + $total_enc_jun;
                    $total_enc = $total_enc + $total_enc_jui + $total_enc_aou + $total_enc_sep + $total_enc_oct + $total_enc_nov + $total_enc_dec;
                    echo number_format($total_enc, 2, ',', ' ');
                    ?>
                </TD>
            </TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD class="titre" align="left" colspan="2">
                    <BR>&nbsp;&nbsp;Solde pour l'exercice <?php echo $param ?>
                </TD>
                <TD class="titre" align="right" colspan="2">
                    <BR>
                    <?php
                    echo number_format($total_enc - $total_dec, 2, ',', ' ');
                    ?>
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
            <?php
        }
        ?>
        <TR>
            <TD colspan="4">
                &nbsp;
            </TD>
        </TR>
    </TABLE>
</div>
<?php
$Ajouter = "";
$Modifier = "";
$Supprimer = "";
$Rechercher = "";
$Annuler = "";
?>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

//error_reporting(0);
$param = isset($_GET['param']) ? $_GET['param'] : '';
if ($param == "") {
    $param = date("Y");
}

$annee = $param;

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    echo $START_JAVASCRIPT;
    echo "	top.location.replace('../index.php'); ";
    echo $END_JAVASCRIPT;
}

$req_enc_tot = "SELECT sum(MONTANT) 'HT', sum(MONTANT * (1 + TVA/100)) 'TTC_ENC' ";
$req_enc_tot .= "FROM ENCAISSE ";
$req_enc_tot .= "WHERE mid(date_envoi, 1, 4) = " . $annee;
$res_rec_enc = $db->prepare($req_enc_tot);
$res_rec_enc->execute();

$req_dec_tot = "SELECT sum(`DEC_HT_TOT_AMOUNT`) 'HT', sum(`DEC_TTC_TOT_AMOUNT`) 'TTC_DEC' ";
$req_dec_tot .= "FROM DECAISSE ";
$req_dec_tot .= "WHERE mid(`DATE_COMPTA`, 1, 4) = " . $annee;
$res_rec_dec = $db->prepare($req_dec_tot);
$res_rec_dec->execute();

$req_dec_tot_tva = "SELECT sum(`DEC_HT_TOT_AMOUNT`) 'HT', sum(`DEC_TTC_TOT_AMOUNT`) 'TTC_DEC' ";
$req_dec_tot_tva .= "FROM DECAISSE ";
$req_dec_tot_tva .= "WHERE fournisseur != 37 and mid(`DATE_COMPTA`, 1, 4) = " . $annee;
$res_rec_dec_tva = $db->prepare($req_dec_tot_tva);
$res_rec_dec_tva->execute();
?>
<div class="container">
    <TABLE cellpadding="0" cellspacing="0" border="1" bordercolor="white" class="table table-bordered">
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
            <TD align="left"  class="normal">
                <?php
                $tmp1 = $param - 1;
                ?>
                &nbsp;&nbsp;&nbsp;<A class="lien"  href="#" onclick="location.href = 'memo.php?&param=<?php echo $tmp1 ?>';">Ann&eacute;e pr&eacute;c&eacute;dente</A>
            </TD>
            <TD>
            </TD>
            <TD>
            </TD>
            <TD align="right" class="normal">
                <?php
                $tmp2 = $param + 1;
                ?>
                <A class="lien" href="#" onclick="location.href = 'memo.php?&param=<?php echo $tmp2 ?>';">Ann&eacute;e suivante</A>&nbsp;&nbsp;&nbsp;
            </TD>
        </TR>
        <TR>
            <TD class="titre"  align="middle" colspan="4">
                <?php
                if ($res_rec_dec->rowCount() == 0 && $res_rec_enc->rowCount() == 0 && $res_rec_dec_tva->rowCount() == 0)
                    echo "Aucune mémo possible pour l'année $annee.";
                ?>
            </TD>
        </TR>
        <?php
        if ($res_rec_dec->rowCount() != 0 || $res_rec_enc->rowCount() != 0 || $res_rec_dec_tva->rowCount() != 0) {
            ?>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Mémo <?php echo $annee; ?></I></font>
                </TD>
            <TR>
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
                    &nbsp; Total HT en euro &nbsp;
                </TD>
                <TD class="normal" align="middle">
                    &nbsp; Montant TTC en euro &nbsp;
                </TD>
                <TD class="normal" align="middle">
                    &nbsp; Montant HT en euro &nbsp;
                </TD>
                <TD class="normal" align="middle">
                    &nbsp; Montant TTC en euro &nbsp;
                </TD>
            </TR>
            <TR bordercolor="#FF9640" valign="bottom">
                <TD align="left"  class="normal">
                    <?php
                    foreach ($res_rec_dec_tva->fetchAll(PDO::FETCH_ASSOC) as $records) {
                        $ht_dec = $records['HT'];

                        echo "&nbsp;&nbsp;";
                        echo number_format($ht_dec, 2, ',', ' ') . ' €';
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                </TD>
                <TD align="left"  class="normal">
                    <?php
                    foreach ($res_rec_dec->fetchAll(PDO::FETCH_ASSOC) as $records2) {
                        $ttc_dec = $records2['TTC_DEC'];

                        echo "&nbsp;&nbsp;";
                        echo number_format($ttc_dec, 2, ',', ' ') . ' €';
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                </TD>
                <TD align="left"  class="normal">
                    <?php
                    foreach ($res_rec_enc->fetchAll(PDO::FETCH_ASSOC) as $records1) {
                        $ht_enc = $records1['HT'];
                        $ttc_enc = $records1['TTC_ENC'];

                        echo "&nbsp;&nbsp;";
                        echo number_format($ht_enc, 2, ',', ' ') . ' €';
                        echo "&nbsp;&nbsp;";
                        echo "<BR>";
                    }
                    ?>
                </TD>
                <TD align="left"  class="normal">
                    <?php
                    echo "&nbsp;&nbsp;";
                    echo number_format($ttc_enc, 2, ',', ' ') . ' €';
                    echo "&nbsp;&nbsp;";
                    echo "<BR>";
                    ?>
                </TD>
            </TR>
            <TR bordercolor="#FF9640">
                <TD align="middle"  class="normal" colspan=4>
                    &nbsp;&nbsp;&nbsp;<font color="#FF9640"><I>Différence HT</I></font>
                </TD>
            </TR>
            <TR bordercolor="#FF9640">
                <TD align="left"  class="normal" colspan=4>
                    <?php
                    $dif_ht = $ht_enc - $ht_dec;

                    echo "&nbsp;&nbsp;";
                    echo number_format($dif_ht, 2, ',', ' ') . ' €';
                    echo "&nbsp;&nbsp;";
                    echo "<BR>";
                    ?>
                </TD>
            </TR>
        </TABLE>

        <?php
    }

    $req_placement = "select p.id ID, P.client CLIENT, c.nom NomClient, p.poste POSTE, po.libelle NomPoste, p.mois_placement MOIS_PLACEMENT, 
		p.annee_placement ANNEE_PLACEMENT, p.candidat CANDIDAT, concat(ca.nom, ' ', ca.prenom) 'NomCandidat', p.reglement REGLEMENT,
		r.montant MONTANT_REGLEMENT, p.salaire SALAIRE, p.pourcentage POURCENTAGE, p.contrat CONTRAT, p.duree DUREE,p.forfait FORFAIT, 
                p.encaisse ENCAISSE, p.facture FACTURE, r.isFacture RFACTURE, r.isEncaisse RENCAISSE, r.montant HT 
		FROM PLACEMENT p
		LEFT JOIN REGLEMENTS r ON p.ID = r.fk_placement_id
		INNER JOIN CLIENT c ON p.CLIENT = c.id
		INNER JOIN POSTE po ON p.POSTE = po.id
		INNER JOIN CANDIDAT ca ON p.CANDIDAT = ca.id
		WHERE `ANNEE_PLACEMENT` = " . $annee . " AND r.montant != 0 
		AND r.isFacture != 'Y' AND r.isEncaisse != 'Y'";
    $result_req_placement = $db->prepare($req_placement);
    $result_req_placement->execute();
    ?>
    <TABLE class="table table-bordered">
        <TR>
            <TD colspan="8" class="titre" align="middle">
                <BR />Liste des placements de l'année <?php echo $annee; ?> dont la facture n'a pas été émise et non encaissée.
            </TD>
        </TR>
        <?php
        if ($result_req_placement->rowCount() == 0) {
            ?>
            <TR>
                <TD align="left">
                    &nbsp;&nbsp;&nbsp;
                </TD>
                <TD class="titre"  align="middle" colspan=4">
                    Aucun Placement non encaissé trouvé
                </TD>
            </TR>
            <?php
        }
        ?>
        <TR>
            <TD colspan="7">
                &nbsp;
            </TD>
        </TR>

        <?php
        if ($result_req_placement->rowCount() != 0) {
            ?>
            <TR>
                <TD class="titre" align="left" class="col-sm-1">
                    ID
                </TD>
                <TD class="titre" align="left" class="col-sm-2">
                    Client
                </TD>
                <TD class="titre" align="left" class="col-sm-2">
                    Poste
                </TD>
                <TD class="titre" align="left" class="col-sm-2">
                    Candidat
                </TD>
                <TD class="titre" align="left" class="col-sm-1">
                    Mois/Année
                </TD>
                <TD class="titre" align="right" class="col-sm-4">
                    HT		 
                </TD>
            </TR>
            <?php
            $cpt = 0;
            $total = 0;
            foreach ($result_req_placement->fetchAll(PDO::FETCH_ASSOC) as $enregistrement) {
                if (($enregistrement['REGLEMENT'] == "N" && $enregistrement['FACTURE'] == "N" && $enregistrement['ENCAISSE'] == "N") || ($enregistrement['REGLEMENT'] == "Y" && $enregistrement['RFACTURE'] == "N" && $enregistrement['RENCAISSE'] == "N")) {
                    ?>
                    <TR>
                        <TD align="left"  class="normal">
                            <a href="../client/upd_placement.php?id=<?= $enregistrement['ID'] ?>"><?= $enregistrement['ID'] ?></a>
                        </TD>
                        <TD align="left" class="normal">
                            <a href="../client/upd_client.php?id=<?= $enregistrement['CLIENT'] ?>"><?= $enregistrement['NomClient'] ?></a>
                        </TD>
                        <TD align="left" class="normal">
                            <a href="../client/upd_job.php?id=<?= $enregistrement['POSTE'] ?>"><?= $enregistrement['NomPoste'] ?></a>
                        </TD>
                        <TD align="left" class="normal">
                            <a href="../candidat/upd_applicant.php?id=<?= $enregistrement['CANDIDAT'] ?>"><?= $enregistrement['NomCandidat'] ?></a>
                        </TD>
                        <TD align="middle" class="normal">
                            <?php
                            $mois_placement = '';
                            if ($enregistrement['MOIS_PLACEMENT'] == "janvier")
                                $mois_placement = "01";
                            if ($enregistrement['MOIS_PLACEMENT'] == "février")
                                $mois_placement = "02";
                            if ($enregistrement['MOIS_PLACEMENT'] == "mars")
                                $mois_placement = "03";
                            if ($enregistrement['MOIS_PLACEMENT'] == "avril")
                                $mois_placement = "04";
                            if ($enregistrement['MOIS_PLACEMENT'] == "mai")
                                $mois_placement = "05";
                            if ($enregistrement['MOIS_PLACEMENT'] == "juin")
                                $mois_placement = "06";
                            if ($enregistrement['MOIS_PLACEMENT'] == "juillet")
                                $mois_placement = "07";
                            if ($enregistrement['MOIS_PLACEMENT'] == "août")
                                $mois_placement = "08";
                            if ($enregistrement['MOIS_PLACEMENT'] == "septembre")
                                $mois_placement = "09";
                            if ($enregistrement['MOIS_PLACEMENT'] == "octobre")
                                $mois_placement = "10";
                            if ($enregistrement['MOIS_PLACEMENT'] == "novembre")
                                $mois_placement = "11";
                            if ($enregistrement['MOIS_PLACEMENT'] == "décembre")
                                $mois_placement = "12";

                            echo $mois_placement . "/" . $enregistrement['ANNEE_PLACEMENT']
                            ?>
                        </TD>
                        <TD class="text-right">
                            &nbsp;&nbsp;&nbsp;
                            <?php
                            echo number_format($enregistrement['HT'], 2, ',', ' ') . ' €';
                            $total += $enregistrement['HT'];
                            ?>
                        </TD>
                    </TR>
                    <?php
                    $cpt = $cpt + 1;
                }
            }
            ?>
            <TR>
                <TD colspan="7" class="normal">
                    &nbsp;Le montant total des placements s&eacute;lectionn&eacute;s s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total, 2, ',', ' '); ?> euros HT.
                </TD>
            </TR>
        </table>

        <?php
        $req_placement = "select p.id ID, P.client CLIENT, c.nom NomClient, p.poste POSTE, po.libelle NomPoste, p.mois_placement MOIS_PLACEMENT, 
		p.annee_placement ANNEE_PLACEMENT, p.candidat CANDIDAT, concat(ca.nom, ' ', ca.prenom) 'NomCandidat', p.reglement REGLEMENT,
		r.montant MONTANT_REGLEMENT, p.salaire SALAIRE, p.pourcentage POURCENTAGE, p.contrat CONTRAT, p.duree DUREE,p.forfait FORFAIT, 
                p.encaisse ENCAISSE, p.facture FACTURE, r.isFacture RFACTURE, r.isEncaisse RENCAISSE, r.montant HT 
		FROM PLACEMENT p
		LEFT JOIN REGLEMENTS r ON p.ID = r.fk_placement_id
		INNER JOIN CLIENT c ON p.CLIENT = c.id
		INNER JOIN POSTE po ON p.POSTE = po.id
		INNER JOIN CANDIDAT ca ON p.CANDIDAT = ca.id
		WHERE `ANNEE_PLACEMENT` = " . $annee . " AND r.montant != 0 
		AND r.isFacture = 'Y' AND r.isEncaisse != 'Y'";
        $result_req_placement = $db->prepare($req_placement);
        $result_req_placement->execute();
        ?>
        <TABLE class="table table-bordered">
            <TR>
                <TD colspan="8" class="titre" align="middle">
                    <BR />Liste des placements de l'année <?php echo $annee; ?> dont la facture a été émise mais non encaissée.
                </TD>
            </TR>
            <?php
            if ($result_req_placement->rowCount() == 0) {
                ?>
                <TR>
                    <TD align="left">
                        &nbsp;&nbsp;&nbsp;
                    </TD>
                    <TD class="titre"  align="middle" colspan=4">
                        Aucun Placement non encaissé trouvé
                    </TD>
                </TR>
                <?php
            }
            ?>
            <TR>
                <TD colspan="7">
                    &nbsp;
                </TD>
            </TR>

            <?php
            if ($result_req_placement->rowCount() != 0) {
                ?>
                <TR>
                    <TD class="titre" align="left" class="col-sm-1">
                        ID
                    </TD>
                    <TD class="titre" align="left" class="col-sm-2">
                        Client
                    </TD>
                    <TD class="titre" align="left" class="col-sm-2">
                        Poste
                    </TD>
                    <TD class="titre" align="left" class="col-sm-2">
                        Candidat
                    </TD>
                    <TD class="titre" align="left" class="col-sm-1">
                        Mois/Année
                    </TD>
                    <TD class="titre" align="right" class="col-sm-4">
                        HT		 
                    </TD>
                </TR>
                <?php
                $cpt = 0;
                $total = 0;
                foreach ($result_req_placement->fetchAll(PDO::FETCH_ASSOC) as $enregistrement) {
                    if (($enregistrement['REGLEMENT'] == "N" && $enregistrement['FACTURE'] == "N" && $enregistrement['ENCAISSE'] == "N") || ($enregistrement['REGLEMENT'] == "Y" && $enregistrement['RFACTURE'] == "N" && $enregistrement['RENCAISSE'] == "N")) {
                        ?>
                        <TR>
                            <TD align="left"  class="normal">
                                <a href="../client/upd_placement.php?id=<?= $enregistrement['ID'] ?>"><?= $enregistrement['ID'] ?></a>
                            </TD>
                            <TD align="left" class="normal">
                                <a href="../client/upd_client.php?id=<?= $enregistrement['CLIENT'] ?>"><?= $enregistrement['NomClient'] ?></a>
                            </TD>
                            <TD align="left" class="normal">
                                <a href="../client/upd_job.php?id=<?= $enregistrement['POSTE'] ?>"><?= $enregistrement['NomPoste'] ?></a>
                            </TD>
                            <TD align="left" class="normal">
                                <a href="../candidat/upd_applicant.php?id=<?= $enregistrement['CANDIDAT'] ?>"><?= $enregistrement['NomCandidat'] ?></a>
                            </TD>
                            <TD align="middle" class="normal">
                                <?php
                                $mois_placement = '';
                                if ($enregistrement['MOIS_PLACEMENT'] == "janvier")
                                    $mois_placement = "01";
                                if ($enregistrement['MOIS_PLACEMENT'] == "février")
                                    $mois_placement = "02";
                                if ($enregistrement['MOIS_PLACEMENT'] == "mars")
                                    $mois_placement = "03";
                                if ($enregistrement['MOIS_PLACEMENT'] == "avril")
                                    $mois_placement = "04";
                                if ($enregistrement['MOIS_PLACEMENT'] == "mai")
                                    $mois_placement = "05";
                                if ($enregistrement['MOIS_PLACEMENT'] == "juin")
                                    $mois_placement = "06";
                                if ($enregistrement['MOIS_PLACEMENT'] == "juillet")
                                    $mois_placement = "07";
                                if ($enregistrement['MOIS_PLACEMENT'] == "août")
                                    $mois_placement = "08";
                                if ($enregistrement['MOIS_PLACEMENT'] == "septembre")
                                    $mois_placement = "09";
                                if ($enregistrement['MOIS_PLACEMENT'] == "octobre")
                                    $mois_placement = "10";
                                if ($enregistrement['MOIS_PLACEMENT'] == "novembre")
                                    $mois_placement = "11";
                                if ($enregistrement['MOIS_PLACEMENT'] == "décembre")
                                    $mois_placement = "12";

                                echo $mois_placement . "/" . $enregistrement['ANNEE_PLACEMENT']
                                ?>
                            </TD>
                            <TD class="text-right">
                                &nbsp;&nbsp;&nbsp;
                                <?php
                                echo number_format($enregistrement['HT'], 2, ',', ' ') . ' €';
                                $total += $enregistrement['HT'];
                                ?>
                            </TD>
                        </TR>
                        <?php
                        $cpt = $cpt + 1;
                    }
                }
                ?>
                <TR>
                    <TD colspan="7" class="normal">
                        &nbsp;Le montant total des placements s&eacute;lectionn&eacute;s s'&eacute;l&egrave;ve &agrave; <?php echo number_format($total, 2, ',', ' '); ?> euros HT.
                    </TD>
                </TR>
                <?php
            }
            ?>
            <TR>
                <TD colspan="7">
                    &nbsp;
                </TD>
            </TR>
        </TABLE>
        <?php
    }
    ?>
</div>
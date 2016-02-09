<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

error_reporting(0);
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
        <TD colspan="4">
            &nbsp;
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
    <TR>
        <TD colspan="4">
            &nbsp;
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
                    echo number_format($ht_dec, 2, ',', ' ');
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
                    echo number_format($ttc_dec, 2, ',', ' ');
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
                    echo number_format($ht_enc, 2, ',', ' ');
                    echo "&nbsp;&nbsp;";
                    echo "<BR>";
                }
                ?>
            </TD>
            <TD align="left"  class="normal">
                <?php
                echo "&nbsp;&nbsp;";
                echo number_format($ttc_enc, 2, ',', ' ');
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
                $dif_ttc = $ttc_enc - $ttc_dec;
                $dif_ht = $ht_enc - $ht_dec;

                echo "&nbsp;&nbsp;";
                echo number_format($dif_ht, 2, ',', ' ');
                echo "&nbsp;&nbsp;";
                echo "<BR>";
                ?>
            </TD>
        </TR>
    </TABLE>

    <?php
}


/* $req_placement   = " select PLACEMENT.ID, PLACEMENT.CLIENT, PLACEMENT.POSTE, PLACEMENT.CANDIDAT, PLACEMENT.CONSULTANT, MOIS_PLACEMENT, ANNEE_PLACEMENT,";
  $req_placement  .= " PLACEMENT.TITRE, PLACEMENT.DESCRIPTION, PLACEMENT.CONTRAT, PLACEMENT.DUREE, PLACEMENT.LIEUX, POSTE.DUREE, PLACEMENT.APPORTEUR, ";
  $req_placement  .= " PLACEMENT.SALAIRE, PLACEMENT.HORAIRES, DATE_FORMAT(PLACEMENT.DATE_DEB,'%d/%m/%Y') 'DATE_DEB', ";
  $req_placement  .= " PLACEMENT.POURCENTAGE, PLACEMENT.REMISE, PLACEMENT.FORFAIT, PLACEMENT.FACTURE, PLACEMENT.ENCAISSE, PLACEMENT.REMARQUE,  ";
  $req_placement  .= " str_to_date(CONCAT('01/',CONCAT(CONCAT(LPAD(mois_placement+0,2,'0'),'/'),annee_placement)) ,'%d/%m/%Y')  DATE_PLACEMENT, ";
  $req_placement  .= " concat(CANDIDAT.NOM, ' ', CANDIDAT.PRENOM) 'NomCandidat', POSTE.LIBELLE 'NomPoste', CLIENT.NOM 'NomClient' ";
  $req_placement  .= " from PLACEMENT, CLIENT, POSTE, CANDIDAT";
  $req_placement  .= " where PLACEMENT.CLIENT = CLIENT.ID AND PLACEMENT.CANDIDAT = CANDIDAT.ID and PLACEMENT.POSTE = POSTE.ID ";
  $req_placement  .= " AND `ENCAISSE` = 'N' AND FACTURE = 'N' AND `ANNEE_PLACEMENT` = " . $annee;
  $req_placement  .= " order by DATE_PLACEMENT "; */

$req_placement = "select p.id ID, P.client CLIENT, c.nom NomClient, p.poste POSTE, po.libelle NomPoste, p.mois_placement MOIS_PLACEMENT, 
		p.annee_placement ANNEE_PLACEMENT, p.candidat CANDIDAT, concat(ca.nom, ' ', ca.prenom) 'NomCandidat', p.reglement REGLEMENT,
		r.montant MONTANT_REGLEMENT, p.salaire SALAIRE, p.pourcentage POURCENTAGE, p.contrat CONTRAT, p.duree DUREE,p.forfait FORFAIT, p.encaisse ENCAISSE, p.facture FACTURE, r.isFacture RFACTURE, r.isEncaisse RENCAISSE 
		FROM PLACEMENT p
		LEFT JOIN REGLEMENTS r ON p.ID = r.fk_placement_id
		INNER JOIN CLIENT c ON p.CLIENT = c.id
		INNER JOIN POSTE po ON p.POSTE = po.id
		INNER JOIN CANDIDAT ca ON p.CANDIDAT = ca.id
		WHERE `ANNEE_PLACEMENT` = " . $annee;
$result_req_placement = $db->prepare($req_placement);
$result_req_placement->execute();
?>
<TABLE style="width:70%">
    <TR>
        <TD colspan="8" class="titre" align="middle">
            <BR />Liste des placements de l'année <?php echo $annee; ?> dont la facture n'a pas été émise et non encaissée.
        </TD>
    </TR>
    <TR>
        <TD colspan="8">
            &nbsp;
        </TD>
    </TR>
    <TR>
        <TD align="left">
            &nbsp;&nbsp;&nbsp;
        </TD>
        <TD class="titre"  align="middle" colspan=4">
            <?php
            if ($result_req_placement->rowCount() == 0)
                echo ': Aucun Placement non encaissé trouvé.<BR />';
            ?>
        </TD>
    </TR>
    <TR>
        <TD colspan="7">
            &nbsp;
        </TD>
    </TR>

    <?php
    if ($result_req_placement->rowCount() != 0) {
        ?>
        <TR>
            <TD class="titre" align="left">
                <BR />&nbsp;&nbsp;&nbsp;&nbsp;Identifiant<BR />
            </TD>
            <TD class="titre" align="left">
                <BR />&nbsp;&nbsp;&nbsp;&nbsp;Client<BR />
            </TD>
            <TD class="titre" align="left">
                <BR />&nbsp;&nbsp;&nbsp;&nbsp;Poste<BR />
            </TD>
            <TD class="titre" align="left">
                <BR />&nbsp;&nbsp;&nbsp;&nbsp;Candidat<BR />
            </TD>
            <TD class="titre" align="left" WIDTH=70>
                <BR />&nbsp;&nbsp;&nbsp;&nbsp;Mois<BR />
            </TD>
            <TD class="titre" align="middle" WIDTH=65>
                HT		 
            </TD>
        </TR>
        <?php
        $cpt = 0;
        foreach ($result_req_placement->fetchAll(PDO::FETCH_ASSOC) as $enregistrement) {
            if (($enregistrement['REGLEMENT'] == "N" && $enregistrement['FACTURE'] == "N" && $enregistrement['ENCAISSE'] == "N") || ($enregistrement['REGLEMENT'] == "Y" && $enregistrement['RFACTURE'] == "N" && $enregistrement['RENCAISSE'] == "N")) {
                ?>
                <TR>
                    <TD align="center"  class="normal" style="width:10%">
                        <a href="../client/upd_placement.php?id=<?= $enregistrement['ID'] ?>"><?= $enregistrement['ID'] ?></a>
                    </TD>
                    <TD align="left" class="normal" style="width:20%">
                        <a href="../client/upd_client.php?id=<?= $enregistrement['CLIENT'] ?>"><?= $enregistrement['NomClient'] ?></a>
                    </TD>
                    <TD align="left" class="normal" style="width:30%">
                        <?php
                        $tmp4 = urlencode($enregistrement['POSTE']);
                        echo "<A onclick=\"go_to('../client/poste.php?&param=$tmp4');\" href=\"#\" class=\"lien\"><U>".$enregistrement['NomPoste']."</U></A>";
                        ?>
                    </TD>
                    <TD align="left" class="normal" style="width:20%">
                        <?php
                        $tmp5 = urlencode($enregistrement['CANDIDAT']);
                        echo "<A onclick=\"go_to('../candidat/candidat.php?&param=$tmp5');\" href=\"#\" class=\"lien\"><U>".$enregistrement['NomCandidat']."</U></A>";
                        ?>
                    </TD>
                    <TD align="middle" class="normal" style="width:10%">
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
                    <TD align="middle" class="normal" style="width:10%">
                        &nbsp;&nbsp;&nbsp;
                        <?php
                        if ($enregistrement['REGLEMENT'] == "Y") {
                            $montant = $enregistrement['MONTANT_REGLEMENT'];
                        } else {
                            if ($enregistrement['FORFAIT'] == "" || $enregistrement['FORFAIT'] == 0)
                                if ($enregistrement['CONTRAT'] == 'CDI') {
                                    $montant = ($enregistrement['SALAIRE'] * $enregistrement['POURCENTAGE'] / 100) - $enregistrement['REMISE'];
                                } elseif ($enregistrement['CONTRAT'] == 'CDD') {
                                    $montant = ($enregistrement['SALAIRE'] * $enregistrement['POURCENTAGE'] * $enregistrement['DUREE'] / (12 * 100)) - $enregistrement['REMISE'];
                                } else {
                                    $montant = $enregistrement['FORFAIT'];
                                }
                        }
                        echo number_format($montant, 2, ',', ' ');
                        $total = $total + $montant;
                        ?>
                    </TD>
                </TR>
                <?php
                $cpt = $cpt + 1;
            }
        }
        ?>


        <?php
        /* $req_placement   = " select PLACEMENT.ID, PLACEMENT.CLIENT, PLACEMENT.POSTE, PLACEMENT.CANDIDAT, PLACEMENT.CONSULTANT, MOIS_PLACEMENT, ANNEE_PLACEMENT,";
          $req_placement  .= " PLACEMENT.TITRE, PLACEMENT.DESCRIPTION, PLACEMENT.CONTRAT, PLACEMENT.DUREE, PLACEMENT.LIEUX, POSTE.DUREE, PLACEMENT.APPORTEUR, ";
          $req_placement  .= " PLACEMENT.SALAIRE, PLACEMENT.HORAIRES, DATE_FORMAT(PLACEMENT.DATE_DEB,'%d/%m/%Y') 'DATE_DEB', ";
          $req_placement  .= " PLACEMENT.POURCENTAGE, PLACEMENT.REMISE, PLACEMENT.FORFAIT, PLACEMENT.FACTURE, PLACEMENT.ENCAISSE, PLACEMENT.REMARQUE,  ";
          $req_placement  .= " str_to_date(CONCAT('01/',CONCAT(CONCAT(LPAD(mois_placement+0,2,'0'),'/'),annee_placement)) ,'%d/%m/%Y')  DATE_PLACEMENT, ";
          $req_placement  .= " concat(CANDIDAT.NOM, ' ', CANDIDAT.PRENOM) 'NomCandidat', POSTE.LIBELLE 'NomPoste', CLIENT.NOM 'NomClient' ";
          $req_placement  .= " from PLACEMENT, CLIENT, POSTE, CANDIDAT";
          $req_placement  .= " where PLACEMENT.CLIENT = CLIENT.ID AND PLACEMENT.CANDIDAT = CANDIDAT.ID and PLACEMENT.POSTE = POSTE.ID ";
          $req_placement  .= " AND `ENCAISSE` = 'N' AND FACTURE = 'Y' AND `ANNEE_PLACEMENT` = " . $annee;
          $req_placement  .= " order by DATE_PLACEMENT "; */

        $req_placement = "select p.id ID, P.client CLIENT, c.nom NomClient, p.poste POSTE, po.libelle NomPoste, p.mois_placement MOIS_PLACEMENT, 
		p.annee_placement ANNEE_PLACEMENT, p.candidat CANDIDAT, concat(ca.nom, ' ', ca.prenom) 'NomCandidat', p.reglement REGLEMENT,
		r.montant MONTANT_REGLEMENT, p.salaire SALAIRE, p.pourcentage POURCENTAGE, p.contrat CONTRAT, p.duree DUREE,p.forfait FORFAIT, p.encaisse ENCAISSE, p.facture FACTURE, r.isFacture RFACTURE, r.isEncaisse RENCAISSE 
		FROM PLACEMENT p
		LEFT JOIN REGLEMENTS r ON p.ID = r.fk_placement_id
		INNER JOIN CLIENT c ON p.CLIENT = c.id
		INNER JOIN POSTE po ON p.POSTE = po.id
		INNER JOIN CANDIDAT ca ON p.CANDIDAT = ca.id
		WHERE `ANNEE_PLACEMENT` = " . $annee;
        $result_req_placement = $db->prepare($req_placement);
        $result_req_placement->execute();
        ?>
        <TABLE style="width:70%">
            <TR>
                <TD colspan="8" class="titre" align="middle">
                    <BR />Liste des placements de l'année <?php echo $annee; ?> dont la facture a été émise mais non encaissée.
                </TD>
            </TR>
            <TR>
                <TD colspan="8">
                    &nbsp;
                </TD>
            </TR>
            <TR>
                <TD align="left">
                    &nbsp;&nbsp;&nbsp;
                </TD>
                <TD class="titre"  align="middle" colspan=4">
                    <?php
                    if ($result_req_placement->rowCount() == 0) {
                        echo ': Aucun Placement non encaissé trouvé.<BR />';
                    }
                    ?>
                </TD>
            </TR>
            <TR>
                <TD colspan="7">
                    &nbsp;
                </TD>
            </TR>

            <?php
            if ($result_req_placement->rowCount() != 0) {
                ?>
                <TR>
                    <TD class="titre" align="left" >
                        <sub><a href="#"><img border=0 src="../image/up.jpg" onclick="document.formulaire.order.value = 'ID';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                        <BR />&nbsp;&nbsp;&nbsp;&nbsp;Identifiant<BR />		 
                        <sub><a href="#"><img border=0 src="../image/down.jpg" onclick="document.formulaire.order.value = 'ID desc';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                    </TD>
                    <TD class="titre" align="left">
                        <sub><a href="#"><img border=0 src="../image/up.jpg" onclick="document.formulaire.order.value = 'NOMCLIENT';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                        <BR />&nbsp;&nbsp;&nbsp;&nbsp;Client<BR />
                        <sub><a href="#"><img border=0 src="../image/down.jpg" onclick="document.formulaire.order.value = 'NOMCLIENT desc';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                    </TD>
                    <TD class="titre" align="left">
                        <sub><a href="#"><img border=0 src="../image/up.jpg" onclick="document.formulaire.order.value = 'NOMPOSTE';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                        <BR />&nbsp;&nbsp;&nbsp;&nbsp;Poste<BR />
                        <sub><a href="#"><img border=0 src="../image/down.jpg" onclick="document.formulaire.order.value = 'NOMPOSTE desc';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                    </TD>
                    <TD class="titre" align="left">
                        <sub><a href="#"><img border=0 src="../image/up.jpg" onclick="document.formulaire.order.value = 'NomCandidat';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                        <BR />&nbsp;&nbsp;&nbsp;&nbsp;Candidat<BR />
                        <sub><a href="#"><img border=0 src="../image/down.jpg" onclick="document.formulaire.order.value = 'NomCandidat desc';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                    </TD>
                    <TD class="titre" align="left" WIDTH=70>
                        <sub><a href="#"><img border=0 src="../image/up.jpg" onclick="document.formulaire.order.value = 'DATE_PLACEMENT';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                        <BR />&nbsp;&nbsp;&nbsp;&nbsp;Mois<BR />		 
                        <sub><a href="#"><img border=0 src="../image/down.jpg" onclick="document.formulaire.order.value = 'DATE_PLACEMENT desc';
                                        document.formulaire.Rechercher.value = 'Rechercher';
                                        document.formulaire.submit();"></a></sub>
                    </TD>
                    <TD class="titre" align="middle" WIDTH=65>
                        HT		 
                    </TD>
                </TR>
                <?php
                $cpt = 0;
                foreach ($result_req_placement->fetchAll(PDO::FETCH_ASSOC) as $enregistrement) {
                    if (($enregistrement[REGLEMENT] == "N" && $enregistrement[FACTURE] == "Y" && $enregistrement[ENCAISSE] == "N") || ($enregistrement[REGLEMENT] == "Y" && $enregistrement[RFACTURE] == "Y" && $enregistrement[RENCAISSE] == "N")) {
                        ?>
                        <TR <?php
                        if (($cpt % 2) == 0)
                            echo "bgcolor=\"#CCCCCC\" OnMouseover=\"this.bgColor='#EEEEEE';\" OnMouseout=\"this.bgColor='#CCCCCC';\"";
                        else
                            echo "OnMouseover=\"this.bgColor='#EEEEEE';\" OnMouseout=\"this.bgColor='#FFFFFF';\"";
                        ?> 
                            >
                            <TD align="center"  class="normal" style="width:10%">
                                <?php
                                $tmp2 = urlencode($enregistrement[ID]);
                                echo "<A onclick=\"go_to('../client/placement.php?&param=$tmp2');\" href=\"#\" class=\"lien\"><U>$enregistrement[ID]</U></A>";
                                ?>
                            </TD>
                            <TD align="left" class="normal" style="width:20%">
                                <?php
                                $tmp3 = urlencode($enregistrement[CLIENT]);
                                echo "<A onclick=\"go_to('../client/societe.php?&param=$tmp3');\" href=\"#\" class=\"lien\"><U>$enregistrement[NomClient]</U></A>";
                                ?>
                            </TD>
                            <TD align="left" class="normal" style="width:30%">
                                <?php
                                $tmp4 = urlencode($enregistrement[POSTE]);
                                echo "<A onclick=\"go_to('../client/poste.php?&param=$tmp4');\" href=\"#\" class=\"lien\"><U>$enregistrement[NomPoste]</U></A>";
                                ?>
                            </TD>
                            <TD align="left" class="normal" style="width:20%">
                                <?php
                                $tmp5 = urlencode($enregistrement[CANDIDAT]);
                                echo "<A onclick=\"go_to('../candidat/candidat.php?&param=$tmp5');\" href=\"#\" class=\"lien\"><U>$enregistrement[NomCandidat]</U></A>";
                                ?>
                            </TD>
                            <TD align="middle" class="normal" style="width:10%">
                                <?php
                                if ($enregistrement[MOIS_PLACEMENT] == "janvier")
                                    $mois_placement = "01";
                                if ($enregistrement[MOIS_PLACEMENT] == "février")
                                    $mois_placement = "02";
                                if ($enregistrement[MOIS_PLACEMENT] == "mars")
                                    $mois_placement = "03";
                                if ($enregistrement[MOIS_PLACEMENT] == "avril")
                                    $mois_placement = "04";
                                if ($enregistrement[MOIS_PLACEMENT] == "mai")
                                    $mois_placement = "05";
                                if ($enregistrement[MOIS_PLACEMENT] == "juin")
                                    $mois_placement = "06";
                                if ($enregistrement[MOIS_PLACEMENT] == "juillet")
                                    $mois_placement = "07";
                                if ($enregistrement[MOIS_PLACEMENT] == "août")
                                    $mois_placement = "08";
                                if ($enregistrement[MOIS_PLACEMENT] == "septembre")
                                    $mois_placement = "09";
                                if ($enregistrement[MOIS_PLACEMENT] == "octobre")
                                    $mois_placement = "10";
                                if ($enregistrement[MOIS_PLACEMENT] == "novembre")
                                    $mois_placement = "11";
                                if ($enregistrement[MOIS_PLACEMENT] == "décembre")
                                    $mois_placement = "12";

                                echo $mois_placement . "/" . $enregistrement[ANNEE_PLACEMENT]
                                ?>
                            </TD>
                            <TD align="middle" class="normal" style="width:10%">
                                &nbsp;&nbsp;&nbsp;
                                <?php
                                if ($enregistrement[REGLEMENT] == "Y") {
                                    $montant = $enregistrement[MONTANT_REGLEMENT];
                                } else {
                                    if ($enregistrement[FORFAIT] == "" || $enregistrement[FORFAIT] == 0)
                                        if ($enregistrement[CONTRAT] == 'CDI')
                                            $montant = ($enregistrement[SALAIRE] * $enregistrement[POURCENTAGE] / 100) - $enregistrement[REMISE];
                                        else
                                            $montant = ($enregistrement[SALAIRE] * $enregistrement[POURCENTAGE] * $enregistrement[DUREE] / (12 * 100)) - $enregistrement[REMISE];
                                    else
                                        $montant = $enregistrement[FORFAIT];
                                }
                                echo number_format($montant, 2, ',', ' ');
                                $total = $total + $montant;
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
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
                <TR>
                    <TD colspan="7" class="normal">
                    </TD>
                </TR>
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
    <TABLE cellpadding="0" cellspacing="0" border="1" bordercolor="white">
        <TR bordercolor="#FF9640">
            <TD colspan="4" class="titre" align="middle">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Différence Totale&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </TD>
            <TD align="left"  class="normal" colspan=4>
                <?php
                $dif_ttc = $ttc_enc - $ttc_dec;
                $dif_ht = $ht_enc - $ht_dec;

                $dif_finale = $dif_ht + $total;

                echo "&nbsp;&nbsp;";
                echo number_format($dif_finale, 2, ',', ' ');
                echo "&nbsp;&nbsp;";
                echo "<BR>";
                ?>
            </TD>
        </TR>
    </TABLE>
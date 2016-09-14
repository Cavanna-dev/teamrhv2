<?php
include './functions/connection_db.php';
error_reporting(0);
$param = isset($_GET['param']) ? $_GET['param'] : '';

// Par défaut on prend le planning de la semaine courante.
if ($param == "") {
    $param = date("Y") . "-" . date("m") . "-" . date("d");
}
$heightCase = 26;
$START_JAVASCRIPT = '<script type="text/javascript">';
$END_JAVASCRIPT = '</script>';

// On cherche le jour de la semaine et on construit la where clause
$tms = mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4));
$nomjour = date("l", $tms);
$clause = " 1 = 1 ";
if ($Annuler == "Annuler")
    $consultant = "";
if ($consultant != "")
    $clause .= "   and RESA_SALLE.CONSULTANT1 = $consultant ";
if ($numsalle != "")
    $clause .= "   and RESA_SALLE.NUMSALLE = $numsalle ";

switch ($nomjour)
{
    case "Monday":
        $nomjour = "lundi";
        $clause .= " and  RESA_SALLE.jour  between  date_sub('$param', interval 0 day) and date_add('$param', interval 6 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 6, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 3, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 4, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 5, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 6, substr($param, 0, 4)));
        break;
    case "Tuesday":
        $nomjour = "mardi";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 1 day) and date_add('$param', interval 5 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 5, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 3, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 4, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 5, substr($param, 0, 4)));
        break;
    case "Wednesday":
        $nomjour = "mercredi";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 2 day) and date_add('$param', interval 4 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 4, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 3, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 4, substr($param, 0, 4)));
        break;
    case "Thursday":
        $nomjour = "jeudi";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 3 day) and date_add('$param', interval 3 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 3, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 3, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 3, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 3, substr($param, 0, 4)));
        break;
    case "Friday":
        $nomjour = "vendredi";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 4 day) and date_add('$param', interval 2 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 4, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 4, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 3, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 2, substr($param, 0, 4)));
        break;
    case "Saturday":
        $nomjour = "samedi";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 5 day) and date_add('$param', interval 1 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 5, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 5, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 4, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 3, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) + 1, substr($param, 0, 4)));
        break;
    case "Sunday":
        $nomjour = "dimanche";
        $clause .= " and  RESA_SALLE.jour between  date_sub('$param', interval 6 day) and date_add('$param', interval 0 day) ";
        $jour_deb = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 6, substr($param, 0, 4)));
        $jour_fin = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        $lundi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 6, substr($param, 0, 4)));
        $mardi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 5, substr($param, 0, 4)));
        $mercredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 4, substr($param, 0, 4)));
        $jeudi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 3, substr($param, 0, 4)));
        $vendredi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 2, substr($param, 0, 4)));
        $samedi = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2) - 1, substr($param, 0, 4)));
        $dimanche = date("d/m/Y", mktime(0, 0, 0, substr($param, 5, 2), substr($param, 8, 2), substr($param, 0, 4)));
        break;
}

$requete = "SELECT RESA_SALLE.ID, mid(RESA_SALLE.nom,1,10) 'CANDIDAT', DATE_FORMAT(jour,'%d/%m/%Y') 'DATE_RDV', ";
$requete .= "  DATE_FORMAT(jour,'%Y/%m/%d') 'ORDRE', HEURE_DEB, MINUTE_DEB, HEURE_FIN, MINUTE_FIN, RESA_SALLE.TYPE 'TYPE', CLIENT.NOM 'NOMCLIENT', ";
$requete .= "  concat(mid(UTILISATEUR.PRENOM,1,1),'.',UTILISATEUR.NOM) 'CONSULTANT', UTILISATEUR.NOM 'NOMCONSULT', NUMSALLE , JOUR, ";
$requete .= "  RESA_SALLE.NOM 'NOMCANDIDAT', RESA_SALLE.PRENOM 'PRENOMCANDIDAT', RESA_SALLE.CIVILITE, TITRE.LIBELLE, ";
$requete .= "  concat(mid(ACCOMP.PRENOM,1,1),'.',ACCOMP.NOM) 'ACCOMPAGNE', ACCOMP.INITIALE 'ACCOMPAGNE2', ACCOMP.COLOR 'COLOR2', UTILISATEUR.COLOR, ";
$requete .= "  RESA_SALLE.CANCELLED ";
$requete .= "FROM UTILISATEUR, RESA_SALLE " . PHP_EOL;
$requete .= "	left join UTILISATEUR ACCOMP on ACCOMP.ID = RESA_SALLE.CONSULTANT2 " . PHP_EOL;
$requete .= "  left join CLIENT on RESA_SALLE.CLIENT = CLIENT.ID " . PHP_EOL;
$requete .= "  left join TITRE on RESA_SALLE.POSTE = TITRE.ID " . PHP_EOL;
$requete .= "WHERE " . $clause . " and RESA_SALLE.CONSULTANT1 = UTILISATEUR.ID " . PHP_EOL;
$requete .= "ORDER BY 5, 4, 6, 7, 1 ";

$resultat = $db->prepare($requete);
$resultat->execute();
$r = $resultat->fetchAll(PDO::FETCH_ASSOC);
?>

<TABLE cellpadding="0" cellspacing="0" border="1" bordercolor="white" width="1200" style="margin-left: 315px;">
    <TR>
        <TD colspan="6" class="titre" align="middle">
            <BR>&nbsp;&nbsp;&nbsp;&nbsp;Liste des RDV pour la p&eacute;riode allant du Lundi <?php echo $lundi; ?> au Samedi <?php echo $samedi; ?>
            <BR>&nbsp;
        </TD>
    </TR>
    <TR>
        <TD colspan="2" align="right" class="titre">
            Voir les RDV de:
        </TD>
        <TD colspan="2" align="middle">
            <?php
            $tmp6 = urlencode($param);
            ?>
            <select class="normal" name="consultant" size="1" onchange="go_to('agenda.php?&param=<?php echo $tmp6; ?>')">
                <?php
                $requete1 = " SELECT ID, concat(nom, ' ', prenom) 'nom' ";
                $requete1 .= " FROM   utilisateur ";
                $requete1 .= " WHERE type IN ( 'CONSULT', 'ADMIN', 'ASSOC') and actif ='Y' ";
                $requete1 .= " ORDER BY concat(nom, ' ', prenom) ";

                $resultat1 = $db->prepare($requete1);
                $resultat1->execute();
                $r1 = $resultat1->fetchAll(PDO::FETCH_ASSOC);

                if (!$r1) {
                    echo " <option  selected value=\"\"> Tous les consultants </option> ";
                } else {
                    echo " <option  selected value=\"\"> Tous les consultants </option> ";

                    foreach ($r1 as $t) {
                        echo " <option ";

                        if ($consultant == $t[ID])
                            echo " selected ";

                        echo " value=$t[ID] > $t[nom] </option> ";
                    }
                }
                ?>
            </select>
        </TD>
        <TD colspan="2" align="left">
            <?php ?>
            <select class="normal" name="numsalle" size="1" onchange="go_to('agenda.php?&param=<?php echo $tmp6; ?>')">
                <option  selected value="" > Toutes les salles</option>
                <option <?php if ($numsalle == 1) echo "selected"; ?> value="1"> Salle A</option>
                <option <?php if ($numsalle == 2) echo "selected"; ?> value="2"> Salle B</option>
                <option <?php if ($numsalle == 3) echo "selected"; ?> value="3"> Salle C</option>
            </select>
        </TD>
    </TR>
    <TR>
        <?php
        if ($erreur == "oui") {
            ?>
            <TD class="titre"  align="middle" colspan="6">
                <B>Connexion impossible &agrave; notre base de donn&eacute;es. Renouveller votre recherche ult&eacute;rieurement.<B>
                        </TD>
                        </TR>
                        <?php
                    } else {
                        ?>
                        <TD class="titre"  align="middle" colspan="6">
                            <?php
                            if (count($r) == 0)
                                echo "Aucun RDV n'est organis&eacute; pour cette semaine. ";
                            ?>
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
                    <TR>
                        <TD align="left"  class="normal" colspan=2>
                            <?php
                            $tmp1 = date("Y-m-d", strtotime('-1 week', strtotime($param)));
                            ?>
                            <A class="lien"  href='index.php?&param=<?php echo $tmp1 ?>'>Semaine précédente</A>
                        </TD>
                        <TD align="center" colspan=3>
                            <a href="./candidat/newRdv.php"><U><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Nouveau RDV</U></A>
                        </TD>
                        <TD align="right"  class="normal">
                            <?php
                            $tmp2 = date("Y-m-d", strtotime('+1 week', strtotime($param)));
                            ?>
                            <A class="lien" href='index.php?&param=<?= $tmp2 ?>'>Semaine suivante</A>
                        </TD>
                    </TR>

                    <TR>
                        <TD>&nbsp;</TD>
                    </TR>


                    <TR>
                        <TD class="titre" align="center" width="35" style=WORD-BREAK:BREAK-ALL; >
                            &nbsp;
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Lundi &nbsp; <?php echo substr($lundi, 0, 2); ?> <BR>
                            <font color=gray><I> Salle A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle C </I></font>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Mardi &nbsp; <?php echo substr($mardi, 0, 2); ?><BR>
                            <font color=gray><I> Salle A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle C </I></font>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Mercredi &nbsp; <?php echo substr($mercredi, 0, 2); ?><BR>
                            <font color=gray><I> Salle A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle C </I></font>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Jeudi &nbsp; <?php echo substr($jeudi, 0, 2); ?><BR>
                            <font color=gray><I> Salle A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle C </I></font>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Vendredi &nbsp; <?php echo substr($vendredi, 0, 2); ?><BR>
                            <font color=gray><I> Salle A &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle B &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salle C </I></font>
                        </TD>
                    </TR>
                    <?php
// Initialisation du compteur de boucle
                    $i = 8;
                    echo "<TR>";
                    echo "<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"black\" width=\"1200\" style=\"margin-left: 315px;margin-bottom: 50px;\">";

                    while ($i <= 20) {
                        echo "<TR id=$i>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL;  width=\"35\" HEIGHT=\"26\">";
                        echo "<SUP>" . $i . "H00</SUP>";
                        echo "</TD>";
                        echo "<TD  valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "</TR>";
                        echo "<TR>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"right\" style=WORD-BREAK:BREAK-ALL; width=\"35\" HEIGHT=\"26\">";
                        echo "<SUP>30</SUP>";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"26\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "</TR>";

                        $i = $i + 1;
                    }
                    echo "</TABLE>";
                    echo "</TR>";
                    ?>

                    </TABLE>

                    <!-- LISTE DES UTILISATEURS SUR LA DROITE -->

                    <?php
                    /* Requ&ecirc;te r&eacute;cup&eacute;ration de la couleur pour chaque utilisateur */

                    $reqcolor = "SELECT ID, nom, prenom, color, login, sorting, type ";
                    $reqcolor .= "FROM utilisateur ";
                    $reqcolor .= "WHERE type IN ( 'ADMIN', 'ASSOC', 'CONSULT', 'ASSIST') and actif ='Y' ";
                    $reqcolor .= "ORDER BY sorting ";

                    $r_color = $db->prepare($reqcolor);
                    $r_color->execute();
                    $rescolor = $r_color->fetchAll(PDO::FETCH_ASSOC);

                    if (!$rescolor) {
                        $erreur = "oui";
                    }

                    if (count($rescolor) == 0) {
                        echo " ERROR ";
                    } else {
                        ?>

                        <div style="position:absolute;right:305px;top:305px;">

                            <?php
                            $test = 0;
                            $widthBlock = 200;
                            foreach ($rescolor as $enrcolor) {
                                ?>
                                <div id="<?php echo $enrcolor[login]; ?>" 
                                     style="position:absolute; left:0px; top:<?= $test ?>px;padding:10px;font-size:18px;
                                     width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#<?php echo $enrcolor[color]; ?>">
                                    <p><strong><?php echo substr($enrcolor[prenom], 0, 1) . "." . $enrcolor[nom]; ?></strong></p>
                                </div>
                                <?php
                                $test+=50;
                            }
                        }
                        ?>
                        <div id="pro" 
                             style="position:absolute; left:0px; top:<?= $test ?>px;padding:10px;font-size:18px;
                             width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#FFFF7D;">
                            <p>
                                <strong>Prospection</strong>
                            </p>
                        </div>

                        <div id="clt" 
                             style="position:absolute; left:0px; top:<?= $test + 50 ?>px;padding:10px;font-size:18px;
                             width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#FF3737;">
                            <p>
                                <strong>Client</strong>
                            </p>
                        </div>

                        <div id="int" 
                             style="position:absolute; left:0px; top:<?= $test + 100 ?>px;padding:10px;font-size:18px;
                             width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#00FF80;">
                            <p>
                                <strong>Interne</strong>
                            </p>
                        </div>

                        <div id="per" 
                             style="position:absolute; left:0px; top:<?= $test + 150 ?>px;padding:10px;font-size:18px;
                             width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#E8BDE4;">
                            <p>
                                <strong>Personnel</strong>
                            </p>
                        </div>

                        <div id="ann" 
                             style="position:absolute; left:0px; top:<?= $test + 200 ?>px;padding:10px;font-size:18px;
                             width:<?= $widthBlock ?>px; overflow:hidden; height:40px; background-color:#FF45DA;">
                            <p>
                                <strong>Annuler</strong>
                            </p>
                        </div>
                    </div>
                    <?php
                    if ($consultant != "")
                        $clause1 = "   $clause and chevauche.CONSULTANT = $consultant ";
                    else
                        $clause1 = $clause;

// On remplit un tableau avec pour un identifiant de case la liste des identifiants des cases qui chevauchent 
                    $requete3 = " SELECT resa_salle.ID, concat(resa_salle.heure_deb, resa_salle.minute_deb) 'RESA_DEB', chevauche.ID 'NUM', ";
                    $requete3 .= "concat(chevauche.heure_deb, chevauche.minute_deb) 'CHEV_DEB' , ";
                    $requete3 .= "concat(chevauche.heure_fin, chevauche.minute_fin) 'CHEV_FIN' ";
                    $requete3 .= "FROM   resa_salle, resa_salle chevauche   ";
                    $requete3 .= " WHERE  $clause1 ";
                    $requete3 .= "     and ((concat(resa_salle.heure_deb, resa_salle.minute_deb) >= concat(chevauche.heure_deb, chevauche.minute_deb) ";
                    $requete3 .= "                               and concat(resa_salle.heure_deb, resa_salle.minute_deb)<  concat(chevauche.heure_fin, chevauche.minute_fin)) ";
                    $requete3 .= "     or   (concat(resa_salle.heure_fin, resa_salle.minute_fin) >  concat(chevauche.heure_deb, chevauche.minute_deb) ";
                    $requete3 .= "            and concat(resa_salle.heure_fin, resa_salle.minute_fin)<= concat(chevauche.heure_fin, chevauche.minute_fin))";
                    $requete3 .= "     or   (concat(resa_salle.heure_deb, resa_salle.minute_deb) <  concat(chevauche.heure_deb, chevauche.minute_deb) ";
                    $requete3 .= "            and concat(resa_salle.heure_fin, resa_salle.minute_fin)> concat(chevauche.heure_fin, chevauche.minute_fin)))";
                    $requete3 .= "     and resa_salle.ID       !=  chevauche.ID      ";
                    $requete3 .= "     and resa_salle.jour     =  chevauche.jour   ";
                    $requete3 .= "     and resa_salle.numsalle =  chevauche.numsalle       ";
                    $requete3 .= " ORDER BY 1, 2 ";

                    $r3 = $db->prepare($requete3);
                    $r3->execute();
                    $rdvs = $r3->fetchAll(PDO::FETCH_ASSOC);

                    function recursion($tab, $tableau, $key1, $cpt)
                    {
                        if ($cpt < 6)
                        // on va parcourir les noeuds liés sur une profondeur donnée par le test (ici 5 niveaux)
                            $i = count($tableau[$key1]);

                        foreach ($tab as $key => $value) {
                            if (!in_array($value, $tableau[$key1])) {
                                $tableau[$key1][$i] = $value;
                                $i = $i + 1;
                                $cpt = $cpt + 1;
                                recursion($tab[$value], $tableau, $key1, $cpt);
                            }
                        }

                        return $tableau;
                    }

                    foreach ($rdvs as $enregistrement3) {
                        $tableau[$enregistrement3[ID]][] = $enregistrement3[NUM];
                        $hordeb[$enregistrement3[NUM]] = $enregistrement3[CHEV_DEB];
                        $horfin[$enregistrement3[NUM]] = $enregistrement3[CHEV_FIN];
                    }
                    /*
                      if(isset($tableau)){
                      foreach ($tableau as $key1 => $value1) {
                      $l = 0;
                      foreach ($tableau[$key1] as $key2 => $value2) {
                      $tableau = recursion($tableau[$value2], $tableau, $key1, 0);
                      }
                      }
                      } */

// Les valeurs left des div prennent en compte le numéro de salle et le jour de la semaine
// La valeur top prend en compte l'heure du RDV
// Pour décaler d'une journée 170 px
// Pour décaler d'une heure 60 px
// Initialisation du compteur de boucle
                    $i = 1;
                    foreach ($r as $enregistrement) {
                        $date = $enregistrement[DATE_RDV];
                        $tms = mktime(0, 0, 0, substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4));

                        // on gère le décalage des jours
                        $nomjour = date("l", $tms);
                        switch ($nomjour)
                        {
                            case "Monday":
                                $col = 62 + 315;
                                break;
                            case "Tuesday":
                                $col = 292 + 315;
                                break;
                            case "Wednesday":
                                $col = 522 + 315;
                                break;
                            case "Thursday":
                                $col = 752 + 315;
                                break;
                            case "Friday":
                                $col = 982 + 315;
                                break;
                        }
                        // on gère le décalage de la salle
                        if ($enregistrement[NUMSALLE] == 2)
                            $col = $col + 76.6;
                        if ($enregistrement[NUMSALLE] == 3)
                            $col = $col + 153.2;

                        $ratio_min = 0.833;

                        // on gère la hauteur des cases
                        $diff1 = ($enregistrement[HEURE_FIN] * ($heightCase * 2) + $enregistrement[MINUTE_FIN] * $ratio_min) - ($enregistrement[HEURE_DEB] * ($heightCase * 2) + $enregistrement[MINUTE_DEB] * $ratio_min);
                        $height = $diff1;

                        // on gère le décalage des heures			
                        $diff2 = ($enregistrement[HEURE_DEB] * ($heightCase * 2) + $enregistrement[MINUTE_DEB] * $ratio_min) - 110;
                        $row = $diff2;

                        // on gère la couleur des cases
                        if (strtoupper($enregistrement[TYPE]) == "CANDIDAT") {
                            $color = $enregistrement[COLOR];
                        } elseif (strtoupper($enregistrement[TYPE]) == "PROSPECTION")
                            $color = "FFFF7D";
                        elseif (strtoupper($enregistrement[TYPE]) == "CLIENT")
                            $color = "FF3737";
                        elseif (strtoupper($enregistrement[TYPE]) == "PERSONNEL")
                            $color = "E8BDE4";
                        elseif (strtoupper($enregistrement[TYPE]) == "INTERNE")
                            $color = "00FF80";
                        
                        if ($enregistrement['CANCELLED'] == 1)
                            $color = "FF45DA";

                        // on gère le libell&eacute;
                        if (strtoupper($enregistrement[TYPE]) == "CANDIDAT") {
                            if ($enregistrement[NOMCLIENT] != "") {
                                $titre = substr(ucfirst($enregistrement[NOMCLIENT]), 0, 10);
                            } else {
                                $titre = ucfirst($enregistrement[CANDIDAT]);
                            }
                        } else {
                            $titre = ucfirst($enregistrement[TYPE]);
                        }

                        /*
                          if (isset($tableau[$enregistrement[ID]])) {
                          // Calcul de la largeur
                          $j = count($tableau[$enregistrement[ID]]);
                          $width = round(76.6 / $j) - 1;

                          //Init des variables
                          $NbCasesAvant = 0;
                          $NbCasesIdentique = 0;

                          // Calcul du decalage
                          foreach ($tableau[$enregistrement[ID]] as $key => $value) {
                          $deb = $enregistrement[HEURE_DEB] . $enregistrement[MINUTE_DEB];
                          $fin = $enregistrement[HEURE_FIN] . $enregistrement[MINUTE_FIN];

                          // Nb de cases avant
                          if ($deb > $hordeb[$value])
                          $NbCasesAvant = $NbCasesAvant + 1;

                          // Nb de cases avant
                          if ($deb == $hordeb[$value] && $fin > $horfin[$value])
                          $NbCasesAvant = $NbCasesAvant + 1;

                          // Nb cases identiques
                          if ($deb == $hordeb[$value] && $fin == $horfin[$value] && $value > $enregistrement[ID])
                          $NbCasesIdentique = $NbCasesIdentique + 1;
                          }
                          $col = $col + $width * ($NbCasesAvant + $NbCasesIdentique);
                          }
                          else {
                          $width = 76.6;
                          } */
                        $width = 76.6;

                        $id = urlencode($enregistrement[ID]);

                        // On gère les caractères spéciaux sur les noms
                        $value1 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[NOMCANDIDAT])));
                        $value2 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[PRENOMCANDIDAT])));
                        $value3 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[NOMCLIENT])));
                        $value4 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[LIBELLE])));

                        $infobulle = "Consultant : " . $enregistrement[CONSULTANT] . "<br />";
                        $infobulle .= "Accompagnant : " . $enregistrement[ACCOMPAGNE] . "<br />";
                        $infobulle .= "Client : " . $enregistrement[NOMCLIENT] . "<br />";
                        $infobulle .= "Poste : " . $enregistrement[LIBELLE] . "<br />";
                        $infobulle .= "Candidat : " . $enregistrement[CIVILITE] . " " . $enregistrement[NOMCANDIDAT] . " " . $enregistrement[PRENOMCANDIDAT] . "<br />";


                        if ($enregistrement[ACCOMPAGNE] != "") {
                            $width_accomp = $width / 2;
                            $str = "<DIV id=\"DIV" . $i . "\" style=\"position:absolute; left:" . $col . "px; top:" . $row . "px; width:" . $width . "px; overflow:hidden; height:" . $height . "px; ";
                            $str .= " BORDER-LEFT: #606060 1px solid; BORDER-RIGHT: #606060 1px solid; BORDER-TOP: #606060 1px solid; BORDER-BOTTOM: #606060 1px solid; ";
                            $str .= " background-color:#" . $color . ";\" >";
                            $str .= "<a href=\"./candidat/upd_rdv.php?id=" . $id . "\" style=\"color:black;\" ";
                            $str .= "tabindex='0' role='button' 
                                                   data-toggle='popover' 
                                                   data-trigger='hover' 
                                                   data-placement='right' 
                                                   data-html='true'
                                                   data-content='" . $infobulle . "'>";
                            $str .= "<TABLE width=" . $width . " height=" . $height . " cellpadding=2 cellspacing=0 border=0>";
                            $str .= "    <TR>  ";
                            $str .= "  		<TD valign=top colspan=2 align=left>";
                            $str .= "				<p style=\"font-size:10px;\">" . $enregistrement[HEURE_DEB] . ":" . $enregistrement[MINUTE_DEB] . " </p>";
                            $str .= "		</TD>";
                            $str .= "  		<TD valign=top colspan=2 align=left style=\"position:absolute;left:80%;background-color:#" . $enregistrement[COLOR2] . ";width:" . $width_accomp . ";font-size:10px;\">";
                            $str .= $enregistrement[ACCOMPAGNE2];
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "	<TR>";
                            $str .= "		<TD align=left valign=top class=rdvbas style=\"font-size:11px!important;  fontweight=bold\" colspan=2>";
                            $str .= $titre;
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "   <TR>  ";
                            $str .= "   	<TD valign=bottom colspan=2 align=left height=" . $height2 . ">";
                            $str .= "				<p style=\"font-size:10px;margin-top:".($height2 + 10)."px;\"> " . $enregistrement[HEURE_FIN] . ":" . $enregistrement[MINUTE_FIN] . " </p>";
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "</TABLE></a>";
                            $str .= " </DIV>";
                        } else {
                            $str = "<a href=\"./candidat/upd_rdv.php?id=" . $id . "\" style=\"color:black;\"><DIV id=\"DIV" . $i . "\" style=\"position:absolute; left:" . $col . "px; top:" . $row . "px; width:" . $width . "px; overflow:hidden; height:" . $height . "px; ";
                            $str .= " BORDER-LEFT: #606060 1px solid; BORDER-RIGHT: #606060 1px solid; BORDER-TOP: #606060 1px solid; BORDER-BOTTOM: #606060 1px solid; ";
                            $str .= " background-color:#" . $color . ";\">";
                            $str .= "<a href=\"./candidat/upd_rdv.php?id=" . $id . "\" style=\"color:black;\" ";
                            $str .= "tabindex='0' role='button' 
                                                   data-toggle='popover' 
                                                   data-trigger='hover' 
                                                   data-placement='right' 
                                                   data-html='true'
                                                   data-content='" . $infobulle . "'>";
                            $str .= "<TABLE width=" . $width . " height=" . $height . " cellpadding=2 cellspacing=0 border=0>";
                            $str .= "    <TR>  ";
                            $str .= "  		<TD valign=top colspan=2 align=left>";
                            $str .= "				<p style=\"font-size:10px;\">" . $enregistrement[HEURE_DEB] . ":" . $enregistrement[MINUTE_DEB] . " </p>";
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "	<TR>";
                            $str .= "		<TD align=left valign=top class=rdvbas style=\"font-size:11px!important;  fontweight=bold\" colspan=2>";
                            $str .= $titre;
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "   <TR>  ";
                            $str .= "   	<TD valign=bottom colspan=2 align=left height=" . $height2 . ">";
                            $str .= "				<p style=\"font-size:10px;margin-top:".($height2 + 10)."px;\"> " . $enregistrement[HEURE_FIN] . ":" . $enregistrement[MINUTE_FIN] . " </p>";
                            $str .= "		</TD>";
                            $str .= "	</TR>";
                            $str .= "</TABLE></a>";
                            $str .= " </DIV>";
                        }
                        echo $str;

                        $i = $i + 1;
                    }
                    ?>

                    <script type="text/javascript">
                        // on calcule la position absolue de la premi&egrave;re colonne de la table
                        // On calibre pour IE (+35 ; -55)


                        function position() {

                            var e = document.getElementById('8');
                            var left = getAbsLeft(e) + 37;
                            var top = getAbsTop(e) - 53;

                            // on met en place les div de l&eacute;gende		  	

<?php
$reqcolor = " SELECT ID, concat(nom, ' ', prenom) 'nom', login, type, SORTING";
$reqcolor .= " FROM   utilisateur   ";
$reqcolor .= " where  (login <> 'admin') and actif ='Y'";
$reqcolor .= " ORDER BY SORTING ";

$r_color = $db->prepare($reqcolor);
$r_color->execute();
$rescolor = $r_color->fetchAll(PDO::FETCH_ASSOC);

if (!$rescolor) {
    $erreur = "oui";
}

if (count($rescolor) == 0) {
    echo " ERROR ";
} else {

    $w = 0;

    foreach ($rescolor as $enrcolor) {

        echo "var " . $enrcolor[login] . " = document.getElementById('" . $enrcolor[login] . "');";
        echo $enrcolor[login] . ".style.left = left + getAbsLeft(" . $enrcolor[login] . ")+ 855 ;";
        echo $enrcolor[login] . ".style.top  = top + getAbsTop(" . $enrcolor[login] . ") + " . $w . " ;";

        $w = $w + 60;
    }
}
?>

                            var pro = document.getElementById('pro');
                            pro.style.left = left + getAbsLeft(pro) + 855;
                            pro.style.top = top + getAbsTop(pro) + <?php echo $w; ?> + 0;

                            var clt = document.getElementById('clt');
                            clt.style.left = left + getAbsLeft(clt) + 855;
                            clt.style.top = top + getAbsTop(clt) + <?php echo $w; ?> + 60;

                            var int = document.getElementById('int');
                            int.style.left = left + getAbsLeft(int) + 855;
                            int.style.top = top + getAbsTop(int) + <?php echo $w; ?> + 120;

                            var per = document.getElementById('per');
                            per.style.left = left + getAbsLeft(per) + 855;
                            per.style.top = top + getAbsTop(per) + <?php echo $w; ?> + 180;

                            // on boucle sur l'ensemble des div 
<?php
$i = 1;
while ($i <= count($resultat)) {
    echo "var div" . $i . " = document.getElementById('DIV" . $i . "');";
    echo "div" . $i . ".style.left = left + getAbsLeft(div" . $i . ");";
    echo "div" . $i . ".style.top  = top + getAbsTop(div" . $i . ");";

    $i = $i + 1;
}
?>
                        }

<?php if (isset($_GET['newRDV'])) { ?>
                            $(window).load(function () {
                                alert('Le RDV a été créée.');
                            });
<?php } ?>
<?php if (isset($_GET['updRDV'])) { ?>
                            $(window).load(function () {
                                alert('Le RDV a été modifié.');
                            });
<?php } ?>
<?php if (isset($_GET['delRDV'])) { ?>
                            $(window).load(function () {
                                alert('Le RDV a été supprimé.');
                            });
<?php } ?>

                        $(function () {
                            $('[data-toggle="popover"]').popover({
                                container: 'body'
                            });
                        });

                    </script>

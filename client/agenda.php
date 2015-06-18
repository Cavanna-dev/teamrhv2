<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

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
    $clause .= "   and ENTRETIEN.CONSULTANT = $consultant ";

switch ($nomjour)
{
    case "Monday":
        $nomjour = "lundi";
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 0 day) and date_add('$param', interval 6 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 1 day) and date_add('$param', interval 5 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 2 day) and date_add('$param', interval 4 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 3 day) and date_add('$param', interval 3 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 4 day) and date_add('$param', interval 2 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 5 day) and date_add('$param', interval 1 day) ";
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
        $clause .= " and  ENTRETIEN.date_rdv between  date_sub('$param', interval 6 day) and date_add('$param', interval 0 day) ";
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

$requete = " select ENTRETIEN.ID, ENTRETIEN.CLIENT 'CLIENT', CONTACT, CANDIDAT, DATE_FORMAT(DATE_RDV,'%d/%m/%Y') 'DATE_RDV', HORAIRE ,";
$requete .= "        DATE_FORMAT(DATE_RDV,'%Y/%m/%d') 'ORDRE', NUMERO_RDV, POSTE, RMQ_CLIENT, RMQ_CANDI, RMQ_TEAMRH, CLIENT.NOM 'SOCIETE', ";
$requete .= "        concat(CANDIDAT.NOM, ' ', CANDIDAT.PRENOM) 'NOM' , POSTE.LIBELLE, UTILISATEUR.NOM 'NOMCONSULT', DATE_RDV 'RDV', ";
$requete .= "        concat(mid(CANDIDAT.PRENOM,1,1),'.',CANDIDAT.NOM) 'NOMCANDIDAT', UTILISATEUR.COLOR ";
$requete .= " from   CANDIDAT, UTILISATEUR, CLIENT, POSTE right join ENTRETIEN on POSTE.ID = ENTRETIEN.POSTE  ";
$requete .= " where $clause  ";
$requete .= "   and UTILISATEUR.ID   = ENTRETIEN.CONSULTANT ";
$requete .= "   and ENTRETIEN.CLIENT   = CLIENT.ID ";
$requete .= "   and ENTRETIEN.CANDIDAT = CANDIDAT.ID ";
$requete .= " order by 6, 7, 2 ";


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
        <TD colspan="3" align="right" class="titre">
            Voir les RDV de:
        </TD>
        <TD colspan="2" align="left">
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
                            echo "*Veuillez choisir un consultant pour n'afficher que ces RDVs";
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
                        <TD align="left"  class="normal" colspan="2">
                            <?php
                            $tmp1 = date("Y-m-d", strtotime('-1 week', strtotime($param)));
                            ?>
                            <A class="lien"  href='agenda.php?param=<?php echo $tmp1 ?>'>Semaine précédente</A>
                        </TD>
                        <TD colspan="3" align="center" class="normal">
                            &nbsp;
                        </TD>
                        <TD align="right"  class="normal">
                            <?php
                            $tmp2 = date("Y-m-d", strtotime('+1 week', strtotime($param)));
                            ?>
                            <A class="lien" href='agenda.php?param=<?= $tmp2 ?>'>Semaine suivante</A>
                        </TD>
                    </TR>

                    <TR>
                        <TD>&nbsp;</TD>
                    </TR>


                    <TR>
                        <TD class="titre" align="center" width="35" style=WORD-BREAK:BREAK-ALL; >
                            &nbsp;
                        </TD>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Lundi &nbsp; <?php echo substr($lundi, 0, 2); ?> 
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Mardi &nbsp; <?php echo substr($mardi, 0, 2); ?>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Mercredi &nbsp; <?php echo substr($mercredi, 0, 2); ?>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Jeudi &nbsp; <?php echo substr($jeudi, 0, 2); ?>
                        </TD>
                        <TD class="titre" align="center" width="168" style=WORD-BREAK:BREAK-ALL;>
                            Vendredi &nbsp; <?php echo substr($vendredi, 0, 2); ?>
                        </TD>
                    </TR>
                    <?php
// Initialisation du compteur de boucle
                    $i = 8;
                    echo "<TR>";
                    echo "<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"black\" width=\"1200\" style=\"margin-left: 315px;margin-bottom: 50px;\">";

                    while ($i <= 20) {
                        echo "<TR id=$i>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL;  width=\"35\" HEIGHT=\"30\">";
                        echo "<SUP>" . $i . "H00</SUP>";
                        echo "</TD>";
                        echo "<TD  valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"heure\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "</TR>";
                        echo "<TR>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"right\" style=WORD-BREAK:BREAK-ALL; width=\"35\" HEIGHT=\"30\">";
                        echo "<SUP>30</SUP>";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "<TD valign=\"top\" class=\"demi\" align=\"center\" style=WORD-BREAK:BREAK-ALL; width=\"168\" HEIGHT=\"30\">";
                        echo "&nbsp;";
                        echo "</TD>";
                        echo "</TR>";
                        $i = $i + 1;
                    }
                    echo "</TABLE>";
                    echo "</TR>";
                    ?>

                    </TABLE>

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
                            ?>
                        </div>
                        <?php
                    }

                    if ($consultant != "")
                        $clause1 = " $clause  and chevauche.CONSULTANT = $consultant ";
                    else
                        $clause1 = $clause;

                    // On rempli un tableau avec pour un identifiant de case la liste des identifiants des cases qui chevauchent 
                    $requete3 = " select ENTRETIEN.ID, ENTRETIEN.HORAIRE 'ENT_DEB', chevauche.ID 'NUM' , chevauche.HORAIRE 'CHEV_DEB' ,  ";
                    $requete3 .= "        concat(lpad(mid(chevauche.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(chevauche.HORAIRE, 4, 2)) 'CHEV_FIN'      ";
                    $requete3 .= " from   entretien, entretien chevauche   ";
                    $requete3 .= " where  $clause1 ";
                    $requete3 .= "     and ((ENTRETIEN.HORAIRE >= chevauche.HORAIRE and ENTRETIEN.HORAIRE < concat(lpad(mid(chevauche.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(chevauche.HORAIRE, 4, 2))) ";
                    $requete3 .= "     or   (concat(lpad(mid(ENTRETIEN.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(ENTRETIEN.HORAIRE, 4, 2)) >  chevauche.HORAIRE ";
                    $requete3 .= "            and concat(lpad(mid(ENTRETIEN.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(ENTRETIEN.HORAIRE, 4, 2))<= concat(lpad(mid(chevauche.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(chevauche.HORAIRE, 4, 2)))";
                    $requete3 .= "     or   (ENTRETIEN.HORAIRE  <  chevauche.HORAIRE ";
                    $requete3 .= "            and concat(lpad(mid(ENTRETIEN.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(ENTRETIEN.HORAIRE, 4, 2)) > concat(lpad(mid(chevauche.HORAIRE, 1, 2) + 1, 2, '0'), ':', mid(chevauche.HORAIRE, 4, 2))))";
                    $requete3 .= "     and ENTRETIEN.ID       !=  chevauche.ID      ";
                    $requete3 .= "     and ENTRETIEN.date_rdv  =  chevauche.date_rdv ";
                    $requete3 .= "     order by 1, 2 ";

                    $r3 = $db->prepare($requete3);
                    $r3->execute();
                    $resultat3 = $r3->fetchAll(PDO::FETCH_ASSOC);

                    function recursion($tab, $tableau, $key1, $cpt)
                    {
                        if ($cpt < 6)
                        // on va parcourir les noeuds li&eacute;s sur une profondeur donn&eacute;e par le test (ici 5 niveaux)
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

                    foreach ($resultat3 as $enregistrement3) {
                        $tableau[$enregistrement3[ID]][] = $enregistrement3[NUM];
                        $hordeb[$enregistrement3[NUM]] = $enregistrement3[CHEV_DEB];
                        $horfin[$enregistrement3[NUM]] = $enregistrement3[CHEV_FIN];
                    }

                    foreach ($tableau as $key1 => $value1) {
                        $l = 0;
                        foreach ($tableau[$key1] as $key2 => $value2) {
                            $tableau = recursion($tableau[$value2], $tableau, $key1, 0);
                        }
                    }


                    // Les valeurs left des div prennent en compte le num&eacute;ro de salle et le jour de la semaine
                    // La valeur top prend en compte l'heure du RDV
                    // Pour d&eacute;caler d'une journ&eacute;e 170 px
                    // Pour d&eacute;caler d'une heure 60 px
                    // Initialisation du compteur de boucle
                    $i = 1;
                    foreach ($r as $enregistrement):
                        $date = $enregistrement[DATE_RDV];
                        $tms = mktime(0, 0, 0, substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4));

                        // on g&egrave;re le d&eacute;calage des jours
                        $nomjour = date("l", $tms);
                        switch ($nomjour)
                        {
                            case "Monday":
                                $col = 62 + 302;
                                break;
                            case "Tuesday":
                                $col = 292 + 302;
                                break;
                            case "Wednesday":
                                $col = 522 + 302;
                                break;
                            case "Thursday":
                                $col = 752 + 302;
                                break;
                            case "Friday":
                                $col = 982 + 302;
                                break;
                        }

                        // on g&egrave;re la hauteur des cases
                        $height = 60;
                        $height2 = $height - 50;

                        // on g&egrave;re le d&eacute;calage des heures			
                        $heure = substr($enregistrement[HORAIRE], 0, 2);
                        $minute = substr($enregistrement[HORAIRE], 3, 2);
                        $diff2 = ($heure * 60 + $minute) - ( 8 * 60 ) + 305;
                        $row = round($diff2);

                        // on g&egrave;re la couleur des cases
                        $color = $enregistrement[COLOR];

                        // on g&egrave;re le libell&eacute;
                        $titre = substr(ucfirst($enregistrement[SOCIETE]), 0, 10) . "<BR>";
                        $titre .= $enregistrement[NOM] . "<BR>";
                        $titre .= $enregistrement[LIBELLE];


                        // On g&egrave;re la taille des cases
                        if (isset($tableau[$enregistrement[ID]])) {
                            // Calcul de la largeur
                            $j = count($tableau[$enregistrement[ID]]);
                            $width = round(232 / $j); //test
                            //$width = round(232 / $j)-1; ANCIEN
                            //Init des variables
                            $NbCasesAvant = 0;
                            $NbCasesIdentique = 0;

                            // Calcul du decalage
                            foreach ($tableau[$enregistrement[ID]] as $key => $value) {
                                $deb = $enregistrement[HORAIRE];

                                $heure = substr($enregistrement[HORAIRE], 0, 2);
                                $minute = substr($enregistrement[HORAIRE], 3, 2);
                                $heure = $heure + 1;
                                $fin = str_pad($heure, 2, "0", STR_PAD_LEFT) . ":" . $minute;

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
                            $width = 230;
                        }




                        $id = urlencode($enregistrement[ID]);

                        // On g&egrave;re les caract&egrave;res sp&eacute;ciaux sur les noms
                        $value1 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[SOCIETE])));
                        $value2 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[NOM])));
                        $value3 = str_replace('"', '\\\'', str_replace($linefeed, '<BR>', str_replace('\'', '\\\'', $enregistrement[LIBELLE])));




                        $commentaire = "Client : " . $value1 . "<br />";
                        $commentaire .= "Poste : " . $value3 . "<br />";
                        $commentaire .= "Candidat  : " . $value2 . "<br />";
                        if ($enregistrement[NUMERO_RDV] != "" && $enregistrement[NUMERO_RDV] != "0")
                            $commentaire .= "RDV N°" . $enregistrement[NUMERO_RDV];


                        $tmp1 = urlencode($enregistrement[ID]);
                        $tmp2 = urlencode($enregistrement[CLIENT]);
                        $tmp3 = urlencode($enregistrement[CANDIDAT]);
                        $tmp4 = urlencode($enregistrement[POSTE]);
                        $tmp5 = substr($enregistrement[HORAIRE], 0, 2) + 2;
                        $tmp5 = $tmp5 . ":" . substr($enregistrement[HORAIRE], 3, 2);

                        $str = "<DIV id=\"DIV" . $i . "\" style=\"position:absolute; left:" . $col . "px; top:" . $row . "px; width:" . $width . "px; overflow:hidden; height:" . $height . "px; ";
                        $str .= " BORDER-LEFT: #606060 1px solid; BORDER-RIGHT: #606060 1px solid; BORDER-TOP: #606060 1px solid; BORDER-BOTTOM: #606060 1px solid; ";
                        $str .= " background-color:#" . $color . ";\">";
                        $str .= "<a href=\"./upd_rdv.php?id=" . $id;
                        $str .= "tabindex='0' role='button' 
                                                   data-toggle='popover' 
                                                   data-trigger='hover' 
                                                   data-placement='right' 
                                                   data-html='true'
                                                   data-content='" . $commentaire . "'>";
                        $str .= "<TABLE width=" . $width . " height=" . $height . " cellpadding=2 cellspacing=0 border=0>";
                        $str .= "    <TR>  ";
                        $str .= "		<TD align=left colspan=2 valign=top>";
                        $str .= "		   <A href=\"upd_client.php?id=$tmp2\" style=\"font-size:12px;color:black;\">" . substr($enregistrement[SOCIETE], 0, 10) . "</A>";
                        $str .= "		</TD>";
                        $str .= "	</TR>";
                        $str .= "	<TR>";
                        $str .= "		<TD align=left valign=top >";
                        $str .= "		<br /><A href=\"../candidat/upd_applicant.php?id=$tmp3\" style=\"font-size:12px;color:black;\">" . substr($enregistrement[NOMCANDIDAT], 0, 10) . "</A>";
                        $str .= "		<br /><A href=\"upd_job.php?id=$tmp4\" style=\"font-size:12px;color:black;\">" . substr($enregistrement[LIBELLE], 0, 10) . "</A>";
                        $str .= "		</TD>";
                        $str .= "	</TR>";
                        $str .= "</TABLE>";
                        $str .= "</a>";
                        $str .= " </DIV>";
                        echo $str;

                        $i = $i + 1;
                    endforeach;
                    ?>


                    <?php include("../include/bas.php"); ?>

                    <SCRIPT>
                        // on calcule la position absolue de la premi&egrave;re colonne de la table
                        // On calibre pour IE (+35 ; -55)


                        function position() {
                            var e = document.getElementById('8');
                            var left = getAbsLeft(e) + 37;
                            var top = getAbsTop(e) - 53;

                            // on met en place les div de l&eacute;gende

<?php
$reqcolor = " select ID, concat(nom, ' ', prenom) 'nom', type, login, SORTING";
$reqcolor .= " from   utilisateur   ";
$reqcolor .= " where  (login <> 'admin') and actif ='Y'";
$reqcolor .= " order by  SORTING ";

$rescolor = mysql_query($reqcolor);

if (!$rescolor) {
    $erreur = "oui";
}

if (mysql_num_rows($rescolor) == 0) {
    echo " ERROR ";
} else {

    $w = 0;

    while ($enrcolor = mysql_fetch_array($rescolor)) {

        echo "var " . $enrcolor[login] . " = document.getElementById('" . $enrcolor[login] . "');";
        echo $enrcolor[login] . ".style.left = left + getAbsLeft(" . $enrcolor[login] . ")+ 855 ;";
        echo $enrcolor[login] . ".style.top  = top + getAbsTop(" . $enrcolor[login] . ") + " . $w . " ;";
        $w = $w + 60;
    }
}
?>

                            // on boucle sur l'ensemble des div 
<?php
$i = 1;
while ($i <= mysql_num_rows($resultat)) {
    echo "var div" . $i . " = document.getElementById('DIV" . $i . "');";
    echo "div" . $i . ".style.left = left + getAbsLeft(div" . $i . ");";
    echo "div" . $i . ".style.top  = top + getAbsTop(div" . $i . ");";

    $i = $i + 1;
}
?>
                        }

                        $(function () {
                            $('[data-toggle="popover"]').popover({
                                container: 'body'
                            });
                        });

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

                    </SCRIPT>
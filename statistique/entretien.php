<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

error_reporting(0);
$param = isset($_GET['param']) ? $_GET['param'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';
$consultant = isset($_GET['consultant']) ? $_GET['consultant'] : '';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    echo "<script>";
    echo "	top.location.replace('../index.php'); ";
    echo "</script>";
}
$clause = " 1 = 1 ";

// Par d&eacute;faut on prend le rapport de l'annee.
if ($param == "") {
    $param = date("Y");
}
if ($order == "") {
    $order = "4, 3";
}

if ($consultant != "")
    $clause .= "   and ENTRETIEN.CONSULTANT = $consultant ";

$requete = " select count(ENTRETIEN.ID) 'NOMBRE', ENTRETIEN.CLIENT 'CLIENT', DATE_FORMAT(DATE_RDV,'%m') 'MOIS', CLIENT.NOM 'SOCIETE' ";
$requete .= " from   CLIENT, ENTRETIEN ";
$requete .= " where $clause ";
$requete .= "   and ENTRETIEN.CLIENT   = CLIENT.ID ";
$requete .= "   and DATE_FORMAT(DATE_RDV,'%Y') = $param ";
$requete .= " group by   ENTRETIEN.CLIENT , DATE_FORMAT(DATE_RDV,'%m'), CLIENT.NOM  ";
$requete .= " order by $order";
$resultat = $db->prepare($requete);
$resultat->execute();

if (!$resultat) {
    $erreur_sql = "oui";
    $erreur = "oui";
    $msg = mysql_error();
}
echo "<script language=\"JavaScript\">";
$msg = strtr($msg, "'", "\'");
if ($erreur == "oui")
    echo "	alert('$msg');";
echo "</script>";
?>

<div class="container">
    <TABLE cellpadding="0" cellspacing="0" class="table table-bordered" border="1" bordercolor="white">
        <TR>
            <TD colspan="15" class="titre" align="middle">
                <BR>&nbsp;&nbsp;&nbsp;&nbsp;Rapport des entretiens client pour l'ann&eacute;e <?php echo $param ?>.
            </TD>
        </TR>
        <TR>
            <TD colspan="15">
                &nbsp;
            </TD>
        </TR>
        <TR>
            <TD>
                &nbsp;
            </TD>
            <TD colspan="5" align="center" class="titre">
                Voir les entretiens de:
            </TD>
            <TD colspan="8" align="left">
                <select class="normal" id="changeConsult" name="consultant" size="1" onchange="location.href = 'entretien.php?param=<?= $tmp3 ?>';">
                    <?php
                    $requete1 = " select id, concat(nom, ' ', prenom) 'nom' ";
                    $requete1 .= " from   utilisateur   ";
                    $requete1 .= " where  type = 'CONSULT' or type = 'ADMIN' or type = 'ASSOC'";
                    $requete1 .= " order by  2 ";
                    $resultat1 = $db->prepare($requete1);
                    $resultat1->execute();

                    if (!$resultat1) {
                        $erreur = "oui";
                    }

                    if ($resultat1->rowCount() == 0) {
                        echo " <option  selected value=\"\"> Tous les consultants </option> ";
                    } else {
                        echo " <option  selected value=\"\"> Tous les consultants </option> ";
                        foreach ($resultat1->fetchAll(PDO::FETCH_ASSOC) as $enregistrement1) {
                            echo " <option ";
                            if ($consultant == $enregistrement1[id])
                                echo " selected ";
                            echo " value=$enregistrement1[id] > $enregistrement1[nom] </option> ";
                        }
                    }
                    ?>
                </select>
            </TD>
            <TD>
                &nbsp;
            </TD>
        </TR>
        <TR>
            <TD>
                <BR>&nbsp;
            </TD>
        </TR>

        <TR>
            <?php
            if ($erreur == "oui") {
                ?>
                <TD class="titre"  align="middle" colspan="15">
                    <B>Connexion impossible &agrave; notre base de donn&eacute;es. Renouveller votre recherche ult&eacute;rieurement.<B>
                            </TD>
                            </TR>
                            <?php
                        } else {
                            ?>
                            <TD class="titre"  align="middle" colspan="15">
                                <?php
                                if ($resultat->rowCount() == 0)
                                    echo "Aucun entretien n'a été organisé pour l'année $param.";
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
                            <TD>
                                &nbsp;
                            </TD>
                            <TD align="left"  class="normal" colspan="7">
                                <?php
                                $tmp1 = $param - 1;
                                ?>
                                <A class="lien"  href="#" onclick="location.href = 'entretien.php?&param=<?= $tmp1 ?>';">Ann&eacute;e pr&eacute;c&eacute;dente</A>
                            </TD>
                            <TD align="right"  class="normal"  colspan="7">
                                <?php
                                $tmp2 = $param + 1;
                                ?>
                                <A class="lien"  href="#" onclick="location.href = 'entretien.php?&param=<?= $tmp2 ?>';">Ann&eacute;e suivante</A>
                            </TD>
                        </TR>
                        <TR>
                            <TD colspan="14">
                                &nbsp;
                            </TD>
                        </TR>
                        <TR>
                            <TD colspan="3">
                                &nbsp;
                            </TD>
                            <TD align="left"  class="normal" colspan="5">
                                <?php
                                $tmp1 = $param;
                                $ord1 = urlencode("3, 4")
                                ?>
                                <A class="lien"  href="#" onclick="location.href = 'entretien.php?&param=<?= $tmp1; ?>&order=<?= $ord1; ?>';">Class&eacute; par mois</A>
                            </TD>
                            <TD align="right"  class="normal"  colspan="5">
                                <?php
                                $tmp2 = $param;
                                $ord2 = urlencode("4, 3")
                                ?>
                                <A class="lien"  href="#" onclick="location.href = 'entretien.php?&param=<?= $tmp1; ?>&order=<?= $ord2; ?>';">Class&eacute; par client</A>
                            </TD>
                        </TR>
                        <TR>
                            <TD colspan="14">
                                &nbsp;
                            </TD>
                        </TR>
                        <TR>
                            <TD colspan="14">
                                &nbsp;
                            </TD>
                        </TR>
                        <?php
                        if ($resultat->rowCount() != 0) {
                            ?>
                            <TR bordercolor="white">
                                <TD class="titre" align="center">
                                    &nbsp;
                                </TD>
                                <TD class="titre" align="center">
                                    &nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Jan<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Fev<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Mar<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Avr<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Mai<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Jun<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Jui<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Aou<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Sep<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Oct<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Nov<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Dec<BR>&nbsp;
                                </TD>
                                <TD class="titre" align="center" bordercolor=#FF9640 width="40">
                                    Total client<BR>&nbsp;
                                </TD>
                            </TR>
                            <?php
                            // Initialisation du compteur de boucle
                            $i = 0;
                            foreach ($resultat->fetchAll(PDO::FETCH_ASSOC) as $enregistrement) {
                                // on force la conversion
                                switch ($enregistrement['MOIS']) {
                                    case "01":
                                        $colspan = 1;
                                        $janvier = $janvier + $enregistrement['NOMBRE'];
                                        break;
                                    case "02":
                                        $colspan = 2;
                                        $fevrier = $fevrier + $enregistrement['NOMBRE'];
                                        break;
                                    case "03":
                                        $colspan = 3;
                                        $mars = $mars + $enregistrement['NOMBRE'];
                                        break;
                                    case "04":
                                        $colspan = 4;
                                        $avril = $avril + $enregistrement['NOMBRE'];
                                        break;
                                    case "05":
                                        $colspan = 5;
                                        $mai = $mai + $enregistrement['NOMBRE'];
                                        break;
                                    case "06":
                                        $colspan = 6;
                                        $juin = $juin + $enregistrement['NOMBRE'];
                                        break;
                                    case "07":
                                        $colspan = 7;
                                        $juillet = $juillet + $enregistrement['NOMBRE'];
                                        break;
                                    case "08":
                                        $colspan = 8;
                                        $aout = $aout + $enregistrement['NOMBRE'];
                                        break;
                                    case "09":
                                        $colspan = 9;
                                        $septembre = $septembre + $enregistrement['NOMBRE'];
                                        break;
                                    case "10":
                                        $colspan = 10;
                                        $octobre = $octobre + $enregistrement['NOMBRE'];
                                        break;
                                    case "11":
                                        $colspan = 11;
                                        $novembre = $novembre + $enregistrement['NOMBRE'];
                                        break;
                                    case "12":
                                        $colspan = 12;
                                        $decembre = $decembre + $enregistrement['NOMBRE'];
                                        break;
                                }

                                if ($client != $enregistrement['SOCIETE'] || $order == "3, 4") {
                                    if ($i != 0) {

                                        for ($j = 1; $j < (14 - $old_colspan - 1); $j++) {
                                            ?>
                                            <TD align="right"  class="normal">
                                                &nbsp;
                                            </TD>
                                            <?php
                                        }
                                        ?>
                                        <TD align="center"  class="normal">
                                            <?php
                                            if ($order == "3, 4")
                                                echo $nombre_mois;
                                            else
                                                echo $nombre;
                                            ?>
                                        </TD>
                                        </TR>

                                        <?php
                                    }
                                    ?>
                                    <TR bordercolor=#FF9640>
                                        <TD class="titre" align="center" bordercolor="white">
                                            &nbsp;
                                        </TD>
                                        <TD align="left"  class="normal">
                                            <?php
                                            echo $enregistrement[SOCIETE];
                                            ?>
                                        </TD>
                                        <?php
                                        for ($j = 1; $j < $colspan; $j++) {
                                            ?>
                                            <TD align="right"  class="normal">
                                                &nbsp;
                                            </TD>
                                            <?php
                                        }
                                        ?>
                                        <TD align="center"  class="normal">
                                            <?php
                                            echo $enregistrement[NOMBRE];
                                            ?>
                                        </TD>
                                        <?php
                                    } else {
                                        for ($j = 1; $j < ($colspan - $old_colspan); $j++) {
                                            ?>
                                            <TD align="right"  class="normal">
                                                &nbsp;
                                            </TD>
                                            <?php
                                        }
                                        ?>
                                        <TD align="center"  class="normal">
                                            <?php
                                            echo $enregistrement[NOMBRE];
                                            ?>
                                        </TD>
                                        <?php
                                    }
                                    // On positionne les variables
                                    if ($client != $enregistrement[SOCIETE])
                                        $nombre = 0;

                                    $client = $enregistrement[SOCIETE];
                                    $nombre = $nombre + $enregistrement[NOMBRE];
                                    $nombre_mois = $enregistrement[NOMBRE];
                                    $old_colspan = $enregistrement[MOIS];

                                    $i = 1;
                                }
                                for ($j = 1; $j < (14 - $old_colspan - 1); $j++) {
                                    ?>
                                    <TD align="right"  class="normal">
                                        &nbsp;
                                    </TD>
                                    <?php
                                }
                                ?>
                                <TD align="center"  class="normal">
                                    <?php
                                    if ($order == "3, 4")
                                        echo $nombre_mois;
                                    else
                                        echo $nombre;
                                    ?>
                                </TD>
                            </TR>
                            <TR>
                                <TD>
                                    &nbsp;
                                </TD>
                                <TD align="left"  class="normal" bordercolor=#FF9640>
                                    Total mois
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($janvier != "")
                                        echo $janvier;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($fevrier != "")
                                        echo $fevrier;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($mars != "")
                                        echo $mars;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($avril != "")
                                        echo $avril;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($mai != "")
                                        echo $mai;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($juin != "")
                                        echo $juin;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($juillet != "")
                                        echo $juillet;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($aout != "")
                                        echo $aout;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($septembre != "")
                                        echo $septembre;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($octobre != "")
                                        echo $octobre;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($novembre != "")
                                        echo $novembre;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php
                                    if ($decembre != "")
                                        echo $decembre;
                                    else
                                        echo "&nbsp;";
                                    ?>
                                </TD>
                                <TD align="center"  class="normal" bordercolor=#FF9640>
                                    <?php echo $janvier + $fevrier + $mars + $avril + $mai + $juin + $juillet + $aout + $septembre + $octobre + $novembre + $decembre; ?>
                                </TD>
                            </TR>
                            <?php
                        }
                        ?>
                        </TABLE>
                        </div>
                        <script type="text/javascript">
                            var param = <?= urlencode($param); ?>;

                            $('#changeConsult').change(function (e) {
                                var consult = $(this).val();
                                location.href = 'entretien.php?param=' + param + '&consultant=' + consult;
                            });
                        </script>
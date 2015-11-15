<?php
/** CONSTANTES * */
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
$id = $_GET['input_id'] ? htmlspecialchars($_GET['input_id']) : '';
$month = $_GET['input_month'] ? htmlspecialchars($_GET['input_month']) : '';
$year = $_GET['input_year'] ? htmlspecialchars($_GET['input_year']) : '';
$ht = $_GET['input_ht'] ? htmlspecialchars($_GET['input_ht']) : '';
$ttc = $_GET['input_ttc'] ? htmlspecialchars($_GET['input_ttc']) : '';

$sql = "SELECT ndf.id, ndf.description, ndf.ht_tot_amount, ndf.tva_tot_amount,"
        . "ndf.ttc_tot_amount "
        . "FROM notesfrais ndf ";

if (!empty($month) || !empty($year) || !empty($id) || !empty($ht) || !empty($ttc))
    $sql .= "WHERE ";
if (!empty($month))
    $sql .= "mois = '" . $month . "'";
if (!empty($month) && (!empty($year) || !empty($id) || !empty($ht) || !empty($ttc) ))
    $sql .= " AND ";
if (!empty($year))
    $sql .= "annee = '" . $year . "'";
if (!empty($year) && (!empty($id) || !empty($ht) || !empty($ttc) ))
    $sql .= " AND ";
if (!empty($id))
    $sql .= "id = '" . $id . "'";
if (!empty($id) && (!empty($ht) || !empty($ttc) ))
    $sql .= " AND ";
if (!empty($ht))
    $sql .= "ht_tot_amount = '" . $ht . "'";
if (!empty($ht) && (!empty($ttc) ))
    $sql .= " AND ";
if (!empty($ttc))
    $sql .= "ttc_tot_amount = '" . $ttc . "'";

$sql .= " GROUP BY id ORDER BY id";
//var_dump($sql);die;
$r_decaisse = $db->prepare($sql);
$r_decaisse->execute();
$r_ndfs = $r_decaisse->fetchAll(PDO::FETCH_OBJ);
?>

<h1><?= count($r_ndfs) ?> notes de frais - <?= $_GET['input_month'] != '' ? $_GET['input_month'] : 'Aucun mois selectionne'; ?></h1>
<div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>HT</th>
                <th>TVA</th>
                <th>TTC</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_ht_ndf = 0;
            $total_tva_ndf = 0;
            $total_tva_0_ndf = 0;
            $total_tva_5_ndf = 0;
            $total_tva_10_ndf = 0;
            $total_tva_20_ndf = 0;
            $total_tva_unk_ndf = 0;
            $total_ttc_ndf = 0;

            foreach ($r_ndfs as $r_ndfs) {
                ?>
                <tr>
                    <td>
                        <?= $r_ndfs->id ?>
                    </td>
                    <td>
                        <?= $r_ndfs->description ?>
                    </td>
                    <td>
                        <?= $r_ndfs->ht_tot_amount ?>
                    </td>
                    <td>
                        <?= $r_ndfs->tva_tot_amount ?>
                    </td>
                    <td>
                        <?= $r_ndfs->ttc_tot_amount ?>
                    </td>
                </tr>
                <?php
                $total_ht_ndf += $r_ndfs->ht_tot_amount;
                $total_tva_ndf += $r_ndfs->tva_tot_amount;
                $total_ttc_ndf += $r_ndfs->ttc_tot_amount;

                $ndfd = getAllNdfDByNdfId($db, $r_ndfs->id);
                foreach ($ndfd as $k => $v):
                    switch ($v->TVA_PERCENT):
                        case '0.00':
                            $total_tva_0_ndf += $v->TTC_AMOUNT;
                            break;
                        case '5.50':
                            $total_tva_5_ndf += $v->TVA_AMOUNT;
                            break;
                        case '10.00':
                            $total_tva_10_ndf += $v->TVA_AMOUNT;
                            break;
                        case '20.00':
                            $total_tva_20_ndf += $v->TVA_AMOUNT;
                            break;
                        default:
                            $total_tva_unk_ndf += $v->TVA_AMOUNT;
                            break;
                    endswitch;
                endforeach;
            }
            ?>
        </tbody>
    </table>
</div>

<?php

function getAllNdfDByNdfId($db, $id)
{
    $sql = "SELECT * "
            . "FROM notesfrais_detail "
            . "WHERE fk_notesfrais_id='" . $id . "'";
    $r_rdv = $db->prepare($sql);
    $r_rdv->execute();
    $r = $r_rdv->fetchAll(PDO::FETCH_OBJ);

    return $r;
}
?>
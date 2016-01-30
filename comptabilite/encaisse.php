<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    ?>
    <script type="text/javascript">
        top.location.replace('../index.php');
    </script>
    <?php
}
?>
<div class="container">
    <h1>Gestion Encaissés</h1>
    <form class="form-horizontal" method="GET" action="encaisse.php" id="form_encaisse">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-3 control-label">Client</label>
                            <div class="col-lg-9">
                                <select class="select2-container select2-container-multi form-control" 
                                        name="input_customer" id="input_customer" 
                                        style="width:100%">
                                            <?php if (isset($_GET['input_customer'])) { ?>
                                                <?php $r_client = getOneCustomerById($db, $_GET['input_customer']); ?>
                                        <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_fac" class="col-lg-3 control-label">Référence Facture</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_ref_fac" name="input_ref_fac" 
                                       placeholder="Référence" type="text" 
                                       value="<?= isset($_GET['input_ref_fac']) ? $_GET['input_ref_fac'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_compta_mini" class="col-lg-3 control-label">Date Envoi</label>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" 
                                       name="input_date_compta_mini" 
                                       id="input_date_paie_mini"
                                       value="<?= isset($_GET['input_date_compta_mini']) ? $_GET['input_date_compta_mini'] : '' ?>"/>
                            </div>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" 
                                       name="input_date_compta_maxi" 
                                       id="input_date_paie_maxi"
                                       value="<?= isset($_GET['input_date_compta_maxi']) ? $_GET['input_date_compta_maxi'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_amount" class="col-lg-2 control-label">Montants</label>
                            <div class="col-lg-5">
                                <input class="form-control" id="input_amount" name="input_ht" 
                                       placeholder="Montant HT" type="text" 
                                       value="<?= isset($_GET['input_ht']) ? $_GET['input_ht'] : '' ?>"/>
                            </div>
                            <div class="col-lg-5">
                                <input class="form-control" id="input_amount" name="input_amount" 
                                       placeholder="Montant TTC" type="text" 
                                       value="<?= isset($_GET['input_amount']) ? $_GET['input_amount'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_paie" class="col-lg-3 control-label">Référence Paiement</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_ref_paie" name="input_ref_paie" 
                                       placeholder="Référence" type="text" 
                                       value="<?= isset($_GET['input_ref_paie']) ? $_GET['input_ref_paie'] : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_paie_mini" class="col-lg-3 control-label">Date Paiement</label>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" 
                                       name="input_date_paie_mini" 
                                       id="input_date_paie_mini"
                                       value="<?= isset($_GET['input_date_paie_mini']) ? $_GET['input_date_paie_mini'] : '' ?>"/>
                            </div>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" 
                                       name="input_date_paie_maxi" 
                                       id="input_date_paie_maxi"
                                       value="<?= isset($_GET['input_date_paie_maxi']) ? $_GET['input_date_paie_maxi'] : '' ?>"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <?php
        if (!empty($_GET)) {
            $r_encaisses = searchEncaisse($db);

            if ($r_encaisses) {
                ?>

                <h1>Résultats - <?= count($r_encaisses) ?> factures</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th class="col-lg-1">Plac.</th>
                                <th class="col-lg-2">Client</th>
                                <th>Ref Facture</th>
                                <th>Date Paie.</th>
                                <th class="text-right">HT</th>
                                <th class="text-right">Montant TVA</th>
                                <th class="text-right">TTC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $amount_ht_tot = 0;
                            $amount_tva_tot = 0;
                            $amount_ttc_tot = 0;
                            foreach ($r_encaisses as $r_encaisse) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="./upd_encaisse.php?id=<?= $r_encaisse->id ?>">
                                            <?= $r_encaisse->id ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php $r_placement = getOnePlacementById($db, $r_encaisse->placement); ?>
                                        <a href="../client/upd_placement.php?id=<?= $r_placement ? $r_placement->id : '' ?>">
                                            <?= $r_placement ? $r_placement->id : '' ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../client/upd_client.php?id=<?= $r_encaisse->idClient ?>">
                                            <?= $r_encaisse->nom ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $r_encaisse->ref_facture ?>
                                    </td>
                                    <td>
                                        <?= date("d/m/Y", strtotime($r_encaisse->date_paiement)) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($r_encaisse->montant, 2, '.', ' ') ?> €
                                    </td>
                                    <td class="text-right">
                                        <?=  number_format($r_encaisse->amountTva, 2, '.', ' ') ?> €
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($r_encaisse->ttc, 2, '.', ' ') ?> €
                                    </td>
                                </tr>
                                <?php
                                $amount_ht_tot += $r_encaisse->montant;
                                $amount_tva_tot += $r_encaisse->tva;
                                $amount_ttc_tot += $r_encaisse->ttc;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h4>Attention!</h4>
                    <p>Aucun résultats</p>
                </div>
            <?php } ?>
            <h1>Bilan</h1>
            <div class="">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                Total HT
                            </td>
                            <td>
                                <?= isset($amount_ht_tot) ? number_format($amount_ht_tot, 2, '.', ' ') : 0 ?> €
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Total TVA
                            </td>
                            <td>
                                    <?= isset($amount_tva_tot) ? number_format($amount_tva_tot, 2, '.', ' ') : 0 ?> €
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Total TTC
                            </td>
                            <td>
                                <?= isset($amount_ttc_tot) ? number_format($amount_ttc_tot, 2, '.', ' ') : 0 ?> €
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#input_customer').select2({
            ajax: {
                url: "../api/customers.php",
                dataType: 'json',
                delay: 50,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            allowClear: true,
            placeholder: 'Selectionner un client',
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1
        });
    });
</script>
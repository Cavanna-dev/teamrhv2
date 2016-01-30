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

$r = getOnePlacementDetailById($db, $_GET['detail']);
$r_client = getOneCustomerById($db, $_GET['c']);
$r_placement = getOnePlacementById($db, $_GET['p']);
?>
<div class="container">
    <h1>Création Encaissé</h1>
    <form class="form-horizontal" method="POST" action="../functions/new_encaisse.php" id="form_decaisse">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">
                                <a href="../client/upd_client.php?id=<?= $r_client->id ?>">
                                    Client
                                </a>
                            </label>
                            <div class="col-lg-10">
                                <select class="select2 form-control" 
                                        name="input_customer" id="input_customer" 
                                        style="width:100%">
                                    <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_send" class="col-lg-2 control-label">Date envoi</label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" 
                                       name="input_date_send" id="input_date_send" 
                                       value="<?= $r->date ?>" 
                                       placeholder="Date envoi" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_fac" class="col-lg-2 control-label">Référence facture</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ref_fac" id="input_ref_fac"
                                       placeholder="Référence facture" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_tva" class="col-lg-2 control-label">TVA</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_tva" id="input_tva"
                                       value="<?= $r->tva ?>"
                                       placeholder="TVA" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_amount_tva" class="col-lg-2 control-label">Montant TVA</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_amount_tva" id="input_amount_tva"
                                       placeholder="Montant TVA" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ttc" class="col-lg-2 control-label">Montant TTC</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ttc" id="input_ttc"
                                       placeholder="Montant TTC" required>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">
                                <a href="../client/upd_placement.php?id=<?= $r_placement->id ?>">
                                    Placement
                                </a>
                            </label>
                            <div class="col-lg-10">
                                <select class="select2 form-control" 
                                        name="input_placement" id="input_placement" 
                                        style="width:100%">
                                            <?php $r_poste = getOneJobById($db, $r_placement->poste); ?>
                                            <?php $r_applicant = getOneApplicantById($db, $r_placement->candidat); ?>
                                    <option value="<?= $r_placement->id ?>"><?= $r_client->nom ?> / <?= $r_poste->libelle ?> / <?= $r_applicant->nom ?> <?= $r_applicant->prenom ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_pay" class="col-lg-2 control-label">Date paiement</label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" 
                                       name="input_date_pay" id="input_date_pay"
                                       placeholder="Date paiement" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_pay" class="col-lg-2 control-label">Référence paiement</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ref_pay" id="input_ref_pay"
                                       placeholder="Référence paiement" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_mode_paiement" class="col-lg-2 control-label">Mode de paiement</label>
                            <div class="col-lg-4">
                                <select class="form-control" 
                                        name="input_mode_paiement" id="input_mode_paiement">
                                    <option value=""></option>
                                    <option value="VIREMENT">Virement</option>
                                    <option value="CHEQUE">Chèque</option>
                                    <option value="CB">CB</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ht" class="col-lg-2 control-label">Montant HT</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ht" id="input_ht"
                                       value="<?= $r->montant ?>"
                                       placeholder="Montant HT" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_description" class="col-lg-2 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea name="input_description" class="form-control"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <fieldset>
                <div class="form-group">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(window).ready(function () {
        
        var tva = parseInt($('#input_tva').val());
        var ht = parseInt($('#input_ht').val());
        
        var amountTva = (ht * (tva/100));
        var amountTtc = ht + amountTva;
        
        $('#input_amount_tva').val(amountTva);
        $('#input_ttc').val(amountTtc);
        
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
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 1
        });
    });
</script>
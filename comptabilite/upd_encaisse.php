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

$r = getOneEncaisseById($db, $_GET['id']);
?>
<div class="container">
    <h1>Modification Encaissé</h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_encaisse.php" id="form_decaisse">
        <input type="hidden" name="input_id" value="<?= $r->id ?>"/>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">
                                <a href="../client/upd_client.php?id=<?= $r->idClient ?>">
                                    Client
                                </a>
                            </label>
                            <div class="col-lg-10">
                                <select class="select2 form-control" 
                                        name="input_customer" id="input_customer" 
                                        style="width:100%">
                                    <option value="<?= $r->idClient ?>"><?= $r->nomClient ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_send" class="col-lg-2 control-label">Date envoi</label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" 
                                       name="input_date_send" id="input_date_send" 
                                       value="<?= $r->date_envoi ?>" 
                                       placeholder="Date envoi" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_fac" class="col-lg-2 control-label">Référence facture</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ref_fac" id="input_ref_fac"
                                       value="<?= $r->ref_facture ?>" 
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
                                       value="<?= $r->enc_tva_tot_amount ?>" 
                                       placeholder="Montant TVA" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ttc" class="col-lg-2 control-label">Montant TTC</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ttc" id="input_ttc"
                                       value="<?= $r->enc_ttc_tot_amount ?>" 
                                       placeholder="Montant TTC" required>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">
                                <a href="../client/upd_placement.php?id=<?= $r->idPlacement ?>">
                                    Placement
                                </a>
                            </label>
                            <div class="col-lg-10">
                                <select class="select2 form-control" 
                                        name="input_placement" id="input_placement" 
                                        style="width:100%">
                                    <option value="<?= $r->idPlacement ?>"><?= $r->nomClient ?> / <?= $r->libelle ?> / <?= $r->nomCandidat ?> <?= $r->prenomCandidat ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date_pay" class="col-lg-2 control-label">Date paiement</label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" 
                                       name="input_date_pay" id="input_date_pay"
                                       value="<?= $r->date_paiement ?>" 
                                       placeholder="Date paiement" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_ref_pay" class="col-lg-2 control-label">Référence paiement</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" 
                                       name="input_ref_pay" id="input_ref_pay"
                                       value="<?= $r->ref_paiement ?>" 
                                       placeholder="Référence paiement" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_mode_paiement" class="col-lg-2 control-label">Mode de paiement</label>
                            <div class="col-lg-4">
                                <select class="form-control" 
                                        name="input_mode_paiement" id="input_mode_paiement">
                                    <option value=""></option>
                                    <option value="VIREMENT" <?= $r->mode_paiement == 'VIREMENT' ? 'selected' : '' ?>>Virement</option>
                                    <option value="CHEQUE" <?= $r->mode_paiement == 'CHEQUE' ? 'selected' : '' ?>>Chèque</option>
                                    <option value="CB" <?= $r->mode_paiement == 'CB' ? 'selected' : '' ?>>CB</option>
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
                                <textarea name="input_description" class="form-control"><?= $r->description ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <fieldset>
                <div class="form-group">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(window).ready(function () {
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
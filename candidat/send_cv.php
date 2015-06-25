<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneApplicantById($db, $_GET['candidat']);
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion Envoi CVs - <a href="upd_applicant.php?id=<?= $r->id ?>"><?= $r->nom . ' ' . $r->prenom ?></a></h1>
    <form class="form-horizontal" method="POST" action="../functions/new_send_cv.php">
        <input type="hidden" name="candidat" value="<?= isset($_GET['candidat']) ? $_GET['candidat'] : '' ?>"/>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="date_envoi" class="col-lg-3 control-label">Date envoi</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" 
                                       name="date_envoi" id="date_envoi"
                                       value="<?= date("Y-m-d", strtotime("now")) ?>"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-12">
                    <fieldset>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="input_customer" class="col-lg-2 control-label">Cible Client</label>
                                <div class="col-lg-10">
                                    <?php $r_customers = getAllCustomers($db); ?>
                                    <select class="form-control" id="cible_client_left">
                                        <?php
                                        while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                            ?>
                                            <option value="<?php echo $r_customer->id; ?>"><?php echo $r_customer->nom; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <input type="button" value="<<" id="rmv_item_cust">
                            <input type="button" value=">>" id="add_item_cust">
                        </div>
                        <div class="col-lg-5">
                            <select class="form-control" name="customers[]" 
                                    id="cible_client_right" multiple 
                                    style="height:100px;">
                                        <?php if (isset($_GET['candidat']) && isset($_GET['date_envoi'])) { ?>
                                            <?php $r_customers = getCustomersBySendCvs($db, $_GET['candidat'], $_GET['date_envoi']); ?>
                                            <?php
                                            while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                        <option value="<?php echo $r_customer->id; ?>" selected><?php echo $r_customer->nom; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <fieldset>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="input_customer" class="col-lg-2 control-label">Cible Poste</label>
                                <div class="col-lg-10">
                                    <select class="form-control" id="cible_poste_left">
                                        <?php $r_jobs = getAllJobsSendCv($db); ?>
                                        <?php
                                        foreach ($r_jobs as $r_job):
                                            ?>
                                            <option value="<?php echo $r_job->id; ?>"><?php echo $r_job->nom; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <input type="button" value="<<" id="rmv_item_job">
                            <input type="button" value=">>" id="add_item_job">
                        </div>
                        <div class="col-lg-5">
                            <select class="form-control" name="jobs[]" 
                                    id="cible_poste_right" multiple
                                    style="height:100px;">
                                        <?php if (isset($_GET['candidat']) && isset($_GET['date_envoi'])) { ?>
                                            <?php $r_jobs = getJobSendCv($db, $_GET['candidat'], $_GET['date_envoi']); ?>
                                            <?php
                                            foreach ($r_jobs as $r_job) :
                                                ?>
                                        <option value="<?php echo $r_job->id; ?>" selected><?php echo $r_job->nom; ?></option>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <fieldset>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="input_customer" class="col-lg-2 control-label">Cible Prospect</label>
                                <div class="col-lg-10">
                                    <?php $r_prosps = getAllProspect($db); ?>
                                    <select class="form-control" id="cible_prosp_left">
                                        <?php
                                        foreach ($r_prosps as $r_prosp) :
                                            ?>
                                            <option value="<?php echo $r_prosp->id; ?>"><?php echo $r_prosp->nom; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <input type="button" value="<<" id="rmv_item_prosp">
                            <input type="button" value=">>" id="add_item_prosp">
                        </div>
                        <div class="col-lg-5">
                            <select class="form-control" name="prospects[]" 
                                    id="cible_prosp_right" multiple
                                    style="height:100px;">
                                        <?php if (isset($_GET['candidat']) && isset($_GET['date_envoi'])) { ?>
                                            <?php $r_prospects = getProspectSendCv($db, $_GET['candidat'], $_GET['date_envoi']); ?>
                                            <?php
                                            foreach ($r_prospects as $r_prospect) :
                                                ?>
                                        <option value="<?php echo $r_prospect->id; ?>" selected><?php echo $r_prospect->nom; ?></option>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        /**
         * Ajout/Suppression des clients
         */
        $('#add_item_cust').click(function () {
            var id = $('#cible_client_left').val();
            var right = $('#cible_client_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_client_right').append(option);
            else
                alert('Veuillez selectionner un client à gauche pour l\'ajouter.');

            $('#cible_client_right').each(function () {
                $('#cible_client_left option[value="' + id + '"]').remove();
            });
        });

        $('#rmv_item_cust').click(function () {
            var id = $('#cible_client_right').val();
            var right = $('#cible_client_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_client_left').append(option);
            else
                alert('Veuillez selectionner un client à droite pour le supprimer.');

            $('#cible_client_left').each(function () {
                $('#cible_client_right option[value="' + id + '"]').remove();
            });
        });

        /**
         * Ajout/Suppression des postes
         */
        $('#add_item_job').click(function () {
            var id = $('#cible_poste_left').val();
            var right = $('#cible_poste_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_poste_right').append(option);
            else
                alert('Veuillez selectionner un prospect à gauche pour l\'ajouter.');

            $('#cible_poste_right').each(function () {
                $('#cible_poste_left option[value="' + id + '"]').remove();
            });
        });

        $('#rmv_item_job').click(function () {
            var id = $('#cible_poste_right').val();
            var right = $('#cible_poste_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_poste_left').append(option);
            else
                alert('Veuillez selectionner un prospect à droite pour le supprimer.');

            $('#cible_poste_left').each(function () {
                $('#cible_poste_right option[value="' + id + '"]').remove();
            });
        });

        /**
         * Ajout/Suppression des prospects
         */
        $('#add_item_prosp').click(function () {
            var id = $('#cible_prosp_left').val();
            var right = $('#cible_prosp_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_prosp_right').append(option);
            else
                alert('Veuillez selectionner un prospect à gauche pour l\'ajouter.');

            $('#cible_prosp_right').each(function () {
                $('#cible_prosp_left option[value="' + id + '"]').remove();
            });
        });

        $('#rmv_item_prosp').click(function () {
            var id = $('#cible_prosp_right').val();
            var right = $('#cible_prosp_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');

            if (id != '' && right != '')
                $('#cible_prosp_left').append(option);
            else
                alert('Veuillez selectionner un prospect à droite pour le supprimer.');

            $('#cible_prosp_left').each(function () {
                $('#cible_prosp_right option[value="' + id + '"]').remove();
            });
        });
    });
</script>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion RDVs</h1>
    <form class="form-horizontal" method="POST" action="../functions/new_rdv_customer.php" id="form_rdv">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_applicant" class="col-lg-2 control-label">Candidat*</label>
                            <div class="col-lg-10">
                                <select class="select2-container select2-container-multi form-control" 
                                        name="input_applicant" id="input_applicant" 
                                        style="width:100%">
                                            <?php if (isset($_GET['candidat'])) { ?>
                                                <?php $r_applicant = getOneApplicantById($db, $_GET['candidat']); ?>
                                        <option value="<?= $r_applicant->id ?>"><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">Client*</label>
                            <div class="col-lg-10">
                                <select class="select2-container select2-container-multi form-control" 
                                        name="input_customer" id="input_customer" 
                                        style="width:100%">
                                            <?php if (isset($_GET['client'])) { ?>
                                                <?php $r_client = getOneCustomerById($db, $_GET['client']); ?>
                                        <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_job" class="col-lg-2 control-label">Poste</label>
                            <div class="col-lg-10">
                                <?php if (isset($_GET['client'])) { ?>
                                    <?php $r_jobs = getJobsCustomer($db, $_GET['client']); ?>
                                    <?php //var_dump($r_jobs); ?>    
                                    <select class="form-control" 
                                            name="input_job">
                                        <option value=""></option>
                                        <?php
                                        if (count($r_jobs) != 0) {
                                            foreach ($r_jobs as $r_job) :
                                                ?>
                                                <option value="<?= $r_job->id; ?>" <?php if (isset($_GET['poste']) && $r_job->id == $_GET['poste']) echo 'selected'; ?>><?= $r_job->libelle ?></option>
                                                <?php
                                            endforeach;
                                        }else {
                                            ?>
                                            <option value="">Aucun Poste</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php } else { ?>
                                    <?php $r_jobs = getAllJobs($db); ?>		
                                    <select class="form-control" 
                                            name="input_job">
                                        <option value=""></option>
                                        <?php
                                        foreach ($r_jobs as $r_job) {
                                            ?>
                                            <option value="<?php echo $r_job->id; ?>"><?php echo $r_job->libelle; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_hours" class="col-lg-2 control-label">Horaires (hh:mm)*</label>
                            <div class="col-lg-4">		
                                <input class="form-control" type="text" 
                                       name="input_hours" required />
                            </div>
                            <label for="input_n_rdv" class="col-lg-2 control-label">Numéro RDV</label>
                            <div class="col-lg-4">		
                                <input class="form-control" type="text" 
                                       name="input_n_rdv" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_customer" class="col-lg-2 control-label">Remarque Client</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_customer"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Créer RDV Client</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_consult" class="col-lg-2 control-label">Consult.*</label>
                            <div class="col-lg-10">	
                                <?php $r_users = getAllImportantUsers($db); ?>
                                <select class="form-control" 
                                        name="input_consult" 
                                        id="input_contact_law" required>
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>"><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact" class="col-lg-2 control-label">Contact</label>
                            <div class="col-lg-10">
                                <?php if (isset($_GET['client'])) { ?>
                                    <?php $r_contacts = getContactActifByClient($db, $_GET['client']); ?>
                                    <select class="form-control" 
                                            name="input_contact">
                                        <option value=""></option>
                                        <?php
                                        foreach ($r_contacts as $r_contact) :
                                            ?>
                                            <option value="<?php echo $r_contact->id; ?>"><?php echo $r_contact->nom . ' ' . $r_contact->prenom; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                <?php } else { ?>
                                    <?php $r_contacts = getAllContact($db); ?>
                                    <select class="form-control" 
                                            name="input_contact">
                                        <option value=""></option>
                                        <?php
                                        while ($r_contact = $r_contacts->fetch(PDO::FETCH_OBJ)) {
                                            ?>
                                            <option value="<?php echo $r_contact->id; ?>"><?php echo $r_contact->nom . ' ' . $r_contact->prenom; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date" class="col-lg-2 control-label">Date*</label>
                            <div class="col-lg-8">
                                <input type="date" 
                                       class="form-control" name="input_date" 
                                       id="input_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_teamrh" class="col-lg-2 control-label">Remarque TeamRH</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control"
                                          name="input_rmq_teamrh"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_applicant" class="col-lg-2 control-label">Remarque Candidat</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_applicant"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
<script type='text/javascript'>
    $('#input_customer').change(function () {
        var url = 'new_rdv.php';
        if ($('#input_applicant').val() != '' || $('#input_customer').val() != '') {
            url += '?';
        }
        if ($('#input_applicant').val() != '' && $('#input_applicant').val() != null) {
            url += 'candidat=' + $('#input_applicant').val();
        }
        if (($('#input_applicant').val() != '' && $('#input_applicant').val() != null) && $('#input_customer').val() != '') {
            url += '&';
        }
        if ($('#input_customer').val() != '') {
            url += 'client=' + $('#input_customer').val();
        }

        window.location = url;

    });

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
            escapeMarkup: function (markup) {
                return markup;
            }
        });
        $('#input_applicant').select2({
            ajax: {
                url: "../api/applicants.php",
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
            minimumInputLength: 2,
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
</script>
</body>

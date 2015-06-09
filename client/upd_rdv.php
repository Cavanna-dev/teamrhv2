<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$rdv = getOneRdvCustomerById($db, $_GET['id']);
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion RDVs</h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_rdv_customer.php" id="form_rdv">
            <input type="hidden" class="form-control" name="input_id" id="input_id" value="<?= $rdv->ID ?>">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_applicant" class="col-lg-2 control-label">Candidat*</label>
                            <div class="col-lg-10">
                                <?php $r_applicant = getOneApplicantById($db, $rdv->CANDIDAT); ?>		
                                <select class="form-control" 
                                        name="input_applicant">
                                    <option value="<?= $r_applicant->id ?>"   ><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?>   </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">Client*</label>
                            <div class="col-lg-10">
                                <?php $r_customers = getAllCustomers($db); ?>		
                                <select class="form-control" 
                                        name="input_customer">
                                    <?php
                                    while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_customer->id; ?>" <?php if($r_customer->id == $rdv->CLIENT) echo "selected"; ?>><?php echo $r_customer->nom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_job" class="col-lg-2 control-label">Poste</label>
                            <div class="col-lg-10">
                                <?php $r_jobs = getAllJobs($db); ?>		
                                <select class="form-control" 
                                        name="input_job">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_jobs as $r_job) {
                                        ?>
                                        <option value="<?= $r_job->id; ?>" <?php if($r_job->id == $rdv->POSTE) echo "selected"; ?>><?= $r_job->libelle; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_customer" class="col-lg-2 control-label">Remarque Client</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_customer"><?= $rdv->RMQ_CLIENT ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_hours" class="col-lg-2 control-label">Horaires (hh:mm)</label>
                            <div class="col-lg-4">		
                                <input class="form-control" type="text" 
                                       name="input_hours" required 
                                       value="<?= $rdv->HORAIRE ?>"/>
                            </div>
                            <label for="input_n_rdv" class="col-lg-2 control-label">Numéro RDV</label>
                            <div class="col-lg-4">		
                                <input class="form-control" type="text" 
                                       name="input_n_rdv" required 
                                       value="<?= $rdv->NUMERO_RDV ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                <a href="../functions/del_rdv_customer.php?id=<?= $rdv->ID ?>"><button type="button" class="btn btn-primary">Supprimer</button></a>
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
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if($r_user->id == $rdv->CONSULTANT) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact" class="col-lg-2 control-label">Contact</label>
                            <div class="col-lg-10">	
                                <?php $r_contacts = getAllContact($db); ?>
                                <select class="form-control" 
                                        name="input_contact" required>
                                    <option value=""></option>
                                    <?php
                                    while ($r_contact = $r_contacts->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_contact->id; ?>" <?php if($r_contact->id == $rdv->CONTACT) echo "selected"; ?>><?= $r_contact->nom . ' ' . $r_contact->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date" class="col-lg-2 control-label">Date*</label>
                            <div class="col-lg-8">
                                <input type="date" 
                                       class="form-control" name="input_date" 
                                       id="input_date" required
                                       value="<?= $rdv->DATE_RDV ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_applicant" class="col-lg-2 control-label">Remarque Candidat</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_applicant"><?= $rdv->RMQ_CANDI ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_teamrh" class="col-lg-2 control-label">Remarque TeamRH</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control"
                                          name="input_rmq_teamrh"><?= $rdv->RMQ_TEAMRH ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
</body>

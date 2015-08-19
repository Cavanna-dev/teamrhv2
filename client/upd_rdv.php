<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$rdv = getOneRdvCustomerById($db, $_GET['id']);
//var_dump($rdv);die;
$mail_customer = getOneCustomerById($db, $rdv->CLIENT);
$mail_contact = getOneContactById($db, $rdv->CONTACT);
$mail_job = getOneJobById($db, $rdv->POSTE);
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
                            <label for="input_applicant" class="col-lg-2 control-label"><a href="../candidat/upd_applicant.php?id=<?= $rdv->CANDIDAT ?>">Candidat</a>*</label>
                            <div class="col-lg-10">
                                <?php $r_applicant = getOneApplicantById($db, $rdv->CANDIDAT); ?>		
                                <select class="form-control" 
                                        name="input_applicant">
                                    <option value="<?= $r_applicant->id ?>"   ><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?>   </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label"><a href="./upd_client.php?id=<?= $rdv->CLIENT ?>">Client</a>*</label>
                            <div class="col-lg-10">
                                <?php $r_customers = getAllCustomers($db); ?>		
                                <select class="form-control" id="input_customer"
                                        name="input_customer">
                                            <?php
                                            while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                        <option value="<?php echo $r_customer->id; ?>" <?php if ((!isset($_GET['client']) && $r_customer->id == $rdv->CLIENT) || (isset($_GET['client']) && $r_customer->id == $_GET['client'])) echo "selected"; ?>><?php echo $r_customer->nom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_job" class="col-lg-2 control-label">
                                <?php if (!empty($rdv->POSTE)) { ?><a href="./upd_job.php?id=<?= $rdv->POSTE ?>">Poste</a><?php } else { ?>Poste<?php } ?>
                            </label>
                            <div class="col-lg-10">
                                <?php if (isset($_GET['client'])) { ?>
                                    <?php $r_jobs = getJobByCustomerReal($db, $_GET['client']); ?>
                                    <select class="form-control" 
                                            name="input_job">
                                        <option value=""></option>
                                        <?php
                                        foreach ($r_jobs as $r_job) :
                                            ?>
                                            <option value="<?php echo $r_job->ID; ?>" <?php if ($r_job->ID == $rdv->POSTE) echo "selected"; ?>><?php echo $r_job->libelle; ?></option>
                                            <?php
                                        endforeach;
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
                                            <option value="<?= $r_job->id; ?>" <?php if ($r_job->id == $rdv->POSTE) echo "selected"; ?>><?= $r_job->libelle; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
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
                            <label for="input_rmq_customer" class="col-lg-2 control-label">Remarque Client</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_customer"><?= $rdv->RMQ_CLIENT ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12 col-lg-offset-2">
                                <?php
                                if (strtotime('+2 week', strtotime($rdv->DATE_RDV)) > strtotime("now")) {
                                    ?>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    <a href="../functions/del_rdv_customer.php?id=<?= $rdv->ID ?>"><button type="button" class="btn btn-primary">Supprimer</button></a>
                                    <?php
                                }
                                ?>
                                <?php
                                $subject_cust = "TeamRH : Confirmation d’entretien";
                                //var_dump($r_applicant);die;
                                if (isset($r_applicant->sexe)) {
                                    switch ($r_applicant->sexe)
                                    {
                                        case "M" : $body_cust = "Monsieur,";
                                            break;
                                        case "F" : $body_cust = "Madame,";
                                            break;
                                        default: $body_cust = "Madame/Monsieur,";
                                            break;
                                    }
                                }
                                
                                $body_cust .= "%0A%0ANous vous confirmons le rendez-vous avec ";
                                $body_cust .= $r_applicant->nom . ' ' . $r_applicant->prenom;
                                $body_cust .= " le " . date("d/m/Y", strtotime($rdv->DATE_RDV)) . " à " . $rdv->HORAIRE . ".";
                                $body_cust .= "%0ANous restons à votre disposition.";
                                $body_cust .= "%0A%0ATrès sincèrement. ";
                                ?>
                                <a href="mailto:<?= $mail_contact->email ?>?subject=<?= $subject_cust . "&body=" . rawurlencode($body_cust) ?>"><button type="button" class="btn btn-primary">Confirmation Client</button></a>
                                <?php
                                $subject_appli = "TeamRH : Confirmation d’entretien";
                                $body_appli = "******************";
                                $body_appli .= "*     Merci de nous confirmer la lecture de ce mail              *";
                                $body_appli .= "******************";
                                $body_appli .= "%0A%0A%0A%0AChère " . $r_applicant->prenom . ",";
                                $body_appli .= "%0A%0AVotre rendez-vous a été confirmé pour "
                                        . "le " . date("d/m/Y", strtotime($rdv->DATE_RDV)) . " à " . $rdv->HORAIRE . " "
                                        . "avec " . $mail_contact->civilite . " " . $mail_contact->nom . " " . $mail_contact->prenom;
                                $body_appli .= "%0A" . $mail_customer->nom;
                                $body_appli .= "%0A" . $mail_customer->adresse1;
                                $body_appli .= "%0A" . $mail_customer->postal . " " . $mail_customer->ville;
                                $body_appli .= "%0A%0AMétro : " . $mail_customer->metro;
                                $body_appli .= "%0ATél Standard : " . $mail_customer->tel_std;
                                $body_appli .= "%0ASite web : " . $mail_customer->url;
                                if (!empty($mail_job))
                                    $body_appli .= "%0A%0APoste : " . $mail_job->libelle;

                                $body_appli .= "%0A%0AMerci de nous rappeler à l'issue de l'entretien pour nous donner votre feedback.";
                                $body_appli .= "%0ANous vous souhaitons bonne chance.";
                                $body_appli .= "%0A%0ATrès sincèrement.";
                                ?>
                                <a href="mailto:<?= $r_applicant->email ?>?subject=<?= $subject_appli ?>&body=<?= rawurlencode($body_appli) ?>"><button type="button" class="btn btn-primary">Confirmation Candidat</button></a>
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
                                        <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $rdv->CONSULTANT) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact" class="col-lg-2 control-label">
                                <?php if (!empty($rdv->CONTACT)) { ?><a href="./upd_contact.php?id=<?= $rdv->CONTACT ?>">Contact</a><?php } else { ?>Contact<?php } ?>
                            </label>
                            <div class="col-lg-10">
                                <?php if (isset($_GET['client'])) { ?>
                                    <?php $r_contacts = getContactActifByClient($db, $_GET['client']); ?>
                                    <select class="form-control" 
                                            name="input_contact">
                                        <option value=""></option>
                                        <?php
                                        foreach ($r_contacts as $r_contact) :
                                            ?>
                                            <option value="<?php echo $r_contact->id; ?>" <?php if ($r_contact->id == $rdv->CONTACT) echo "selected"; ?>><?php echo $r_contact->nom . ' ' . $r_contact->prenom; ?></option>
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
                                            <option value="<?= $r_contact->id; ?>" <?php if ($r_contact->id == $rdv->CONTACT) echo "selected"; ?>><?= $r_contact->nom . ' ' . $r_contact->prenom; ?></option>
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
                                       id="input_date" required
                                       value="<?= $rdv->DATE_RDV ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_teamrh" class="col-lg-2 control-label">Remarque TeamRH</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control"
                                          name="input_rmq_teamrh"><?= $rdv->RMQ_TEAMRH ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_rmq_applicant" class="col-lg-2 control-label">Remarque Candidat</label>
                            <div class="col-lg-10">		
                                <textarea class="form-control" 
                                          name="input_rmq_applicant"><?= $rdv->RMQ_CANDI ?></textarea>
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
        window.location = 'upd_rdv.php?id=<?= $_GET['id'] ?>&client=' + $(this).val();
    });
</script>
</body>

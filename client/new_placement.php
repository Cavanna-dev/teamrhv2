<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if($_SESSION['user']['type'] != 'ADMIN' && $_SESSION['user']['type'] != 'SUPERADMIN'){
    echo 'Vous n\'avez pas accès à cette page';
}else{
?>

<div class="container-fluid">
    <form class="form-horizontal" method="POST" action="../functions/new_placement.php" id="form_upd_customer">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-9">
                        <h1>Reglements</h1>
                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Pourcentage 1</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                Pourcentage
                                                <input type="text" class="form-control" 
                                                       name="input_p1_pourcentage" id="input_p1_pourcentage" 
                                                       placeholder="Pourcentage">
                                            </div>
                                            <div class="col-lg-4">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_p1_tva" id="input_p1_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-4">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_p1_montant" id="input_p1_montant" 
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_p1_facture" id="input_p1_facture">
                                                    <option value="">N/A</option>
                                                    <option value="Y">Y</option>
                                                    <option value="N">N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_p1_encaisse" id="input_p1_encaisse">
                                                    <option value="">N/A</option>
                                                    <option value="Y">Y</option>
                                                    <option value="N">N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_p1_date" id="input_p1_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <h2>Pourcentage 2</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                Pourcentage
                                                <input type="text" class="form-control" 
                                                       name="input_p2_pourcentage" id="input_p2_pourcentage" 
                                                       placeholder="Pourcentage">
                                            </div>
                                            <div class="col-lg-4">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_p2_tva" id="input_p2_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-4">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_p2_montant" id="input_p2_montant" 
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_p2_facture" id="input_p2_facture">
                                                    <option value="" <?php if (isset($r_detail_p2->isFacture) && ($r_detail_p2->isFacture == "" || $r_detail_p2->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_p2->isFacture) && $r_detail_p2->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_p2->isFacture) && $r_detail_p2->isFacture == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_p2_encaisse" id="input_p3_encaisse">
                                                    <option value="" <?php if (isset($r_detail_p2->isEncaisse) && ($r_detail_p2->isEncaisse == "" || $r_detail_p2->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_p2->isEncaisse) && $r_detail_p2->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_p2->isEncaisse) && $r_detail_p2->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_p2_date" id="input_p2_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <h2>Pourcentage 3</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-4">
                                                Pourcentage
                                                <input type="text" class="form-control" 
                                                       name="input_p3_pourcentage" id="input_p3_pourcentage" 
                                                       placeholder="Pourcentage">
                                            </div>
                                            <div class="col-lg-4">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_p3_tva" id="input_p3_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-4">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_p3_montant" id="input_p3_montant" 
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_p3_facture" id="input_p3_facture">
                                                    <option value="" <?php if (isset($r_detail_p3->isFacture) && ($r_detail_p3->isFacture == "" || $r_detail_p3->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_p3->isFacture) && $r_detail_p3->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_p3->isFacture) && $r_detail_p3->isFacture == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_p3_encaisse" id="input_p3_encaisse">
                                                    <option value="" <?php if (isset($r_detail_p3->isEncaisse) && ($r_detail_p3->isEncaisse == "" || $r_detail_p3->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_p3->isEncaisse) && $r_detail_p3->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_p3->isEncaisse) && $r_detail_p3->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_p3_date" id="input_p3_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2>Forfait 1</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-6">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_f1_tva" id="input_f1_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-6">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_f1_montant" id="input_f1_montant" 
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_f1_facture" id="input_f1_facture">
                                                    <option value="" <?php if (isset($r_detail_f1->isFacture) && ($r_detail_f1->isFacture == "" || $r_detail_f1->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_f1->isFacture) && $r_detail_f1->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_f1->isFacture) && $r_detail_f1->isFacture == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_f1_encaisse" id="input_f1_encaisse">
                                                    <option value="" <?php if (isset($r_detail_f1->isEncaisse) && ($r_detail_f1->isEncaisse == "" || $r_detail_f1->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_f1->isEncaisse) && $r_detail_f1->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_f1->isEncaisse) && $r_detail_f1->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_f1_date" id="input_f1_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <h2>Forfait 2</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-6">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_f2_tva" id="input_f2_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-6">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_f2_montant" id="input_f2_montant" 
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_f2_facture" id="input_f2_facture">
                                                    <option value="" <?php if (isset($r_detail_f2->isFacture) && ($r_detail_f2->isFacture == "" || $r_detail_f2->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_f2->isFacture) && $r_detail_f2->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_f2->isFacture) && $r_detail_f2->isFacture == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_f2_encaisse" id="input_f3_encaisse">
                                                    <option value="" <?php if (isset($r_detail_f2->isEncaisse) && ($r_detail_f2->isEncaisse == "" || $r_detail_f2->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if ($r_detail_f2->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if ($r_detail_f2->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_f2_date" id="input_f2_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <h2>Forfait 3</h2>
                                    <fieldset>
                                        <div class="form-group">
                                            <div class="col-lg-6">
                                                TVA
                                                <input type="text" class="form-control" 
                                                       name="input_f3_tva" id="input_f3_tva" 
                                                       placeholder="TVA">
                                            </div>
                                            <div class="col-lg-6">
                                                Montant
                                                <input type="text" class="form-control" 
                                                       name="input_f3_montant" id="input_f3_montant"  
                                                       placeholder="Montant">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                Facture
                                                <select class="form-control" name="input_f3_facture" id="input_f3_facture">
                                                    <option value="" <?php if (isset($r_detail_f3->isFacture) && ($r_detail_f3->isFacture == "" || $r_detail_f3->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_f3->isFacture) && $r_detail_f3->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_f3->isFacture) && $r_detail_f3->isFacture == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                Encaisse
                                                <select class="form-control" name="input_p3_encaisse" id="input_p3_encaisse">
                                                    <option value="" <?php if (isset($r_detail_f3->isEncaisse) && ($r_detail_f3->isEncaisse == "" || $r_detail_f3->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                    <option value="Y" <?php if (isset($r_detail_f3->isEncaisse) && $r_detail_f3->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                    <option value="N" <?php if (isset($r_detail_f3->isEncaisse) && $r_detail_f3->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                Date
                                                <input type="date" class="form-control" 
                                                       name="input_f3_date" id="input_f3_date" 
                                                       placeholder="Date">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-9">
                        <h1>Fiche placement</h1>
                    </div>
                    <div class="col-lg-3">
                        <h1 class="pull-right">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </h1>
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_customer" class="col-lg-2 control-label">
                                        Client
                                    </label>
                                    <div class="col-lg-10">
                                        <?php $r_customers = getAllCustomers($db); ?>
                                        <select class="form-control" name="input_customer" id="input_customer">
                                            <option value=""></option>
                                            <?php
                                            while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_customer->id ?>" <?php if($r_customer->id == $_GET['c'])echo 'selected'; ?>><?= $r_customer->nom ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_applicant" class="col-lg-2 control-label">
                                        Candidat
                                    </label>
                                    <div class="col-lg-10">
                                        <?php $r_applicants = getAllApplicants($db); ?>
                                        <select class="form-control" name="input_applicant" id="input_applicant">
                                            <option value=""></option>
                                            <?php
                                            while ($r_applicant = $r_applicants->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_applicant->id ?>">
                                                    <?= $r_applicant->nom . ' ' . $r_applicant->prenom ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_consult" class="col-lg-2 control-label">
                                        Consultant
                                    </label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllUsers($db); ?>
                                        <select class="form-control" name="input_consult" id="input_consult">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_user->id ?>" <?= isset($_GET['co']) && $_GET['co'] == $r_user->id ? 'selected' : '' ?>>
                                                    <?= $r_user->prenom . ' ' . $r_user->nom ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_month" class="col-lg-2 control-label">Mois</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_month" 
                                                id="input_month">
                                            <option value=""></option>
                                            <option value="janvier">Janvier</option>
                                            <option value="février">Février</option>
                                            <option value="mars">Mars</option>
                                            <option value="avril">Avril</option>
                                            <option value="mai">Mai</option>
                                            <option value="juin">Juin</option>
                                            <option value="juillet">Juillet</option>
                                            <option value="août">Août</option>
                                            <option value="septembre">Septembre</option>
                                            <option value="octobre">Octobre</option>
                                            <option value="novembre">Novembre</option>
                                            <option value="décembre">Décembre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_contrat" id="input_contrat">
                                            <option value="N/A" <?= isset($_GET['con']) && $_GET['con'] == 'N/A' ? 'selected' : '' ?>>N/A</option>
                                            <option value="CDD" <?= isset($_GET['con']) && $_GET['con'] == 'CDD' ? 'selected' : '' ?>>CDD</option>
                                            <option value="CDI" <?= isset($_GET['con']) && $_GET['con'] == 'CDI' ? 'selected' : '' ?>>CDI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_lieux" class="col-lg-2 control-label">Lieux</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_lieux" id="input_lieux" 
                                               value="<?= isset($_GET['li']) ? $_GET['li'] : '' ?>"
                                               placeholder="Lieux">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_deb" class="col-lg-2 control-label">Date deb.</label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" 
                                               name="input_deb" id="input_deb" 
                                               value="<?= isset($_GET['datedeb']) ? $_GET['datedeb'] : '' ?>" 
                                               placeholder="Salaire" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_deb" class="col-lg-2 control-label">Pourcentage</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_deb" id="input_deb" 
                                               value="<?= isset($_GET['pt']) ? $_GET['pt'] : '' ?>" 
                                               placeholder="Salaire" required>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_job" class="col-lg-2 control-label">
                                        Poste
                                    </label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_job" id="input_job">
                                            <option value=""></option>
                                            <?php
                                            $r_jobs = getAllJobsByCustomer($db, $_GET['c']);
                                            foreach ($r_jobs as $r_job) {
                                                ?>
                                                <option value="<?= $r_job->id ?>" <?php if($r_job->id == $_GET['p'])echo 'selected'; ?>><?= $r_job->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title" class="col-lg-2 control-label">Titre</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title" id="input_title">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>" <?php if($r_title->id == $_GET['t'])echo 'selected'; ?>><?= $r_title->libelle ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_apporteur" class="col-lg-2 control-label">
                                        Apporteur
                                    </label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllUsers($db); ?>
                                        <select class="form-control" name="input_apporteur" id="input_apporteur">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_user->id ?>">
                                                    <?= $r_user->prenom . ' ' . $r_user->nom ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_year" class="col-lg-2 control-label">Année</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_year" id="input_year" 
                                               value="<?= date('Y') ?>" 
                                               placeholder="Année" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_duree" class="col-lg-2 control-label">Durée</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_duree" id="input_duree" 
                                               value="<?= isset($_GET['dur']) ? $_GET['dur'] : '' ?>" 
                                               placeholder="Durée">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_salaire" class="col-lg-2 control-label">Salaire</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_salaire" id="input_salaire" 
                                               value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>"
                                               placeholder="Salaire">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_remise" class="col-lg-2 control-label">Remise</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_remise" id="input_remise" 
                                               value="" 
                                               placeholder="Remise">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_facture" class="col-lg-2 control-label">Facturé</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_facture" id="input_facture">
                                            <option value=""></option>
                                            <option value="N" selected>N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_encaisse" class="col-lg-2 control-label">Encaissé</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_encaisse" id="input_encaisse">
                                            <option value=""></option>
                                            <option value="N" selected>N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_reglement" class="col-lg-2 control-label">Reglement</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_reglement" id="input_reglement">
                                            <option value=""></option>
                                            <option value="N" selected>N</option>
                                            <option value="Y">Y</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if ($_SESSION['user']['type'] != 'ADMIN' && $_SESSION['user']['type'] != 'SUPERADMIN') {
    echo 'Vous n\'avez pas accès à cette page';
} else {
    $r = getOnePlacementById($db, $_GET['id']);
    ?>
    <script>
        $(document).ready(function () {
            $("#show-up").slideDown('slow').delay(2000).slideUp('slow');
        });
    </script>
    <div class="container-fluid">
        <form class="form-horizontal" method="POST" action="../functions/upd_placement.php" id="form_upd_customer">
            <?php if (isset($_GET['success'])) { ?>
                <div class="alert alert-dismissible alert-success" id="show-up" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Le placement a été modifié.
                </div>
            <?php } else if (isset($_GET['error'])) { ?>
                <div class="alert alert-dismissible alert-warning" id="show-up" style="display:none;">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Il y a eut un problème avec la modification.
                </div>
            <?php } ?>
            <input type="hidden" name="input_id" value="<?= $r->id ?>"/>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-9">
                            <h1>Reglements</h1>
                        </div>
                        <div class="col-lg-3">
                            <h1 class="pull-right">
                                <!--<a href="new_encaisse.php">
                                    <button type="button" class="btn btn-primary">Encaissé</button>
                                </a>-->
                            </h1>
                        </div>
                    </div>
                    <div class="jumbotron">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php $r_detail_p1 = getPlacementDetailById($db, $r->id, 'P', 1); ?>
                                        <h2>Pourcentage 1</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    Pourcentage
                                                    <input type="text" class="form-control" 
                                                           name="input_p1_pourcentage" id="input_p1_pourcentage" 
                                                           value="<?= isset($r_detail_p1->pourcentage) ? $r_detail_p1->pourcentage : '' ?>" 
                                                           placeholder="Pourcentage">
                                                </div>
                                                <div class="col-lg-4">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_p1_tva" id="input_p1_tva" 
                                                           value="<?= isset($r_detail_p1->tva) ? $r_detail_p1->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-4">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_p1_montant" id="input_p1_montant" 
                                                           value="<?= isset($r_detail_p1->montant) ? $r_detail_p1->montant : '' ?>" 
                                                           placeholder="Montant">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-3">
                                                    Facture
                                                    <select class="form-control" name="input_p1_facture" id="input_p1_facture">
                                                        <option value="" <?php if (isset($r_detail_p1->isFacture) && ($r_detail_p1->isFacture == "" || $r_detail_p1->isFacture == NULL)) echo "selected"; ?>>N/A</option>
                                                        <option value="Y" <?php if (isset($r_detail_p1->isFacture) && $r_detail_p1->isFacture == "Y") echo "selected"; ?>>Y</option>
                                                        <option value="N" <?php if (isset($r_detail_p1->isFacture) && $r_detail_p1->isFacture == "N") echo "selected"; ?>>N</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    Encaisse
                                                    <select class="form-control" name="input_p1_encaisse" id="input_p1_encaisse">
                                                        <option value="" <?php if (isset($r_detail_p1->isEncaisse) && ($r_detail_p1->isEncaisse == "" || $r_detail_p1->isEncaisse == NULL)) echo "selected"; ?>>N/A</option>
                                                        <option value="Y" <?php if (isset($r_detail_p1->isEncaisse) && $r_detail_p1->isEncaisse == "Y") echo "selected"; ?>>Y</option>
                                                        <option value="N" <?php if (isset($r_detail_p1->isEncaisse) && $r_detail_p1->isEncaisse == "N") echo "selected"; ?>>N</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    Date
                                                    <input type="date" class="form-control" 
                                                           name="input_p1_date" id="input_p1_date" 
                                                           value="<?= isset($r_detail_p1->date) ? $r_detail_p1->date : '' ?>" 
                                                           placeholder="Date">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php $r_detail_p2 = getPlacementDetailById($db, $r->id, 'P', 2); ?>
                                        <h2>Pourcentage 2</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    Pourcentage
                                                    <input type="text" class="form-control" 
                                                           name="input_p2_pourcentage" id="input_p2_pourcentage" 
                                                           value="<?= isset($r_detail_p2->pourcentage) ? $r_detail_p2->pourcentage : '' ?>" 
                                                           placeholder="Pourcentage">
                                                </div>
                                                <div class="col-lg-4">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_p2_tva" id="input_p2_tva" 
                                                           value="<?= isset($r_detail_p2->tva) ? $r_detail_p2->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-4">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_p2_montant" id="input_p2_montant" 
                                                           value="<?= isset($r_detail_p2->montant) ? $r_detail_p2->montant : '' ?>" 
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
                                                           value="<?= isset($r_detail_p2->date) ? $r_detail_p2->date : '' ?>" 
                                                           placeholder="Date">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php $r_detail_p3 = getPlacementDetailById($db, $r->id, 'P', 3); ?>
                                        <h2>Pourcentage 3</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-4">
                                                    Pourcentage
                                                    <input type="text" class="form-control" 
                                                           name="input_p3_pourcentage" id="input_p3_pourcentage" 
                                                           value="<?= isset($r_detail_p3->pourcentage) ? $r_detail_p3->pourcentage : '' ?>" 
                                                           placeholder="Pourcentage">
                                                </div>
                                                <div class="col-lg-4">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_p3_tva" id="input_p3_tva" 
                                                           value="<?= isset($r_detail_p3->tva) ? $r_detail_p3->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-4">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_p3_montant" id="input_p3_montant" 
                                                           value="<?= isset($r_detail_p3->montant) ? $r_detail_p3->montant : '' ?>" 
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
                                                           value="<?= isset($r_detail_p3->date) ? $r_detail_p3->date : '' ?>" 
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
                                        <?php $r_detail_f1 = getPlacementDetailById($db, $r->id, 'F', 1); ?>
                                        <h2>Forfait 1</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-6">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_f1_tva" id="input_f1_tva" 
                                                           value="<?= isset($r_detail_f1->tva) ? $r_detail_f1->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-6">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_f1_montant" id="input_f1_montant" 
                                                           value="<?= isset($r_detail_f1->montant) ? $r_detail_f1->montant : '' ?>" 
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
                                                           value="<?= isset($r_detail_f1->date) ? $r_detail_f1->date : '' ?>" 
                                                           placeholder="Date">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php $r_detail_f2 = getPlacementDetailById($db, $r->id, 'F', 2); ?>
                                        <h2>Forfait 2</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-6">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_f2_tva" id="input_f2_tva" 
                                                           value="<?= isset($r_detail_f2->tva) ? $r_detail_f2->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-6">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_f2_montant" id="input_f2_montant" 
                                                           value="<?= isset($r_detail_f2->montant) ? $r_detail_f2->montant : '' ?>" 
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
                                                           value="<?= isset($r_detail_f2->date) ? $r_detail_f2->date : '' ?>" 
                                                           placeholder="Date">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <?php $r_detail_f3 = getPlacementDetailById($db, $r->id, 'F', 3); ?>
                                        <h2>Forfait 3</h2>
                                        <fieldset>
                                            <div class="form-group">
                                                <div class="col-lg-6">
                                                    TVA
                                                    <input type="text" class="form-control" 
                                                           name="input_f3_tva" id="input_f3_tva" 
                                                           value="<?= isset($r_detail_f3->tva) ? $r_detail_f3->tva : '' ?>" 
                                                           placeholder="TVA">
                                                </div>
                                                <div class="col-lg-6">
                                                    Montant
                                                    <input type="text" class="form-control" 
                                                           name="input_f3_montant" id="input_f3_montant" 
                                                           value="<?= isset($r_detail_f3->montant) ? $r_detail_f3->montant : '' ?>" 
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
                                                           value="<?= isset($r_detail_f3->date) ? $r_detail_f3->date : '' ?>" 
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
                            <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
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
                                            <a href="./upd_client.php?id=<?= $r->client ?>">
                                                Client
                                            </a>
                                        </label>
                                        <div class="col-lg-10">
                                            <select class="select2-container select2-container-multi form-control" 
                                                    name="input_customer" id="input_customer" 
                                                    style="width:100%">
                                                        <?php if (isset($r->client)) { ?>
                                                            <?php $r_client = getOneCustomerById($db, $r->client); ?>
                                                    <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_applicant" class="col-lg-2 control-label">
                                            <a href="../candidat/upd_applicant.php?id=<?= $r->candidat ?>">
                                                Candidat
                                            </a>
                                        </label>
                                        <div class="col-lg-10">
                                            <select class="select2-container select2-container-multi form-control" 
                                                    name="input_applicant" id="input_applicant" 
                                                    style="width:100%">
                                                        <?php if (isset($r->candidat) && $r->candidat != 0) { ?>
                                                            <?php $r_applicant = getOneApplicantById($db, $r->candidat); ?>
                                                    <option value="<?= $r_applicant->id ?>"><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?></option>
                                                <?php } ?>
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
                                                    <option value="<?= $r_user->id ?>" <?php if ($r_user->id == $r->consultant) echo "selected"; ?>>
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
                                                <option value="janvier" <?php if ($r->mois_placement == 'janvier') echo "selected"; ?>>Janvier</option>
                                                <option value="février" <?php if ($r->mois_placement == 'février') echo "selected"; ?>>Février</option>
                                                <option value="mars" <?php if ($r->mois_placement == 'mars') echo "selected"; ?>>Mars</option>
                                                <option value="avril" <?php if ($r->mois_placement == 'avril') echo "selected"; ?>>Avril</option>
                                                <option value="mai" <?php if ($r->mois_placement == 'mai') echo "selected"; ?>>Mai</option>
                                                <option value="juin" <?php if ($r->mois_placement == 'juin') echo "selected"; ?>>Juin</option>
                                                <option value="juillet" <?php if ($r->mois_placement == 'juillet') echo "selected"; ?>>Juillet</option>
                                                <option value="août" <?php if ($r->mois_placement == 'août') echo "selected"; ?>>Août</option>
                                                <option value="septembre" <?php if ($r->mois_placement == 'septembre') echo "selected"; ?>>Septembre</option>
                                                <option value="octobre" <?php if ($r->mois_placement == 'octobre') echo "selected"; ?>>Octobre</option>
                                                <option value="novembre" <?php if ($r->mois_placement == 'novembre') echo "selected"; ?>>Novembre</option>
                                                <option value="décembre" <?php if ($r->mois_placement == 'décembre') echo "selected"; ?>>Décembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="input_contrat" id="input_contrat">
                                                <option value="N/A" <?php if ($r->contrat == "" || $r->contrat == NULL) echo "selected"; ?>>N/A</option>
                                                <option value="CDD" <?php if ($r->contrat == "CDD") echo "selected"; ?>>CDD</option>
                                                <option value="CDI" <?php if ($r->contrat == "CDI") echo "selected"; ?>>CDI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_lieux" class="col-lg-2 control-label">Lieux</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" 
                                                   name="input_lieux" id="input_lieux" 
                                                   value="<?= $r->lieux ?>" 
                                                   placeholder="Lieux">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_deb" class="col-lg-2 control-label">Date deb.</label>
                                        <div class="col-lg-10">
                                            <input type="date" class="form-control" 
                                                   name="input_deb" id="input_deb" 
                                                   value="<?= $r->date_deb ?>" 
                                                   placeholder="Salaire" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_pourcent" class="col-lg-2 control-label">Pourcentage</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" 
                                                   name="input_pourcent" id="input_pourcent" 
                                                   value="<?= $r->pourcentage ?>" 
                                                   placeholder="Pourcentage" required>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="input_job" class="col-lg-2 control-label">
                                            <a href="./upd_job.php?id=<?= $r->poste ?>">
                                                Poste
                                            </a>
                                        </label>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="input_job" id="input_job">
                                                <option value=""></option>
                                                <?php
                                                if ($r->client != '') {
                                                    $r_jobs = getAllJobsByCustomer($db, $r->client);
                                                    foreach ($r_jobs as $r_job) {
                                                        ?>
                                                        <option value="<?= $r_job->id ?>" <?php if ($r_job->id == $r->poste) echo "selected"; ?>><?= $r_job->libelle ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    $r_jobs = getAllJobs($db);
                                                    foreach ($r_jobs as $r_job) {
                                                        ?>
                                                        <option value="<?= $r_job->id ?>" <?php if ($r_job->id == $r->poste) echo "selected"; ?>><?= $r_job->libelle ?></option>
                                                        <?php
                                                    }
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
                                                    <option value="<?= $r_title->id ?>" <?php if ($r_title->id == $r->titre) echo "selected"; ?>><?= $r_title->libelle ?></option>
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
                                                    <option value="<?= $r_user->id ?>" <?php if ($r_user->id == $r->apporteur) echo "selected"; ?>>
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
                                                   value="<?= $r->annee_placement ?>" 
                                                   placeholder="Année" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_duree" class="col-lg-2 control-label">Durée</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" 
                                                   name="input_duree" id="input_duree" 
                                                   value="<?= $r->duree ?>" 
                                                   placeholder="Durée">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_salaire" class="col-lg-2 control-label">Salaire</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" 
                                                   name="input_salaire" id="input_salaire" 
                                                   value="<?= $r->salaire ?>" 
                                                   placeholder="Salaire">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_remise" class="col-lg-2 control-label">Remise</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" 
                                                   name="input_remise" id="input_remise" 
                                                   value="<?= $r->remise ?>" 
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
                                                <option value="" <?php if ($r->facture == "" || $r->facture == NULL) echo "selected"; ?>></option>
                                                <option value="N" <?php if ($r->facture == "N") echo "selected"; ?>>N</option>
                                                <option value="Y" <?php if ($r->facture == "Y") echo "selected"; ?>>Y</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_encaisse" class="col-lg-2 control-label">Encaissé</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="input_encaisse" id="input_encaisse">
                                                <option value="" <?php if ($r->encaisse == "" || $r->encaisse == NULL) echo "selected"; ?>></option>
                                                <option value="N" <?php if ($r->encaisse == "N") echo "selected"; ?>>N</option>
                                                <option value="Y" <?php if ($r->encaisse == "Y") echo "selected"; ?>>Y</option>
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
                                                <option value="" <?php if ($r->reglement == "" || $r->reglement == NULL) echo "selected"; ?>></option>
                                                <option value="N" <?php if ($r->reglement == "N") echo "selected"; ?>>N</option>
                                                <option value="Y" <?php if ($r->reglement == "Y") echo "selected"; ?>>Y</option>
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
    <?php if (isset($_GET['new'])) { ?>
        <script>
            $(window).ready(function () {
                alert('Le placement a été créée.');
            });
        </script>
    <?php } ?>


    <script type="text/javascript">

        $(window).ready(function () {
            var salary = $('#input_salaire').val();
            var percent = $('#input_pourcent').val();
            var contract = $('#input_contrat').val();
            var duree = $('#input_duree').val();
            var remise = $('#input_remise').val();

            var benef = (salary) * (percent / 100);

            if (contract == 'CDD')
                benef = benef * duree;

            benef -= remise;

    <?php for ($i = 1; $i <= 3; $i++) { ?>
                $("#input_p<?= $i ?>_pourcentage").keyup(function () {
                    var tmp = ($(this).val()) / 100;
                    $('#input_p<?= $i ?>_tva').val('20');
                    $('#input_p<?= $i ?>_montant').val(benef * tmp);
                });
    <?php } ?>

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
<?php } ?>
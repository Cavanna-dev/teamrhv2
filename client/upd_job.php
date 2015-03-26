<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneJobById($db, $_GET['id']);
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="../functions/upd_job.php" id="form_upd_customer">
        <div class = "row">
            <div class = "col-lg-10">
                <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
                <h1>Fiche Poste</h1>
            </div>
            <div class = "col-lg-2">
                <h1><button type="submit" class="btn btn-primary">Enregistrer</button></h1>
            </div>
        </div>
        <div class="jumbotron">
            <div class="form-group">
                <label for="input_description" class="col-lg-1 control-label">Description</label>
                <div class="col-lg-11">
                    <textarea class="form-control" id="input_description" name="input_description" placeholder="Description" type="text" rows="15"><?= $r->description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="input_com" class="col-lg-1 control-label">Commentaire</label>
                <div class="col-lg-11">
                    <textarea class="form-control" id="input_com" name="input_com" placeholder="Commentaire" type="text" rows="15"><?= $r->commentaire; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label"><b>Libelle</b></label>
                            <div class="col-lg-10">
                                <b><input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= $r->libelle; ?>"></b>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">Client</label>
                            <div class="col-lg-10">
                                <?php $r_customers = getAllCustomers($db); ?>
                                <select class="form-control" name="input_customer" id="input_customer">
                                    <option value=""></option>
                                    <?php
                                    while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_customer->id ?>" <?php if ($r_customer->id == $r->client) echo "selected"; ?>><?= $r_customer->nom ?></option>
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
                                    while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?php if ($r_title->id == $r->titre) echo "selected"; ?>><?= $r_title->libelle ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_exp" class="col-lg-2 control-label">Expérience</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_exp" id="input_exp">
                                    <option value=""<?php if ($r->experience == "") echo "selected"; ?>></option>
                                    <option value="1 à 3 ans" <?php if ($r->experience == "1 à 3 ans") echo "selected"; ?>>1 à 3 ans</option>
                                    <option value="4 à 5 ans" <?php if ($r->experience == "4 à 5 ans") echo "selected"; ?>>4 à 5 ans</option>
                                    <option value="6 à 10 ans" <?php if ($r->experience == "6 à 10 ans") echo "selected"; ?>>6 à 10 ans</option>
                                    <option value="&gt; 10 ans" <?php if ($r->experience == "&gt; 10 ans") echo "selected"; ?>>> 10 ans</option>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_contrat" id="input_contrat">
                                    <option value="" <?php if ($r->contrat == "") echo "selected"; ?>></option>
                                    <option value="CDD" <?php if ($r->contrat == "CDD") echo "selected"; ?>>CDD</option>
                                    <option value="CDI" <?php if ($r->contrat == "CDI") echo "selected"; ?>>CDI</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_period" class="col-lg-2 control-label">Durée</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_period" name="input_period" placeholder="URL" type="text" value="<?= $r->duree; ?>">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_salary" class="col-lg-2 control-label">Salaire</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_salary" name="input_salary" placeholder="Salaire" type="text" value="<?= $r->salaire; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_schedule" class="col-lg-2 control-label">Horaires</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_schedule" id="input_schedule">
                                    <option value="" <?php if ($r->horaires == "") echo "selected"; ?>></option>
                                    <option value="matinée" <?php if ($r->horaires == "matinée") echo "selected"; ?>>Matinée</option>
                                    <option value="jour" <?php if ($r->horaires == "jour") echo "selected"; ?>>Jour</option>
                                    <option value="après-midi" <?php if ($r->horaires == "après-midi") echo "selected"; ?>>Après-midi</option>
                                    <option value="soirée" <?php if ($r->horaires == "soirée") echo "selected"; ?>>Soirée</option>
                                    <option value="nuit" <?php if ($r->horaires == "nuit") echo "selected"; ?>>Nuit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_starting_date" class="col-lg-2 control-label">Date Début</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_starting_date" name="input_starting_date" type="date" value="<?= $r->date_deb; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_speed" name="input_speed" type="text" value="<?= $r->vitesse; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_speed" class="col-lg-2 control-label">Communication</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_schedule" id="input_schedule">
                                    <option value="" <?php if ($r->communication == "" || $r->communication == NULL) echo "selected"; ?>></option>
                                    <option value="N" <?php if ($r->communication == "N") echo "selected"; ?>>N</option>
                                    <option value="Y" <?php if ($r->communication == "Y") echo "selected"; ?>>Y</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_place" class="col-lg-2 control-label">Lieux</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_place" name="input_place" placeholder="Lieux" type="text" value="<?= $r->lieux; ?>">
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
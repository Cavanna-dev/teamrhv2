<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneJobById($db, $_GET['id']);
?>
<script>
    $(document).ready(function () {
        $("#show-up").slideDown('slow').delay(2000).slideUp('slow');
    });
</script>
<div class="container">
    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-dismissible alert-success" id="show-up" style="display:none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Le poste a été modifié.
        </div>
    <?php } else if (isset($_GET['error'])) { ?>
        <div class="alert alert-dismissible alert-warning" id="show-up" style="display:none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Il y a eut un problème avec la modification.
        </div>
    <?php } ?>
    <form class="form-horizontal" method="POST" action="../functions/upd_job.php" id="form_upd_customer">
        <input type="hidden" name="input_id" value="<?= $r->id ?>"/>
        <div class = "row">
            <div class = "col-lg-10">
                <h1>Fiche Poste</h1>
            </div>
            <div class = "col-lg-2">
                <h1><button type="submit" class="btn btn-primary">Enregistrer</button></h1>
            </div>
        </div>
        <div class="jumbotron">
            <div class="form-group">
                <label for="input_description" class="col-lg-1 control-label">Description</label>
                <div class="col-lg-5">
                    <textarea class="form-control" id="input_description" name="input_description" placeholder="Description" type="text" rows="15"><?= $r->description; ?></textarea>
                </div>
                <label for="input_commentaire" class="col-lg-1 control-label">Commentaire</label>
                <div class="col-lg-5">
                    <textarea class="form-control" id="input_commentaire" name="input_commentaire" placeholder="Commentaire" type="text" rows="15"><?= $r->commentaire; ?></textarea>
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
                            <label for="input_exp" class="col-lg-2 control-label">Expérience</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_exp" id="input_exp">
                                    <option value=""<?php if ($r->experience == "") echo "selected"; ?>></option>
                                    <option value="Aucune" <?php if ($r->experience == "Aucune") echo "selected"; ?>>Aucune</option>
                                    <option value="< 1 an" <?php if ($r->experience == "< 1 an") echo "selected"; ?>>< 1 an</option>
                                    <option value="1 à 3 ans" <?php if ($r->experience == "1 à 3 ans") echo "selected"; ?>>1 à 3 ans</option>
                                    <option value="4 à 5 ans" <?php if ($r->experience == "4 à 5 ans") echo "selected"; ?>>4 à 5 ans</option>
                                    <option value="6 à 10 ans" <?php if ($r->experience == "6 à 10 ans") echo "selected"; ?>>6 à 10 ans</option>
                                    <option value="> 10 ans" <?php if ($r->experience == "> 10 ans") echo "selected"; ?>>> 10 ans</option>
                                </select>
                            </div>
                            <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_contrat" id="input_contrat">
                                    <option value="" <?php if ($r->contrat == "") echo "selected"; ?>></option>
                                    <option value="CDD" <?php if ($r->contrat == "CDD") echo "selected"; ?>>CDD</option>
                                    <option value="CDI" <?php if ($r->contrat == "CDI") echo "selected"; ?>>CDI</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_period" class="col-lg-2 control-label">Durée</label>
                            <div class="col-lg-5">
                                <input class="form-control" id="input_period" name="input_period" placeholder="URL" type="text" value="<?= $r->duree; ?>">
                            </div>
                            <label for="input_communication" class="col-lg-2 control-label">Comm.</label>
                            <div class="col-lg-3">
                                <select class="form-control" name="input_communication" id="input_communication">
                                    <option value="" <?php if ($r->communication == "" || $r->communication == NULL) echo "selected"; ?>></option>
                                    <option value="N" <?php if ($r->communication == "N") echo "selected"; ?>>N</option>
                                    <option value="Y" <?php if ($r->communication == "Y") echo "selected"; ?>>Y</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_word" class="col-lg-2 control-label">Word</label>
                            <div class="col-lg-2">
                                <input class="form-control" id="input_word" name="input_word" placeholder="Word" type="text" value="<?= $r->word; ?>">
                            </div>
                            <label for="input_excel" class="col-lg-2 control-label">Excel</label>
                            <div class="col-lg-2">
                                <input class="form-control" id="input_excel" name="input_excel" placeholder="Excel" type="text" value="<?= $r->excel; ?>">
                            </div>
                            <label for="input_pp" class="col-lg-2 control-label">PP</label>
                            <div class="col-lg-2">
                                <input class="form-control" id="input_pp" name="input_pp" placeholder="PP" type="text" value="<?= $r->powerpoint; ?>">
                            </div>
                            <label for="input_internet" class="col-lg-2 control-label">Internet</label>
                            <div class="col-lg-2">
                                <input class="form-control" id="input_internet" name="input_internet" placeholder="Internet" type="text" value="<?= $r->internet; ?>">
                            </div>
                            <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                            <div class="col-lg-2">
                                <input class="form-control" id="input_speed" name="input_speed" type="text" value="<?= $r->vitesse; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_appli_1" class="col-lg-3 control-label">Autre Appli. 1</label>
                            <div class="col-lg-3">
                                <input class="form-control" id="input_appli_1" name="input_appli_1" placeholder="Application" type="text" value="<?= $r->autre_appli1; ?>">
                            </div>
                            <label for="input_appli_2" class="col-lg-3 control-label">Autre Appli. 2</label>
                            <div class="col-lg-3">
                                <input class="form-control" id="input_appli_2" name="input_appli_2" placeholder="Application" type="text" value="<?= $r->autre_appli2; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_forfait" class="col-lg-2 control-label">Forfait</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="input_forfait" name="input_forfait" placeholder="Forfait" type="text" value="<?= $r->forfait; ?>">
                            </div>
                            <label for="input_signature" class="col-lg-2 control-label">Signature</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="input_signature" name="input_signature" type="date" value="<?= $r->signature; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_formule" class="col-lg-2 control-label">Formule</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="input_formule" name="input_formule" placeholder="Formule" type="text"><?= $r->formule; ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_contact" class="col-lg-2 control-label">Consultant</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_contact" id="input_contact">
                                    <option value=""></option>
                                    <?php
                                    while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $user_r->id; ?>" <?php if ($user_r->id == $r->consultant) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_diplome" class="col-lg-2 control-label">Diplôme</label>
                            <div class="col-lg-10">
                                <?php $r_diplomes = getAllDiplomes($db); ?>
                                <select class="form-control" name="input_diplome" id="input_diplome">
                                    <option value=""></option>
                                    <?php
                                    while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_diplome->id; ?>" <?php if ($r_diplome->id == $r->diplome) echo "selected"; ?>><?php echo $r_diplome->libelle; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
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
                            <label for="input_place" class="col-lg-2 control-label">Lieux</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_place" name="input_place" placeholder="Lieux" type="text" value="<?= $r->lieux; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_fr" class="col-lg-2 control-label">Niveau FR</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="input_fr" name="input_fr" placeholder="Niveau francais" type="text" value="<?= $r->niveau_fr; ?>">
                            </div>
                            <label for="input_an" class="col-lg-3 control-label">Niveau AN</label>
                            <div class="col-lg-3">
                                <input class="form-control" id="input_an" name="input_an" placeholder="Niveau anglais" type="text" value="<?= $r->niveau_en; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_percent" class="col-lg-2 control-label">Pourcent.</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="input_percent" name="input_percent" placeholder="Pourcentage" type="text" value="<?= $r->pourcentage; ?>">
                            </div>
                            <label for="input_garantie" class="col-lg-2 control-label">Garantie</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="input_garantie" name="input_garantie" placeholder="Garantie" type="text" value="<?= $r->garantie; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_pourvu" class="col-lg-2 control-label">Statut</label>
                            <div class="col-lg-10">
                                <select name="input_pourvu" id="input_pourvu" class="form-control">
                                    <option value="" <?php if(isset($r->pourvu) && $r->pourvu == '') echo 'selected'; ?>></option>
                                    <option value="Y" <?php if(isset($r->pourvu) && $r->pourvu == 'Y') echo 'selected'; ?>>Poste Fermé</option>
                                    <option value="N" <?php if(isset($r->pourvu) && $r->pourvu == 'N') echo 'selected'; ?>>Poste Ouvert</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
<?php if (isset($_GET['new'])) { ?>
    <script>
        $(window).ready(function () {
            alert('Le poste a été créée.');
        });
    </script>
<?php } ?>
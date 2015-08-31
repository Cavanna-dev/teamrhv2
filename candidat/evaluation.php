<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<script>
    $(document).ready(function () {
        $("#show-up").slideDown('slow').delay(2000).slideUp('slow');
    });
</script>
<div class="container-fluid">
    <?php if (isset($_GET['success']) && $_GET['success'] == "c") { ?>
        <div class="alert alert-dismissible alert-success" id="show-up" style="display:none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            L'évaluation à bien a été créé.
        </div>
    <?php } else if (isset($_GET['error'])) { ?>
        <div class="alert alert-dismissible alert-warning" id="show-up" style="display:none;">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Il y a eut un problème avec l'action. Veuillez rééssayé ultérieurement.
        </div>
    <?php } ?>
    <h1>Gestion Evaluation</h1>
    <ul class="nav nav-tabs">
        <li <?= (isset($_GET['tab']) && $_GET['tab'] == "search") || isset($_GET['tab']) ? '' : 'class="active"' ?>><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li <?= isset($_GET['tab']) && $_GET['tab'] == "new" ? 'class="active"' : '' ?>><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == "new" ? "" : "active in" ?>" id="search">
            <form class="form-horizontal" method="GET" action="evaluation.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="input_name" class="form-control" 
                                               value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : '' ?>" />
                                    </div>
                                    <label for="input_phone" class="col-lg-2 control-label">N° Tel.</label>
                                    <div class="col-lg-4">
                                        <input type="text" name="input_phone" class="form-control" 
                                               value="<?= isset($_GET['input_phone']) ? $_GET['input_phone'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_horaire" class="col-lg-2 control-label">Horaires</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_horaire" id="input_horaire">
                                            <option value="" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == '' ? 'selected' : '' ?>></option>
                                            <option value="matinée" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == 'matinée' ? 'selected' : '' ?>>Matinée</option>
                                            <option value="jour" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == 'jour' ? 'selected' : '' ?>>Jour</option>
                                            <option value="après-midi" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == 'après-midi' ? 'selected' : '' ?>>Après-midi</option>
                                            <option value="soirée" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == 'soirée' ? 'selected' : '' ?>>Soirée</option>
                                            <option value="nuit" <?= isset($_GET['input_horaire']) && $_GET['input_horaire'] == 'nuit' ? 'selected' : '' ?>>Nuit</option>
                                        </select>
                                    </div>
                                    <label for="input_l1" class="col-lg-2 control-label">Langue Mat.</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_l1" id="input_l1">
                                            <option value="" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == '' ? 'selected' : '' ?>></option>
                                            <option value="LMA" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LMA' ? 'selected' : 'LMA' ?>>LMA</option>
                                            <option value="LMF" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LMF' ? 'selected' : 'LMF' ?>>LMF</option>
                                            <option value="LMF-LMA" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LMF-LMA' ? 'selected' : '' ?>>LMF-LMA</option>
                                            <option value="LM Allemande" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LM Allemande' ? 'selected' : '' ?>>LM Allemande</option>
                                            <option value="LM Espagnole" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LM Espagnole' ? 'selected' : '' ?>>LM Espagnole</option>
                                            <option value="LM Italienne" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'LM Italienne' ? 'selected' : '' ?>>LM Italienne</option>
                                            <option value="Autre" <?= isset($_GET['input_l1']) && $_GET['input_l1'] == 'Autre' ? 'selected' : '' ?>>Autre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_disponible" class="col-lg-2 control-label">Disponible</label>
                                    <div class="col-lg-2">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" 
                                                       name="input_disponible" id="input_disponible" 
                                                       <?php if (isset($_GET['input_disponible']) && $_GET['input_disponible'] == 'Y') echo "checked"; ?>
                                                       value="Y"> Oui
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_note" class="col-lg-2 control-label">Note</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_note" id="input_note">
                                            <option value="" <?= isset($_GET['input_note']) && $_GET['input_note'] == '' ? 'selected' : '' ?>></option>
                                            <option value="A" <?= isset($_GET['input_note']) && $_GET['input_note'] == 'A' ? 'selected' : '' ?>>A</option>
                                            <option value="B" <?= isset($_GET['input_note']) && $_GET['input_note'] == 'B' ? 'selected' : '' ?>>B</option>
                                            <option value="C" <?= isset($_GET['input_note']) && $_GET['input_note'] == 'C' ? 'selected' : '' ?>>C</option>
                                            <option value="D" <?= isset($_GET['input_note']) && $_GET['input_note'] == 'D' ? 'selected' : '' ?>>D</option>
                                        </select>
                                    </div>
                                    <label for="input_date_eval" class="col-lg-2 control-label">Date eval.</label>
                                    <div class="col-lg-4">
                                        <select name="input_date_eval" class="form-control" >
                                            <option value=""<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '' ? 'selected' : '' ?>>               </option>
                                            <option value="1"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '1' ? 'selected' : '' ?>>Moins de 1 mois</option>
                                            <option value="2"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '2' ? 'selected' : '' ?>>Moins de 2 mois</option>
                                            <option value="3"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '3' ? 'selected' : '' ?>>Moins de 3 mois</option>
                                            <option value="6"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '6' ? 'selected' : '' ?>>Moins de 6 mois</option>
                                            <option value="12"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '12' ? 'selected' : '' ?>>Moins de 12 mois</option>
                                            <option value="24"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '24' ? 'selected' : '' ?>>Moins de 24 mois</option>
                                            <option value="36"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '36' ? 'selected' : '' ?>>Moins de 36 mois</option>
                                            <option value="48"<?= isset($_GET['input_date_eval']) && $_GET['input_date_eval'] == '48' ? 'selected' : '' ?>>Moins de 48 mois</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_age" class="col-lg-2 control-label">Age</label>
                                    <div class="col-lg-4">
                                        <select name="input_age" class="form-control">
                                            <option value=""<?= isset($_GET['input_age']) && $_GET['input_age'] == '' ? 'selected' : '' ?>>          </option>
                                            <option value="25"<?= isset($_GET['input_age']) && $_GET['input_age'] == '25' ? 'selected' : '' ?>> < 25 ans </option>
                                            <option value="30"<?= isset($_GET['input_age']) && $_GET['input_age'] == '30' ? 'selected' : '' ?>> < 30 ans </option>
                                            <option value="35"<?= isset($_GET['input_age']) && $_GET['input_age'] == '35' ? 'selected' : '' ?>> < 35 ans </option>
                                            <option value="40"<?= isset($_GET['input_age']) && $_GET['input_age'] == '40' ? 'selected' : '' ?>> < 40 ans </option>
                                            <option value="45"<?= isset($_GET['input_age']) && $_GET['input_age'] == '45' ? 'selected' : '' ?>> < 45 ans </option>
                                            <option value="50"<?= isset($_GET['input_age']) && $_GET['input_age'] == '50' ? 'selected' : '' ?>> < 50 ans </option>
                                        </select>
                                    </div>
                                    <label for="input_sexe" class="col-lg-2 control-label">Sexe</label>
                                    <div class="col-lg-4">
                                        <select name="input_sexe" class="form-control">
                                            <option value=""<?= isset($_GET['input_sexe']) && $_GET['input_sexe'] == '' ? 'selected' : '' ?>>       </option>
                                            <option value="F"<?= isset($_GET['input_sexe']) && $_GET['input_sexe'] == 'F' ? 'selected' : '' ?>> Femme </option>
                                            <option value="H"<?= isset($_GET['input_sexe']) && $_GET['input_sexe'] == 'M' ? 'selected' : '' ?>> Homme </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_salaire_mini" class="col-lg-3 control-label">Salaire mini.</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_mini" id="input_salaire_mini" 
                                               placeholder="Salaire mini."
                                               value="<?= isset($_GET['input_salaire_mini']) ? $_GET['input_salaire_mini'] : "" ?>">
                                    </div>
                                    <label for="input_salaire_maxi" class="col-lg-3 control-label">Salaire maxi.</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_maxi" id="input_salaire_maxi" 
                                               placeholder="Salaire mini."
                                               value="<?= isset($_GET['input_salaire_maxi']) ? $_GET['input_salaire_maxi'] : "" ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_dipl_left" class="col-lg-2 control-label">Diplôme</label>
                                            <div class="col-lg-10">
                                                <?php $r_diplomes = getAllDiplomes($db); ?>
                                                <select class="form-control" id="cible_dipl_left">
                                                    <?php
                                                    while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <?php if (!in_array($r_diplome->id, $_GET['input_diplomes'])) { ?>
                                                            <option value="<?= $r_diplome->id; ?>"><?= $r_diplome->libelle; ?></option>
                                                        <?php } ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_dipl">
                                        <input type="button" value=">>" id="add_item_dipl">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_diplomes[]" 
                                                id="cible_dipl_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_diplomes'] as $value):
                                                        $r = getOneDiplomeById($db, $value);
                                                        ?>
                                                <option value="<?= $r->id; ?>" selected><?= $r->libelle; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_exp_left" class="col-lg-2 control-label">Expérience</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" id="cible_exp_left">
                                                    <option value="Aucune">Aucune</option>
                                                    <option value="< 1 an">< 1 an</option>
                                                    <option value="1 à 3 ans">1 à 3 ans</option>
                                                    <option value="4 à 5 ans">4 à 5 ans</option>
                                                    <option value="6 à 10 ans">6 à 10 ans</option>
                                                    <option value="> 10 ans">> 10 ans</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_exp">
                                        <input type="button" value=">>" id="add_item_exp">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_exps[]" 
                                                id="cible_exp_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_exps'] as $value):
                                                        ?>
                                                <option value="<?= $value; ?>" selected><?= $value; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_loc_left" class="col-lg-2 control-label">Localisation</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" id="cible_loc_left">
                                                    <OPTION  value="75" >(75) Paris         </OPTION>
                                                    <OPTION  value="77" >(77) Seine et Marne</OPTION>
                                                    <OPTION  value="78" >(78) Yvelines      </OPTION>
                                                    <OPTION  value="91" >(91) Essonne       </OPTION>
                                                    <OPTION  value="92" >(92) Hauts de Seine</OPTION>
                                                    <OPTION  value="93" >(93) Seine St Denis</OPTION>
                                                    <OPTION  value="94" >(94) Val de Marne  </OPTION>
                                                    <OPTION  value="95" >(95) Val d'Oise    </OPTION>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_loc">
                                        <input type="button" value=">>" id="add_item_loc">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_locs[]" 
                                                id="cible_loc_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_locs'] as $value):
                                                        ?>
                                                <option value="<?= $value; ?>" selected><?= $value; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_zone_left" class="col-lg-2 control-label">Secteur d'activité</label>
                                            <div class="col-lg-10">
                                                <?php $r_zones = getAllZones($db); ?>
                                                <select class="form-control" id="cible_zone_left">
                                                    <?php
                                                    while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <?php if (!in_array($r_zone->id, $_GET['input_zones'])) { ?>
                                                            <option value="<?= $r_zone->id; ?>"><?= $r_zone->libelle; ?></option>
                                                        <?php } ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_zone">
                                        <input type="button" value=">>" id="add_item_zone">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_zones[]" 
                                                id="cible_zone_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_zones'] as $value):
                                                        $r = getOneZoneById($db, $value);
                                                        ?>
                                                <option value="<?= $r->id; ?>" selected><?= $r->libelle; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_spec_left" class="col-lg-2 control-label">Spécialité</label>
                                            <div class="col-lg-10">
                                                <?php $r_specs = getAllSpec($db); ?>
                                                <select class="form-control" id="cible_spec_left">
                                                    <?php
                                                    while ($r_spec = $r_specs->fetch(PDO::FETCH_OBJ)) {
                                                        ?>
                                                        <?php if (!in_array($r_spec->id, $_GET['input_specs'])) { ?>
                                                            <option value="<?= $r_spec->id; ?>"><?= $r_spec->libelle; ?></option>
                                                        <?php } ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_spec">
                                        <input type="button" value=">>" id="add_item_spec">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_specs[]" 
                                                id="cible_spec_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_specs'] as $value):
                                                        $r = getOneSpecById($db, $value);
                                                        ?>
                                                <option value="<?= $r->id; ?>" selected><?= $r->libelle; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_titac_left" class="col-lg-2 control-label">Poste Actuel</label>
                                            <div class="col-lg-10">
                                                <?php $r_titacs = getAllTitles($db); ?>
                                                <select class="form-control" id="cible_titac_left">
                                                    <?php
                                                    foreach ($r_titacs as $value):
                                                        ?>
                                                        <?php if (!in_array($value->id, $_GET['input_titacs'])) { ?>
                                                            <option value="<?= $value->id; ?>"><?= $value->libelle; ?></option>
                                                        <?php } ?>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_titac">
                                        <input type="button" value=">>" id="add_item_titac">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_titacs[]" 
                                                id="cible_titac_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_titacs'] as $value):
                                                        $r = getOneTitleById($db, $value);
                                                        ?>
                                                <option value="<?= $r->id; ?>" selected><?= $r->libelle; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="cible_titso_left" class="col-lg-2 control-label">Poste souhaité</label>
                                            <div class="col-lg-10">
                                                <?php $r_titsos = getAllTitles($db); ?>
                                                <select class="form-control" id="cible_titso_left">
                                                    <?php
                                                    foreach ($r_titsos as $value):
                                                        ?>
                                                        <?php if (!in_array($value->id, $_GET['input_titso'])) { ?>
                                                            <option value="<?= $value->id; ?>"><?= $value->libelle; ?></option>
                                                        <?php } ?>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" value="<<" id="rmv_item_titso">
                                        <input type="button" value=">>" id="add_item_titso">
                                    </div>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="input_titsos[]" 
                                                id="cible_titso_right" multiple 
                                                style="height:100px;">
                                                    <?php
                                                    foreach ($_GET['input_titsos'] as $value):
                                                        $r = getOneTitleById($db, $value);
                                                        ?>
                                                <option value="<?= $r->id; ?>" selected><?= $r->libelle; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_remarque" class="col-lg-1 control-label">Remarque</label>
                                    <div class="col-lg-11">
                                        <textarea class="form-control" rows="6" name="input_remarque" id="input_remarque"><?= isset($_GET['input_remarque']) ? $_GET['input_remarque'] : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if (!empty($_GET) && !isset($_GET['tab']) && !isset($_GET['success']) && !isset($_GET['error'])) {
                $r_evals = searchEval($db);
                $result_search = $r_evals->fetchAll(PDO::FETCH_OBJ);
                if ($result_search) {
                    ?>

                    <h1>Résultats - <?= count($result_search) ?></h1>
                    <div class="jumbotron">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">Eval.</th>
                                    <th class="col-lg-2">NOM Prénom</th>
                                    <th class="col-lg-2">Secteur</th>
                                    <th class="col-lg-3">Titre actuel</th>
                                    <th class="col-lg-3">Titre recherché</th>
                                    <th class="col-lg-1">Salaire rech.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result_search as $r_eval) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="upd_evaluation.php?id=<?= $r_eval->id ?>">
                                                <?= $r_eval->id; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="upd_applicant.php?id=<?= $r_eval->candidat; ?>"
                                               tabindex="0" role="button" 
                                               data-toggle="popover" 
                                               data-trigger="hover" 
                                               data-placement="right" 
                                               data-html="true"
                                               data-content="<?= str_replace('"', '\'', $r_eval->remarque) ?>">
                                                   <?php $r_applicant = getOneApplicantById($db, $r_eval->candidat); ?>
                                                   <?= $r_applicant ? $r_applicant->nom . " " . $r_applicant->prenom : ''; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $r_zone = getOneZoneById($db, $r_eval->secteur_actuel); ?>
                                            <?= $r_zone ? $r_zone->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?php $r_title = getOneTitleById($db, $r_eval->titre1_actuel); ?>
                                            <?= $r_title ? $r_title->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?php $r_title2 = getOneTitleById($db, $r_eval->titre1_rech); ?>
                                            <?= $r_title2 ? $r_title2->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?= $r_eval->sal_min_rech ? $r_eval->sal_min_rech : ''; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <h4>Aucune évaluation trouvée</h4>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="tab-pane fade <?= isset($_GET['tab']) ? "active in" : "" ?>" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_eval.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-9" style="min-height: 250px;">
                            <fieldset>
                                <div class="form-group col-lg-12">
                                    <label for="input_candidat" class="col-lg-1 control-label">Candidat</label>
                                    <div class="col-lg-4">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            $r_applicant_eval = getOneApplicantById($db, $_GET['id']);
                                        }
                                        ?>
                                        <input type="hidden" 
                                               name="input_candidat" id="input_eval" 
                                               value="<?= isset($r_applicant_eval) ? $r_applicant_eval->id : '' ?>">
                                        <input type="text" 
                                               class="form-control"
                                               value="<?= isset($r_applicant_eval) ? $r_applicant_eval->nom . " " . $r_applicant_eval->prenom : ''; ?>" disabled />
                                    </div>
                                    <label for="input_disponible" class="col-lg-2 control-label">Disponible*</label>
                                    <div class="col-lg-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_disponible" id="input_disponible1" 
                                                       value="Y" checked>
                                                Oui
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_disponible" id="input_disponible2" 
                                                       value="N" >
                                                Non
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="input_title1" class="col-lg-1 control-label">Titre actuel 1</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title1" id="input_title1">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_title2" class="col-lg-1 control-label">Titre actuel 2</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title2" id="input_title2">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_title3" class="col-lg-1 control-label">Titre actuel 3</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title3" id="input_title3">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="input_title_futur1" class="col-lg-1 control-label">Titre rech. 1*</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur1" id="input_title_futur1" required>
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_title_futur2" class="col-lg-1 control-label">Titre rech. 2</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur2" id="input_title_futur2">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_title_futur3" class="col-lg-1 control-label">Titre rech. 3</label>
                                    <div class="col-lg-3">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur3" id="input_title_futur3">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>">
                                                    <?= $r_title->libelle ?>
                                                </option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-3" style="position:absolute;right:0;"><img src="http://placehold.it/200x225" /></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_diplome" class="col-lg-2 control-label">Diplôme</label>
                                    <div class="col-lg-4">
                                        <?php $r_diplomes = getAllDiplomes($db); ?>
                                        <select class="form-control" name="input_diplome" id="input_diplome">
                                            <option value=""></option>
                                            <?php
                                            while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_diplome->id ?>">
                                                    <?= $r_diplome->libelle ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_exp" class="col-lg-2 control-label">Expérience</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_exp" id="input_exp">
                                            <option value=""></option>
                                            <option value="Aucune">Aucune</option>
                                            <option value="< 1 an">< 1 an</option>
                                            <option value="1 à 3 ans">1 à 3 ans</option>
                                            <option value="4 à 5 ans">4 à 5 ans</option>
                                            <option value="6 à 10 ans">6 à 10 ans</option>
                                            <option value="> 10 ans">> 10 ans</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_oral_fr" class="col-lg-2 control-label">Test Oral FR</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_oral_fr" id="input_oral_fr">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <label for="input_test_fr1" class="col-lg-2 control-label">Test FR 1</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_test_fr1" id="input_test_fr1"
                                               placeholder="Test FR 1"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_oral_en" class="col-lg-2 control-label">Test Oral ANG</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_oral_en" id="input_oral_en">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <label for="input_test_en1" class="col-lg-2 control-label">Test ANG 1</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_test_en1" id="input_test_en1"
                                               placeholder="Test AN 1"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                                    <div class="col-lg-4">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone" id="input_zone">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>">
                                                    <?php echo $r_zone->libelle; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label for="input_zone_rech" class="col-lg-2 control-label">Secteur rech.</label>
                                    <div class="col-lg-4">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone_rech" id="input_zone_rech">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>">
                                                    <?php echo $r_zone->libelle; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contrat_1" class="col-lg-2 control-label">Contrat rech. 1</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_contrat_1" id="input_contrat_1">
                                            <option value=""></option>
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
                                            <option value="Libéral">Libéral</option>
                                        </select>
                                    </div>
                                    <label for="input_contrat_2" class="col-lg-2 control-label">Contrat rech. 2</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_contrat_2" id="input_contrat_2">
                                            <option value=""></option>
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
                                            <option value="Libéral">Libéral</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_salaire_actuel" class="col-lg-2 control-label">Salaire actuel</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" 
                                               name="input_salaire_actuel" id="input_salaire_actuel" 
                                               placeholder="Salaire actuel"
                                               value="">
                                    </div>
                                    <label for="input_salaire_rech" class="col-lg-2 control-label">Salaire recherché</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" 
                                               name="input_salaire_rech" id="input_salaire_rech" 
                                               placeholder="Salaire mini."
                                               value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_horaires_1" class="col-lg-2 control-label">Horaires rech. 1</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_horaires_1" id="input_horaires_1">
                                            <option value=""></option>
                                            <option value="matinée">Matinée</option>
                                            <option value="jour">Jour</option>
                                            <option value="après-midi">Après-midi</option>
                                            <option value="soirée">Soirée</option>
                                            <option value="nuit">Nuit</option>
                                        </select>
                                    </div>
                                    <label for="input_horaires_2" class="col-lg-2 control-label">Horaires rech. 2</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_horaires_2" id="input_horaires_2">
                                            <option value=""></option>
                                            <option value="matinée">Matinée</option>
                                            <option value="jour">Jour</option>
                                            <option value="après-midi">Après-midi</option>
                                            <option value="soirée">Soirée</option>
                                            <option value="nuit">Nuit</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_l1" class="col-lg-2 control-label">Langue 1</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_l1" id="input_l1">
                                            <option value=""></option>
                                            <option value="LMA">LMA</option>
                                            <option value="LMF">LMF</option>
                                            <option value="LMF-LMA">LMF-LMA</option>
                                            <option value="LM Allemande">>LM Allemande</option>
                                            <option value="LM Espagnole">LM Espagnole</option>
                                            <option value="LM Italienne">LM Italienne</option>
                                            <option value="Autre">Autre</option>
                                        </select>
                                    </div>
                                    <label for="input_l2" class="col-lg-2 control-label">Langue 2</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_l2" id="input_l2">
                                            <option value=""></option>
                                            <option value="LMA">LMA</option>
                                            <option value="LMF">LMF</option>
                                            <option value="LMF-LMA">LMF-LMA</option>
                                            <option value="LM Allemande">LM Allemande</option>
                                            <option value="LM Espagnole">LM Espagnole</option>
                                            <option value="LM Italienne">LM Italienne</option>
                                            <option value="Autre">Autre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_test_fr2" class="col-lg-2 control-label">Test FR 2</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_test_fr2" id="input_test_fr2"
                                               placeholder="Test FR 2"
                                               value=""/>
                                    </div>
                                    <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_speed" id="input_speed"
                                               placeholder="Vitesse"
                                               value=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_test_en2" class="col-lg-2 control-label">Test ANG 2</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_test_en2" id="input_test_en2"
                                               placeholder="Test AN 2"
                                               value=""/>
                                    </div>
                                    <label for="input_appli1" class="col-lg-2 control-label">Autre appli.</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text"
                                               name="input_appli1" id="input_appli1"
                                               placeholder="Autre application"
                                               value=""/>
                                    </div>
                                </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="spec[]" class="col-lg-2 control-label">Spécialités</label>
                                <div class="col-lg-4">
                                    <?php $specs = getAllSpec($db); ?>
                                    <select class="form-control" 
                                            name="spec[]" id="spec[]" multiple="multiple" size="8">
                                                <?php
                                                while ($spec = $specs->fetch(PDO::FETCH_OBJ)) {
                                                    ?>
                                            <option value="<?php echo $spec->id; ?>">
                                                <?= $spec->libelle; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <p class="text-warning" style="font-size: 12px;">*Maintenir Ctrl pour faire une selection multiple.</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="input_preavis" class="col-lg-2 control-label">Préavis</label>
                                <div class="col-lg-4">
                                    <select class="form-control" 
                                            name="input_preavis" id="input_preavis">
                                        <option value=""></option>
                                        <option value="Aucun">Aucun</option>
                                        <option value="1 mois">1 mois</option>
                                        <option value="2 mois">2 mois</option>
                                        <option value="3 mois">3 mois</option>
                                        <option value="> 3 mois">> 3 mois</option>
                                    </select>
                                </div>
                                <label for="input_note_gen" class="col-lg-2 control-label">Note générale</label>
                                <div class="col-lg-4">
                                    <select class="form-control" 
                                            name="input_note_gen" id="input_note_gen">
                                        <option value=""></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_remarque" class="col-lg-1 control-label">Remarque</label>
                                    <div class="col-lg-11">
                                        <textarea class="form-control" rows="6" name="input_remarque" id="input_remarque"><?= isset($r->REMARQUE) ? $r->REMARQUE : '' ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $(function () {
            $('[data-toggle="popover"]').popover({
                container: 'body'
            });
        });

        /**
         * Ajout/Suppression des diplomes
         */
        $('#add_item_dipl').click(function () {
            var id = $('#cible_dipl_left').val();
            var right = $('#cible_dipl_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_dipl_right').append(option);
            else
                alert('Veuillez selectionner un diplôme à gauche pour l\'ajouter.');
            $('#cible_dipl_right').each(function () {
                $('#cible_dipl_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_dipl').click(function () {
            var id = $('#cible_dipl_right').val();
            var right = $('#cible_dipl_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_dipl_left').append(option);
            else
                alert('Veuillez selectionner un diplôme à droite pour le supprimer.');
            $('#cible_dipl_left').each(function () {
                $('#cible_dipl_right option[value="' + id + '"]').remove();
            });
            $('#cible_dipl_right').each(function () {
                $('#cible_dipl_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des expériences
         */
        $('#add_item_exp').click(function () {
            var id = $('#cible_exp_left').val();
            var right = $('#cible_exp_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_exp_right').append(option);
            else
                alert('Veuillez selectionner une expérience à gauche pour l\'ajouter.');
            $('#cible_exp_right').each(function () {
                $('#cible_exp_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_exp').click(function () {
            var id = $('#cible_exp_right').val();
            var right = $('#cible_exp_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_exp_left').append(option);
            else
                alert('Veuillez selectionner une expérience à droite pour le supprimer.');
            $('#cible_exp_left').each(function () {
                $('#cible_exp_right option[value="' + id + '"]').remove();
            });
            $('#cible_exp_right').each(function () {
                $('#cible_exp_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des localisations
         */
        $('#add_item_loc').click(function () {
            var id = $('#cible_loc_left').val();
            var right = $('#cible_loc_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_loc_right').append(option);
            else
                alert('Veuillez selectionner une localisation à gauche pour l\'ajouter.');
            $('#cible_loc_right').each(function () {
                $('#cible_loc_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_loc').click(function () {
            var id = $('#cible_loc_right').val();
            var right = $('#cible_loc_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_loc_left').append(option);
            else
                alert('Veuillez selectionner une localisation à droite pour le supprimer.');
            $('#cible_loc_left').each(function () {
                $('#cible_loc_right option[value="' + id + '"]').remove();
            });
            $('#cible_loc_right').each(function () {
                $('#cible_loc_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des secteurs
         */
        $('#add_item_zone').click(function () {
            var id = $('#cible_zone_left').val();
            var right = $('#cible_zone_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_zone_right').append(option);
            else
                alert('Veuillez selectionner un secteur à gauche pour l\'ajouter.');
            $('#cible_zone_right').each(function () {
                $('#cible_zone_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_zone').click(function () {
            var id = $('#cible_zone_right').val();
            var right = $('#cible_zone_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_zone_left').append(option);
            else
                alert('Veuillez selectionner un secteur à droite pour le supprimer.');
            $('#cible_zone_left').each(function () {
                $('#cible_zone_right option[value="' + id + '"]').remove();
            });
            $('#cible_zone_right').each(function () {
                $('#cible_zone_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des spécialités
         */
        $('#add_item_spec').click(function () {
            var id = $('#cible_spec_left').val();
            var right = $('#cible_spec_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_spec_right').append(option);
            else
                alert('Veuillez selectionner une spécialité à gauche pour l\'ajouter.');
            $('#cible_spec_right').each(function () {
                $('#cible_spec_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_spec').click(function () {
            var id = $('#cible_spec_right').val();
            var right = $('#cible_spec_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_spec_left').append(option);
            else
                alert('Veuillez selectionner une spécialité à droite pour le supprimer.');
            $('#cible_spec_left').each(function () {
                $('#cible_spec_right option[value="' + id + '"]').remove();
            });
            $('#cible_spec_right').each(function () {
                $('#cible_spec_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des titres actuels
         */
        $('#add_item_titac').click(function () {
            var id = $('#cible_titac_left').val();
            var right = $('#cible_titac_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_titac_right').append(option);
            else
                alert('Veuillez selectionner un poste actuel à gauche pour l\'ajouter.');
            $('#cible_titac_right').each(function () {
                $('#cible_titac_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_titac').click(function () {
            var id = $('#cible_titac_right').val();
            var right = $('#cible_titac_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_titac_left').append(option);
            else
                alert('Veuillez selectionner un poste actuel à droite pour le supprimer.');
            $('#cible_titac_left').each(function () {
                $('#cible_titac_right option[value="' + id + '"]').remove();
            });
            $('#cible_titac_right').each(function () {
                $('#cible_titac_right option').attr("selected");
            });
        });

        /**
         * Ajout/Suppression des titres recherchés
         */
        $('#add_item_titso').click(function () {
            var id = $('#cible_titso_left').val();
            var right = $('#cible_titso_left option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '" selected>' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_titso_right').append(option);
            else
                alert('Veuillez selectionner un poste recherché à gauche pour l\'ajouter.');
            $('#cible_titso_right').each(function () {
                $('#cible_titso_left option[value="' + id + '"]').remove();
            });
        });
        $('#rmv_item_titso').click(function () {
            var id = $('#cible_titso_right').val();
            var right = $('#cible_titso_right option[value="' + id + '"]').text();
            var option = $('<option value="' + id + '">' + right + '</option>');
            if (id != '' && right != '')
                $('#cible_titso_left').append(option);
            else
                alert('Veuillez selectionner un poste recherché à droite pour le supprimer.');
            $('#cible_titso_left').each(function () {
                $('#cible_titso_right option[value="' + id + '"]').remove();
            });
            $('#cible_titso_right').each(function () {
                $('#cible_titso_right option').attr("selected");
            });
        });

    });

</script>
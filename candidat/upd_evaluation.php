<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneEvalById($db, $_GET['id']);
//var_dump($r);die;
?>

<?php if (isset($_GET['success'])) { ?>
    <script>
        $(window).load(function () {
            alert('L\'évaluation a été modifié.');
        });
    </script>
<?php } ?>
<div class="container-fluid">
    <form class="form-horizontal" method="POST" action="../functions/upd_eval.php" id="form_customer" enctype="multipart/form-data">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-10" style="min-height: 150px;">
                    <fieldset>
                        <div class="form-group col-lg-12">
                            <label for="input_candidat" class="col-lg-1 control-label">Candidat</label>
                            <div class="col-lg-4">
                                <?php $r_applicant_eval = getOneApplicantById($db, $r->CANDIDAT); ?>
                                <input type="hidden" 
                                       name="input_eval" id="input_eval" 
                                       value="<?= $r->ID ?>">
                                <input type="hidden" 
                                       name="input_apply" id="input_eval" 
                                       value="<?= $r->CANDIDAT ?>">
                                <input type="text" 
                                       class="form-control"
                                       value="<?= $r_applicant_eval->nom . " " . $r_applicant_eval->prenom; ?>" disabled />
                            </div>
                            <label for="input_disponible" class="col-lg-2 control-label">Disponible</label>
                            <div class="col-lg-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="input_disponible" id="input_disponible1" 
                                               value="Y" 
                                               <?= ($r->DISPONIBLE == 'Y') ? 'checked=""' : '' ?>>
                                        Oui
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="input_disponible" id="input_disponible2" 
                                               value="N" 
                                               <?= $r->DISPONIBLE == 'N' ? 'checked=""' : '' ?>>
                                        Non
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="input_title1" class="col-lg-1 control-label">Titre act 1</label>
                            <div class="col-lg-3">
                                <?php $r_titles = getAllTitles($db); ?>
                                <select class="form-control" name="input_title1" id="input_title1">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE1_ACTUEL == $r_title->id ? 'selected' : '' ?>>
                                            <?= $r_title->libelle ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <label for="input_title2" class="col-lg-1 control-label">Titre act 2</label>
                            <div class="col-lg-3">
                                <?php $r_titles = getAllTitles($db); ?>
                                <select class="form-control" name="input_title2" id="input_title2">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE2_ACTUEL == $r_title->id ? 'selected' : '' ?>>
                                            <?= $r_title->libelle ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                            <label for="input_title3" class="col-lg-1 control-label">Titre act 3</label>
                            <div class="col-lg-3">
                                <?php $r_titles = getAllTitles($db); ?>
                                <select class="form-control" name="input_title3" id="input_title3">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE3_ACTUEL == $r_title->id ? 'selected' : '' ?>>
                                            <?= $r_title->libelle ?>
                                        </option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="input_title_futur1" class="col-lg-1 control-label">Titre rech. 1</label>
                            <div class="col-lg-3">
                                <?php $r_titles = getAllTitles($db); ?>
                                <select class="form-control" name="input_title_futur1" id="input_title_futur1">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE1_RECH == $r_title->id ? 'selected' : '' ?>>
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
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE2_RECH == $r_title->id ? 'selected' : '' ?>>
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
                                    foreach ($r_titles as $r_title) :
                                        ?>
                                        <option value="<?= $r_title->id ?>" <?= $r->TITRE3_RECH == $r_title->id ? 'selected' : '' ?>>
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
                <div class="col-lg-2">
                    <?php if ($r->PICTURE_PATH) { ?>
                        <div class="fileinput fileinput-exists" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="<?= $r->PICTURE_PATH ?>" data-src="<?= $r->PICTURE_PATH ?>" data-trigger="fileinput">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 11px;">
                                <img src="<?= $r->PICTURE_PATH ?>" style="max-height: 140px;"></div>
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Choisir image</span>
                                    <span class="fileinput-exists">Modifier</span>
                                    <input type="hidden" value="<?= $r->PICTURE_PATH ?>" name="photo"><input type="file" value="<?= $r->PICTURE_PATH ?>" name="photo"></span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Retirer</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://placehold.it/200x150" data-src="http://placehold.it/200x150" data-trigger="fileinput">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Choisir image</span>
                                    <span class="fileinput-exists">Modifier</span>
                                    <input type="file" name="photo"></span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Retirer</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="row" style="margin-top: 50px;">
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
                                        <option value="<?= $r_diplome->id ?>" <?= $r->DIPLOME == $r_diplome->id ? 'selected' : '' ?>>
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
                                    <option value="" <?= $r->EXPERIENCE == '' ? 'selected' : '' ?>></option>
                                    <option value="Aucune" <?= $r->EXPERIENCE == 'Aucune' ? 'selected' : '' ?>>Aucune</option>
                                    <option value="< 1 an" <?= $r->EXPERIENCE == '< 1 an' ? 'selected' : '' ?>>< 1 an</option>
                                    <option value="1 à 3 ans" <?= $r->EXPERIENCE == '1 à 3 ans' ? 'selected' : '' ?>>1 à 3 ans</option>
                                    <option value="4 à 5 ans" <?= $r->EXPERIENCE == '4 à 5 ans' ? 'selected' : '' ?>>4 à 5 ans</option>
                                    <option value="6 à 10 ans" <?= $r->EXPERIENCE == '6 à 10 ans' ? 'selected' : '' ?>>6 à 10 ans</option>
                                    <option value="> 10 ans" <?= $r->EXPERIENCE == '> 10 ans' ? 'selected' : '' ?>>> 10 ans</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_oral_fr" class="col-lg-2 control-label">Test Oral FR</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_oral_fr" id="input_oral_fr">
                                    <option value="" <?= $r->LVL_ORAL_FR == '' ? 'selected' : '' ?>></option>
                                    <option value="A" <?= $r->LVL_ORAL_FR == 'A' ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= $r->LVL_ORAL_FR == 'B' ? 'selected' : '' ?>>B</option>
                                    <option value="C" <?= $r->LVL_ORAL_FR == 'C' ? 'selected' : '' ?>>C</option>
                                    <option value="D" <?= $r->LVL_ORAL_FR == 'D' ? 'selected' : '' ?>>D</option>
                                    <option value="N/A" <?= $r->LVL_ORAL_FR == 'N/A' ? 'selected' : '' ?>>N/A</option>
                                </select>
                            </div>
                            <label for="input_test_fr1" class="col-lg-2 control-label">Test FR 1</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" 
                                       name="input_test_fr1" id="input_test_fr1"
                                       placeholder="Test FR 1"
                                       value="<?= isset($r->LVL_TEST1_FR) && $r->LVL_TEST1_FR != 0 ? $r->LVL_TEST1_FR : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_oral_en" class="col-lg-2 control-label">Test Oral ANG</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_oral_en" id="input_oral_en">
                                    <option value="" <?= $r->LVL_ORAL_EN == '' ? 'selected' : '' ?>></option>
                                    <option value="A" <?= $r->LVL_ORAL_EN == 'A' ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= $r->LVL_ORAL_EN == 'B' ? 'selected' : '' ?>>B</option>
                                    <option value="C" <?= $r->LVL_ORAL_EN == 'C' ? 'selected' : '' ?>>C</option>
                                    <option value="D" <?= $r->LVL_ORAL_EN == 'D' ? 'selected' : '' ?>>D</option>
                                    <option value="N/A" <?= $r->LVL_ORAL_EN == 'N/A' ? 'selected' : '' ?>>N/A</option>
                                </select>
                            </div>
                            <label for="input_test_en1" class="col-lg-2 control-label">Test ANG 1</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" 
                                       name="input_test_en1" id="input_test_en1"
                                       placeholder="Test AN 1"
                                       value="<?= isset($r->LVL_TEST1_EN) && $r->LVL_TEST1_EN != 0 ? $r->LVL_TEST1_EN : '' ?>"/>
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
                                        <option value="<?php echo $r_zone->id; ?>" <?= $r->SECTEUR_ACTUEL == $r_zone->id ? 'selected' : '' ?>>
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
                                        <option value="<?php echo $r_zone->id; ?>" <?= $r->SECTEUR_RECH == $r_zone->id ? 'selected' : '' ?>>
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
                                    <option value="" <?= $r->CONTRAT1_RECH == '' ? 'selected' : '' ?>></option>
                                    <option value="CDI" <?= $r->CONTRAT1_RECH == 'CDI' ? 'selected' : '' ?>>CDI</option>
                                    <option value="CDD" <?= $r->CONTRAT1_RECH == 'CDD' ? 'selected' : '' ?>>CDD</option>
                                    <option value="Libéral" <?= $r->CONTRAT1_RECH == 'Libéral' ? 'selected' : '' ?>>Libéral</option>
                                </select>
                            </div>
                            <label for="input_contrat_2" class="col-lg-2 control-label">Contrat rech. 2</label>
                            <div class="col-lg-4">
                                <select class="form-control" 
                                        name="input_contrat_2" id="input_contrat_2">
                                    <option value="" <?= $r->CONTRAT2_RECH == '' ? 'selected' : '' ?>></option>
                                    <option value="CDI" <?= $r->CONTRAT2_RECH == 'CDI' ? 'selected' : '' ?>>CDI</option>
                                    <option value="CDD" <?= $r->CONTRAT2_RECH == 'CDD' ? 'selected' : '' ?>>CDD</option>
                                    <option value="Libéral" <?= $r->CONTRAT2_RECH == 'Libéral' ? 'selected' : '' ?>>Libéral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_salaire_actuel" class="col-lg-2 control-label">Salaire actuel</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" 
                                       name="input_salaire_actuel" id="input_salaire_actuel" 
                                       placeholder="Salaire actuel"
                                       value="<?= isset($r->SALAIRE_ACTUEL) ? $r->SALAIRE_ACTUEL : '' ?>">
                            </div>
                            <label for="input_salaire_rech" class="col-lg-2 control-label">Salaire recherché</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" 
                                       name="input_salaire_rech" id="input_salaire_rech" 
                                       placeholder="Salaire mini."
                                       value="<?= isset($r->SAL_MIN_RECH) ? $r->SAL_MIN_RECH : '' ?>">
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
                                    <option value="" <?= $r->LANGUE == '' ? 'selected' : '' ?>></option>
                                    <option value="LMA" <?= $r->LANGUE == 'LMA' ? 'selected' : '' ?>>LMA</option>
                                    <option value="LMF" <?= $r->LANGUE == 'LMF' ? 'selected' : '' ?>>LMF</option>
                                    <option value="LMF-LMA" <?= $r->LANGUE == 'LMF-LMA' ? 'selected' : '' ?>>LMF-LMA</option>
                                    <option value="LM Allemande" <?= $r->LANGUE == 'LM Allemande' ? 'selected' : '' ?>>LM Allemande</option>
                                    <option value="LM Espagnole" <?= $r->LANGUE == 'LM Espagnole' ? 'selected' : '' ?>>LM Espagnole</option>
                                    <option value="LM Italienne" <?= $r->LANGUE == 'LM Italienne' ? 'selected' : '' ?>>LM Italienne</option>
                                    <option value="Autre" <?= $r->LANGUE == 'Autre' ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>
                            <label for="input_l2" class="col-lg-2 control-label">Langue 2</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_l2" id="input_l2">
                                    <option value="" <?= $r->LANGUE2 == '' ? 'selected' : '' ?>></option>
                                    <option value="LMA" <?= $r->LANGUE2 == 'LMA' ? 'selected' : '' ?>>LMA</option>
                                    <option value="LMF" <?= $r->LANGUE2 == 'LMF' ? 'selected' : '' ?>>LMF</option>
                                    <option value="LMF-LMA" <?= $r->LANGUE2 == 'LMF-LMA' ? 'selected' : '' ?>>LMF-LMA</option>
                                    <option value="LM Allemande" <?= $r->LANGUE2 == 'LM Allemande' ? 'selected' : '' ?>>LM Allemande</option>
                                    <option value="LM Espagnole" <?= $r->LANGUE2 == 'LM Espagnole' ? 'selected' : '' ?>>LM Espagnole</option>
                                    <option value="LM Italienne" <?= $r->LANGUE2 == 'LM Italienne' ? 'selected' : '' ?>>LM Italienne</option>
                                    <option value="Autre" <?= $r->LANGUE2 == 'Autre' ? 'selected' : '' ?>>Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_test_fr2" class="col-lg-2 control-label">Test FR 2</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" 
                                       name="input_test_fr2" id="input_test_fr2"
                                       placeholder="Test FR 2"
                                       value="<?= isset($r->LVL_TEST2_FR) && $r->LVL_TEST2_FR != 0 ? $r->LVL_TEST2_FR : '' ?>"/>
                            </div>
                            <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" 
                                       name="input_speed" id="input_speed"
                                       placeholder="Vitesse"
                                       value="<?= isset($r->VITESSE) && $r->VITESSE != 0 ? $r->VITESSE : '' ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_test_en2" class="col-lg-2 control-label">Test ANG 2</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" 
                                       name="input_test_en2" id="input_test_en2"
                                       placeholder="Test AN 2"
                                       value="<?= isset($r->LVL_TEST2_EN) && $r->LVL_TEST2_EN != 0 ? $r->LVL_TEST2_EN : '' ?>"/>
                            </div>
                            <label for="input_appli1" class="col-lg-2 control-label">Autre appli.</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text"
                                       name="input_appli1" id="input_appli1"
                                       placeholder="Autre application"
                                       value="<?= isset($r->AUTRE_APPLI1) ? $r->AUTRE_APPLI1 : '' ?>"/>
                            </div>
                        </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="spec[]" class="col-lg-2 control-label">Spécialités</label>
                        <div class="col-lg-4">
                            <?php $specs = getAllSpec($db); ?>
                            <select class="form-control" 
                                    name="spec[]" id="spec" multiple="multiple" size="8">
                                        <?php
                                        while ($spec = $specs->fetch(PDO::FETCH_OBJ)) {
                                            ?>
                                    <option value="<?php echo $spec->id; ?>"
                                    <?php
                                    $test_specs = getAllSpecByEval($db, $r->ID);
                                    while ($test_spec = $test_specs->fetch(PDO::FETCH_OBJ)) {
                                        if ($test_spec->id == $spec->id)
                                            echo 'selected';
                                    }
                                    ?>>
                                                <?= $spec->libelle; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <label for="input_serment" class="col-lg-2 control-label">Date de Serment</label>
                        <div class="col-lg-2">
                            <input type="date" class="form-control" 
                                   name="input_serment" 
                                   id="input_serment" 
                                   value="<?= $r->DATE_SERMENT != '0000-00-00' ? $r->DATE_SERMENT : '' ?>">
                        </div>
                        <label class="col-lg-2 control-label">
                            <?php
                            if ($r->DATE_SERMENT && $r->DATE_SERMENT != '0000-00-00') {
                                $am = explode('/', date('d/m/Y', strtotime($r->DATE_SERMENT)));
                                $an = explode('/', date('d/m/Y'));

                                if (($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
                                    echo $an[2] - $am[2];
                                else
                                    echo $an[2] - $am[2] - 1;
                                ?>
                                an(s)
                            <?php } ?>
                        </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="input_preavis" class="col-lg-2 control-label">Préavis</label>
                        <div class="col-lg-4">
                            <select class="form-control" 
                                    name="input_preavis" id="input_preavis">
                                <option value="" <?= $r->PREAVIS == '' ? 'selected' : '' ?>></option>
                                <option value="Aucun" <?= $r->PREAVIS == 'Aucun' ? 'selected' : '' ?>>Aucun</option>
                                <option value="1 mois" <?= $r->PREAVIS == '1 mois' ? 'selected' : '' ?>>1 mois</option>
                                <option value="2 mois" <?= $r->PREAVIS == '2 mois' ? 'selected' : '' ?>>2 mois</option>
                                <option value="3 mois" <?= $r->PREAVIS == '3 mois' ? 'selected' : '' ?>>3 mois</option>
                                <option value="> 3 mois" <?= $r->PREAVIS == '> 3 mois' ? 'selected' : '' ?>>> 3 mois</option>
                            </select>
                        </div>
                        <label for="input_note_gen" class="col-lg-2 control-label">Note générale</label>
                        <div class="col-lg-4">
                            <select class="form-control" 
                                    name="input_note_gen" id="input_note_gen">
                                <option value="" <?= $r->NOTE == '' ? 'selected' : '' ?>></option>
                                <option value="A" <?= $r->NOTE == 'A' ? 'selected' : '' ?>>A</option>
                                <option value="B" <?= $r->NOTE == 'B' ? 'selected' : '' ?>>B</option>
                                <option value="C" <?= $r->NOTE == 'C' ? 'selected' : '' ?>>C</option>
                                <option value="D" <?= $r->NOTE == 'D' ? 'selected' : '' ?>>D</option>
                            </select>
                        </div>
                    </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="input_horaires_1" class="col-lg-2 control-label">Horaires rech. 1</label>
                        <div class="col-lg-4">
                            <select class="form-control" 
                                    name="input_horaires_1" id="input_horaires_1">
                                <option value="" <?= $r->HORAIRES1_RECH == '' ? 'selected' : '' ?>></option>
                                <option value="matinée" <?= $r->HORAIRES1_RECH == 'matinée' ? 'selected' : '' ?>>Matinée</option>
                                <option value="jour" <?= $r->HORAIRES1_RECH == 'jour' ? 'selected' : '' ?>>Jour</option>
                                <option value="après-midi" <?= $r->HORAIRES1_RECH == 'après-midi' ? 'selected' : '' ?>>Après-midi</option>
                                <option value="soirée" <?= $r->HORAIRES1_RECH == 'soirée' ? 'selected' : '' ?>>Soirée</option>
                                <option value="nuit" <?= $r->HORAIRES1_RECH == 'nuit' ? 'selected' : '' ?>>Nuit</option>
                            </select>
                        </div>
                        <label for="input_horaires_2" class="col-lg-2 control-label">Horaires rech. 2</label>
                        <div class="col-lg-4">
                            <select class="form-control" 
                                    name="input_horaires_2" id="input_horaires_2">
                                <option value="" <?= $r->HORAIRES2_RECH == '' ? 'selected' : '' ?>></option>
                                <option value="matinée" <?= $r->HORAIRES2_RECH == 'matinée' ? 'selected' : '' ?>>Matinée</option>
                                <option value="jour" <?= $r->HORAIRES2_RECH == 'jour' ? 'selected' : '' ?>>Jour</option>
                                <option value="après-midi" <?= $r->HORAIRES2_RECH == 'après-midi' ? 'selected' : '' ?>>Après-midi</option>
                                <option value="soirée" <?= $r->HORAIRES2_RECH == 'soirée' ? 'selected' : '' ?>>Soirée</option>
                                <option value="nuit" <?= $r->HORAIRES2_RECH == 'nuit' ? 'selected' : '' ?>>Nuit</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_remarque" class="col-lg-1 control-label">Remarque</label>
                            <div class="col-lg-11">
                                <textarea class="form-control" rows="16" name="input_remarque" id="input_remarque"><?= isset($r->REMARQUE) ? $r->REMARQUE : '' ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <a href="upd_applicant.php?id=<?= $r->CANDIDAT ?>"><button type="button" class="btn btn-primary">Fiche Candidat</button></a>
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
        $("#spec").select2();
    });
</script>
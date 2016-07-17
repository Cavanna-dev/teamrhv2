<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container-fluid">
    <h1>Nouvelle Evaluation</h1>
    <form class="form-horizontal" method="POST" action="../functions/new_eval.php" id="form_eval"  enctype="multipart/form-data">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-10" style="min-height: 250px;">
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
                <div class="col-lg-2">
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
                </div>
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
                                    name="spec[]" id="spec" multiple="multiple" size="8">
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
                        <label for="input_serment" class="col-lg-2 control-label">Date de Serment</label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control" 
                                   name="input_serment" 
                                   id="input_serment">
                        </div>
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
                <div class="col-lg-6">
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
<script type="text/javascript">
    $(document).ready(function () {
        $("#spec").select2();
    });
</script>
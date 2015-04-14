<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion Evaluation</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="evaluation.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
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
                                    <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                                    <div class="col-lg-6">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone" id="input_zone">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>" <?php if (isset($_GET['input_zone']) && $_GET['input_zone'] == $r_zone->id) echo "selected"; ?>><?php echo $r_zone->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title" class="col-lg-2 control-label">Titre actuel</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title" id="input_title">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>" <?php if (isset($_GET['input_title']) && $_GET['input_title'] == $r_title->id) echo "selected"; ?>><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_salaire_mini" class="col-lg-3 control-label">Salaire mini.</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_mini" id="input_salaire_mini" 
                                               placeholder="Salaire mini."
                                               value="<?= $_GET['input_salaire_mini'] ? $_GET['input_salaire_mini'] : "" ?>">
                                    </div>
                                    <label for="input_salaire_maxi" class="col-lg-3 control-label">Salaire maxi.</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_maxi" id="input_salaire_maxi" 
                                               placeholder="Salaire mini."
                                               value="<?= $_GET['input_salaire_maxi'] ? $_GET['input_salaire_maxi'] : "" ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title_futur" class="col-lg-2 control-label">Titre recherché</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur" id="input_title_futur">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>" <?php if (isset($_GET['input_title_futur']) && $_GET['input_title_futur'] == $r_title->id) echo "selected"; ?>><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
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
                                        <textarea class="form-control" rows="6" name="input_remarque" id="input_remarque"><?= $_GET['input_remarque'] ?></textarea>
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
            if (!empty($_GET)) {
                $r_evals = searchEval($db);
                if ($r_evals->fetch(PDO::FETCH_OBJ)) {
                    ?>

                    <h1>Résultats</h1>
                    <div class="jumbotron">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">Eval.</th>
                                    <th class="col-lg-2">NOM Prénom</th>
                                    <th class="col-lg-2">Secteur</th>
                                    <th class="col-lg-3">Titre actuel</th>
                                    <th class="col-lg-3">Titre recherché</th>
                                    <th class="col-lg-1">Salaire actuel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($r_eval = $r_evals->fetch(PDO::FETCH_OBJ)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="upd_evaluation.php?id=<?= $r_eval->id; ?>">
                                                <?= $r_eval->id; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="upd_applicant.php?id=<?= $r_eval->candidat; ?>">
                                                <?php $r_applicant = getOneApplicantById($db, $r_eval->candidat); ?>
                                                <?= $r_applicant->nom . " " . $r_applicant->prenom; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $r_zone = getOneZoneById($db, $r_eval->secteur_actuel); ?>
                                            <?= $r_zone->libelle ? $r_zone->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?php $r_zone = getOneTitleById($db, $r_eval->titre1_actuel); ?>
                                            <?= $r_zone->libelle ? $r_zone->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?php $r_zone = getOneTitleById($db, $r_eval->titre1_rech); ?>
                                            <?= $r_zone->libelle ? $r_zone->libelle : ''; ?>
                                        </td>
                                        <td>
                                            <?= $r_eval->salaire_actuel ? $r_eval->salaire_actuel : ''; ?>
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
        <div class="tab-pane fade" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_eval.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_disponible" class="col-lg-2 control-label">Disponible</label>
                                    <div class="col-lg-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_disponible" id="input_disponible1" value="Y" checked="">
                                                Oui
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_disponible" id="input_disponible2" value="N" checked="">
                                                Non
                                            </label>
                                        </div>
                                    </div>
                                    <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                                    <div class="col-lg-4">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone" id="input_zone">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>"><?php echo $r_zone->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title1" class="col-lg-2 control-label">Titre actuel 1</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title1" id="input_title1">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title2" class="col-lg-2 control-label">Titre actuel 2</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title2" id="input_title2">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title3" class="col-lg-2 control-label">Titre actuel 3</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title3" id="input_title3">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
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
                                    <label for="input_diplome" class="col-lg-2 control-label">Diplôme</label>
                                    <div class="col-lg-4">
                                        <?php $r_diplomes = getAllDiplomes($db); ?>
                                        <select class="form-control" name="input_title" id="input_title">
                                            <option value=""></option>
                                            <?php
                                            while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_diplome->id ?>"><?= $r_diplome->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_oral_fr" class="col-lg-2 control-label">Test Oral FR</label>
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_test_fr1" id="input_test_fr1"
                                               placeholder="Test FR 1"/>
                                    </div>
                                    <label for="input_test_fr2" class="col-lg-2 control-label">Test FR 2</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_test_fr2" id="input_test_fr2"
                                               placeholder="Test FR 2"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_type" class="col-lg-2 control-label">Type</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="text"
                                               name="input_type" id="input_type"
                                               />
                                    </div>
                                    <label for="input_note" class="col-lg-2 control-label">Note</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_note" id="input_note"
                                               placeholder="Note"/>
                                    </div>
                                    <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_speed" id="input_speed"
                                               placeholder="Vitesse"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_appli1" class="col-lg-2 control-label">Autre appli. 1</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text"
                                               name="input_appli1" id="input_appli1"
                                               placeholder="Autre application 1"/>
                                    </div>
                                    <label for="input_appli2" class="col-lg-2 control-label">Autre appli. 2</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_appli2" id="input_appli2"
                                               placeholder="Autre application 2"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_zone_rech" class="col-lg-2 control-label">Secteur rech.</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text"
                                               name="input_zone_rech" id="input_zone_rech"
                                               placeholder="Secteur recherché"/>
                                    </div>
                                    <label for="input_soc_rech" class="col-lg-2 control-label">Société rech.</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" type="text" 
                                               name="input_soc_rech" id="input_soc_rech"
                                               placeholder="Société recherchée"/>
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
                                    <label for="input_salaire_actuel" class="col-lg-3 control-label">Salaire actuel</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_actuel" id="input_salaire_actuel" 
                                               placeholder="Salaire actuel">
                                    </div>
                                    <label for="input_salaire_rech" class="col-lg-3 control-label">Salaire recherché</label>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" 
                                               name="input_salaire_rech" id="input_salaire_rech" 
                                               placeholder="Salaire mini.">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title_futur1" class="col-lg-2 control-label">Titre rech. 1</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur1" id="input_title_futur1">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title_futur2" class="col-lg-2 control-label">Titre rech. 2</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur2" id="input_title_futur2">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title_futur3" class="col-lg-2 control-label">Titre rech. 3</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title_futur3" id="input_title_futur3">
                                            <option value=""></option>
                                            <?php
                                            while ($r_title = $r_titles->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_title->id ?>"><?= $r_title->libelle ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_l1" class="col-lg-2 control-label">Langue 1</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_l1" id="input_l1">
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
                                    <label for="input_oral_en" class="col-lg-2 control-label">Test Oral AN</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" name="input_oral_en" id="input_oral_en">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <label for="input_test_en1" class="col-lg-2 control-label">Test AN 1</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_test_en1" id="input_test_en1"
                                               placeholder="Test FR 1"/>
                                    </div>
                                    <label for="input_test_en2" class="col-lg-2 control-label">Test AN 2</label>
                                    <div class="col-lg-2">
                                        <input class="form-control" type="number" 
                                               name="input_test_en2" id="input_test_en2"
                                               placeholder="Test FR 2"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_word" class="col-lg-2 control-label">Word</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" 
                                                name="input_word" id="input_word">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <label for="input_excel" class="col-lg-2 control-label">Excel</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" 
                                                name="input_excel" id="input_excel">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <label for="input_pp" class="col-lg-2 control-label">PowerPoint</label>
                                    <div class="col-lg-2">
                                        <select class="form-control" 
                                                name="input_pp" id="input_pp">
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_mob" class="col-lg-2 control-label">Mobilité</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" 
                                               name="input_mob" id="input_mob"
                                               placeholder="Mobilité"/>
                                    </div>
                                    <label for="input_soc" class="col-lg-2 control-label">Société actuelle</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" 
                                               name="input_soc" id="input_soc"
                                               placeholder="Société actuelle"/>
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
                                        </select>
                                    </div>
                                    <label for="input_contrat_2" class="col-lg-2 control-label">Contrat rech. 2</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" 
                                                name="input_contrat_2" id="input_contrat_2">
                                            <option value=""></option>
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
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
                                        <textarea class="form-control" rows="6" name="input_remarque" id="input_remarque"><?php if (isset($_GET['input_remarque'])) echo $_GET['input_remarque']; ?></textarea>
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
        </div>
    </div>
</div>
</div>

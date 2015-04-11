<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="GET" action="evaluation.php" id="form_customer">
        <h1>Recherche Evaluation</h1>
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
                                <input type="text" class="form-control" name="input_salaire_mini" id="input_salaire_mini" placeholder="Salaire mini.">
                            </div>
                            <label for="input_salaire_maxi" class="col-lg-3 control-label">Salaire maxi.</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="input_salaire_maxi" id="input_salaire_maxi" placeholder="Salaire mini.">
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
    <h1>Résultats</h1>
    <?php
    if (!empty($_GET)) {
        $r_evals = searchEval($db);
        if ($r_evals) {
            ?>

            <div class="jumbotron">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th class="col-lg-1">Eval.</th>
                            <th class="col-lg-2">NOM Prénom</th>
                            <th>Secteur</th>
                            <th>Titre actuel</th>
                            <th>Titre recherché</th>
                            <th>Salaire demandé</th>
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
                <h4>Attention!</h4>
                <p>Aucun résultats</p>
            </div>
        <?php } ?>
    <?php } ?>
</div>

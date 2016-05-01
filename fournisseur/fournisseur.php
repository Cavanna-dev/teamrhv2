<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion Fournisseur</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="fournisseur.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-3 control-label">Nom</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_name" 
                                               name="input_name" placeholder="Nom" type="text" 
                                               value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_remarque" class="col-lg-3 control-label">Remarque</label>
                                    <div class="col-lg-9">
                                        <textarea class="form-control" id="input_remarque" 
                                                  name="input_remarque"
                                                  ><?= isset($_GET['input_remarque']) ? $_GET['input_remarque'] : ""; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_zone" class="col-lg-3 control-label">Secteur</label>
                                    <div class="col-lg-9">
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
                            </fieldset>
                        </div>
                    </div>
                </div>

                <?php
                if (!empty($_GET)) {
                    $r_fourns = searchFourn($db);
                    $result_search = $r_fourns->fetchAll(PDO::FETCH_OBJ);
                    if ($result_search) {
                        ?>

                        <h1>Résultats - <?= count($result_search) ?></h1>
                        <div class="jumbotron">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Secteur</th>
                                        <th>URL</th>
                                        <th>Remarque</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($result_search as $r_fourn) {
                                        ?>
                                        <tr>
                                            <td><a href="upd_fournisseur.php?id=<?= $r_fourn->id; ?>"><?= $r_fourn->nom; ?></a></td>
                                            <td>
                                                <?php
                                                $r_zone = getOneZoneById($db, $r_fourn->secteur);
                                                if (!empty($r_zone))
                                                    echo $r_zone->libelle;
                                                ?>
                                            </td>
                                            <td>
                                                <?= $r_fourn->url ?>
                                            </td>
                                            <td>
                                                <?= $r_fourn->remarque ?>
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
            </form>
        </div>
        <div class="tab-pane fade" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_fournisseur.php" id="form_new_fourn">
                <div class="jumbotron">
                    <div class="form-group">
                        <label for="input_remarque" class="col-lg-2 control-label">Remarque</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="input_remarque" name="input_remarque" placeholder="Remarque" type="text" rows="15"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-3 control-label"><b>Dénomination</b></label>
                                    <div class="col-lg-9">
                                        <b><input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text"></b>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_addr" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_addr" name="input_addr" placeholder="Adresse" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_town" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_town" name="input_town" placeholder="Ville" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_tel" class="col-lg-2 control-label">Tél.</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_tel" name="input_tel" placeholder="Téléphone" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_url" class="col-lg-2 control-label">URL</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_url" name="input_url" placeholder="URL" type="url">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                                    <div class="col-lg-10">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone" id="input_zone">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>" ><?php echo $r_zone->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_postal" class="col-lg-2 control-label">Code Postal</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_postal" name="input_postal" placeholder="Code Postal" type="text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_country" class="col-lg-2 control-label">Pays</label>
                                    <div class="col-lg-10">
                                        <?php $r_countries = getAllCountries($db); ?>
                                        <select class="form-control" name="input_country" id="input_country">
                                            <option value=""></option>
                                            <?php
                                            while ($r_country = $r_countries->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_country->id; ?>" ><?= $r_country->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_metro" class="col-lg-2 control-label">Accès</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_metro" name="input_metro" placeholder="Metro" type="text">
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


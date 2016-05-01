<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$fourn = getOneFournById($db, $_GET['id']);
//var_dump($fourn);
//die;
?>

<div class="container">
    <h1>Gestion Fournisseur</h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_fournisseur.php" id="form_rdv">
        <input type="hidden" class="form-control" name="input_id" id="input_id" value="<?= $fourn->id ?>">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-3 control-label"><b>Dénomination</b></label>
                            <div class="col-lg-9">
                                <b><input class="form-control" id="input_name" 
                                          name="input_name" placeholder="Nom" type="text"
                                          value="<?= isset($fourn->nom) ? $fourn->nom : '' ?>"></b>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_addr" class="col-lg-2 control-label">Adresse</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_addr" 
                                       name="input_addr" placeholder="Adresse" type="text"
                                       value="<?= isset($fourn->adresse1) ? $fourn->adresse1 : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_town" class="col-lg-2 control-label">Ville</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_town" 
                                       name="input_town" placeholder="Ville" type="text"
                                       value="<?= isset($fourn->ville) ? $fourn->ville : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_tel" class="col-lg-2 control-label">Tél.</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_tel" 
                                       name="input_tel" placeholder="Téléphone" type="text"
                                       value="<?= isset($fourn->tel_std) ? $fourn->tel_std : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_url" class="col-lg-2 control-label">URL</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_url" 
                                       name="input_url" placeholder="URL" type="url"
                                       value="<?= isset($fourn->url) ? $fourn->url : '' ?>">
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
                                        <option value="<?php echo $r_zone->id; ?>" <?php if ($fourn->secteur == $r_zone->id) echo 'selected' ?> ><?php echo $r_zone->libelle; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_postal" class="col-lg-2 control-label">Code Postal</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_postal" 
                                       name="input_postal" placeholder="Code Postal" type="text"
                                       value="<?= isset($fourn->postal) ? $fourn->postal : '' ?>"/>
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
                                        <option value="<?php echo $r_country->id; ?>" <?php if ($fourn->country_fk == $r_country->id) echo 'selected' ?>><?= $r_country->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_metro" class="col-lg-2 control-label">Accès</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_metro" 
                                       name="input_metro" placeholder="Metro" type="text"
                                       value="<?= isset($fourn->metro) ? $fourn->metro : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_remarque" class="col-lg-2 control-label">Remarque</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="input_remarque" 
                                          name="input_remarque"
                                          ><?= isset($fourn->remarque) ? $fourn->remarque : '' ?></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
</body>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
?>

<?php
if ($_POST) {
    var_dump($_POST);
    die;
}
?>

<?php
$customer_r = $db->prepare("SELECT nom, secteur, adresse1, ville, postal, "
        . "country_fk, nationalite, tel_std, fax, url, metro, remarque, "
        . "mngt_law, mngt_supp, status_fk, raison_factu, nom_factu, prenom_factu, "
        . "titre_factu, adr1_factu, ville_factu, postal_factu, pays_factu, country_factu_fk, email_factu "
        . "FROM client "
        . "WHERE id=" . $_GET['id']);
$customer_r->execute();
$r = $customer_r->fetch(PDO::FETCH_OBJ);

?>


<div class="container">
    <form class="form-horizontal" method="POST" action="upd_client.php" id="form_upd_customer">
        <h1>Modification d'un client</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputName" class="col-lg-2 control-label">Dénomination</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputName" name="inputName" placeholder="Nom" type="text" value="<?= $r->nom; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddr" class="col-lg-2 control-label">Adresse</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputAddr" name="inputAddr" placeholder="Adresse" type="text" value="<?= $r->adresse1; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTown" class="col-lg-2 control-label">Ville</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputTown" name="inputTown" placeholder="Ville" type="text" value="<?= $r->ville; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputTel" class="col-lg-2 control-label">Téléphone</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputTel" name="inputTel" placeholder="Téléphone" type="number" value="<?= $r->tel_std; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputFax" class="col-lg-2 control-label">Fax</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputFax" name="inputFax" placeholder="Fax" type="number" value="<?= $r->fax; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputUrl" class="col-lg-2 control-label">URL</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputUrl" name="inputUrl" placeholder="URL" type="text" value="<?= $r->url; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMetro" class="col-lg-2 control-label">Metro</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputMetro" name="inputMetro" placeholder="Metro" type="text" value="<?= $r->metro; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContactSupp" class="col-lg-2 control-label">Responsable Support</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllUsers.php' ?>
                                <select class="form-control" name="inputContactSupp" id="inputContactSupp">
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $users_r->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $r->mngt_supp) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputRemarque" class="col-lg-2 control-label">Remarque</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="inputRemarque" name="inputRemarque" placeholder="Remarque" type="text" rows="25"><?= $r->remarque; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCountry" class="col-lg-2 control-label">Pays</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllCountries.php' ?>
                                <select class="form-control" name="inputCountry" id="inputCountry">
                                    <option value=""></option>
                                    <?php
                                    while ($r_country = $countries_r->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_country->id; ?>" <?php if ($r_country->id == 70) echo "selected"; ?>><?php echo $r_country->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputZone" class="col-lg-2 control-label">Secteur</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllZones.php' ?>
                                <select class="form-control" name="inputZone" id="inputZone">
                                    <option value=""></option>
                                    <?php
                                    while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_zone->id; ?>" <?php if ($r_zone->id == $r->secteur) echo "selected"; ?>><?php echo $r_zone->libelle; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPostal" class="col-lg-2 control-label">Code Postal</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputPostal" name="inputPostal" placeholder="Code Postal" type="text" value="<?= $r->postal; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputNation" class="col-lg-2 control-label">Nationalité</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputNation" name="inputNation" placeholder="Nationalité" type="text" value="<?= $r->nationalite; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus" class="col-lg-2 control-label">Status</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllStatus.php' ?>
                                <select class="form-control" name="inputStatus" id="inputStatus">
                                    <option value=""></option>
                                    <?php
                                    while ($r_statu = $r_status->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_statu->id; ?>" <?php if ($r_statu->id == $r->status_fk) echo "selected"; ?>><?= $r_statu->status ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContactLaw" class="col-lg-2 control-label">Responsable Avocat</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllUsers.php' ?>
                                <select class="form-control" name="inputContactLaw" id="inputContactLaw">
                                    <option value=""></option>
                                    <?php 
                                    while ($r_user = $users_r->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $r->mngt_law) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
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
    </form>
</div>
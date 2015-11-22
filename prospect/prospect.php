<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion Prospect</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="prospect.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-3 control-label">Nom</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact_law" class="col-lg-3 control-label">Resp. Avocat</label>
                                    <div class="col-lg-9">
                                        <?php $r_users = getAllImportantUsers($db); ?>
                                        <select class="form-control" name="input_contact_law" id="input_contact_law">
                                            <option value=""></option>
                                            <?php
                                            while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $user_r->id; ?>" <?php if (isset($_GET['input_contact_law']) && $_GET['input_contact_law'] == $user_r->id) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_nation" class="col-lg-3 control-label">Nationalité</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_nation" id="input_nation">
                                            <option value="" <?php if (isset($_GET['input_nation']) && $_GET['input_nation'] == "") echo "selected"; ?>></option>
                                            <option value="Autre" <?php if (isset($_GET['input_nation']) && $_GET['input_nation'] == "Autre") echo "selected"; ?>>Autre</option>
                                            <option value="Américain" <?php if (isset($_GET['input_nation']) && $_GET['input_nation'] == "Américain") echo "selected"; ?>>Américaine</option>
                                            <option value="Britannique" <?php if (isset($_GET['input_nation']) && $_GET['input_nation'] == "Britannique") echo "selected"; ?>>Britannique</option>
                                            <option value="Francais" <?php if (isset($_GET['input_nation']) && $_GET['input_nation'] == "Francais") echo "selected"; ?>>Française</option>
                                        </select>
                                    </div>
                                </div>
                        <div class="form-group">
                            <label for="input_contact_name" class="col-lg-3 control-label">Nom contact client</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_contact_name" name="input_contact_name" 
                                       placeholder="Nom contact" type="text" value="<?= isset($_GET['input_contact_name']) ? $_GET['input_contact_name'] : ""; ?>">
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
                                <div class="form-group">
                                    <label for="input_contact_supp" class="col-lg-3 control-label">Resp. Support</label>
                                    <div class="col-lg-9">
                                        <?php $r_users = getAllImportantUsers($db); ?>
                                        <select class="form-control" name="input_contact_supp" id="input_contact_supp">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_user->id; ?>" <?php if (isset($_GET['input_contact_supp']) && $_GET['input_contact_supp'] == $r_user->id) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_status" class="col-lg-2 control-label">Statut</label>
                                    <div class="col-lg-10">
                                        <?php $r_status = getAllStatus($db); ?>
                                        <select class="form-control" name="input_status" id="input_status">
                                            <option value=""></option>
                                            <?php
                                            while ($r_statu = $r_status->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_statu->id; ?>" <?php if (isset($_GET['input_status']) && $_GET['input_status'] == $r_statu->id) echo 'selected'; ?>><?= $r_statu->status ?></option>
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
                    $r_prospects = searchProspect($db);
                    $result_search = $r_prospects->fetchAll(PDO::FETCH_OBJ);
                    if ($result_search) {
                        ?>

                        <h1>Résultats - <?= count($result_search) ?></h1>
                        <div class="jumbotron">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Secteur</th>
                                        <th>Resp. Avocat</th>
                                        <th>Resp. Support</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($result_search as $r_prospect) {
                                        ?>
                                        <tr>
                                            <td><a href="upd_prospect.php?id=<?= $r_prospect->id; ?>"><?= $r_prospect->nom; ?></a></td>
                                            <td>
                                                <?php
                                                $r_zone = getOneZoneById($db, $r_prospect->secteur);
                                                if (!empty($r_zone))
                                                    echo $r_zone->libelle;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $r_user_law = getUserById($db, $r_prospect->mngt_law);
                                                if (!empty($r_user_law))
                                                    echo $r_user_law->initiale;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $r_user_sup = getUserById($db, $r_prospect->mngt_supp);
                                                if (!empty($r_user_sup))
                                                    echo $r_user_sup->initiale;
                                                ?>
                                            </td>
                                            <td>
                                                <a href="del_prospect.php?id=<?= $r_prospect->id; ?>" onclick="return confirm('Pas disponible pour le moment.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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
            <form class="form-horizontal" method="POST" action="../functions/new_prospect.php" id="form_upd_customer">
                <div class="jumbotron">
                    <div class="form-group">
                        <label for="input_remarque" class="col-lg-2 control-label">Informations Générales</label>
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
                                    <label for="input_status" class="col-lg-2 control-label">Statut</label>
                                    <div class="col-lg-10">
                                        <?php $r_status = getAllStatus($db); ?>
                                        <select class="form-control" name="input_status" id="input_status">
                                            <option value=""></option>
                                            <?php
                                            while ($r_statu = $r_status->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_statu->id; ?>"><?= $r_statu->status ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact_law" class="col-lg-2 control-label">Resp. Avocat</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllImportantUsers($db); ?>
                                        <select class="form-control" name="input_contact_law" id="input_contact_law">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?= $r_user->id; ?>"><?= $r_user->nom . " " . $r_user->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
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
                                    <label for="input_nation" class="col-lg-3 control-label">Nationalité</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_nation" id="input_nation">
                                            <option value="Autre" >Autre</option>
                                            <option value="Américain" >Américaine</option>
                                            <option value="Britannique" >Britannique</option>
                                            <option value="Francais" >Française</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="visibility: hidden;">
                                    <label for="input_nation" class="col-lg-2 control-label"></label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="" name="" placeholder="" type="text" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact_supp" class="col-lg-2 control-label">Resp. Support</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllImportantUsers($db); ?>
                                        <select class="form-control" name="input_contact_supp" id="input_contact_supp">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_user->id; ?>"><?= $r_user->nom . " " . $r_user->prenom; ?></option>
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


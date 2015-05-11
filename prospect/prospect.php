<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="GET" action="prospect.php" id="form_customer">
        <h1>Recherche prospect</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label">Nom</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact_law" class="col-lg-2 control-label">Resp. compte Avocat</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
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
                            <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_nation" id="input_nation">
                                    <option value="" <?php if ($_GET['input_nation'] == "") echo "selected"; ?>></option>
                                    <option value="Autre" <?php if ($_GET['input_nation'] == "Autre") echo "selected"; ?>>Autre</option>
                                    <option value="Anglais" <?php if ($_GET['input_nation'] == "Anglais") echo "selected"; ?>>Anglais</option>
                                    <option value="Américain" <?php if ($_GET['input_nation'] == "Américain") echo "selected"; ?>>Américain</option>
                                    <option value="Britannique" <?php if ($_GET['input_nation'] == "Britannique") echo "selected"; ?>>Britannique</option>
                                    <option value="Francais" <?php if ($_GET['input_nation'] == "Francais") echo "selected"; ?>>Francais</option>
                                </select>
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
                            <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                            <div class="col-lg-10">
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
                            <label for="input_contact_supp" class="col-lg-2 control-label">Resp. compte Support</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
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

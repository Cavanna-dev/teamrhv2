<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="prospect.php" id="form_customer">
        <h1>Recherche prospect</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label">Nom</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_POST['input_name']) ? $_POST['input_name'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact_law" class="col-lg-2 control-label">Responsable du compte Avocat</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_contact_law" id="input_contact_law">
                                    <option value=""></option>
                                    <?php
                                    while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $user_r->id; ?>" <?php if (isset($_POST['input_contact_law']) && $_POST['input_contact_law'] == $user_r->id) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
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
                                        <option value="<?php echo $r_zone->id; ?>" <?php if (isset($_POST['input_zone']) && $_POST['input_zone'] == $r_zone->id) echo "selected"; ?>><?php echo $r_zone->libelle; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact_supp" class="col-lg-2 control-label">Responsable du compte Support</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_contact_supp" id="input_contact_supp">
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if (isset($_POST['input_contact_supp']) && $_POST['input_contact_supp'] == $r_user->id) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
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

        <h1>Résultats</h1>
        <?php
        if ($_POST) {
            $r_prospects = searchProspect($db);
            if ($r_prospects) {
                ?>

                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Secteur</th>
                                <th>Responsable Avocat</th>
                                <th>Responsable Support</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r_prospect = $r_prospects->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td><a href="upd_prospect.php?id=<?= $r_prospect->id; ?>"><?= $r_prospect->nom; ?></a></td>
                                    <td>
                                        <?php
                                        $r_zone = getOneZoneById($db, $r_prospect->secteur);
                                        echo $r_zone->libelle;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $r_user_law = getUserById($db, $r_prospect->mngt_law);
                                        echo $r_user_law->initiale;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $r_user_sup = getUserById($db, $r_prospect->mngt_supp);
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

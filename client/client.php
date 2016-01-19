<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion Client</h1>
    <form class="form-horizontal" method="GET" action="client.php" id="form_customer">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-3 control-label">Dénomination</label>
                            <div class="col-lg-9">
                                <input class="form-control" id="input_name" name="input_name" 
                                       placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
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
                            <div class="col-lg-9">
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
                            <label for="input_statut" class="col-lg-2 control-label">Statut</label>
                            <div class="col-lg-10">
                                <select name="input_statut" id="input_pourvu" class="form-control">
                                    <option value="" <?php if (isset($_GET['input_statut']) && $_GET['input_statut'] == '') echo 'selected'; ?>></option>
                                    <option value="3" <?php if (isset($_GET['input_statut']) && $_GET['input_statut'] == '3') echo 'selected'; ?>>Liquidé</option>
                                    <option value="2" <?php if (isset($_GET['input_statut']) && $_GET['input_statut'] == '2') echo 'selected'; ?>>Actif</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <?php
        if (!empty($_GET)) {
            $r_customers = searchCustomers($db);
            $result_search = $r_customers->fetchAll(PDO::FETCH_OBJ);
            if ($result_search) {
                ?>

                <h1>Résultats - <?= count($result_search) ?> clients</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Dénomination Client</th>
                                <th class="text-right">Secteur</th>
                                <th class="text-right">Resp. Avocat</th>
                                <th class="text-right">Resp. Support</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result_search as $r_customer) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="upd_client.php?id=<?= $r_customer->id; ?>">
                                            <?= $r_customer->nom; ?>
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <?php $r_zone_search = getOneZoneById($db, $r_customer->secteur); ?>
                                        <?php
                                        if (isset($r_zone_search->libelle))
                                            echo $r_zone_search->libelle;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php $r_user_law = getUserById($db, $r_customer->mngt_law); ?>
                                        <?php
                                        if (isset($r_user_law->initiale))
                                            echo $r_user_law->initiale;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php $r_user_supp = getUserById($db, $r_customer->mngt_supp); ?>
                                        <?php
                                        if (isset($r_user_supp->initiale))
                                            echo $r_user_supp->initiale;
                                        ?>
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

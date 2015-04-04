<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="client.php" id="form_customer">
        <h1>Gestion des clients</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label">Dénomination</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_POST['input_name']) ? $_POST['input_name'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact_law" class="col-lg-2 control-label">Responsable Avocat</label>
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
                            <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_nation" id="input_nation">
                                    <option value="Autre" <?php if (isset($_POST['input_nation']) && ($_POST['input_nation'] == "Autre" || $_POST['input_nation'] == "" || $_POST['input_nation'] == NULL)) echo "selected"; ?>>Autre</option>
                                    <option value="Anglais" <?php if (isset($_POST['input_nation']) && $_POST['input_nation'] == "Anglais") echo "selected"; ?>>Anglais</option>
                                    <option value="Américain" <?php if (isset($_POST['input_nation']) && $_POST['input_nation'] == "Américain") echo "selected"; ?>>Américain</option>
                                    <option value="Britannique" <?php if (isset($_POST['input_nation']) && $_POST['input_nation'] == "Britannique") echo "selected"; ?>>Britannique</option>
                                    <option value="Francais" <?php if (isset($_POST['input_nation']) && $_POST['input_nation'] == "Francais") echo "selected"; ?>>Francais</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact_supp" class="col-lg-2 control-label">Responsable Support</label>
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
            $r_customers = searchCustomers($db);
            if ($r_customers) {
                ?>

                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Dénomination Client</th>
                                <th>Secteur</th>
                                <th>Resp. Avocat</th>
                                <th>Resp. Support</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count_r = 1;
                            while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
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
                                        if(isset($r_zone_search->libelle)) 
                                            echo $r_zone_search->libelle; 
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php $r_user_law = getUserById($db, $r_customer->mngt_law); ?>
                                        <?php 
                                        if(isset($r_user_law->initiale)) 
                                            echo $r_user_law->initiale; 
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php $r_user_supp = getUserById($db, $r_customer->mngt_supp); ?>
                                        <?php 
                                        if(isset($r_user_supp->initiale)) 
                                            echo $r_user_supp->initiale; 
                                        ?>
                                    </td>
                                    <td>
                                        <a href="del_client.php?id=<?= $r_customer->id; ?>" onclick="return confirm('Pas disponible pour le moment.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                    </td>
                                </tr>
                                <?php
                                $count_r++;
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

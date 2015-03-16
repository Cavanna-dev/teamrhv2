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
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-default">Annuler</button>
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_country" class="col-lg-2 control-label">Pays</label>
                            <div class="col-lg-10">
                                <?php $r_countries = getAllCountries($db); ?>
                                <select class="form-control" name="input_country" id="input_country">
                                    <option value=""></option>
                                    <?php
                                    while ($r_country = $r_countries->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_country->id; ?>" <?php if ($r_country->id == 70) echo "selected"; ?>><?php echo $r_country->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
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
                    </fieldset>
                </div>
            </div>
        </div>

        <h1>Résultats</h1>
        <?php
        if ($_POST) {
            //include '../functions/getCustomers.php';

            $r_customers = searchCustomers($db);
            if ($r_customers) {
                ?>

                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Dénomination Client</th>
                                <th>Responsable Avocat</th>
                                <th>Responsable Support</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count_r = 1;
                            while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td><?= $count_r ?></td>
                                    <td><?= $r_customer->nom; ?></td>
                                    <td>
                                        <?php $r_users = getAllUsers($db); ?>
                                        <?php
                                        while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                            if ($r_customer->mngt_law == $r_user->id)
                                                echo $r_user->prenom . " " . $r_user->nom;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php $r_users = getAllUsers($db); ?>
                                        <?php
                                        while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                            if ($r_customer->mngt_supp == $r_user->id)
                                                echo $r_user->prenom . " " . $r_user->nom;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="del_client.php?id=<?= $r_customer->id; ?>" onclick="return confirm('omg')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        <a href="upd_client.php?id=<?= $r_customer->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
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

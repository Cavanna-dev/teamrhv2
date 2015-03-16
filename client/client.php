<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="client.php" id="form_customer">
        <h1>Gestion des clients</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputName" class="col-lg-2 control-label">Dénomination</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="inputName" name="inputName" placeholder="Nom" type="text" value="<?= isset($_POST['inputName']) ? $_POST['inputName'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputContactSupp" class="col-lg-2 control-label">Responsable du compte Support</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllUsers.php' ?>
                                <select class="form-control" name="inputContactSupp" id="inputContactSupp">
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $users_r->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if (isset($_POST['inputContactSupp']) && $_POST['inputContactSupp'] == $r_user->id) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
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
                            <label for="inputContactLaw" class="col-lg-2 control-label">Responsable du compte Avocat</label>
                            <div class="col-lg-10">
                                <?php include '../functions/getAllUsers.php' ?>
                                <select class="form-control" name="inputContactLaw" id="inputContactLaw">
                                    <option value=""></option>
                                    <?php
                                    while ($user_r = $users_r->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $user_r->id; ?>" <?php if (isset($_POST['inputContactLaw']) && $_POST['inputContactLaw'] == $user_r->id) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
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
            include '../functions/getCustomers.php';
            if ($customers_r) {
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
                            while ($customer_r = $customers_r->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>1</td>
                                    <td><a href="read_client.php?id=<?= $customer_r->id; ?>"><?= $customer_r->nom; ?></a></td>
                                    <td>
                                        <?php include '../functions/getAllUsers.php'; ?>
                                        <?php
                                        while ($user_r = $users_r->fetch(PDO::FETCH_OBJ)) {
                                            if ($customer_r->mngt_law == $user_r->id)
                                                echo $user_r->prenom . " " . $user_r->nom;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php include '../functions/getAllUsers.php'; ?>
                                        <?php
                                        while ($user_r = $users_r->fetch(PDO::FETCH_OBJ)) {
                                            if ($customer_r->mngt_supp == $user_r->id)
                                                echo $user_r->prenom . " " . $user_r->nom;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="del_client.php?id=<?= $customer_r->id; ?>" onclick="return confirm('omg')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                        <a href="upd_client.php?id=<?= $customer_r->id; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
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

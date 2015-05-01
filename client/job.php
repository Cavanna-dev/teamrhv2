<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="GET" action="job.php" id="form_customer">
        <h1>Gestion des postes</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label">Libellé</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_contact" class="col-lg-2 control-label">Consultant</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_contact" id="input_contact">
                                    <option value=""></option>
                                    <?php
                                    while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $user_r->id; ?>" <?php if (isset($_GET['input_contact']) && $_GET['input_contact'] == $user_r->id) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
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
                            <label for="input_customer" class="col-lg-2 control-label">Client</label>
                            <div class="col-lg-10">
                                <?php $r_customers = getAllCustomers($db); ?>
                                <select class="form-control" name="input_customer" id="input_customer">
                                    <option value=""></option>
                                    <?php
                                    while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_customer->id ?>" <?php if (isset($_GET['input_customer']) && $_GET['input_customer'] == $r_customer->id) echo "selected"; ?>><?= $r_customer->nom ?></option>
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
            $r_jobs = searchJobs($db);
            $result_search = $r_jobs->fetchAll(PDO::FETCH_OBJ);
            if ($result_search) {
                ?>

                <h1>Résultats - <?= count($result_search) ?> postes</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Libelle</th>
                                <th>Client</th>
                                <th>Titre</th>
                                <th>Consultant</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result_search as $r_job) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="upd_job.php?id=<?= $r_job->id; ?>">
                                            <?= $r_job->libelle; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php $r_customer = getOneCustomerById($db, $r_job->client); ?>
                                        <a href="upd_client.php?id=<?= $r_customer->id ?>">
                                            <?php if ($r_customer) echo $r_customer->nom; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php $r_title = getOneTitleById($db, $r_job->titre); ?>
                                        <?php if ($r_title) echo $r_title->libelle; ?>
                                    </td>
                                    <td>
                                        <?php $r_user = getUserById($db, $r_job->consultant); ?>
                                        <?php
                                        if ($r_user)
                                            echo $r_user->initiale;
                                        ?>
                                    </td>
                                    <td>
                                        <a href="del_client.php?id=<?= $r_customer->id; ?>" onclick="return confirm('Pas disponible pour le moment.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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

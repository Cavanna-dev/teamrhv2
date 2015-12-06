<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion Placement</h1>
    <form class="form-horizontal" method="GET" action="placement.php" id="form_placement">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_applicant" class="col-lg-3 control-label">Candidat</label>
                            <div class="col-lg-9">
                                <?php $r_applicants = getAllApplicants($db); ?>
                                <select class="form-control" name="input_applicant" id="input_applicant">
                                    <option value=""></option>
                                    <?php
                                    while ($r_applicant = $r_applicants->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_applicant->id; ?>" <?php if (isset($_GET['input_applicant']) && $_GET['input_applicant'] == $r_applicant->id) echo "selected"; ?>><?= $r_applicant->nom; ?> <?= $r_applicant->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-3 control-label">Client</label>
                            <div class="col-lg-9">
                                <?php $r_custs = getAllCustomers($db); ?>
                                <select class="form-control" name="input_customer" id="input_customer">
                                    <option value=""></option>
                                    <?php
                                    while ($r_cust = $r_custs->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_cust->id; ?>" <?php if (isset($_GET['input_customer']) && $_GET['input_customer'] == $r_cust->id) echo "selected"; ?>><?= $r_cust->nom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_job" class="col-lg-3 control-label">Poste</label>
                            <div class="col-lg-9">
                                <?php $r_jobs = getAllJobs($db); ?>
                                <select class="form-control" name="input_job" id="input_job">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_jobs as $r_job) {
                                        ?>
                                        <option value="<?php echo $r_job->id; ?>" <?php if (isset($_GET['input_job']) && $_GET['input_job'] == $r_job->id) echo "selected"; ?>><?php echo $r_job->libelle; ?></option>
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
            $r_placements = searchPlacements($db);
            $result_search = $r_placements->fetchAll(PDO::FETCH_OBJ);
            if ($result_search) {
                ?>

                <h1>Résultats - <?= count($result_search) ?> placements</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Candidat</th>
                                <th>Poste</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result_search as $r_placement) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="upd_placement.php?id=<?= $r_placement->id; ?>">
                                            <?= $r_placement->id; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php $r_applicant = getOneApplicantById($db, $r_placement->candidat); ?>
                                        <a href="../candidat/upd_applicant.php?id=<?= $r_applicant->id; ?>" 
                                           title="<?= $r_applicant->nom ?> <?= $r_applicant->prenom ?>">
                                            <?= $r_applicant->nom ?> <?= substr($r_applicant->prenom, 0, 1) ?>.
                                        </a>
                                    </td>
                                    <td>
                                        <?php $r_job = getOneJobById($db, $r_placement->poste); ?>
                                        <a href="upd_job.php?id=<?= $r_job->id; ?>">
                                            <?= $r_job->libelle; ?>
                                        </a>
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
                    <p>Aucun résultats</p>
                </div>
            <?php } ?>
        <?php } ?>
    </form>
</div>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="applicant.php" id="form_customer">
        <h1>Recherche candidat</h1>
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
                            <label for="input_first" class="col-lg-2 control-label">Prénom</label>
                            <div class="col-lg-10">
                                <input class="form-control" id="input_first" name="input_first" placeholder="Prénom" type="text" value="<?= isset($_POST['input_first']) ? $_POST['input_first'] : ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Rechercher</button>
                                <a href="add_applicant.php">
                                    <button type="button" class="btn btn-primary">Nouveau Candidat</button>
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                    </fieldset>
                </div>
            </div>
        </div>

        <h1>Résultats</h1>
        <?php
        if ($_POST) {
            $r_applis = searchApplicant($db);
            if ($r_applis) {
                ?>

                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>Nom - Prénom</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($r_appli = $r_applis->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td><a href="upd_applicant.php?id=<?= $r_appli->id; ?>"><?= $r_appli->nom . " " . $r_appli->prenom; ?></a></td>
                                    <td>
                                        <a href="del_applicant.php?id=<?= $r_appli->id; ?>" onclick="return confirm('Pas disponible pour le moment.')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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

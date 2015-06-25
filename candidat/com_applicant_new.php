<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneApplicantById($db, $_GET['id']);
?>

<div class="container">
    <form action="../functions/new_applicant_com.php" method="POST">
        <input type="hidden" name="input_id_applicant" id="input_id" value="<?= $r->id ?>" />
        <div class="row">
            <div class="col-lg-9">
                <h1>Commentaire : <a href="upd_applicant.php?id=<?= $r->id ?> "><?= $r->nom . ' ' . $r->prenom ?></a></h1>
            </div>
            <div class="col-lg-3">
                <h1 class="pull-right"><button type="submit" class="btn btn-primary">Enregistrer commentaire</button></h1>
            </div>
        </div>
        <div class="jumbotron">
            <label for="remarque">Remarque :</label>
            <textarea 
                name="remarque" id="remarque" class="form-control" rows="5"></textarea>
        </div>
    </form>
</div>
</body>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneApplicantComById($db, $_GET['id']);
$r_applicant = getOneApplicantById($db, $r->candidat);
?>

<div class="container">
    <form action="../functions/upd_applicant_com.php" method="POST">
        <input type="hidden" name="input_id" id="input_id" value="<?= $r->id ?>" />
        <input type="hidden" name="input_id_applicant" id="input_id" value="<?= $r_applicant->id ?>" />
        <div class="row">
            <div class="col-lg-9">
                <h1>Commentaire : <a href="upd_applicant.php?id=<?= $r_applicant->id ?> "><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?></a></h1>
            </div>
            <div class="col-lg-3">
                <h1 class="pull-right"><button type="submit" class="btn btn-primary">Enregistrer commentaire</button></h1>
            </div>
        </div>
        <div class="jumbotron">
            <label for="remarque">Remarque :</label>
            <textarea 
                name="remarque" id="remarque" class="form-control" rows="5"><?= $r->remarque ?></textarea>
        </div>
    </form>
</div>
</body>

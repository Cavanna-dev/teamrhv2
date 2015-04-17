<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneCustomerComById($db, $_GET['id']);
$r_customer = getOneCustomerById($db, $r->client);
?>

<div class="container">
    <form action="../functions/upd_customer_com.php" method="POST">
        <input type="hidden" name="input_id" id="input_id" value="<?= $r->id ?>" />
        <input type="hidden" name="input_id_customer" id="input_id" value="<?= $r_customer->id ?>" />
        <div class="row">
            <div class="col-lg-9">
                <h1>Commentaire : <a href="upd_client.php?id=<?= $r_customer->id ?> "><?= $r_customer->nom ?></a></h1>
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

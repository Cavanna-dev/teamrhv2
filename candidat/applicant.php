<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <h1>Gestion candidat</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="applicant.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= isset($_GET['input_name']) ? $_GET['input_name'] : ""; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_first" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_first" name="input_first" placeholder="Prénom" type="text" value="<?= isset($_GET['input_first']) ? $_GET['input_first'] : ""; ?>">
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
                            </fieldset>
                        </div>
                    </div>
                </div>

                <h1>Résultats</h1>
                <?php
                if (!empty($_GET) && !array_key_exists('success', $_GET)) {
                    $r_applis = searchApplicant($db);
                    if ($r_applis->fetch(PDO::FETCH_OBJ)) {
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
                                                <a href="del_applicant.php?id=<?= $r_appli->id; ?>" 
                                                   onclick="return confirm('Pas disponible pour le moment.')">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true">
                                                    </span>
                                                </a>
                                                <?php
                                                if (!empty($r_appli->eval_id)) :
                                                    ?>
                                                    <a href="upd_evaluation.php?id=<?= $r_appli->eval_id; ?>">
                                                        <span class="glyphicon glyphicon-th-list" aria-hidden="true">
                                                        </span>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="evaluation.php?tab=new&id=<?= $r_appli->id; ?>">
                                                        <span class="glyphicon glyphicon-plus" aria-hidden="true">
                                                        </span>
                                                    </a>
                                                <?php endif; ?>
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
                            <h4>Aucun candidat trouvé</h4>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>
        </div>
        <div class="tab-pane fade" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_applicant.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_name" id="input_name" value="" placeholder="Nom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_birthday" class="col-lg-2 control-label">Date de naissance</label>
                                    <div class="col-lg-5">
                                        <input type="date" class="form-control" name="input_birthday" id="input_birthday" value="">
                                    </div>
                                    <label class="col-lg-2 control-label"></label>
                                </div>
                                <div class="form-group">
                                    <label for="input_civil" class="col-lg-2 control-label">Etat civil</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_civil" id="select">
                                            <option value=""></option>
                                            <option value="Marié(e)">Marié(e)</option>
                                            <option value="Célibataire">Célibataire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_address" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_address" id="input_address" value="" placeholder="Adresse">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_postal" class="col-lg-2 control-label">Code postal</label>
                                    <div class="col-lg-10">
                                        <input type="number" class="form-control" name="input_postal" id="input_postal" value="" placeholder="Code postal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_phone_port" class="col-lg-2 control-label">Tél. portable</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_phone_port" id="input_phone_port" value="" placeholder="Tél. portable">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_phone_work" class="col-lg-2 control-label">Tél. bureau</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_phone_work" id="input_phone_work" value="" placeholder="Tél. bureau">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_media" class="col-lg-2 control-label">Media</label>
                                    <div class="col-lg-10">
                                        <?php $r_medias = getAllMedias($db); ?>
                                        <select class="form-control" name="input_media" id="input_media">
                                            <option value=""></option>
                                            <?php
                                            while ($r_media = $r_medias->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_media->id; ?>" ><?php echo $r_media->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_refusal" class="col-lg-2 control-label">Refus</label>
                                    <div class="col-lg-1">
                                        <div class="checkbox">
                                            <label>
                                                <input name="input_refusal" type="checkbox" value="Y"/>
                                            </label>
                                        </div>
                                    </div>
                                    <label for="input_why_refusal" class="col-lg-2 control-label">Motif Refus</label>
                                    <div class="col-lg-7">
                                        <input type="text" class="form-control" name="input_why_refusal" id="input_why_refusal"  value="" placeholder="Motif Refus">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_last" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_last" id="input_last" value="" placeholder="Prénom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_nation" id="input_nation">
                                            <option value=""></option>
                                            <option value="Autre">Autre</option>
                                            <option value="Américain">Américain</option>
                                            <option value="Britannique">Britannique</option>
                                            <option value="Francais">Francais</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sexe</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_sexe" id="optionsRadios1" value="H">
                                                Masculin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="input_sexe" id="optionsRadios2" value="F">
                                                Féminin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_town" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_town" id="input_town" value="" placeholder="Ville">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_country" class="col-lg-2 control-label">Pays</label>
                                    <div class="col-lg-10">
                                        <?php $r_countries = getAllCountries($db); ?>
                                        <select class="form-control" name="input_country" id="input_country">
                                            <option value=""></option>
                                            <?php
                                            while ($r_country = $r_countries->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_country->id; ?>"><?php echo $r_country->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_subway" class="col-lg-2 control-label">Transport</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_subway" id="input_subway" value="" placeholder="Transport">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_email" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_email" id="input_email" value="" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_mail_birthday" class="col-lg-2 control-label">Mail Anniversaire</label>
                                    <div class="col-lg-1">
                                        <div class="checkbox">
                                            <label>
                                                <input name="input_mail_birthday" type="checkbox" value="Y"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (isset($_GET['success'])) { ?>
    <script type="text/javascript">
        $(window).load(function () {
            alert('Candidat ajouté.');
        });
    </script>
<?php }
?>
</body>

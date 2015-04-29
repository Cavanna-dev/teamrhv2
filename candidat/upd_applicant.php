<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneApplicantById($db, $_GET['id']);
?>

<div class="container">
    <form class="form-horizontal" method="POST" action="../functions/upd_applicant.php" id="form_customer">
        <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>" />
        <h1>Fiche Candidat</h1>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_name" class="col-lg-2 control-label">Nom</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_name" id="input_name" value="<?= $r->nom ?>" placeholder="Nom">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_birthday" class="col-lg-2 control-label">Date de naissance</label>
                            <div class="col-lg-5">
                                <input type="date" class="form-control" name="input_birthday" id="input_birthday" value="<?= $r->naissance ?>">
                            </div>
                            <label class="col-lg-2 control-label">
                                <?php
                                if ($r->naissance) {
                                    $am = explode('/', date('d/m/Y', strtotime($r->naissance)));
                                    $an = explode('/', date('d/m/Y'));

                                    if (($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
                                        echo $an[2] - $am[2];
                                    else
                                        echo $an[2] - $am[2] - 1;
                                    ?>
                                    ans
                                <?php } ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="input_civil" class="col-lg-2 control-label">Etat civil</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_civil" id="select">
                                    <option value="" <?php if ($r->statut == "") echo "selected" ?>></option>
                                    <option value="Marié(e)" <?php if ($r->statut == "Marié(e)") echo "selected" ?>>Marié(e)</option>
                                    <option value="Célibataire" <?php if ($r->statut == "Célibataire") echo "selected" ?>>Célibataire</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_address" class="col-lg-2 control-label">Adresse</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_address" id="input_address" value="<?= $r->adresse1 ?>" placeholder="Adresse">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_postal" class="col-lg-2 control-label">Code postal</label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" name="input_postal" id="input_postal" value="<?= $r->postal ?>" placeholder="Code postal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_phone_port" class="col-lg-2 control-label">Tél. portable</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_phone_port" id="input_phone_port" value="<?= $r->tel_port ?>" placeholder="Tél. portable">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_phone_work" class="col-lg-2 control-label">Tél. bureau</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_phone_work" id="input_phone_work" value="<?= $r->tel_bureau ?>" placeholder="Tél. bureau">
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
                                        <option value="<?php echo $r_media->id; ?>" <?php if ($r_media->id == $r->media) echo "selected"; ?>><?php echo $r_media->libelle; ?></option>
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
                                        <input name="input_refusal" type="checkbox" <?php if ($r->refus == "Y") echo 'checked'; ?> value="Y"/>
                                    </label>
                                </div>
                            </div>
                            <label for="input_why_refusal" class="col-lg-2 control-label">Motif Refus</label>
                            <div class="col-lg-7">
                                <input type="text" class="form-control" name="input_why_refusal" id="input_why_refusal"  value="<?= $r->motif ?>" placeholder="Motif Refus">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_last" class="col-lg-2 control-label">Prénom</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_last" id="input_last" value="<?= $r->prenom ?>" placeholder="Prénom">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_nation" id="input_nation" value="<?= $r->nationalite ?>" placeholder="Nationalité">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sexe</label>
                            <div class="col-lg-10">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="input_sexe" id="optionsRadios1" value="H" <?php if ($r->sexe == "H") echo 'checked="checked"'; ?> >
                                        Masculin
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="input_sexe" id="optionsRadios2" value="F" <?php if ($r->sexe == "F") echo 'checked="checked"'; ?>>
                                        Féminin
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_town" class="col-lg-2 control-label">Ville</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_town" id="input_town" value="<?= $r->ville ?>" placeholder="Ville">
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
                                        <option value="<?php echo $r_country->id; ?>" <?php if ($r_country->id == $r->country_fk) echo "selected"; ?>><?php echo $r_country->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_subway" class="col-lg-2 control-label">Transport</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_subway" id="input_subway" value="<?= $r->metro ?>" placeholder="Transport">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_email" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_email" id="input_email" value="<?= $r->email ?>" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_mail_birthday" class="col-lg-2 control-label">Mail Anniversaire</label>
                            <div class="col-lg-1">
                                <div class="checkbox">
                                    <label>
                                        <input name="input_mail_birthday" type="checkbox" <?php if ($r->anniversaire == "Y") echo 'checked'; ?> value="Y"/>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                <a href="upd_evaluation.php?id=<?= $r->eval_id ?>"><button type="button" class="btn btn-primary">Evaluation</button></a>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>

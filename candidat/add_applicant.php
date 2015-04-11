<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

?>

<div class="container">
    <form class="form-horizontal" method="POST" action="../functions/new_applicant.php" id="form_customer">
        <h1>Fiche Candidat</h1>
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
                                    <option value="Marié(e)">Marié</option>
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
                                <input type="text" class="form-control" name="input_nation" id="input_nation" value="" placeholder="Nationalité">
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
                            <label for="input_subway" class="col-lg-2 control-label">Métro</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_subway" id="input_subway" value="" placeholder="Métro">
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

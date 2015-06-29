<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneApplicantById($db, $_GET['id']);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-5">
            <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
            <div class="row">
                <div class="col-lg-9">
                    <h1>Commentaires</h1>
                </div>
                <div class="col-lg-3">
                    <h1 class="pull-right">
                        <a href="com_applicant_new.php?id=<?= $r->id; ?>">
                            <button type="button" class = "btn btn-primary">Ajouter commentaire</button>
                        </a>
                    </h1>
                </div>
            </div>
            <?php
            $coms = getComByApplicant($db, $r->id);

            if (empty($coms)) {
                ?>
                <div class = "alert alert-dismissible alert-warning">
                    <button type = "button" class = "close" data-dismiss = "alert">×</button>
                    <h4>Aucun Commentaire trouvé</h4>
                </div>
                <?php
            } else {
                foreach ($coms as $com) :
                    $linefeed = "\r\n";
                    $remarque = str_replace('"', '\\\'', str_replace($linefeed, '<BR />', str_replace('\'', '\\\'', $com->remarque)));
                    $remarque = str_replace('\\', '', str_replace('\'\'', '\'', str_replace('"', '\'', $remarque)));
                    ?>
                    <div class="jumbotron" style="margin: 2px 0;padding: 10px;">
                        <p style="font-size: 14px;"><?= $remarque . "..."; ?>
                            <a href="com_applicant.php?id=<?= $com->id; ?>">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </p>
                    </div>

                    <?php
                endforeach;
            }
            ?>
            <h1>Envoi CV</h1>
            <div class="jumbotron">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th class="col-lg-4">Type</th>
                            <th class="col-lg-6">Libellé</th>
                            <th class="col-lg-2">Date envoi</th>
                            <th>
                                <a href="../candidat/send_cv.php?candidat=<?= $_GET['id'] ?>" >
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $r_cvs = getCvsSendByApplicant($db, $_GET['id']);
                        //var_dump($r_cvs);die;

                        foreach ($r_cvs as $r_cv) :
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    switch ($r_cv[1]):
                                        case 1:
                                            echo "[Client]";
                                            break;
                                        case 2:
                                            echo "[Poste]";
                                            break;
                                        case 3:
                                            echo "[Prospect]";
                                            break;
                                    endswitch;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    switch ($r_cv[1]):
                                        case 1:
                                            echo '<a href="../client/upd_client.php?id=' . $r_cv['id_client'] . '">' . $r_cv['nom_client'] . '</a>';
                                            break;
                                        case 2:
                                            echo '<a href="../client/upd_client.php?id=' . $r_cv['id_client'] . '">' . $r_cv['nom_client'] . '</a> - ';
                                            echo '<a href="../client/upd_job.php?id=' . $r_cv['id_poste'] . '">' . $r_cv['libelle_poste'] . '</a>';
                                            break;
                                        case 3:
                                            echo '<a href="../prospect/upd_prospect.php?id=' . $r_cv['id_prospect'] . '">' . $r_cv['nom_prospect'] . '</a>';
                                            break;
                                    endswitch;
                                    ?>
                                </td>
                                <td>
                                    <a href="../candidat/upd_send_cv.php?candidat=<?= $_GET['id'] ?>&date_envoi=<?= isset($r_cv['date_ordre']) ? date('Y-m-d', strtotime($r_cv['date_ordre'])) : ''; ?>" >
                                        <?= isset($r_cv['date_envoi']) ? $r_cv['date_envoi'] : 'N/A'; ?>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-7">
            <form class="form-horizontal" method="POST" 
                  action="../functions/upd_applicant.php" 
                  id="form_customer" enctype="multipart/form-data" >
                <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>" />
                <h1>Fiche Candidat</h1>
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Nom*</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_name" id="input_name" 
                                               value="<?= $r->nom ?>" 
                                               placeholder="Nom" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_birthday" class="col-lg-2 control-label">Date de naissance*</label>
                                    <div class="col-lg-5">
                                        <input type="date" class="form-control" 
                                               name="input_birthday" 
                                               id="input_birthday" 
                                               value="<?= $r->naissance ?>" required>
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
                                <div class="form-group">
                                    <label for="input_cv_perso" class="col-lg-2 control-label">CV Perso</label>
                                    <div class="col-lg-9">
                                        <div class="fileinput">
                                            <label>
                                                <input name="input_cv_perso" type="file"/>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <?php 
                                        if($r->cv_perso != ''){
                                        ?>
                                        <a href="file://///srv-teamrh\t\Candidat\CV TeamRH<?= $r->cv_perso ?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_cv_teamrh" class="col-lg-2 control-label">CV TeamRH</label>
                                    <div class="col-lg-9">
                                        <div class="fileinput">
                                            <label>
                                                <input name="input_cv_teamrh" type="file"/>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <?php 
                                        if($r->cv_teamrh != ''){
                                        ?>
                                        <a href="file://///srv-teamrh\t\Candidat\CV TeamRH<?= $r->cv_teamrh ?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_last" class="col-lg-2 control-label">Prénom*</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" 
                                               name="input_last" id="input_last" 
                                               value="<?= $r->prenom ?>" 
                                               placeholder="Prénom" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="input_nation" id="input_nation" value="<?= $r->nationalite ?>" placeholder="Nationalité">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sexe*</label>
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
                                    <label for="input_email" class="col-lg-2 control-label"><a href="mailto:<?= isset($r->email) ? $r->email : '' ?>">Email</a></label>
                                    <div class="col-lg-10">
                                        <input type="email" class="form-control" name="input_email" id="input_email" value="<?= isset($r->email) ? $r->email : '' ?>" placeholder="Email">
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
                                        <?php if ($r->eval_id) { ?>
                                            <a href="upd_evaluation.php?id=<?= $r->eval_id ?>"><button type="button" class="btn btn-primary">Evaluation</button></a>
                                        <?php } else { ?>
                                            <a href="evaluation.php?tab=new&id=<?= $r->id ?>"><button type="button" class="btn btn-primary">Créer Evaluation</button></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
            <h1>RDVs(<6mois)</h1>
            <div class="jumbotron">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th class="col-lg-6">Client</th>
                            <th class="col-lg-2">N° RDV</th>
                            <th class="col-lg-4">Date</th>
                            <th>
                                <a href="../client/new_rdv.php?candidat=<?= $_GET['id'] ?>" >
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $r_rdvs = getRdvsByApplicant($db, $_GET['id']);
                        //var_dump($r_rdvs);die;

                        foreach ($r_rdvs as $r_rdv) :
                            ?>
                            <tr>
                                <td>
                                    <?= isset($r_rdv->societe) ? '<a href="../client/upd_client.php?id=' . $r_rdv->id_client . '">' . $r_rdv->societe . '</a>' : 'N/A'; ?>
                                </td>
                                <td>
                                    <?= isset($r_rdv->numero_rdv) ? $r_rdv->numero_rdv : 'N/A'; ?>
                                </td>
                                <td>
                                    <?= isset($r_rdv->date_rdv) ? date("d/m/Y", strtotime($r_rdv->date_rdv)) : 'N/A'; ?>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
<?php if (isset($_GET['newcom'])) { ?>
        $(window).load(function () {
            alert('Nouveau commentaire ajouté.');
        });
<?php } ?>
<?php if (isset($_GET['comupd'])) { ?>
        $(window).load(function () {
            alert('Commentaire modifié.');
        });
<?php } ?>
</script>

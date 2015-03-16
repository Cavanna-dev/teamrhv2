<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneCustomerbyId($db, $_GET['id']);
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <h1>Envoi de CV (<4mois)</h1>
            <div class="jumbotron">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Consultant</th>
                            <th>Date d'envoi</th>
                            <th>Candidat</th>
                            <th>Poste</th>
                            <th><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $r_send_cvs = getSendCvByCustomer($db, $_GET['id']);
                        $count_cvs = 1;
                        while ($r_send_cv = $r_send_cvs->fetch(PDO::FETCH_OBJ)) {
                            ?>
                            <tr>
                                <td><?= $count_cvs ?></td>
                                <td>
                                    <?php
                                    $consultant = getUserById($db, $r_send_cv->consultant);
                                    $r_consult = $consultant->fetch(PDO::FETCH_OBJ);
                                    echo strtoupper($r_consult->nom) . " " . $r_consult->prenom;
                                    ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($r_send_cv->date_envoi)) ?></td>
                                <td>
                                    <?php
                                    $candidat = getApplicantById($db, $r_send_cv->candidat);
                                    $r_cand = $candidat->fetch(PDO::FETCH_OBJ);
                                    echo $r_cand->nom . " " . $r_cand->prenom;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $job = getJobById($db, $r_send_cv->poste);
                                    $r_job = $job->fetch(PDO::FETCH_OBJ);
                                    echo $r_job->libelle;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $count_cvs++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-8">
            <form class="form-horizontal" method="POST" action="../functions/updCustomer.php" id="form_upd_customer">
                <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
                <h1>Modification d'un client</h1>
                <div class="jumbotron">
                    <div class="form-group">
                        <label for="input_remarque" class="col-lg-1 control-label">Remarque</label>
                        <div class="col-lg-11">
                            <textarea class="form-control" id="input_remarque" name="input_remarque" placeholder="Remarque" type="text" rows="15"><?= $r->remarque; ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label">Dénomination</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= $r->nom; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_addr" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_addr" name="input_addr" placeholder="Adresse" type="text" value="<?= $r->adresse1; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_town" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_town" name="input_town" placeholder="Ville" type="text" value="<?= $r->ville; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_tel" class="col-lg-2 control-label">Téléphone</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_tel" name="input_tel" placeholder="Téléphone" type="text" value="<?= $r->tel_std; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_fax" class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_fax" name="input_fax" placeholder="Fax" type="number" value="<?= $r->fax; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact_supp" class="col-lg-2 control-label">Responsable Support</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllUsers($db); ?>
                                        <select class="form-control" name="input_contact_supp" id="input_contact_supp">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $r->mngt_supp) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_url" class="col-lg-2 control-label">URL</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_url" name="input_url" placeholder="URL" type="text" value="<?= $r->url; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
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
                                    <label for="input_zone" class="col-lg-2 control-label">Secteur</label>
                                    <div class="col-lg-10">
                                        <?php $r_zones = getAllZones($db); ?>
                                        <select class="form-control" name="input_zone" id="input_zone">
                                            <option value=""></option>
                                            <?php
                                            while ($r_zone = $r_zones->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_zone->id; ?>" <?php if ($r_zone->id == $r->secteur) echo "selected"; ?>><?php echo $r_zone->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_postal" class="col-lg-2 control-label">Code Postal</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_postal" name="input_postal" placeholder="Code Postal" type="text" value="<?= $r->postal; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_nation" class="col-lg-2 control-label">Nationalité</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_nation" name="input_nation" placeholder="Nationalité" type="text" value="<?= $r->nationalite; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_status" class="col-lg-2 control-label">Status</label>
                                    <div class="col-lg-10">
                                        <?php $r_status = getAllStatus($db); ?>
                                        <select class="form-control" name="input_status" id="input_status">
                                            <option value=""></option>
                                            <?php
                                            while ($r_statu = $r_status->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_statu->id; ?>" <?php if ($r_statu->id == $r->status_fk) echo "selected"; ?>><?= $r_statu->status ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact_law" class="col-lg-2 control-label">Responsable Avocat</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllUsers($db); ?>
                                        <select class="form-control" name="input_contact_law" id="input_contact_law">
                                            <option value=""></option>
                                            <?php
                                            while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $r->mngt_law) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_metro" class="col-lg-2 control-label">Metro</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_metro" name="input_metro" placeholder="Metro" type="text" value="<?= $r->metro; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <h1>Modification Facturation</h1>
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_factu_social" class="col-lg-2 control-label">Raison Sociale</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_social" name="input_factu_social" placeholder="Raison sociale" type="text" value="<?= $r->raison_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_last" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_last" name="input_factu_last" placeholder="Nom" type="text" value="<?= $r->nom_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_first" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_first" name="input_factu_first" placeholder="Prenom" type="text" value="<?= $r->prenom_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_addr" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_addr" name="input_factu_addr" placeholder="Adresse Facturation" type="text" value="<?= $r->adr1_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_town" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_town" name="input_factu_town" placeholder="Ville" type="text" value="<?= $r->ville_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_tel" class="col-lg-2 control-label">Téléphone</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_tel" name="input_factu_tel" placeholder="Téléphone" type="text" value="<?= $r->tel_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_fax" class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_fax" name="input_factu_fax" placeholder="Fax" type="text" value="<?= $r->fax_factu; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_factu_civil" class="col-lg-2 control-label">Civilité</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_civil" name="input_factu_civil" placeholder="Civilité" type="text" value="<?= $r->civilite_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_titre" class="col-lg-2 control-label">Titre</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_titre" name="input_factu_titre" placeholder="Titre" type="text" value="<?= $r->titre_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_country" class="col-lg-2 control-label">Pays Facturation</label>
                                    <div class="col-lg-10">
                                        <?php $r_countries = getAllCountries($db); ?>
                                        <select class="form-control" name="input_factu_country" id="input_factu_country">
                                            <option value=""></option>
                                            <?php
                                            while ($r_country = $r_countries->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_country->id; ?>" <?php if ($r_country->id == $r->country_factu_fk) echo "selected"; ?>><?php echo $r_country->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_postal" class="col-lg-2 control-label">Code Postal</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_postal" name="input_factu_postal" placeholder="Code Postal" type="text" value="<?= $r->postal_factu; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_factu_email" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_factu_email" name="input_factu_email" placeholder="Email" type="text" value="<?= $r->email_factu; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <h1>Enregistrer modification</h1>
                <div class="jumbotron">
                    <div class="form-group">
                        <button type="reset" class="btn btn-default">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
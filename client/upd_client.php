<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneCustomerById($db, $_GET['id']);
if (!$r) {
    ?>

    <div class="alert alert-dismissible alert-warning">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h4>Client introuvable</h4>
    </div>
<?php } else { ?>

    <div class="container-fluid">    
        <div class = "row">
            <div class = "col-md-6">
                <input type = "hidden" name = "input_id" value = "<?= $_GET['id'] ?>"/>
                <div class = "row">
                    <div class = "col-lg-9">
                        <h1>Suivi du client</h1>
                    </div>
                    <div class = "col-lg-3">
                        <h1 class = "pull-right"><a href="com_client_new.php?id=<?= $r->id; ?>"><button type = "button" class = "btn btn-primary">Enregistrer commentaire</button></a></h1>
                    </div>
                </div>
                <?php
                $coms = getComByCustomer($db, $r->id);

                while ($com = $coms->fetch(PDO::FETCH_OBJ)) {
                    $linefeed = "\r\n";
                    $remarque = str_replace('"', '\\\'', str_replace($linefeed, '<BR />', str_replace('\'', '\\\'', $com->remarque)));
                    $remarque = str_replace('\\', '', str_replace('\'\'', '\'', str_replace('"', '\'', $remarque)));
                    ?>
                    <div class="jumbotron" style="margin: 2px 0;padding: 15px;">
                        <p style="font-size: 14px;"><?= $remarque . "..."; ?>
                            <a href="com_client.php?id=<?= $com->id; ?>">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </a>
                        </p>
                    </div>

                <?php } ?>
            </div>
            <div class="col-md-6">
                <form class="form-horizontal" method="POST" action="../functions/upd_customer.php" id="form_upd_customer">
                    <div class="row">
                        <div class="col-lg-10">
                            <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
                            <h1>Fiche client</h1>
                        </div>
                        <div class="col-lg-2">
                            <h1 class="pull-right"><button type = "submit" class = "btn btn-primary">Enregistrer</button></h1>
                        </div>
                    </div>
                    <div class="jumbotron">
                        <div class="form-group">
                            <label for="input_remarque" class = "col-lg-1 control-label">Inform. Générales</label>
                            <div class="col-lg-11">
                                <textarea class="form-control" id="input_remarque" name="input_remarque" placeholder = "Remarque" type = "text" rows = "15"><?= $r->remarque; ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="input_name" class="col-lg-3 control-label"><b>Dénomination</b></label>
                                        <div class="col-lg-9">
                                            <b><input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= $r->nom; ?>"></b>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_addr" class="col-lg-3 control-label">Adresse</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="input_addr" name="input_addr" placeholder="Adresse" type="text" value="<?= $r->adresse1; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_town" class="col-lg-3 control-label">Ville</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="input_town" name="input_town" placeholder="Ville" type="text" value="<?= $r->ville; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_tel" class="col-lg-3 control-label">Téléphone</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="input_tel" name="input_tel" placeholder="Téléphone" type="text" value="<?= $r->tel_std; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_status" class="col-lg-3 control-label">Statut</label>
                                        <div class="col-lg-9">
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
                                        <label for="input_url" class="col-lg-3 control-label">URL</label>
                                        <div class="col-lg-9">
                                            <a href="<?= $r->url; ?>" target="_blank"><input class="form-control" id="input_url" name="input_url" placeholder="URL" type="text" value="<?= $r->url; ?>"></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_contact_law" class="col-lg-3 control-label">Resp. Avocat</label>
                                        <div class="col-lg-9">
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
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="input_zone" class="col-lg-3 control-label">Secteur</label>
                                        <div class="col-lg-9">
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
                                        <label for="input_postal" class="col-lg-3 control-label">Code Postal</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="input_postal" name="input_postal" placeholder="Code Postal" type="text" value="<?= $r->postal; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_country" class="col-lg-3 control-label">Pays</label>
                                        <div class="col-lg-9">
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
                                        <label for="input_nation" class="col-lg-3 control-label">Nationalité</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="input_nation" id="input_nation">
                                                <option value="Autre" <?php if ($r->nationalite == "Autre" || $r->nationalite == "" || $r->nationalite == NULL) echo "selected"; ?>>Autre</option>
                                                <option value="Américain" <?php if ($r->nationalite == "Américain") echo "selected"; ?>>Américaine</option>
                                                <option value="Britannique" <?php if ($r->nationalite == "Britannique") echo "selected"; ?>>Britannique</option>
                                                <option value="Francais" <?php if ($r->nationalite == "Francais") echo "selected"; ?>>Française</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" style="visibility: hidden;">
                                        <label for="input_nation" class="col-lg-3 control-label"></label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="" name="" placeholder="" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_metro" class="col-lg-3 control-label">Accès</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="input_metro" name="input_metro" placeholder="Metro" type="text" value="<?= $r->metro; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input_contact_supp" class="col-lg-3 control-label">Resp. Support</label>
                                        <div class="col-lg-9">
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
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#contact_support" data-toggle="tab">Contacts Support</a></li>
                    <li><a href="#contact_avocat" data-toggle="tab">Contacts Avocat</a></li>
                </ul>
                <div class="jumbotron">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="contact_support">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th class="col-lg-5">Identité</th>
                                        <th class="col-lg-3">Titre</th>
                                        <th class="col-lg-3">Téléphone</th>
                                        <th class="col-lg-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r_contacts = getContactByClientId($db, "SUP", $_GET['id']);
                                    while ($r_contact = $r_contacts->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <tr>
                                            <td><?= $r_contact->civilite . " " . $r_contact->nom . " " . $r_contact->prenom; ?></td>
                                            <td><?= $r_contact->fonction; ?></td>
                                            <td><?= $r_contact->tel; ?></td>
                                            <td>
                                                <?php if (!empty($r_contact->email)): ?>
                                                    <a href="mailto:<?= $r_contact->email; ?>?subject=Contact"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="contact_avocat">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th class="col-lg-5">Identité</th>
                                        <th class="col-lg-3">Titre</th>
                                        <th class="col-lg-3">Téléphone</th>
                                        <th class="col-lg-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $r_contacts = getContactByClientId($db, "LAW", $_GET['id']);
                                    while ($r_contact = $r_contacts->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <tr>
                                            <td><?= $r_contact->civilite . " " . $r_contact->nom . " " . $r_contact->prenom; ?></td>
                                            <td><?= $r_contact->fonction; ?></td>
                                            <td><?= $r_contact->tel; ?></td>
                                            <td>
                                                <?php if (!empty($r_contact->email)): ?>
                                                    <a href="mailto:<?= $r_contact->email; ?>?subject=Contact"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <h1>Postes en cours</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th class="col-lg-4">Libelle</th>
                                <th class="col-lg-4">Identité candidat</th>
                                <th class="col-lg-4">Date RDV</th>
                                <th>
                                    <a href="job.php?tab=new&id_client=<?= $_GET['id'] ?>">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $r_jobs = getJobByCustomer($db, $_GET['id']);
                            while ($r_job = $r_jobs->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="upd_job.php?id=<?= $r_job->ID ?>"><?= $r_job->libelle; ?></a>
                                    </td>
                                    <td>
                                        <a href="../candidat/upd_applicant.php?id=<?= $r_job->candidat ?>">
                                            <?= $r_job->nom . " " . $r_job->prenom ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $r_job->date_rdv; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <h1>Envoi de CV (<6mois)</h1>
                <div class="jumbotron">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th class="col-lg-2">Consult.</th>
                                <th class="col-lg-2">Date d'envoi</th>
                                <th class="col-lg-3">Candidat</th>
                                <th class="col-lg-5">Poste</th>
                                <th><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $r_send_cvs = getSendCvByCustomer($db, $_GET['id']);
                            while ($r_send_cv = $r_send_cvs->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        $r_consult = getUserById($db, $r_send_cv->consultant);
                                        if ($r_consult)
                                            echo $r_consult->initiale;
                                        ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($r_send_cv->date_envoi)) ?></td>
                                    <td>
                                        <?php
                                        $r_appli = getOneApplicantById($db, $r_send_cv->candidat);
                                        if ($r_appli)
                                            echo '<a href="../candidat/upd_applicant.php?id=' . $r_appli->id . '">' . $r_appli->nom . " " . $r_appli->prenom . '</a>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $job = getJobById($db, $r_send_cv->poste);
                                        $r_job = $job->fetch(PDO::FETCH_OBJ);
                                        ?>
                                        <a href="upd_job.php?id=<?= isset($r_job) ? $r_job->id : '' ?>">
                                            <?= isset($r_job) ? $r_job->libelle : ''; ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_GET['success'])) { ?>
        <script type="text/javascript">
            $(window).load(function () {
                alert('Commentaire modifié');
            });
        </script>
    <?php }
    ?>
    </body>

<?php } ?>
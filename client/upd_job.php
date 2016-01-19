<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$r = getOneJobById($db, $_GET['id']);
?>
<script>
    $(document).ready(function () {
        $("#show-up").slideDown('slow').delay(2000).slideUp('slow');
    });
</script>
<div class="container-fluid">
    <form class="form-horizontal" method="POST" action="../functions/upd_job.php" id="form_upd_customer">
        <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-dismissible alert-success" id="show-up" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Le poste a été modifié.
            </div>
        <?php } else if (isset($_GET['error'])) { ?>
            <div class="alert alert-dismissible alert-warning" id="show-up" style="display:none;">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Il y a eut un problème avec la modification.
            </div>
        <?php } ?>
        <input type="hidden" name="input_id" value="<?= $r->id ?>"/>
        <div class="row">
            <div class="col-md-6">
                <div class="jumbotron">
                    <div class="form-group">
                        <label for="input_description" class="col-lg-1 control-label">Description</label>
                        <div class="col-lg-11">
                            <textarea class="form-control" id="input_description" name="input_description" placeholder="Description" type="text" rows="15"><?= $r->description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="form-group">
                        <label for="input_description" class="col-lg-1 control-label">Comment.</label>
                        <div class="col-lg-11">
                            <textarea class="form-control" id="input_commentaire"
                                      name="input_commentaire" placeholder="Commentaire" 
                                      type="text" rows="20"><?= $r->commentaire; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-4">
                        <input type="hidden" name="input_id" value="<?= $_GET['id'] ?>"/>
                        <h1>Fiche poste</h1>
                    </div>
                    <div class="col-lg-8">
                        <h1 class="pull-right">
                            <?php if (($_SESSION['user']['type'] == 'ADMIN' || $_SESSION['user']['type'] == 'SUPERADMIN') && $r->pourvu == 'N') { ?>
                                <?php
                                $geturl = 'c=' . $r->client;
                                $geturl .= '&p=' . $r->id;
                                $geturl .= '&t=' . $r->titre;
                                $geturl .= '&pt=' . $r->pourcentage;
                                $geturl .= '&s=' . $r->salaire;
                                $geturl .= '&co=' . $r->consultant;
                                $geturl .= '&datedeb=' . $r->date_deb;
                                $geturl .= '&li=' . $r->lieux;
                                $geturl .= '&con=' . $r->contrat;
                                $geturl .= '&dur=' . $r->duree;
                                $geturl .= '&f1=' . $r->forfait;
                                $geturl .= '&f2=' . $r->forfait2;
                                $geturl .= '&f3=' . $r->forfait3;
                                ?>
                                <a href="new_placement.php?<?= $geturl ?>"><button type="button" class="btn btn-primary">Créer Placement</button></a>
                            <?php } ?>
                            <a href="new_rdv.php?client=<?= $r->client ?>&poste=<?= $r->id ?>"><button type="button" class="btn btn-primary">Créer RDV</button></a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </h1>
                    </div>
                </div>
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_name" class="col-lg-2 control-label"><b>Libelle</b></label>
                                    <div class="col-lg-10">
                                        <b><input class="form-control" id="input_name" name="input_name" placeholder="Nom" type="text" value="<?= $r->libelle; ?>"></b>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_title" class="col-lg-2 control-label">Titre</label>
                                    <div class="col-lg-10">
                                        <?php $r_titles = getAllTitles($db); ?>
                                        <select class="form-control" name="input_title" id="input_title">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_titles as $r_title):
                                                ?>
                                                <option value="<?= $r_title->id ?>" <?php if ($r_title->id == $r->titre) echo "selected"; ?>><?= $r_title->libelle ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_customer" class="col-lg-2 control-label">
                                        <a href="./upd_client.php?id=<?= $r->client ?>">
                                            Client
                                        </a>
                                    </label>
                                    <div class="col-lg-10">
                                        <?php $r_client = getOneCustomerById($db, $r->client); ?>
                                        <select class="select2-container select2-container-multi form-control" 
                                                name="input_customer" id="input_customer" 
                                                style="width:100%">
                                            <option value="<?= $r_client->id ?>" selected="selected"><?= $r_client->nom ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_signature" class="col-lg-4 control-label">Date de miss.</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="input_signature" name="input_signature" type="date" value="<?= $r->signature; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_exp" class="col-lg-2 control-label">Expérience</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="input_exp" id="input_exp">
                                            <option value=""<?php if ($r->experience == "") echo "selected"; ?>></option>
                                            <option value="Aucune" <?php if ($r->experience == "Aucune") echo "selected"; ?>>Aucune</option>
                                            <option value="< 1 an" <?php if ($r->experience == "< 1 an") echo "selected"; ?>>< 1 an</option>
                                            <option value="1 à 3 ans" <?php if ($r->experience == "1 à 3 ans") echo "selected"; ?>>1 à 3 ans</option>
                                            <option value="4 à 5 ans" <?php if ($r->experience == "4 à 5 ans") echo "selected"; ?>>4 à 5 ans</option>
                                            <option value="6 à 10 ans" <?php if ($r->experience == "6 à 10 ans") echo "selected"; ?>>6 à 10 ans</option>
                                            <option value="> 10 ans" <?php if ($r->experience == "> 10 ans") echo "selected"; ?>>> 10 ans</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_communication" class="col-lg-2 control-label">Com.</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_communication" id="input_communication">
                                            <option value="" <?php if ($r->communication == "" || $r->communication == NULL) echo "selected"; ?>></option>
                                            <option value="N" <?php if ($r->communication == "N") echo "selected"; ?>>N</option>
                                            <option value="Y" <?php if ($r->communication == "Y") echo "selected"; ?>>Y</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_pourvu" class="col-lg-2 control-label">Statut</label>
                                    <div class="col-lg-10">
                                        <select name="input_pourvu" id="input_pourvu" class="form-control">
                                            <option value="" <?php if (isset($r->pourvu) && $r->pourvu == '') echo 'selected'; ?>></option>
                                            <option value="Y" <?php if (isset($r->pourvu) && $r->pourvu == 'Y') echo 'selected'; ?>>Poste Fermé</option>
                                            <option value="N" <?php if (isset($r->pourvu) && $r->pourvu == 'N') echo 'selected'; ?>>Poste Ouvert</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_contact" class="col-lg-2 control-label">Consultant</label>
                                    <div class="col-lg-10">
                                        <?php $r_users = getAllUsers($db); ?>
                                        <select class="form-control" name="input_contact" id="input_contact">
                                            <option value=""></option>
                                            <?php
                                            while ($user_r = $r_users->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $user_r->id; ?>" <?php if ($user_r->id == $r->consultant) echo "selected"; ?>><?php echo $user_r->nom . " " . $user_r->prenom; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_starting_date" class="col-lg-3 control-label">Date de deb.</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_starting_date" 
                                               name="input_starting_date" type="date" 
                                               value="<?= $r->date_deb; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_percent" class="col-lg-2 control-label">Pourcent.</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_percent" 
                                               name="input_percent" placeholder="Pourcentage" 
                                               type="text" value="<?= $r->pourcentage; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_forfait" class="col-lg-2 control-label">Forfait</label>
                                    <div class="col-lg-3">
                                        <input class="form-control col-lg-4" id="input_forfait" 
                                               name="input_forfait" placeholder="1" 
                                               type="text" value="<?= $r->forfait; ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="form-control col-lg-4" id="input_forfait2" 
                                               name="input_forfait2" placeholder="2" 
                                               type="text" value="<?= $r->forfait2; ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <input class="form-control col-lg-4" id="input_forfait3" 
                                               name="input_forfait3" placeholder="3" 
                                               type="text" value="<?= $r->forfait3; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_garantie" class="col-lg-2 control-label">Garantie</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_garantie" 
                                                id="input_garantie">
                                            <option value="" <?php if ($r->garantie == "") echo "selected"; ?>></option>
                                            <option value="2 semaines" <?php if ($r->garantie == "2 semaines") echo "selected"; ?>>2 semaines</option>
                                            <option value="3 semaines" <?php if ($r->garantie == "3 semaines") echo "selected"; ?>>3 semaines</option>
                                            <option value="1 mois" <?php if ($r->garantie == "1 mois") echo "selected"; ?>>1 mois</option>
                                            <option value="2 mois" <?php if ($r->garantie == "2 mois") echo "selected"; ?>>2 mois</option>
                                            <option value="3 mois" <?php if ($r->garantie == "3 mois") echo "selected"; ?>>3 mois</option>
                                            <option value="4 mois" <?php if ($r->garantie == "4 mois") echo "selected"; ?>>4 mois</option>
                                            <option value="6 mois" <?php if ($r->garantie == "6 mois") echo "selected"; ?>>6 mois</option>
                                            <option value="12 mois" <?php if ($r->garantie == "12 mois") echo "selected"; ?>>12 mois</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_formule" class="col-lg-2 control-label">Formule</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" id="input_formule" 
                                                  name="input_formule" placeholder="Formule" 
                                                  type="text"><?= $r->formule; ?></textarea>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_contrat" class="col-lg-2 control-label">Contrat</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_contrat" id="input_contrat">
                                            <option value="" <?php if ($r->contrat == "") echo "selected"; ?>></option>
                                            <option value="Libéral" <?php if ($r->contrat == "Libéral") echo "selected"; ?>>Libéral</option>
                                            <option value="CDD" <?php if ($r->contrat == "CDD") echo "selected"; ?>>CDD</option>
                                            <option value="CDI" <?php if ($r->contrat == "CDI") echo "selected"; ?>>CDI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_salary" class="col-lg-2 control-label">Rém.</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_salary" 
                                               name="input_salary" placeholder="Salaire" 
                                               type="text" value="<?= $r->salaire; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_diplome" class="col-lg-2 control-label">Diplôme</label>
                                    <div class="col-lg-10">
                                        <?php $r_diplomes = getAllDiplomes($db); ?>
                                        <select class="form-control" name="input_diplome" id="input_diplome">
                                            <option value=""></option>
                                            <?php
                                            while ($r_diplome = $r_diplomes->fetch(PDO::FETCH_OBJ)) {
                                                ?>
                                                <option value="<?php echo $r_diplome->id; ?>" <?php if ($r_diplome->id == $r->diplome) echo "selected"; ?>><?php echo $r_diplome->libelle; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_speed" class="col-lg-2 control-label">Vitesse</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" id="input_speed" 
                                               name="input_speed" type="text"
                                               value="<?= $r->vitesse; ?>"/>
                                    </div>
                                    <label for="input_appli_1" class="col-lg-2 control-label">Autre Appli. 1</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" id="input_appli_1"
                                               name="input_appli_1" placeholder="Application" 
                                               type="text" value="<?= $r->autre_appli1; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_fr" class="col-lg-2 control-label">Niveau FR</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" id="input_fr" 
                                               name="input_fr" placeholder="Niveau francais" 
                                               type="text" value="<?= $r->niveau_fr; ?>">
                                    </div>
                                    <label for="input_an" class="col-lg-2 control-label">Niveau AN</label>
                                    <div class="col-lg-4">
                                        <input class="form-control" id="input_an" 
                                               name="input_an" placeholder="Niveau anglais" 
                                               type="text" value="<?= $r->niveau_en; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_place" class="col-lg-2 control-label">Lieux</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_place" 
                                               name="input_place" placeholder="Lieux" 
                                               type="text" value="<?= $r->lieux; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_period" class="col-lg-2 control-label">Durée</label>
                                    <div class="col-lg-5">
                                        <input class="form-control" id="input_period" 
                                               name="input_period" placeholder="URL" 
                                               type="text" value="<?= $r->duree; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_schedule" class="col-lg-2 control-label">Horaires</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="input_schedule" id="input_schedule">
                                            <option value="" <?php if ($r->horaires == "") echo "selected"; ?>></option>
                                            <option value="matinée" <?php if ($r->horaires == "matinée") echo "selected"; ?>>Matinée</option>
                                            <option value="jour" <?php if ($r->horaires == "jour") echo "selected"; ?>>Jour</option>
                                            <option value="après-midi" <?php if ($r->horaires == "après-midi") echo "selected"; ?>>Après-midi</option>
                                            <option value="soirée" <?php if ($r->horaires == "soirée") echo "selected"; ?>>Soirée</option>
                                            <option value="nuit" <?php if ($r->horaires == "nuit") echo "selected"; ?>>Nuit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_appli_2" class="col-lg-2 control-label">Autre Appli. 2</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" id="input_appli_2" 
                                               name="input_appli_2" placeholder="Application" 
                                               type="text" value="<?= $r->autre_appli2; ?>">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php if (isset($_GET['new'])) { ?>
    <script>
        $(window).ready(function () {
            alert('Le poste a été créée.');
        });
    </script>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#input_customer').select2({
            ajax: {
                url: "../api/customers.php",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
        });
    });
</script>
<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if ($_SESSION['user']['type'] != 'ADMIN' && $_SESSION['user']['type'] != 'SUPERADMIN') {
    echo 'Vous n\'avez pas accès à cette page';
} else {
    ?>

    <div class="container-fluid">
        <h1>Gestion Placement</h1>
        <form class="form-horizontal" method="GET" action="placement.php" id="form_placement">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-6">
                        <fieldset>
                            <div class="form-group">
                                <label for="input_applicant" class="col-lg-3 control-label">Candidat</label>
                                <div class="col-lg-9">
                                    <select class="select2-container select2-container-multi form-control" 
                                            name="input_applicant" id="input_applicant" 
                                            style="width:100%">
                                                <?php if (isset($_GET['input_applicant'])) { ?>
                                                    <?php $r_applicant = getOneApplicantById($db, $_GET['input_applicant']); ?>
                                            <option value="<?= $r_applicant->id ?>"><?= $r_applicant->nom . ' ' . $r_applicant->prenom ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_customer" class="col-lg-3 control-label">Client</label>
                                <div class="col-lg-9">
                                    <select class="select2-container select2-container-multi form-control" 
                                            name="input_customer" id="input_customer" 
                                            style="width:100%">
                                                <?php if (isset($_GET['input_customer'])) { ?>
                                                    <?php $r_client = getOneCustomerById($db, $_GET['input_customer']); ?>
                                            <option value="<?= $r_client->id ?>"><?= $r_client->nom ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_consult" class="col-lg-3 control-label">Consultant</label>
                                <div class="col-lg-9">
                                    <?php $r_users = getAllConsults($db); ?>
                                    <select class="form-control" name="input_consult" id="input_consult">
                                        <option value=""></option>
                                        <?php
                                        foreach ($r_users as $r_user) {
                                            ?>
                                            <option value="<?= $r_user->id; ?>" <?php if (isset($_GET['input_consult']) && $_GET['input_consult'] == $r_user->id) echo "selected"; ?>><?= $r_user->prenom . ' ' . $r_user->nom; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Rechercher</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-lg-6">
                        <fieldset>
                            <div class="form-group">
                                <label for="input_job" class="col-lg-3 control-label">Poste</label>
                                <div class="col-lg-9">
                                    <select class="select2-container select2-container-multi form-control" 
                                            name="input_job" id="input_job" 
                                            style="width:100%">
                                                <?php if (isset($_GET['input_job'])) { ?>
                                                    <?php $r_job = getOneJobById($db, $_GET['input_job']); ?>
                                            <option value="<?= $r_job->id ?>"><?= $r_job->libelle ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_month" class="col-lg-3 control-label">Date</label>
                                <div class="col-lg-5">
                                    <select class="form-control" name="input_month" 
                                            id="input_month">
                                        <option value=""></option>
                                        <option value="janvier" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'janvier') echo "selected"; ?>>Janvier</option>
                                        <option value="février" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'février') echo "selected"; ?>>Février</option>
                                        <option value="mars" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'mars') echo "selected"; ?>>Mars</option>
                                        <option value="avril" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'avril') echo "selected"; ?>>Avril</option>
                                        <option value="mai" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'mai') echo "selected"; ?>>Mai</option>
                                        <option value="juin" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'juin') echo "selected"; ?>>Juin</option>
                                        <option value="juillet" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'juillet') echo "selected"; ?>>Juillet</option>
                                        <option value="août" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'août') echo "selected"; ?>>Août</option>
                                        <option value="septembre" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'septembre') echo "selected"; ?>>Septembre</option>
                                        <option value="octobre" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'octobre') echo "selected"; ?>>Octobre</option>
                                        <option value="novembre" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'novembre') echo "selected"; ?>>Novembre</option>
                                        <option value="décembre" <?php if (isset($_GET['input_month']) && $_GET['input_month'] == 'décembre') echo "selected"; ?>>Décembre</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select class="form-control" name="input_year" id="input_year">
                                        <option value=""></option>
                                        <?php
                                        for ($i = date('Y'); $i >= 2002; $i--) {
                                            ?>
                                            <option value="<?= $i ?>" <?php if ((isset($_GET['input_year']) && $_GET['input_year'] == $i) || ((!isset($_GET['input_year']) && $i == date('Y')))) echo "selected"; ?>><?= $i ?></option>
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

            <?php
            if (!empty($_GET)) {
                $r_placements = searchPlacements($db);
                $result_search = $r_placements->fetchAll(PDO::FETCH_OBJ);
                if ($result_search) {
                    ?>

                    <h1>Résultats - <?= count($result_search) ?> placements</h1>
                    <div class="jumbotron">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Consultant</th>
                                    <th>Client</th>
                                    <th>Candidat</th>
                                    <th>Poste</th>
                                    <th>Secteur</th>
                                    <th class="text-right">Honoraires non Facturés</th>
                                    <th class="text-right">Honoraires non Encaissés</th>
                                    <th class="text-right">Honoraires Encaissés</th>
                                    <th class="text-right">Date placement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalIncomeNonFacture = 0;
                                $totalIncomeNonRecu = 0;
                                $totalIncomeRecu = 0;
                                foreach ($result_search as $r_placement) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="upd_placement.php?id=<?= $r_placement->id; ?>">
                                                <?= $r_placement->id; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $r_user = getUserById($db, $r_placement->consultant); ?>
                                            <?php if ($r_user) { ?>
                                                <?= $r_user->initiale ?>
                                                <?php
                                            } else {
                                                echo 'Aucun';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="upd_client.php?id=<?= $r_placement->idclient; ?>">
                                                <?= $r_placement->client; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php $r_applicant = getOneApplicantById($db, $r_placement->candidat); ?>
                                            <?php if ($r_applicant) { ?>
                                                <a href="../candidat/upd_applicant.php?id=<?= $r_applicant->id; ?>" 
                                                   title="<?= $r_applicant->nom ?> <?= $r_applicant->prenom ?>">
                                                    <?= $r_applicant->nom ?> <?= substr($r_applicant->prenom, 0, 1) ?>.
                                                </a>
                                                <?php
                                            } else {
                                                echo 'Aucun';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php $r_job = getOneJobById($db, $r_placement->poste); ?>
                                            <?php if ($r_job) { ?>
                                                <a href="upd_job.php?id=<?= $r_job->id; ?>">
                                                    <?= $r_job->libelle; ?>
                                                </a>
                                                <?php
                                            } else {
                                                echo "Aucun";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $r_placement->secteur ?>
                                        </td>
                                        <td class="text-right">
                                            <?php $nonFacture = getTotalFactureByPlacementId($db, $r_placement->id); ?>
                                            <span class="text-danger"><?= number_format($nonFacture->total, 2, ',', ' ') ?> €</span>
                                        </td>
                                        <td class="text-right">
                                            <?php $nonReçu = getTotalByPlacementId($db, $r_placement->id, 'N'); ?>
                                            <span class="text-warning"><?= number_format($nonReçu->total, 2, ',', ' ') ?> €</span>
                                        </td>
                                        <td class="text-right">
                                            <?php $reçu = getTotalByPlacementId($db, $r_placement->id, 'Y'); ?>
                                            <span class="text-success"><?= number_format($reçu->total, 2, ',', ' ') ?> €</span>
                                        </td>
                                        <td class="text-right">
                                            <?php
                                            $month = '';
                                            switch ($r_placement->mois_placement) {
                                                case 'janvier':
                                                    $month = '01';
                                                    break;
                                                case 'février':
                                                    $month = '02';
                                                    break;
                                                case 'mars':
                                                    $month = '03';
                                                    break;
                                                case 'avril':
                                                    $month = '04';
                                                    break;
                                                case 'mai':
                                                    $month = '05';
                                                    break;
                                                case 'juin':
                                                    $month = '06';
                                                    break;
                                                case 'juillet':
                                                    $month = '07';
                                                    break;
                                                case 'août':
                                                    $month = '08';
                                                    break;
                                                case 'septembre':
                                                    $month = '09';
                                                    break;
                                                case 'octobre':
                                                    $month = '10';
                                                    break;
                                                case 'novembre':
                                                    $month = '11';
                                                    break;
                                                case 'décembre':
                                                    $month = '12';
                                                    break;
                                            }
                                            ?>
                                            <?= $month . '/' . $r_placement->annee_placement ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $totalIncomeNonFacture += $nonFacture->total;
                                    $totalIncomeNonRecu += $nonReçu->total;
                                    $totalIncomeRecu += $reçu->total;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <p>Aucun résultats</p>
                    </div>
                <?php } ?>
                <h1>Total Non Facturé: <?= isset($totalIncomeNonFacture) ? number_format($totalIncomeNonFacture, 2, '.', ' ') : 0 ?> €</h1>
                <h1>Total Non Encaissé: <?= isset($totalIncomeNonRecu) ? number_format($totalIncomeNonRecu, 2, '.', ' ') : 0 ?> €</h1>
                <h1>Total Encaissé: <?= isset($totalIncomeRecu) ? number_format($totalIncomeRecu, 2, '.', ' ') : 0 ?> €</h1>
            <?php } ?>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#input_customer').select2({
                ajax: {
                    url: "../api/customers.php",
                    dataType: 'json',
                    delay: 50,
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
                allowClear: true,
                placeholder: 'Selectionner un client',
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1
            });
            $('#input_applicant').select2({
                ajax: {
                    url: "../api/applicants.php",
                    dataType: 'json',
                    delay: 50,
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
                minimumInputLength: 2,
                placeholder: 'Selectionner un candidat',
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
            $('#input_job').select2({
                ajax: {
                    url: "../api/jobs.php",
                    dataType: 'json',
                    delay: 50,
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
                minimumInputLength: 2,
                placeholder: 'Selectionner un poste',
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
        });
    </script>
<?php } ?>

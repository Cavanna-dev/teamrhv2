<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

if (!($_SESSION['user']['type'] == "ADMIN" || $_SESSION['user']['type'] == "SUPERADMIN")) {
    ?>
    <script type="text/javascript">
        top.location.replace('../index.php');
    </script>
    <?php
}
?>
<div class="container">
    <h1>Gestion Décaissés</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#search" data-toggle="tab">Rechercher</a></li>
        <li><a href="#add" data-toggle="tab">Ajouter</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="search">
            <form class="form-horizontal" method="GET" action="decaisse.php" id="form_customer">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_ref_fac" class="col-lg-3 control-label">Référence Facture</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_ref_fac" name="input_ref_fac" 
                                               placeholder="Référence" type="text" 
                                               value="<?= isset($_GET['input_ref_fac']) ? $_GET['input_ref_fac'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_date_compta_mini" class="col-lg-4 control-label">Date comptabilité</label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" 
                                               name="input_date_compta_mini" 
                                               id="input_date_compta_mini"
                                               value="<?= isset($_GET['input_date_compta_mini']) ? $_GET['input_date_compta_mini'] : '' ?>"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" 
                                               name="input_date_compta_maxi" 
                                               id="input_date_compta_maxi"
                                               value="<?= isset($_GET['input_date_compta_maxi']) ? $_GET['input_date_compta_maxi'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_fournisseur" class="col-lg-3 control-label">Fournisseur</label>
                                    <div class="col-lg-9">
                                        <?php $r_fourns = getAllFourns($db); ?>
                                        <select class="form-control" name="input_fournisseur" 
                                                id="input_fournisseur">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_fourns as $r_fourn) :
                                                ?>
                                                <option value="<?= $r_fourn->id; ?>"
                                                        <?php if (isset($_GET['input_fournisseur']) && $_GET['input_fournisseur'] == $r_fourn->id) echo 'selected'; ?>><?= $r_fourn->nom; ?></option>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-9">
                                        <button type="submit" class="btn btn-primary">Rechercher</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_ref_paie" class="col-lg-3 control-label">Référence Paiement</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_ref_paie" name="input_ref_paie" 
                                               placeholder="Référence" type="text" 
                                               value="<?= isset($_GET['input_ref_paie']) ? $_GET['input_ref_paie'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_date_paie_mini" class="col-lg-4 control-label">Date Paiement</label>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" 
                                               name="input_date_paie_mini" 
                                               id="input_date_paie_mini"
                                               value="<?= isset($_GET['input_date_paie_mini']) ? $_GET['input_date_paie_mini'] : '' ?>"/>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" 
                                               name="input_date_paie_maxi" 
                                               id="input_date_paie_maxi"
                                               value="<?= isset($_GET['input_date_paie_maxi']) ? $_GET['input_date_paie_maxi'] : '' ?>"/>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <?php
                if (!empty($_GET)) {
                    $r_decaisses = searchDecaisse($db);
                    if ($r_decaisses) {
                        ?>

                        <h1>Résultats - <?= count($r_decaisses) ?> factures</h1>
                        <div class="jumbotron">
                            <table class="table table-striped table-hover ">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Ref Facture</th>
                                        <th>Fournisseur</th>
                                        <th>Ref Paiement</th>
                                        <th>Date Factu.</th>
                                        <th>Date Paie.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($r_decaisses as $r_decaisse) {
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="./upd_decaisse.php?id=<?= $r_decaisse->id ?>">
                                                    <?= $r_decaisse->id ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?= $r_decaisse->ref_facture ?>
                                            </td>
                                            <td>
                                                <?= $r_decaisse->nom ?>
                                            </td>
                                            <td>
                                                <?= $r_decaisse->ref_paiement ?>
                                            </td>
                                            <td>
                                                <?= $r_decaisse->date_compta ?>
                                            </td>
                                            <td>
                                                <?= $r_decaisse->date_paiement ?>
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
                            <h4>Attention!</h4>
                            <p>Aucun résultats</p>
                        </div>
                    <?php } ?>
                <?php } ?>
            </form>
        </div>
        <div class="tab-pane fade" id="add">
            <form class="form-horizontal" method="POST" action="../functions/new_decaisse.php" id="form_decaisse">
                <div class="jumbotron">
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_fournisseur" class="col-lg-3 control-label">Fournisseur</label>
                                    <div class="col-lg-9">
                                        <?php $r_fourns = getAllFourns($db); ?>
                                        <select class="form-control" name="input_fournisseur" 
                                                id="input_fournisseur">
                                            <option value=""></option>
                                            <?php
                                            foreach ($r_fourns as $r_fourn) :
                                                ?>
                                                <option value="<?= $r_fourn->id; ?>"
                                                        <?php if (isset($_GET['fou']) && $_GET['fou'] == $r_fourn->id) echo 'selected'; ?>><?= $r_fourn->nom; ?></option>
                                                        <?php
                                                    endforeach;
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_date_compta" class="col-lg-3 control-label">Date Compta</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" 
                                               name="input_date_compta" 
                                               id="input_date_compta"
                                               value="<?= isset($_GET['dc']) ? $_GET['dc'] : '' ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_mode_paiement" class="col-lg-3 control-label">Mode paiement</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="input_mode_paiement" >
                                            <option value=""        >        </option>
                                            <option value="CB"      >CB      </option>
                                            <option value="CHEQUE"  >CHEQUE  </option>
                                            <option value="LIQUIDE" >LIQUIDE </option>
                                            <option value="MANDAT"  >MANDAT  </option>
                                            <option value="TIP"     >TIP     </option>
                                            <option value="VIREMENT">VIREMENT</option>
                                            <option value="AUTRE"   >AUTRE   </option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <div class="form-group">
                                    <label for="input_ref_fac" class="col-lg-3 control-label">Ref. Fact.</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_ref_fac" name="input_ref_fac" 
                                               placeholder="Référence Facture" type="text"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_date_paiement" class="col-lg-3 control-label">Date Paiement</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" 
                                               name="input_date_paiement" 
                                               id="input_date_paiement"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_ref_pai" class="col-lg-3 control-label">Ref Paiement</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="input_ref_pai" name="input_ref_pai" 
                                               placeholder="Référence Paiement" type="text"/>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <fieldset>

                        <div class="form-group">
                            <label for="input_line1" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line1" /> 20%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line1_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line2" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line2" /> 10%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line2_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line3" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line3" /> 5,5%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line3_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_line4" class="col-lg-2 control-label">
                                <input type="checkbox" name="input_line4" /> 0%
                            </label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_ht" 
                                       id="input_line1_ht" 
                                       placeholder="Montant HT" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_tva" 
                                       id="input_line1_tva"  
                                       placeholder="Montant Tva" />
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" 
                                       name="input_line4_ttc" 
                                       id="input_line1_ttc"  
                                       placeholder="Montant TTC" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_description" class="col-lg-1 control-label">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" name="input_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-9">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

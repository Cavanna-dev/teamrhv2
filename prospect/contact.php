<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$type_contact = $_GET['type'];
$id_prospect_contact = $_GET['id_prospect'];

$r_prospect = getOneProspectById($db, $id_prospect_contact);
?>

<div class="container">
    <h1>Ajout Contact pour <a href="upd_prospect.php?id=<?= $r_prospect->id ?>"><?= $r_prospect->nom ?></a></h1>
    <form class="form-horizontal" method="POST" action="../functions/new_contact_prospect.php" id="form_rdv">
        <input type="hidden" name="prospect" value="<?= $r_prospect->id ?>" />
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_civil" class="col-lg-2 control-label">Identité</label>
                            <div class="col-lg-3">			
                                <select class="form-control" name="input_civil" >
                                    <OPTION value=""     >     </OPTION>
                                    <OPTION value="Melle">Melle</OPTION>
                                    <OPTION value="Mme"  >Mme  </OPTION>
                                    <OPTION value="Mr"   >Mr   </OPTION>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="input_name" 
                                       id="input_name" placeholder="Nom" >
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="input_last" 
                                       id="input_last" placeholder="Prénom" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_statut" class="col-lg-2 control-label">Statut</label>
                            <div class="col-lg-4">
                                <select class="form-control" name="input_statut" 
                                        id="input_statut" required>
                                    <option value="N">Actif</option>
                                    <option value="Y">Inactif</option>
                                </select>
                            </div>
                            <label for="input_tel" class="col-lg-2 control-label">Téléphone</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="input_tel" 
                                       id="input_tel" placeholder="Téléphone" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_fonction" class="col-lg-2 control-label">Fonction</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="input_fonction" 
                                       id="input_fonction" placeholder="Fonction" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_remarque" class = "col-lg-2 control-label">Remarque</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="input_remarque" 
                                          name="input_remarque" placeholder="Remarque" 
                                          type="text" rows="7"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_mail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" name="input_mail" 
                                       id="input_mail" placeholder="Email" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_type" class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-10">			
                                <select class="form-control" name="input_type">
                                    <option value="LAW" <?php if($type_contact == 'LAW') echo 'selected'; ?>>Avocat</option> 
                                    <option value="SUP" <?php if($type_contact == 'SUP') echo 'selected'; ?>>Support</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Créer nouveau contact</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
</body>

<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion RDVs</h1>
    <form class="form-horizontal" method="POST" action="../functions/new_rdv.php" id="form_rdv">
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_consult1" class="col-lg-2 control-label">Consult. 1</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_consult1" id="input_consult1" required>
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>"><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_salle" class="col-lg-2 control-label">Salle</label>
                            <div class="col-lg-10">			
                                <select class="form-control" name="input_salle" required="">
                                    <option value="1">Salle A</option> 
                                    <option value="2">Salle B</option> 
                                    <option value="3">Salle C</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_customer" class="col-lg-2 control-label">Client</label>
                            <?php $r_customers = getAllCustomers($db); ?>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_customer" id="input_customer">
                                    <option value=""></option>
                                    <?php
                                    while ($r_customer = $r_customers->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?= $r_customer->id ?>" ><?= $r_customer->nom ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_civil" class="col-lg-2 control-label">Candidat</label>
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
                                       id="input_name" value="" placeholder="Nom" >
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="input_last" 
                                       id="input_last" value="" placeholder="Prénom" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date" class="col-lg-2 control-label">Date</label>
                            <div class="col-lg-8">
                                <input type="date" class="form-control" name="input_date" 
                                       id="input_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Créer nouveau RDV</button>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_consult2" class="col-lg-2 control-label">Consult. 2</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_consult2" id="input_consult2">
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>"><?php echo $r_user->nom . " " . $r_user->prenom; ?></option> 
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_type_rdv" class="col-lg-2 control-label">Type RDV</label>
                            <div class="col-lg-10">			
                                <select class="form-control" name="input_type_rdv">
                                    <option value="CANDIDAT"   >Candidat   </option> 
                                    <option value="CLIENT"     >Client     </option> 
                                    <option value="INTERNE"    >Interne    </option> 
                                    <option value="PERSONNEL"  >Personnel  </option> 
                                    <option value="PROSPECTION">Prospection</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Poste</label>
                            <?php $r_titles = getAllTitles($db); ?>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_title" id="input_title" required>
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $title):
                                        ?>
                                        <option value="<?= $title->id ?>" ><?= $title->libelle ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Horaires deb.</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_hdeb" id="input_title" required>
                                    <?php
                                    for ($i = 8; $i <= 20; $i++):
                                        ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_mdeb" id="input_title" required>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Horaires fin</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_hfin" id="input_title" required>
                                    <?php
                                    for ($i = 8; $i <= 20; $i++):
                                        ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_mfin" id="input_title" required>
                                    <option value="00">00</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </form>
</div>
</body>

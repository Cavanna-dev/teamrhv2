<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$rdv = getOneRdvById($db, $_GET['id']);
?>

<div class="container">
    <h1>Gestion RDVs</h1>
    <div class="jumbotron">
        <form class="form-horizontal" method="POST" action="../functions/upd_rdv.php" id="form_rdv">
            <input type="hidden" class="form-control" name="input_id" id="input_id" value="<?= $rdv->ID ?>">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_consult1" class="col-lg-2 control-label">Consult. 1</label>
                            <div class="col-lg-10">
                                <?php $r_users = getAllUsers($db); ?>
                                <select class="form-control" name="input_consult1" id="input_consult1">
                                    <option value=""></option>
                                    <?php
                                    while ($r_user = $r_users->fetch(PDO::FETCH_OBJ)) {
                                        ?>
                                        <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $rdv->CONSULTANT1) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_salle" class="col-lg-2 control-label">Salle</label>
                            <div class="col-lg-10">			
                                <select class="form-control" name="input_salle">
                                    <option value="1" <?php if ($rdv->NUMSALLE == 1) echo "selected"; ?>>Salle A</option> 
                                    <option value="2" <?php if ($rdv->NUMSALLE == 2) echo "selected"; ?>>Salle B</option> 
                                    <option value="3" <?php if ($rdv->NUMSALLE == 3) echo "selected"; ?>>Salle C</option> 
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
                                        <option value="<?= $r_customer->id ?>" <?php if ($rdv->CLIENT == $r_customer->id) echo "selected"; ?>><?= $r_customer->nom ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_civil" class="col-lg-2 control-label">Candidat</label>
                            <div class="col-lg-3">			
                                <select class="form-control" name="input_civil">
                                    <OPTION value=""      <?php if ($rdv->CIVILITE == '') echo "selected"; ?>>     </OPTION>
                                    <OPTION value="Melle" <?php if ($rdv->CIVILITE == 'Melle') echo "selected"; ?>>Melle</OPTION>
                                    <OPTION value="Mme"   <?php if ($rdv->CIVILITE == 'Mme') echo "selected"; ?>>Mme  </OPTION>
                                    <OPTION value="Mr"    <?php if ($rdv->CIVILITE == 'Mr') echo "selected"; ?>>Mr   </OPTION>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="input_name" id="input_name" value="<?= $rdv->NOM ?>" placeholder="Nom">
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="input_last" id="input_last" value="<?= $rdv->PRENOM ?>" placeholder="Prénom">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date" class="col-lg-2 control-label">Date</label>
                            <div class="col-lg-8">
                                <input type="date" class="form-control" name="input_date" id="input_date" value="<?= $rdv->JOUR ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_date" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-8">
                                <?php
                                $sql = "SELECT email FROM candidat WHERE nom = '" . $rdv->NOM . "' AND prenom = '" . $rdv->PRENOM . "'";
                                $r_mail = $db->prepare($sql);
                                $r_mail->execute();
                                $r = $r_mail->fetch(PDO::FETCH_OBJ);
                                ?>
                                <p><a href="mailto:<?= isset($r->email) ? $r->email : '' ?>?subject=test&body=test"><?= $r->email ?></a></p>
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
                                        <option value="<?php echo $r_user->id; ?>" <?php if ($r_user->id == $rdv->CONSULTANT2) echo "selected"; ?>><?php echo $r_user->nom . " " . $r_user->prenom; ?></option>
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
                                    <option value="0"></option>
                                    <option value="CANDIDAT"    <?php if ($rdv->TYPE == 'CANDIDAT') echo 'selected'; ?>>Candidat   </option> 
                                    <option value="CLIENT"      <?php if ($rdv->TYPE == 'CLIENT') echo 'selected'; ?>>Client     </option> 
                                    <option value="INTERNE"     <?php if ($rdv->TYPE == 'INTERNE') echo 'selected'; ?>>Interne    </option> 
                                    <option value="PERSONNEL"   <?php if ($rdv->TYPE == 'PERSONNEL') echo 'selected'; ?>>Personnel  </option> 
                                    <option value="PROSPECTION" <?php if ($rdv->TYPE == 'PROSPECTION') echo 'selected'; ?>>Prospection</option> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Poste</label>
                            <?php $r_titles = getAllTitles($db); ?>
                            <div class="col-lg-10">
                                <select class="form-control" name="input_title" id="input_title">
                                    <option value=""></option>
                                    <?php
                                    foreach ($r_titles as $title):
                                        ?>
                                        <option value="<?= $title->id ?>" <?php if ($rdv->POSTE == $title->id) echo 'selected'; ?>><?= $title->libelle ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Horaires deb.</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_hdeb" id="input_title">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 8; $i <= 20; $i++):
                                        ?>
                                        <option value="<?= $i ?>" <?php if ($rdv->HEURE_DEB == $i) echo 'selected'; ?>><?= $i ?></option>
                                        <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_mdeb" id="input_title">
                                    <option value=""   <?php if ($rdv->MINUTE_DEB == '') echo 'selected'; ?>></option>
                                    <option value="00" <?php if ($rdv->MINUTE_DEB == '00') echo 'selected'; ?>>00</option>
                                    <option value="15" <?php if ($rdv->MINUTE_DEB == '15') echo 'selected'; ?>>15</option>
                                    <option value="30" <?php if ($rdv->MINUTE_DEB == '30') echo 'selected'; ?>>30</option>
                                    <option value="45" <?php if ($rdv->MINUTE_DEB == '45') echo 'selected'; ?>>45</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input_title" class="col-lg-2 control-label">Horaires fin</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_hfin" id="input_title">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 8; $i <= 20; $i++):
                                        ?>
                                        <option value="<?= $i ?>" <?php if ($rdv->HEURE_FIN == $i) echo 'selected'; ?>><?= $i ?></option>
                                        <?php
                                    endfor;
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-control" name="input_mfin" id="input_title">
                                    <option value=""   <?php if ($rdv->MINUTE_FIN == '') echo 'selected'; ?>></option>
                                    <option value="00" <?php if ($rdv->MINUTE_FIN == '00') echo 'selected'; ?>>00</option>
                                    <option value="15" <?php if ($rdv->MINUTE_FIN == '15') echo 'selected'; ?>>15</option>
                                    <option value="30" <?php if ($rdv->MINUTE_FIN == '30') echo 'selected'; ?>>30</option>
                                    <option value="45" <?php if ($rdv->MINUTE_FIN == '45') echo 'selected'; ?>>45</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="form-group pull-left">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Modifier RDV</button>
                </div>
            </div>
        </form>
        <form class="form-horizontal" method="POST" action="../functions/del_rdv.php" id="form_rdv">
            <input type="hidden" class="form-control" name="input_id" id="input_id" value="<?= $rdv->ID ?>">
            <div class="form-group pull-left" style="margin-left: 15px;">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Suppr. RDV</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
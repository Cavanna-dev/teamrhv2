<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';

$ndf = getOneNdfById($db, $_GET['id']);
?>

<div class="container" style="font-size: 8px!important;">
    <h1>Gestion Notes de frais</h1>
    <form class="form-horizontal" method="POST" action="../functions/upd_ndf.php" id="form_decaisse">
        <input type="hidden" name="input_id" value="<?= $ndf->ID ?>"/>
        <div class="jumbotron">
            <div class="row">
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_month" class="col-lg-3 control-label">Mois</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="input_month" 
                                        id="input_month">
                                    <option value=""></option>
                                    <option value="janvier" <?php if ($ndf->MOIS == 'janvier') echo "selected"; ?>>Janvier</option>
                                    <option value="février" <?php if ($ndf->MOIS == 'février') echo "selected"; ?>>Février</option>
                                    <option value="mars" <?php if ($ndf->MOIS == 'mars') echo "selected"; ?>>Mars</option>
                                    <option value="avril" <?php if ($ndf->MOIS == 'avril') echo "selected"; ?>>Avril</option>
                                    <option value="mai" <?php if ($ndf->MOIS == 'mai') echo "selected"; ?>>Mai</option>
                                    <option value="juin" <?php if ($ndf->MOIS == 'juin') echo "selected"; ?>>Juin</option>
                                    <option value="juillet" <?php if ($ndf->MOIS == 'juillet') echo "selected"; ?>>Juillet</option>
                                    <option value="août" <?php if ($ndf->MOIS == 'août') echo "selected"; ?>>Août</option>
                                    <option value="septembre" <?php if ($ndf->MOIS == 'septembre') echo "selected"; ?>>Septembre</option>
                                    <option value="octobre" <?php if ($ndf->MOIS == 'octobre') echo "selected"; ?>>Octobre</option>
                                    <option value="novembre" <?php if ($ndf->MOIS == 'novembre') echo "selected"; ?>>Novembre</option>
                                    <option value="décembre" <?php if ($ndf->MOIS == 'décembre') echo "selected"; ?>>Décembre</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-6">
                    <fieldset>
                        <div class="form-group">
                            <label for="input_year" class="col-lg-3 control-label">Année</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="input_year" 
                                        id="input_year">
                                    <option value=""></option>
                                    <?php
                                    for ($i = 2002; $i <= date('Y'); $i++):
                                        ?>
                                        <option value="<?= $i ?>" 
                                        <?php
                                        if ($ndf->ANNEE == $i) {
                                            echo "selected";
                                        }
                                        ?>><?= $i ?></option>
                                                <?php
                                            endfor;
                                            ?>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <fieldset>
                <?php
                $dd = getAllNdfDByNdfId($db, $ndf->ID);
                ?>
                <div class="form-group">
                    <label for="input_line1" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line1" 
                               <?php if (isset($dd[0])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_ht" 
                               id="input_line1_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[0]->HT_AMOUNT) ? $dd[0]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line1_percent" 
                               id="input_line1_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[0]->TVA_PERCENT) ? $dd[0]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_tva" 
                               id="input_line1_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[0]->TVA_AMOUNT) ? $dd[0]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line1_ttc" 
                               id="input_line1_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[0]->TTC_AMOUNT) ? $dd[0]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line2" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line2" 
                               <?php if (isset($dd[1])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_ht" 
                               id="input_line2_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[1]->HT_AMOUNT) ? $dd[1]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line2_percent" 
                               id="input_line2_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[1]->TVA_PERCENT) ? $dd[1]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_tva" 
                               id="input_line2_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[1]->TVA_AMOUNT) ? $dd[1]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line2_ttc" 
                               id="input_line2_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[1]->TTC_AMOUNT) ? $dd[1]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line3" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line3" 
                               <?php if (isset($dd[2])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_ht" 
                               id="input_line3_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[2]->HT_AMOUNT) ? $dd[2]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line3_percent" 
                               id="input_line3_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[2]->TVA_PERCENT) ? $dd[2]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_tva" 
                               id="input_line3_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[2]->TVA_AMOUNT) ? $dd[2]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line3_ttc" 
                               id="input_line3_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[2]->TTC_AMOUNT) ? $dd[2]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_line4" class="col-lg-1 control-label">
                        <input type="checkbox" name="input_line4" 
                               <?php if (isset($dd[3])) echo 'checked'; ?>/>
                    </label>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_ht" 
                               id="input_line4_ht" 
                               placeholder="Montant HT" 
                               value="<?= isset($dd[3]->HT_AMOUNT) ? $dd[3]->HT_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" class="form-control" 
                               name="input_line4_percent" 
                               id="input_line4_percent"  
                               placeholder="Taux TVA" 
                               value="<?= isset($dd[3]->TVA_PERCENT) ? $dd[3]->TVA_PERCENT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_tva" 
                               id="input_line4_tva"  
                               placeholder="Montant Tva" 
                               value="<?= isset($dd[3]->TVA_AMOUNT) ? $dd[3]->TVA_AMOUNT : '' ?>"/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" class="form-control" 
                               name="input_line4_ttc" 
                               id="input_line4_ttc"  
                               placeholder="Montant TTC"
                               value="<?= isset($dd[3]->TTC_AMOUNT) ? $dd[3]->TTC_AMOUNT : '' ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="input_description" class="col-lg-1 control-label">Description</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" name="input_description" placeholder="Description"><?= $ndf->DESCRIPTION ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-9">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
<script type="text/javascript">
<?php if (isset($_GET['success']) && $_GET['success'] == 'upd') { ?>
        $(window).load(function () {
            alert('Facture modifiée avec succès');
        });
<?php } ?>

    $(window).ready(function () {
<?php for ($i = 1; $i <= 4; $i++) { ?>
            $('#input_line<?= $i ?>_ht').keyup(function () {
                var amountHt<?= $i ?> = parseFloat($(this).val());
                var tva<?= $i ?> = parseFloat($('#input_line<?= $i ?>_tva'));

                var amountTva<?= $i ?> = amountHt<?= $i ?> * (tva<?= $i ?> / 100);
                var roundTva<?= $i ?> = Math.round(amountTva<?= $i ?> * 100) / 100;
                $('#input_line<?= $i ?>_tva').val(roundTva<?= $i ?>);

                var amountTtc<?= $i ?> = amountHt<?= $i ?> + amountTva<?= $i ?>;
                var roundTtc<?= $i ?> = Math.round(amountTtc<?= $i ?> * 100) / 100;
                $('#input_line<?= $i ?>_ttc').val(roundTtc<?= $i ?>);
            });

            $('#input_line<?= $i ?>_tva').keyup(function () {
                var amountTva<?= $i ?> = parseFloat($(this).val());
                var tva<?= $i ?> = parseFloat($('#input_line<?= $i ?>_tva'));
                if (tva<?= $i ?> != 0) {

                    var amountTtc<?= $i ?> = amountTva<?= $i ?> * (tva<?= $i ?> + 100) / tva<?= $i ?>;
                    var roundAmountTtc<?= $i ?> = Math.round(amountTtc<?= $i ?> * 100) / 100;
                    $('#input_line<?= $i ?>_ttc').val(roundAmountTtc<?= $i ?>);


                    var amountHt<?= $i ?> = amountTtc<?= $i ?> - amountTva<?= $i ?>;
                    var roundAmountHt<?= $i ?> = Math.round(amountHt<?= $i ?> * 100) / 100;
                    $('#input_line<?= $i ?>_ht').val(roundAmountHt<?= $i ?>);
                }
            });


            $('#input_line<?= $i ?>_ttc').keyup(function () {
                var amountTtc<?= $i ?> = parseFloat($(this).val());
                var tva<?= $i ?> = parseFloat($('#input_line<?= $i ?>_tva'));

                var amountTva<?= $i ?> = amountTtc<?= $i ?> * tva<?= $i ?> / (tva<?= $i ?> + 100);
                var roundAmountTva<?= $i ?> = Math.round(amountTva<?= $i ?> * 100) / 100;
                $('#input_line<?= $i ?>_tva').val(roundAmountTva<?= $i ?>);

                var amountHt<?= $i ?> = amountTtc<?= $i ?> - roundAmountTva<?= $i ?>;
                var roundAmountTva<?= $i ?> = Math.round(amountHt<?= $i ?> * 100) / 100;
                $('#input_line<?= $i ?>_ht').val(roundAmountTva<?= $i ?>);
            });
<?php } ?>
    });
</script>
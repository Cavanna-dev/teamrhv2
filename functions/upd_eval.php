<?php

include './connection_db.php';

error_reporting(0);
//var_dump($_POST);die;
//var_dump($_FILES['photo']);die;

if (isset($_POST['spec'])) {
    foreach ($_POST['spec'] as $value):
        $array_spec[] = $value;
    endforeach;
}
//var_dump($array_spec);die;

foreach ($_POST as $key => $value):
    if ($key != 'spec' && $key != 'input_apply' && $key != 'photo')
        $array_value[':' . $key] = $value;
endforeach;

/**
 * Traitement d'ajout/modif d'image
 */
$finalName = '';
if ($_FILES["photo"]['name'] != '') {
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $name = $_POST['input_eval'] . "_" . date('YmdHmi');
    $finalName = "../img/pictures/" . $name . ".jpg";
    move_uploaded_file($tmp_name, $finalName);
}else{
    $finalName = $_POST['photo'];
}

try {
    $sql = "UPDATE `evaluation` SET "
            . "`PICTURE_PATH`='".$finalName."',`DISPONIBLE`=:input_disponible,`DIPLOME`=:input_diplome,`EXPERIENCE`=:input_exp,"
            . "`LANGUE`=:input_l1,`LANGUE2`=:input_l2,`LVL_TEST1_FR`=:input_test_fr1,"
            . "`LVL_TEST2_FR`=:input_test_fr2,`LVL_ORAL_FR`=:input_oral_fr,`LVL_TEST1_EN`=:input_test_en1,"
            . "`LVL_TEST2_EN`=:input_test_en2,`LVL_ORAL_EN`=:input_oral_en,"
            . "`VITESSE`=:input_speed,`AUTRE_APPLI1`=:input_appli1,`SECTEUR_ACTUEL`=:input_zone,"
            . "`TITRE1_ACTUEL`=:input_title1,`TITRE2_ACTUEL`=:input_title2,`TITRE3_ACTUEL`=:input_title3,"
            . "`SALAIRE_ACTUEL`=:input_salaire_actuel,`SECTEUR_RECH`=:input_zone_rech,"
            . "`TITRE1_RECH`=:input_title_futur1,"
            . "`TITRE2_RECH`=:input_title_futur2,`TITRE3_RECH`=:input_title_futur3,"
            . "`SAL_MIN_RECH`=:input_salaire_rech,`CONTRAT1_RECH`=:input_contrat_1,"
            . "`CONTRAT2_RECH`=:input_contrat_2,`HORAIRES1_RECH`=:input_horaires_1,"
            . "`HORAIRES2_RECH`=:input_horaires_2,`PREAVIS`=:input_preavis,"
            . "`REMARQUE`=:input_remarque,`NOTE`=:input_note_gen,`DATE_SERMENT`=:input_serment,`MODIFICATION`=now() WHERE id=:input_eval";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    $sql = "DELETE FROM `eval_spec` WHERE `ID_EVAL`='" . $array_value[':input_eval'] . "'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    foreach ($array_spec as $spec):
        $sql = "INSERT INTO `eval_spec`(`ID_EVAL`, `ID_SPEC`) VALUES (" . $array_value[':input_eval'] . "," . $spec . ") ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    header('Location:../candidat/upd_evaluation.php?id=' . $array_value[':input_eval'] . '&success');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
<?php

include './connection_db.php';

//var_dump($_POST);die;

if (array_key_exists('spec', $_POST)) {
    foreach ($_POST['spec'] as $value):
        $array_spec[] = $value;
    endforeach;
}
//var_dump($array_spec);die;

foreach ($_POST as $key => $value):
    if ($key != 'spec' && $key != 'photo')
        $array_value[':' . $key] = $value;
endforeach;
//var_dump($array_value);die;

/**
 * Traitement d'ajout/modif d'image
 */
$finalName = '';
if (array_key_exists('photo', $_FILES) && $_FILES["photo"]['name'] != '') {
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $name = $_POST['input_eval'] . "_" . date('Ymd');
    $finalName = "../img/pictures/" . $name . ".jpg";
    move_uploaded_file($tmp_name, $finalName);
}

try {
    $sql = "INSERT INTO `evaluation`"
            . "(`ID`, `CANDIDAT`, `PICTURE_PATH`, `DISPONIBLE`, `DIPLOME`, `EXPERIENCE`, `LANGUE`, "
            . "`LANGUE2`, `LVL_TEST1_FR`, `LVL_TEST2_FR`, `LVL_ORAL_FR`, `LVL_TEST1_EN`, "
            . "`LVL_TEST2_EN`, `LVL_ORAL_EN`, `VITESSE`, `AUTRE_APPLI1`, "
            . "`SECTEUR_ACTUEL`, `TITRE1_ACTUEL`, `TITRE2_ACTUEL`, "
            . "`TITRE3_ACTUEL`, `SALAIRE_ACTUEL`, `SECTEUR_RECH`, "
            . "`TITRE1_RECH`, `TITRE2_RECH`, `TITRE3_RECH`, `SAL_MIN_RECH`, `CONTRAT1_RECH`, "
            . "`CONTRAT2_RECH`, `HORAIRES1_RECH`, `HORAIRES2_RECH`, `PREAVIS`, `REMARQUE`, "
            . "`NOTE`) "
            . "VALUES "
            . "(NULL,:input_candidat,'" . $finalName . "',:input_disponible,:input_diplome,:input_exp,"
            . ":input_l1,:input_l2,:input_test_fr1,:input_test_fr2,:input_oral_fr,"
            . ":input_test_en1,:input_test_en2,:input_oral_en,"
            . ":input_speed,:input_appli1,:input_zone,:input_title1,:input_title2,"
            . ":input_title3,:input_salaire_actuel,:input_zone_rech,"
            . ":input_title_futur1,:input_title_futur2,:input_title_futur3,"
            . ":input_salaire_rech,:input_contrat_1,:input_contrat_2,:input_horaires_1,"
            . ":input_horaires_2,:input_preavis,:input_remarque,:input_note_gen)";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    $lastId = $db->lastInsertId();

    foreach ($array_spec as $spec):
        $sql = "INSERT INTO `eval_spec`(`ID_EVAL`, `ID_SPEC`) VALUES (" . $lastId . "," . $spec . ") ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    endforeach;

    header('Location:../candidat/upd_evaluation.php?id=' . $lastId . '&success');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
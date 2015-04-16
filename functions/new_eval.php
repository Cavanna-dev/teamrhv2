<?php

include './connection_db.php';

foreach($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;
try {
    $sql = "INSERT INTO `evaluation`"
            . "(`ID`, `CANDIDAT`, `DISPONIBLE`, `DIPLOME`, `EXPERIENCE`, `LANGUE`, "
            . "`LANGUE2`, `LVL_TEST1_FR`, `LVL_TEST2_FR`, `LVL_ORAL_FR`, `LVL_TEST1_EN`, "
            . "`LVL_TEST2_EN`, `LVL_ORAL_EN`, `LVL_TYPE`, `LVL_NOTE`, `VITESSE`, `WORD`, "
            . "`EXCEL`, `POWERPOINT`, `AUTRE_APPLI1`, `AUTRE_APPLI2`, `MOBILITE`, "
            . "`SECTEUR_ACTUEL`, `SOCIETE_ACTUEL`, `TITRE1_ACTUEL`, `TITRE2_ACTUEL`, "
            . "`TITRE3_ACTUEL`, `SALAIRE_ACTUEL`, `SECTEUR_RECH`, `SOCIETE_RECH`, "
            . "`TITRE1_RECH`, `TITRE2_RECH`, `TITRE3_RECH`, `SAL_MIN_RECH`, `CONTRAT1_RECH`, "
            . "`CONTRAT2_RECH`, `HORAIRES1_RECH`, `HORAIRES2_RECH`, `PREAVIS`, `REMARQUE`, "
            . "`NOTE`, `CREATION`) "
            . "VALUES "
            . "(NULL,:input_candidat,:input_disponible,:input_diplome,:input_exp,"
            . ":input_l1,:input_l2,:input_test_fr1,:input_test_fr2,:input_oral_fr,"
            . ":input_test_en1,:input_test_en2,:input_oral_en,:input_type,:input_note,"
            . ":input_speed,:input_word,:input_excel,:input_pp,:input_appli1,:input_appli2,"
            . ":input_mob,:input_zone,:input_soc,:input_title1,:input_title2,"
            . ":input_title3,:input_salaire_actuel,:input_zone_rech,:input_soc_rech,"
            . ":input_title_futur1,:input_title_futur2,:input_title_futur3,"
            . ":input_salaire_rech,:input_contrat_1,:input_contrat_2,:input_horaires_1,"
            . ":input_horaires_2,:input_preavis,:input_remarque,:input_note_gen,".date('Y-m-d').")";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);
    
    header('Location:../candidat/evaluation.php?success=c');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
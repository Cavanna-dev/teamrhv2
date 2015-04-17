<?php

include './connection_db.php';


foreach ($_POST as $key => $value):
    $array_value[':'.$key] = $value;
endforeach;
//var_dump($array_value);die;

try {
    $sql = "UPDATE `evaluation` SET "
            . "`DISPONIBLE`=:input_disponible,`DIPLOME`=:input_diplome,`EXPERIENCE`=:input_exp,"
            . "`LANGUE`=:input_l1,`LANGUE2`=:input_l2,`LVL_TEST1_FR`=:input_test_fr1,"
            . "`LVL_TEST2_FR`=:input_test_fr2,`LVL_ORAL_FR`=:input_oral_fr,`LVL_TEST1_EN`=:input_test_en1,"
            . "`LVL_TEST2_EN`=:input_test_en2,`LVL_ORAL_EN`=:input_oral_en,`LVL_TYPE`=:input_type,"
            . "`LVL_NOTE`=:input_note,`VITESSE`=:input_speed,`WORD`=:input_word,`EXCEL`=:input_excel,"
            . "`POWERPOINT`=:input_pp,`AUTRE_APPLI1`=:input_appli1,`AUTRE_APPLI2`=:input_appli2,"
            . "`MOBILITE`=:input_mob,`SECTEUR_ACTUEL`=:input_zone,`SOCIETE_ACTUEL`=:input_soc,"
            . "`TITRE1_ACTUEL`=:input_title1,`TITRE2_ACTUEL`=:input_title2,`TITRE3_ACTUEL`=:input_title3,"
            . "`SALAIRE_ACTUEL`=:input_salaire_actuel,`SECTEUR_RECH`=:input_zone_rech,"
            . "`SOCIETE_RECH`=:input_soc_rech,`TITRE1_RECH`=:input_title_futur1,"
            . "`TITRE2_RECH`=:input_title_futur2,`TITRE3_RECH`=:input_title_futur3,"
            . "`SAL_MIN_RECH`=:input_salaire_rech,`CONTRAT1_RECH`=:input_contrat_1,"
            . "`CONTRAT2_RECH`=:input_contrat_2,`HORAIRES1_RECH`=:input_horaires_1,"
            . "`HORAIRES2_RECH`=:input_horaires_2,`PREAVIS`=:input_preavis,"
            . "`REMARQUE`=:input_remarque,`NOTE`=:input_note_gen WHERE id=:input_eval";
    $stmt = $db->prepare($sql);
    $stmt->execute($array_value);

    header('Location:../candidat/upd_evaluation.php?id='.$array_value[':input_eval'].'&success');
} catch (PDOException $e) {
    die("Error : " . $e->getMessage());
}
?>
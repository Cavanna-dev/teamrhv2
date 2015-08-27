<?php

function searchEval($db)
{
    //var_dump($_GET);die;
    $array_value = array();
    $flag_array_empty = 0;
    //Variable de test : savoir si le tableau est vide, si il a au moins une valeur, 
    //on initialise le WHERE pour la condition
    foreach ($_GET as $key => $value):
        $array_value[":" . $key] = $value;
        if ($value != '')
            $flag_array_empty = 1;
    endforeach;
    //var_dump($flag_array_empty);die;
    //var_dump($array_value);die;
    //var_dump($array_value[':input_diplomes']);die;

    $sql = "SELECT e.id, candidat, disponible, secteur_actuel, titre1_actuel, titre1_rech, salaire_actuel "
            . "FROM evaluation e "
            . "LEFT JOIN  candidat c ON e.candidat = c.id ";

    if ($flag_array_empty == 1)
        $sql .= "WHERE ";
    if (!empty($array_value[':input_name']))
        $sql .= "c.nom like '%" . $array_value[':input_name'] . "%' ";
    if (!empty($array_value[':input_name']) &&
            (!empty($array_value[':input_phone']) || !empty($array_value[':input_remarque']) 
            || !empty($array_value[':input_horaire']) || !empty($array_value[':input_l1'])
            || !empty($array_value[':input_disponible']) || !empty($array_value[':input_note']) 
            || !empty($array_value[':input_date_eval']) || !empty($array_value[':input_age']) 
            || !empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini']) 
            || !empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_diplomes'])
            || !empty($array_value[':input_exps']) || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_phone']))
        $sql .= "(c.tel_bureau like '" . $array_value[':input_phone'] . "%' OR "
                . "c.tel_perso like '" . $array_value[':input_phone'] . "%' OR "
                . "c.tel_port like '" . $array_value[':input_phone'] . "%') ";
    if (!empty($array_value[':input_phone']) &&
            (!empty($array_value[':input_remarque']) || !empty($array_value[':input_horaire']) 
            || !empty($array_value[':input_l1']) || !empty($array_value[':input_disponible']) 
            || !empty($array_value[':input_note']) || !empty($array_value[':input_date_eval']) 
            || !empty($array_value[':input_age']) || !empty($array_value[':input_sexe']) 
            || !empty($array_value[':input_salaire_mini']) || !empty($array_value[':input_salaire_maxi']) 
            || !empty($array_value[':input_diplomes']) || !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_remarque']))
        $sql .= "remarque like '%" . $array_value[':input_remarque'] . "%' ";
    if (!empty($array_value[':input_remarque']) &&
            (!empty($array_value[':input_horaire']) || !empty($array_value[':input_l1']) 
            || !empty($array_value[':input_disponible']) || !empty($array_value[':input_note']) 
            || !empty($array_value[':input_date_eval']) || !empty($array_value[':input_age']) 
            || !empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini'])
            || !empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_diplomes'])
            || !empty($array_value[':input_exps']) || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_horaire']))
        $sql .= "(horaires1_rech = '" . $array_value[':input_horaire'] . "' OR "
                . "horaires2_rech = '" . $array_value[':input_horaire'] . "') ";
    if (!empty($array_value[':input_horaire']) &&
            (!empty($array_value[':input_l1']) || !empty($array_value[':input_diplomes']) 
            || !empty($array_value[':input_disponible']) || !empty($array_value[':input_note']) 
            || !empty($array_value[':input_date_eval']) || !empty($array_value[':input_age']) 
            || !empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini']) 
            || !empty($array_value[':input_salaire_maxi'])|| !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_l1']))
        $sql .= "langue = '" . $array_value[':input_l1'] . "' ";
    if (!empty($array_value[':input_l1']) &&
            (!empty($array_value[':input_disponible']) || !empty($array_value[':input_note']) 
            || !empty($array_value[':input_date_eval']) || !empty($array_value[':input_age']) 
            || !empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini']) 
            || !empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_title_futur']) 
            || !empty($array_value[':input_diplomes'])|| !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_disponible']))
        $sql .= "disponible = '" . $array_value[':input_disponible'] . "' ";
    if (!empty($array_value[':input_disponible']) &&
            (!empty($array_value[':input_note']) || !empty($array_value[':input_date_eval']) 
            || !empty($array_value[':input_age']) || !empty($array_value[':input_sexe']) 
            || !empty($array_value[':input_salaire_mini']) || !empty($array_value[':input_salaire_maxi']) 
            || !empty($array_value[':input_diplomes'])|| !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_note']))
        $sql .= "note = '" . $array_value[':input_note'] . "' ";
    if (!empty($array_value[':input_note']) &&
            (!empty($array_value[':input_date_eval']) || !empty($array_value[':input_age']) 
            || !empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini']) 
            || !empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_diplomes'])
            || !empty($array_value[':input_exps'])|| !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_date_eval']))
        $sql .= "e.creation >= date_sub(now(), interval " . $array_value[':input_date_eval'] . " month) ";
    if (!empty($array_value[':input_date_eval']) &&
            (!empty($array_value[':input_age']) || !empty($array_value[':input_sexe']) 
            || !empty($array_value[':input_salaire_mini']) || !empty($array_value[':input_salaire_maxi']) 
            || !empty($array_value[':input_diplomes'])|| !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_age']))
        $sql .= "date_sub(now(), interval " . $array_value[':input_age'] * 12 . " month) <= c.naissance ";
    if (!empty($array_value[':input_age']) &&
            (!empty($array_value[':input_sexe']) || !empty($array_value[':input_salaire_mini']) 
            || !empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_diplomes'])
            || !empty($array_value[':input_exps']) || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_sexe']))
        $sql .= "c.sexe = '" . $array_value[':input_sexe'] . "' ";
    if (!empty($array_value[':input_sexe']) &&
            (!empty($array_value[':input_salaire_mini']) || !empty($array_value[':input_diplomes']) 
            || !empty($array_value[':input_salaire_maxi'])|| !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_salaire_mini']))
        $sql .= "sal_min_rech > '" . $array_value[':input_salaire_mini'] . "' ";
    if (!empty($array_value[':input_salaire_mini']) &&
            (!empty($array_value[':input_salaire_maxi']) || !empty($array_value[':input_diplomes'])
            || !empty($array_value[':input_exps']) || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_salaire_maxi']))
        $sql .= "sal_min_rech < '" . $array_value[':input_salaire_maxi'] . "' ";
    if (!empty($array_value[':input_salaire_maxi']) &&
            (!empty($array_value[':input_diplomes']) || !empty($array_value[':input_exps'])
            || !empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_diplomes'])) {
        $nb_result_dipl = 0;
        $sql .= '( ';
        foreach ($array_value[':input_diplomes'] as $value):
            $nb_result_dipl++;
            $nb_result_dipl > 1 ? $sql .= 'OR ' : '';
            $sql .= "diplome = '" . $value . "' ";
        endforeach;
        $sql .= ')';
    }
    if (!empty($array_value[':input_diplomes']) &&
            (!empty($array_value[':input_exps'] || !empty($array_value[':input_locs']))
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_exps'])) {
        $nb_result_exp = 0;
        $sql .= '( ';
        foreach ($array_value[':input_exps'] as $value):
            $nb_result_exp++;
            $nb_result_exp > 1 ? $sql .= 'OR ' : '';
            $sql .= "experience = '" . $value . "' ";
        endforeach;
        $sql .= ')';
    }
    if (!empty($array_value[':input_exps']) &&
            (!empty($array_value[':input_locs'])
            ))
        $sql .= "AND ";
    if (!empty($array_value[':input_locs'])) {
        $nb_result_loc = 0;
        $sql .= '( ';
        foreach ($array_value[':input_locs'] as $value):
            $nb_result_loc++;
            $nb_result_loc > 1 ? $sql .= 'OR ' : '';
            $sql .= "SUBSTR(c.postal,1,2) = '" . $value . "' ";
        endforeach;
        $sql .= ')';
    }
    //var_dump($sql);die;

    $r = $db->prepare($sql);
    $r->execute();

    return $r;
}

function getOneEvalById($db, $id)
{
    $sql = "SELECT * "
            . "FROM evaluation "
            . "WHERE id='" . $id . "'";
    $r_eval = $db->prepare($sql);
    $r_eval->execute();
    $r = $r_eval->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>

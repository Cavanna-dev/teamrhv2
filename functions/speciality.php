<?php

function getAllSpec($db)
{
    $sql = "SELECT id, libelle "
            . "FROM specialite "
            . "ORDER BY libelle";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

function getAllSpecByEval($db, $id)
{
    $sql = "SELECT es.id_eval, es.id_spec, s.libelle, s.id "
            . "FROM eval_spec es "
            . "LEFT JOIN specialite s ON s.id = es.id_spec "
            . "WHERE es.ID_EVAL='".$id."' "
            . "ORDER BY s.libelle";
    $r = $db->prepare($sql);
    $r->execute();
    
    return $r;
}

function getOneSpecById($db, $id)
{
    $sql = "SELECT id, libelle "
            . "FROM specialite "
            . "WHERE id='" . $id . "'";
    $r_spec = $db->prepare($sql);
    $r_spec->execute();
    $r = $r_spec->fetch(PDO::FETCH_OBJ);

    return $r;
}

?>
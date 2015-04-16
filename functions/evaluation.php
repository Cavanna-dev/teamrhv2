<?php

function searchEval($db)
{
    $dispo = (isset($_GET['input_disponible'])) ? htmlspecialchars($_GET['input_disponible']) : "";
    $secteur = (isset($_GET['input_zone'])) ? htmlspecialchars($_GET['input_zone']) : "";
    $titre = (isset($_GET['input_title'])) ? htmlspecialchars($_GET['input_title']) : "";
    $titre_rech = (isset($_GET['input_title_futur'])) ? htmlspecialchars($_GET['input_title_futur']) : "";
    $remarque = (isset($_GET['input_remarque'])) ? $_GET['input_remarque'] : "";
    $sal_mini = (isset($_GET['input_salaire_mini'])) ? htmlspecialchars($_GET['input_salaire_mini']) : "";
    $sal_maxi = (isset($_GET['input_salaire_maxi'])) ? htmlspecialchars($_GET['input_salaire_maxi']) : "";

    $sql = "SELECT id, candidat, disponible, secteur_actuel, titre1_actuel, titre1_rech, salaire_actuel "
            . "FROM evaluation ";

    if (!empty($dispo) || !empty($secteur) || !empty($titre) 
            || !empty($titre_rech) || !empty($remarque) || !empty($sal_mini)
             || !empty($sal_maxi))
        $sql .= "WHERE ";
    if (!empty($dispo))
        $sql .= "disponible = '".$dispo."' ";
    if (!empty($dispo) && (!empty($secteur) || !empty($titre) || !empty($titre_rech)))
        $sql .= "AND ";
    if (!empty($secteur))
        $sql .= "secteur_actuel = '".$secteur."' ";
    if (!empty($secteur) && !empty($titre))
        $sql .= "AND ";
    if (!empty($titre))
        $sql .= "titre1_actuel = '".$titre."' ";
    if (!empty($titre_rech) && (!empty($titre) || !empty($secteur)))
        $sql .= "AND ";
    if (!empty($titre_rech))
        $sql .= "titre1_rech = '".$titre."' ";
    if (!empty($remarque) && (!empty($titre) || !empty($secteur) || !empty($titre_rech)))
        $sql .= "AND ";
    if (!empty($remarque))
        $sql .= "remarque like '%".$remarque."%' ";
    if (!empty($sal_mini) && (!empty($titre) || !empty($secteur) || !empty($titre_rech) || !empty($remarque)))
        $sql .= "AND ";
    if (!empty($sal_mini))
        $sql .= "salaire_actuel > '".$sal_mini."' ";
    if (!empty($sal_maxi) && (!empty($titre) || !empty($secteur) || !empty($titre_rech) || !empty($remarque) || !empty($sal_mini)))
        $sql .= "AND ";
    if (!empty($sal_maxi))
        $sql .= "salaire_actuel < '".$sal_maxi."' ";
    
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

<?php

include_once './functions/connection_db.php';

$inputLogin     = htmlspecialchars($_POST['inputLogin'], ENT_QUOTES);
$inputPassword  = htmlspecialchars($_POST['inputPassword'], ENT_QUOTES);

try {
    $resultats = $db->query("SELECT nom, prenom, login, pwd, type, color, arrival, sorting, initiale " .
                            "FROM utilisateur " .
                            "WHERE actif = 'Y' AND login = '" . $inputLogin . "'"
                            , PDO::FETCH_OBJ);
    while ($resultat = $resultats->fetch()) {
        $bdLast     = $resultat->nom;
        $bdFirst    = $resultat->prenom;
        $bdLogin    = $resultat->login;
        $bdPassword = $resultat->pwd;
        $bdType     = $resultat->type;
        $bdColor    = $resultat->color;
        $bdArrival  = $resultat->arrival;
        $bdSorting  = $resultat->sorting;
        $bdInitiale = $resultat->initiale;
    }
    
    if ($bdPassword == $inputPassword) {
        session_start();
        $_SESSION['user']['last']     = $bdLast;
        $_SESSION['user']['first']    = $bdFirst;
        $_SESSION['user']['login']    = $bdLogin;
        $_SESSION['user']['type']     = $bdType;
        $_SESSION['user']['color']    = $bdColor;
        $_SESSION['user']['arrival']  = $bdArrival;
        $_SESSION['user']['sorting']  = $bdSorting;
        $_SESSION['user']['initiale'] = $bdInitiale;
        
        header('Location: index.php');
    } else
        header('Location: index.php?error=mdp');
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
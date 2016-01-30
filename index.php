<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['user']['type'])):
            switch ($_SESSION['user']['type']):
                case "SUPERADMIN":
                    $navbar = Array(
                        "Candidat" => Array(
                            "applicant.php" => "Candidat",
                            "evaluation.php" => "Recherche",
                            "birthdays.php" => "Anniversaires",
                        ),
                        "Client" => Array(
                            "client.php" => "Société",
                            "job.php" => "Poste",
                            "placement.php" => "Placement",
                            "agenda.php" => "Agenda",
                        ),
                        "Prospect" => Array(
                            "prospect.php" => "Prospect",
                        ),
                        "Fournisseur" => Array(
                        ),
                        "Comptabilite" => Array(
                            "encaisse.php" => "Encaissé",
                            "decaisse.php" => "Décaissé",
                            "ndf.php" => "Note de Frais",
                            "resultats.php" => "Résultats",
                        ),
                    );
                    break;
                case "ADMIN":
                    $navbar = Array(
                        "Candidat" => Array(
                            "applicant.php" => "Candidat",
                            "evaluation.php" => "Recherche",
                            "birthdays.php" => "Anniversaires",
                        ),
                        "Client" => Array(
                            "client.php" => "Société",
                            "job.php" => "Poste",
                            "placement.php" => "Placement",
                            "agenda.php" => "Agenda",
                        ),
                        "Prospect" => Array(
                            "prospect.php" => "Prospect",
                        ),
                        "Fournisseur" => Array(
                        ),
                        "Comptabilite" => Array(
                            "encaisse.php" => "Encaissé",
                            "decaisse.php" => "Décaissé",
                            "ndf.php" => "Note de Frais",
                            "resultats.php" => "Résultats",
                        ),
                    );
                    break;
                case "ASSOC":
                    $navbar = Array(
                        "Candidat" => Array(
                            "applicant.php" => "Candidat",
                            "evaluation.php" => "Recherche",
                            "birthdays.php" => "Anniversaires",
                        ),
                        "Client" => Array(
                            "client.php" => "Société",
                            "job.php" => "Poste",
                            "agenda.php" => "Agenda",
                        ),
                        "Prospect" => Array(
                            "prospect.php" => "Prospect",
                        ),
                        "Fournisseur" => Array(
                        )
                    );
                    break;
                case "CONSULT":
                    $navbar = Array(
                        "Candidat" => Array(
                            "applicant.php" => "Candidat",
                            "evaluation.php" => "Recherche",
                            "birthdays.php" => "Anniversaires",
                        ),
                        "Client" => Array(
                            "client.php" => "Société",
                            "job.php" => "Poste",
                            "agenda.php" => "Agenda",
                        ),
                        "Prospect" => Array(
                            "prospect.php" => "Prospect",
                        ),
                        "Fournisseur" => Array(
                        )
                    );
                    break;
                case "ASSIST":
                    $navbar = Array(
                        "Candidat" => Array(
                            "applicant.php" => "Candidat",
                            "evaluation.php" => "Recherche",
                            "birthdays.php" => "Anniversaires",
                        ),
                        "Client" => Array(
                            "client.php" => "Société",
                            "job.php" => "Poste",
                        ),
                        "Prospect" => Array(
                            "prospect.php" => "Prospect",
                        ),
                        "Fournisseur" => Array(
                        )
                    );
                    break;
                default:
                    $navbar = Array();
            endswitch;
        else:
            $navbar = Array();
        endif;
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">TeamRH</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php
                        foreach ($navbar as $dropdown => $navlink):
                            ?><li class="dropdown <?php
                            foreach ($navlink as $testKey => $testValue) {
                                if (strpos($_SERVER['PHP_SELF'], $testKey))
                                    echo "active";
                            }
                            ?>">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $dropdown; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    foreach ($navlink as $key => $value):
                                        ?>
                                        <li><a href="<?php echo strtolower($dropdown) . "/" . $key; ?>"><?php echo $value; ?></a></li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                    <?php if (isset($_SESSION['user'])) { ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">Bienvenue <?php echo $_SESSION['user']['first'] . " " . $_SESSION['user']['last'] ?>!</a></li>
                            <li><a href="./logout.php">Se deconnecter!</a></li>
                        </ul>
                    <?php } ?>
                </div>
        </nav>


        <?php if (!isset($_SESSION['user'])) { ?>
            <?php
            include_once './functions/connection_db.php';
            ?>
            <div class="container">
                <div class="jumbotron">
                    <p>Veuillez vous identifiez,</p>
                </div>

                <form class="form-horizontal" action="login.php" method="POST">
                    <fieldset>
                        <legend>Entrez vos identifiants</legend>
                        <div class="form-group">
                            <label for="inputLogin" class="col-lg-2 control-label">Login</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" name="inputLogin" id="inputLogin" placeholder="Login">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-lg-2 control-label">Mot de passe</label>
                            <div class="col-lg-3">
                                <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Mot de passe">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Se Connecter</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php } else { ?>
            <div class="container-fluid">
                <?php include 'calendar.php'; ?>
            </div>
        <?php } ?>
    </body>
</html>
<?php
switch ($_SESSION['user']['type']):
    case "SUPERADMIN":
        $navbar = Array(
            "Candidat" => Array(
                "applicant.php" => "Candidat",
                "evaluation.php" => "Evaluation",
                "recherche.php" => "Recherche",
                "rendezvous.php" => "Rendez-vous",
            ),
            "Client" => Array(
                "client.php" => "Société",
                "contact.php" => "Contact",
                "poste.php" => "Poste",
                "entretien.php" => "Entretien",
                "placement.php" => "Placement",
                "agenda.php" => "Agenda",
            ),
            "Prospect" => Array(
                "prospect.php" => "Prospect",
                "contact.php" => "Contact",
                "planning.php" => "Planning",
            ),
            "Fournisseur" => Array(
                "fournisseur.php" => "Fournisseur",
                "contact.php" => "Contact",
                "media.php" => "Media",
            ),
            "Facturation" => Array(
                "encaisse.php" => "Encaisse",
                "decaisse.php" => "Decaisse",
            ),
            "Comptabilité" => Array(
                "notedefrais.php" => "Notes de frais",
            ),
        );
    break;
    case "ADMIN":
        $navbar = Array(
            "Candidat" => Array(
                "applicant.php" => "Candidat",
                "evaluation.php" => "Evaluation",
                "recherche.php" => "Recherche",
                "rendezvous.php" => "Rendez-vous",
            ),
            "Client" => Array(
                "societe.php" => "Société",
                "contact.php" => "Contact",
                "poste.php" => "Poste",
                "entretien.php" => "Entretien",
                "placement.php" => "Placement",
                "agenda.php" => "Agenda",
            ),
            "Prospect" => Array(
                "prospect.php" => "Prospect",
                "contact.php" => "Contact",
                "planning.php" => "Planning",
            ),
            "Fournisseur" => Array(
                "fournisseur.php" => "Fournisseur",
                "contact.php" => "Contact",
                "media.php" => "Media",
            ),
            "Facturation" => Array(
                "encaisse.php" => "Encaisse",
                "decaisse.php" => "Decaisse",
            ),
            "Comptabilité" => Array(
                "notedefrais.php" => "Notes de frais",
            ),
        );
    break;
    case "CONSULT":
        $navbar = Array(
            "Candidat" => Array(
                "applicant.php" => "Candidat",
                "evaluation.php" => "Evaluation",
                "recherche.php" => "Recherche",
                "rendezvous.php" => "Rendez-vous",
            ),
            "Client" => Array(
                "societe.php" => "Société",
                "contact.php" => "Contact",
                "poste.php" => "Poste",
                "entretien.php" => "Entretien",
                "placement.php" => "Placement",
                "agenda.php" => "Agenda",
            ),
            "Prospect" => Array(
                "prospect.php" => "Prospect",
                "contact.php" => "Contact",
                "planning.php" => "Planning",
            ),
            "Fournisseur" => Array(
                "fournisseur.php" => "Fournisseur",
                "contact.php" => "Contact",
                "media.php" => "Media",
            )
        );
    break;
    case "ASSIST":
        $navbar = Array(
            "Candidat" => Array(
                "applicant.php" => "Candidat",
                "evaluation.php" => "Evaluation",
                "recherche.php" => "Recherche",
                "rendezvous.php" => "Rendez-vous",
            ),
            "Client" => Array(
                "societe.php" => "Société",
                "contact.php" => "Contact",
                "poste.php" => "Poste",
                "entretien.php" => "Entretien",
                "placement.php" => "Placement",
                "agenda.php" => "Agenda",
            ),
            "Prospect" => Array(
                "prospect.php" => "Prospect",
                "contact.php" => "Contact",
                "planning.php" => "Planning",
            ),
            "Fournisseur" => Array(
                "fournisseur.php" => "Fournisseur",
                "contact.php" => "Contact",
                "media.php" => "Media",
            )
        );
    break;
endswitch;
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
            <a class="navbar-brand" href="../index.php">TeamRH</a>
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
                                <li><a href="<?php echo "../" . strtolower($dropdown) . "/" . $key; ?>"><?php echo $value; ?></a></li>
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
                    <li><a href="/logout.php">Se deconnecter!</a></li>
                </ul>
            <?php } ?>
        </div>
</nav>
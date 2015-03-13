<?php
include_once '../template/header.php';
include_once '../template/menu.php';
?>

<div class="container">
    <h1>Gestion des candidats</h1>

    <ul class="nav nav-tabs">
        <li <?php if (isset($_GET['default'])) echo 'class="active"'; ?>><a href="#default" data-toggle="tab" aria-expanded="true">Rechercher un candidat</a></li>
        <li <?php if (isset($_GET['add'])) echo 'class="active"'; ?>><a href="#add" data-toggle="tab" aria-expanded="false">Ajouter un candidat</a></li>
        <li <?php if (isset($_GET['update'])) echo 'class="active"'; ?>><a href="#update" data-toggle="tab" aria-expanded="false">Voir/Modifier un candidat</a></li>
        <li <?php if (isset($_GET['search'])) echo 'class="active"'; ?>><a href="#search" data-toggle="tab" aria-expanded="false">Résultat de la recherche</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="default">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-horizontal" action="searchApplicant.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputName" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Nom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputLast" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputLast" id="inputLast" placeholder="Prénom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCivil" class="col-lg-2 control-label">Etat civil</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCivil" id="select">
                                            <option value="Inconnu"></option>
                                            <option value="Married">Marié</option>
                                            <option value="Single">Célibataire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Adresse">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPostal" class="col-lg-2 control-label">Code postal</label>
                                    <div class="col-lg-10">
                                        <input type="number" class="form-control" name="inputPostal" id="inputPostal" placeholder="Code postal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry" class="col-lg-2 control-label">Pays</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneHome" class="col-lg-2 control-label">Tél. domicile</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneHome" id="inputPhoneHome" placeholder="Tél. domicile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhonePort" class="col-lg-2 control-label">Tél. portable</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhonePort" id="inputPhonePort" placeholder="Tél. portable">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRefusal" class="col-lg-2 control-label">Refus</label>
                                    <div class="col-lg-10">
                                        <div class="checkbox">
                                            <label>
                                                <input name="inputRefusal" type="checkbox">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputWhyRefusal" class="col-lg-2 control-label">Motif Refus</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputWhyRefusal" id="inputWhyRefusal" placeholder="Motif Refus">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputBirthday" class="col-lg-2 control-label">Date de naissance</label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" name="inputBirthday" id="inputBirthday">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sexe</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios1" value="M" checked="">
                                                Masculin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios2" value="F">
                                                Féminin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTown" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputTown" id="inputTown" placeholder="Ville">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSubway" class="col-lg-2 control-label">Métro</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputSubway" id="inputSubway" placeholder="Métro">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneWork" class="col-lg-2 control-label">Tél. bureau</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneWork" id="inputPhoneWork" placeholder="Tél. bureau">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFax" class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputFax" id="inputFax" placeholder="Fax">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputMedia" class="col-lg-2 control-label">Media</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Rechercher un candidat</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="add">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-horizontal" action="addApplicant.php">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputName" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Nom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputLast" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputLast" id="inputLast" placeholder="Prénom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCivil" class="col-lg-2 control-label">Etat civil</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCivil" id="select">
                                            <option value="Inconnu"></option>
                                            <option value="Married">Marié</option>
                                            <option value="Single">Célibataire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Adresse">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPostal" class="col-lg-2 control-label">Code postal</label>
                                    <div class="col-lg-10">
                                        <input type="number" class="form-control" name="inputPostal" id="inputPostal" placeholder="Code postal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry" class="col-lg-2 control-label">Pays</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneHome" class="col-lg-2 control-label">Tél. domicile</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneHome" id="inputPhoneHome" placeholder="Tél. domicile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhonePort" class="col-lg-2 control-label">Tél. portable</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhonePort" id="inputPhonePort" placeholder="Tél. portable">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRefusal" class="col-lg-2 control-label">Refus</label>
                                    <div class="col-lg-10">
                                        <div class="checkbox">
                                            <label>
                                                <input name="inputRefusal" type="checkbox">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputWhyRefusal" class="col-lg-2 control-label">Motif Refus</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputWhyRefusal" id="inputWhyRefusal" placeholder="Motif Refus">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputBirthday" class="col-lg-2 control-label">Date de naissance</label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" name="inputBirthday" id="inputBirthday">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sexe</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios1" value="M" checked="">
                                                Masculin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios2" value="F">
                                                Féminin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTown" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputTown" id="inputTown" placeholder="Ville">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSubway" class="col-lg-2 control-label">Métro</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputSubway" id="inputSubway" placeholder="Métro">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneWork" class="col-lg-2 control-label">Tél. bureau</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneWork" id="inputPhoneWork" placeholder="Tél. bureau">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFax" class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputFax" id="inputFax" placeholder="Fax">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputMedia" class="col-lg-2 control-label">Media</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Ajouter un candidat</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane face" id="update">
            <div class="jumbotron">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-horizontal" action="updateApplicant.php">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputName" class="col-lg-2 control-label">Nom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Nom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputLast" class="col-lg-2 control-label">Prénom</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputLast" id="inputLast" placeholder="Prénom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCivil" class="col-lg-2 control-label">Etat civil</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCivil" id="select">
                                            <option value="Inconnu"></option>
                                            <option value="Married">Marié</option>
                                            <option value="Single">Célibataire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress" class="col-lg-2 control-label">Adresse</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Adresse">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPostal" class="col-lg-2 control-label">Code postal</label>
                                    <div class="col-lg-10">
                                        <input type="number" class="form-control" name="inputPostal" id="inputPostal" placeholder="Code postal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputCountry" class="col-lg-2 control-label">Pays</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneHome" class="col-lg-2 control-label">Tél. domicile</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneHome" id="inputPhoneHome" placeholder="Tél. domicile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhonePort" class="col-lg-2 control-label">Tél. portable</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhonePort" id="inputPhonePort" placeholder="Tél. portable">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRefusal" class="col-lg-2 control-label">Refus</label>
                                    <div class="col-lg-10">
                                        <div class="checkbox">
                                            <label>
                                                <input name="inputRefusal" type="checkbox">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputWhyRefusal" class="col-lg-2 control-label">Motif Refus</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputWhyRefusal" id="inputWhyRefusal" placeholder="Motif Refus">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-horizontal">
                            <fieldset>
                                <div class="form-group">
                                    <label for="inputBirthday" class="col-lg-2 control-label">Date de naissance</label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" name="inputBirthday" id="inputBirthday">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sexe</label>
                                    <div class="col-lg-10">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios1" value="M" checked="">
                                                Masculin
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="inputSexe" id="optionsRadios2" value="F">
                                                Féminin
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputTown" class="col-lg-2 control-label">Ville</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputTown" id="inputTown" placeholder="Ville">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputSubway" class="col-lg-2 control-label">Métro</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputSubway" id="inputSubway" placeholder="Métro">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhoneWork" class="col-lg-2 control-label">Tél. bureau</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputPhoneWork" id="inputPhoneWork" placeholder="Tél. bureau">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputFax" class="col-lg-2 control-label">Fax</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="inputFax" id="inputFax" placeholder="Fax">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputMedia" class="col-lg-2 control-label">Media</label>
                                    <div class="col-lg-10">
                                        <select class="form-control" name="inputCountry" id="select">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-10 col-lg-offset-2">
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Modifier un candidat</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Gestion des RDV -->
            <div class="col-lg-6">
                <h3>Rendez-vous (< 4mois)</h3>
                <div class="jumbotron">
                </div>
            </div>
            <!-- Fin // Gestion des RDV -->

            <!-- Gestion des Commentaires -->
            <div class="col-lg-6">
                <h3>Commentaires</h3>
                <div class="jumbotron">
                </div>
            </div>
            <!-- Fin // Gestion des Commentaires -->

            <!-- Gestion des Envoi des CVs -->
            <div class="col-lg-6">
                <h3>Envoi des CVs</h3>
                <div class="jumbotron">
                </div>
            </div>
            <!-- Fin // Gestion des Envoi des CVs -->

            <!-- Gestion des Messages -->
            <div class="col-lg-6">
                <h3>Messages</h3>
                <div class="jumbotron">
                </div>
            </div>
            <!-- Fin // Gestion des Messages -->
        </div>
        <div class="tab-pane face" id="search">
            <div class="jumbotron">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Column heading</th>
                            <th>Column heading</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Column content</td>
                            <td>Column content</td>
                            <td>Column content</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
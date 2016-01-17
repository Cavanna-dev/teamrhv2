<?php
include '../template/header.php';
include '../template/menu.php';
include '../functions/connection_db.php';
include '../functions/bootstrap.php';
?>

<div class="container">
    <?php
    $r_applis = getAllBirthdaysApplicants($db);
    $result_search = $r_applis->fetchAll(PDO::FETCH_OBJ);
    if ($result_search) {
        $nb = 0;
        $tos = '';
        foreach ($result_search as $r_appli) {
            if ($nb >= 1)
                $tos .= ';';

            $tos .= isset($r_appli->email) ? $r_appli->email : '';
            $nb++;
        }
        ?>

        <h1><?= count($result_search) ?> anniversaire(s) aujourd'hui ! <a class="btn btn-primary" href="mailto:<?= $tos ?>" role="button">Mail groupé</a></h1>
        <div class="jumbotron">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th class="col-lg-10 text-left">Nom - Prénom</th>
                        <th class="col-lg-1 text-left">Anniversaire</th>
                        <th class="col-lg-1 text-right">Mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($result_search as $r_appli) {
                        ?>
                        <tr>
                            <td>
                                <a href="upd_applicant.php?id=<?= $r_appli->id ?>" 
                                   tabindex="0" role="button" 
                                   data-toggle="popover" 
                                   data-trigger="hover" 
                                   data-placement="right" 
                                   data-html="true"
                                   data-content="<?= str_replace('"', '\'', $r_appli->remarque_eval) ?>">
                                       <?= $r_appli->nom . " " . $r_appli->prenom; ?>
                                </a>
                            </td>
                            <td class='text-center'>
                                <?= isset($r_appli->anniversaire) ? $r_appli->anniversaire : ''; ?>
                            </td>
                            <td class='text-right'>
                                <?php $to = isset($r_appli->email) ? $r_appli->email : ''; ?>
                                <?php if ($to != '') { ?>
                                    <a href="mailto:<?= $to ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-dismissible alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Aucun anniversaire aujourd'hui !</h4>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    $(window).ready(function () {
        $(function () {
            $('[data-toggle="popover"]').popover({
                container: 'body'
            });
        });
    });
</script>
<?php
require __DIR__."/../../core/All_One.php";
require __DIR__."/../../config/prodect.php";
require_once __DIR__."/controller/WebService.php";
Security::checkAccess("test");


$webservice = new WebService();
$val = Security::get("id");
$combinss = $webservice->getCombines($val);
//var_dump($combinss);
//die();
?>

<html>
<head>
    <?php getALLcss(); ?>
    <style>
        th{
            text-align: left;
        }
    </style>
</head>
<body>
<div class="col-md-12">
    <div class="card" style="margin-top: 1%">
        <h5 class="card-header"><?= Languege::_("combines")?></h5>
        <div class="card-body">
            <table class="table table-hover" style="width: 100%">
                <thead class="thead-dark">
                <th><?= Languege::_("ID") ?></th>
                <th><?= Languege::_("name") ?></th>
                <th><?= Languege::_("color") ?></th>
                </thead>
                <tbody>
                <?php
                if ($combinss!=null) {
                    foreach ($combinss as $com) { ?>
                        <tr>
                            <td><?= $com->id ?></td>
                            <td><?= $com->name ?></td>
                            <td style="background: <?= $com->color ?>"></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>

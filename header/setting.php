<?php
require_once __DIR__."/../core/All_One.php";

Security::checkAccess("setting");

$configs=R::exec("SELECT * FROM `config`;");


?>
<html>
<head>
    <?php getALLcss(); ?>

    <script>
        $(document).ready(function () {
            $("select").change(function () {
                $("#select_cat").submit();
            });

            $(".edit_con").change(function () {
                var value = $(this).val();
                var id    = $(this).attr("id");
                $.ajax({
                    url:"config_manager.php?action=config",
                    type:"POST",
                    data:{"id":id,"val":value},
                    success:function (msg) {
                        if (msg.trim()=="ok"){
                            $.notify("<?=Languege::_("ok") ?>","success",{ position:"right bottom" });
                        }
                    }
                });
            });
        });
    </script>


</head>
<body>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <form method="get" id="select_cat">
                <select style="margin-top: 2%" class="form-control col-md-2 offset-10" name="cat">
                    <option value="all">---</option>
                    <?php
                    $cats=R::getAll("SELECT DISTINCT cat FROM `config`;");
                    foreach ($cats as $cat){ ?>
                        <option <?php echo (isset($_GET['cat']) && Security::get("cat")==$cat['cat'])? 'selected=selected' : ""?> value="<?=$cat['cat'] ?>"><?=Languege::_($cat['cat']) ?></option>
                    <?php
                    }
                    ?>
                </select>
            </form>
        </div>
    </div>
    <div class="col-md-12">

        <table class="table table-hover col-md-10 offset-1">
            <thead class="thead-dark">
            <tr>
                <th><?= Languege::_("Row") ?></th>
                <th><?= Languege::_("name") ?></th>
                <th><?= Languege::_("value") ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_GET['cat']) && $_GET['cat']!="all"){
                $cat=Security::get("cat");
                $sql_cat="SELECT * FROM `config` WHERE cat='$cat';";
            }else{
                $sql_cat="SELECT * FROM `config`;";
            }

            $configs = R::getAll($sql_cat);
            $num=1;
            foreach ($configs as $config){ ?>
                <tr>
                    <td><?php echo $num; $num++; ?></td>
                    <td><?=Languege::_($config['name']) ?></td>
                    <td><input id="<?=$config['title'] ?>" name="<?=$config['title'] ?>" class="form-control col-md-6 edit_con" type="text" value="<?=$config['setting'] ?>"></td>
                </tr>

                <?php
            }
            ?>


            </tbody>
        </table>
    </div>
</div>
</body>
</html>

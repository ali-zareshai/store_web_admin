<?php
require_once __DIR__."/../core/All_One.php";
require_once __DIR__."/../core/MenuPlugin.php";

Security::checkAccess("users");

$users     =R::getAll("SELECT * FROM `users`");
$deparement=R::getAll("SELECT * FROM `departman`");
$str_dep="{";
foreach ($deparement as $dep){
    $str_dep .= "\"".$dep['name']."\":\"".$dep['name']."\",";
}
$str_dep .="}";

function checkAccess($page,$group_num,$checked){
    if ($checked=="1"){
        $checked="checked=checked";
    }else{
        $checked="";
    }
    ?>
    <input name="<?=$page."#".$group_num ?>" type="checkbox" <?=$checked ?> class="form-control check_access" id="<?=$page."#".$group_num ?>">
<?php

}

if (isset($_POST['access_submit'])){
    R::exec("UPDATE `departement` SET group1=0 , group2=0 ,group3=0 ,group4=0 ,group5=0 ,group6=0 ,group7=0 ,group8=0 ,group9=0 ,group10=0 ;");
    foreach ($_POST as $item=>$value){
        if ($item=="access_submit"){
            continue;
        }
        list($page,$field)=explode("#",$item);
        $sql="UPDATE `departement` SET $field=1 where `page`='$page' ;";
        R::exec($sql);
    }
    ?>
    <div class="col-md-6 offset-4" >
        <div class="alert alert-success"><?=Languege::_("ok") ?></div>
    </div>
    <script>
        setTimeout(function () {
            $(".alert").slideUp();
        },4000);
    </script>
<?php

}

?>
<html>
<head>
    <?php getALLcss(); ?>

    <style>
        .btn{
            margin-top: 2%;
            margin-bottom: 1%;
        }

        .nav-tabs{
            margin-top: 1%;
        }

        .table{
            margin-top: 1%;
        }
    </style>


</head>
<body>
<div class="col-md-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><?=Languege::_("users") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?=Languege::_("Access Policy") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false"><?=Languege::_("Depatemnts") ?></a>
        </li>
<!--        <li class="nav-item">-->
<!--            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>-->
<!--        </li>-->
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-md-12">
                <button id="user_btnnew" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><?=Languege::_("new user") ?></button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><?=Languege::_("new user") ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"><?=Languege::_("Name") ?>:</label>
                                        <input type="text" class="form-control" id="user_name">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"><?=Languege::_("Username") ?>:</label>
                                        <input type="text" class="form-control" id="user_username">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"><?=Languege::_("Email") ?>:</label>
                                        <input type="text" class="form-control" id="user_email">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label"><?=Languege::_("Password") ?>:</label>
                                        <input type="text" class="form-control" id="user_pass">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=Languege::_("close") ?></button>
                                <button id="user_save" type="button" class="btn btn-primary"><?=Languege::_("save") ?></button>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="users-table"></div>

            </div>
        </div>
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="col-md-12">
                <form method="post" action="">
                    <input type="submit" name="access_submit" class="btn btn-primary" value="<?=Languege::_("save") ?>">
                <table class="table table-hover table-bordered table-responsive-md">
                    <thead class="thead-dark">
                    <tr>
                        <th><?=Languege::_("pages") ?></th>
                        <?php
                        $pages=R::getAll("SELECT * FROM `departman`;");
                        foreach ($pages as $page){ ?>
                            <th><?=$page['name'] ?></th>
                           <?php
                        }
                        ?>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $access=R::getAll("SELECT * FROM `departement`;");
                    foreach ($access as $act){ ?>
                        <tr>
                            <td><?=Languege::_($act['name']) ?></td>
                            <td><?php checkAccess($act['page'],"group1",$act['group1']) ?></td>
                            <td><?php checkAccess($act['page'],"group2",$act['group2']) ?></td>
                            <td><?php checkAccess($act['page'],"group3",$act['group3']) ?></td>
                            <td><?php checkAccess($act['page'],"group4",$act['group4']) ?></td>
                            <td><?php checkAccess($act['page'],"group5",$act['group5']) ?></td>
                            <td><?php checkAccess($act['page'],"group6",$act['group6']) ?></td>
                            <td><?php checkAccess($act['page'],"group7",$act['group7']) ?></td>
                            <td><?php checkAccess($act['page'],"group8",$act['group8']) ?></td>
                            <td><?php checkAccess($act['page'],"group9",$act['group9']) ?></td>
                            <td><?php checkAccess($act['page'],"group10",$act['group10']) ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
            <div class="col-md-12">
                <table class="table table-hover col-md-10 offset-1">
                    <thead class="thead-dark">
                    <tr>
                        <th class="col-md-5"><?=Languege::_("group") ?></th>
                        <th class="col-md-5"><?=Languege::_("name") ?></th>
                        <th class="col-md-2"><?=Languege::_("action") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($deparement as $group){ ?>
                        <tr>
                            <td><?=Languege::_($group['group_code']) ?></td>
                            <td><input size="50" class="form-control col-md-8 txt_dep" id="<?= $group['group_code'] ?>" value="<?= $group['name'] ?>"></td>
                            <td><button style="display: none" class="btn btn-success save_dep" id="<?= $group['group_code'] ?>"><?=Languege::_("save") ?></button></button></td>
                        </tr>
                       <?php
                    }
                    ?>
                    </tbody>
                </table>


            </div>
        </div>
        <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">...</div>
    </div>

    <script>
        $(function () {
            $('#myTab li:last-child a').tab('show')
        })
    </script>
</div>
</body>
<script>
    $(".save_dep").click(function () {
        var id=$(this).attr("id");
        var value = $("input[id="+id+"]").val();
        $.ajax({
            type:"POST",
            url:"users_manager.php?action=departement",
            data:{"id":id,"val":value},
            success:function (msg) {
                if (msg.trim()=="ok"){
                    swal("<?=Languege::_("ok") ?>");
                    $("button[id="+id+"]").css("display","none");
                }
            },
        });
    });

    $(".txt_dep").change(function () {
        var id = $(this).attr("id");
        $("button[id="+id+"]").css("display","block");
    });
    var tableData=<?php echo json_encode($users); ?>;
    $("#users-table").tabulator({
        height:"311px",
        layout:"fitColumns",
        pagination:"local",
        paginationSize:10,
        responsiveLayout:"hide",
        movableColumns:true,
        data:tableData, //set initial table data
        columns:[
            {title:"<?=Languege::_("ID") ?>", field:"id"},
            {title:"<?=Languege::_("Name") ?>", field:"name", align:"center"},
            {title:"<?=Languege::_("Email") ?>", field:"email", align:"center"},
            {title:"<?=Languege::_("Depatemnt") ?>", field:"departemt", align:"center",editor:"select", editorParams:<?=$str_dep ?>},
            {title:"<?=Languege::_("Enable") ?>", field:"enable",  align:"center",formatter:"tickCross",editor:true},
            {title:"<?=Languege::_("Admin") ?>", field:"isadmin", align:"center",formatter:"tickCross",editor:true},
            {title:"<?=Languege::_("Last Login") ?>", field:"last_login", align:"center"},
        ],
        cellEdited:function(cell){
            var value=cell.getValue();
            var id   =cell.getRow().getData().id;
            var field=cell.getField();

            $.ajax({
                url: "users_manager.php?action=update",
                data: {"id":id,"field":field,"value":value},
                type: "post",
                success: function(req){
                    var req=req.trim();

                    if (req =="ok"){
                        $.notify("<?=Languege::_("ok") ?>","success",{ position:"right bottom" });
                    } else {
                        $.notify("<?=Languege::_("error_update") ?>","error",{ position:"right bottom" });
                    }
                },
                error: function(){
                    swal("Ajx Error");
                }
            })
        },
    });

    $("#user_save").click(function () {
        var name=$("#user_name").val();
        var username=$("#user_username").val();
        var email=$("#user_email").val();
        var pass=$("#user_pass").val();
        if (name=="" || username=="" || email=="" || pass==""){
            swal("<?=Languege::_('please enter data') ?>");
            return;
        }
        $.ajax({
            type:"POST",
            url:"users_manager.php?action=new_user",
            data:{"name":name,"username":username,"email":email,"pass":pass},
            success:function (msg) {
                location.reload();
            }
        });
    });





</script>
</html>

<?php
require_once __DIR__."/../core/All_One.php";
require_once __DIR__."/../core/MenuPlugin.php";

Security::checkAccess("users");

$users=R::getAll("SELECT * FROM `users`");
?>
<html>
<head>
    <?php
    echo "<script>";
    echo file_get_contents(__DIR__."\pubic\jquery-3.3.1.min.js");
    echo "</script>\n";
//    echo "<style>";
//    echo file_get_contents(__DIR__."\pubic\style.css");
//    echo "</style>";
    ?>
    <script src="pubic/jquery-ui.min.js"></script>
    <script src="pubic/tabulator.min.js"></script>
    <link rel="stylesheet" type="text/css" href="pubic/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="pubic/tabulator.min.css">
    <script src="pubic/bootstrap.min.js"></script>
    <script type="text/javascript" src="pubic/notify.min.js"></script>

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
            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Messages</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-md-12">

                <div id="users-table"></div>

            </div>
        </div>
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">...</div>
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
            {title:"<?=Languege::_("Depatemnt") ?>", field:"departemt", align:"center",editor:"select", editorParams:{"male":"Male", "female":"Female"}},
            {title:"<?=Languege::_("Enable") ?>", field:"enable",  align:"center",formatter:"tickCross",editor:true},
            {title:"<?=Languege::_("Admi") ?>", field:"isadmin", align:"center",formatter:"tickCross",editor:true},
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
</script>
</html>

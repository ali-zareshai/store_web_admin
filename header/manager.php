<?php
require_once __DIR__."/../core/All_One.php";
require_once __DIR__."/../core/MenuPlugin.php";

Security::checkAccess("manager");

//if (isset($_FILES['package'])){
//    var_dump($_FILES['package']);
//    echo "jk";
//    if ($_FILES['type']!="application/x-zip-compressed"){
//        showMsg("file format not support");
//    }else{
//        if (!move_uploaded_file($_FILES['tmp_name'],__DIR__."/../plugins/".$_FILES['name'])){
//            showMsg("Error in upload file");
//        }else{
//            installPackage($_FILES['name']);
//        }
//    }
//}

//function installPackage($filename){
//
//}



function showMsg($msg=null){ ?>
    <div id="success_msg" class="alert <?= (is_null($msg))? "alert-success": 'alert-danger'?> col-md-6 offset-4">
        <?php echo (is_null($msg))? Languege::_("ok"):$msg ?>
    </div>
    <script>
        setTimeout(function () {
            $("#success_msg").slideUp();
        },5000);
    </script>
    <?php
}

?>

<html>
<head>
    <?php getALLcss(); ?>
    <style>
        .table{
            margin-top: 2%;
        }
        .fa-trash{
            cursor: pointer;
        }
    </style>
    <script>
        $(document).ready(function () {
            $(".fa-trash").click(function () {
                var name=$(this).attr('id');
                swal({
                    title: "<?=Languege::_('Are you sure?')?>",
                    text: "<?=Languege::_('Deleth Plugin:')?>"+name,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type:"POST",
                                url:"plugin_manager.php?action=deleth",
                                data:{"plugin":name},
                                success:function (msg) {
                                    if (msg.trim()=="ok"){
                                        swal("<?=Languege::_('Deletded plugin')?>", {icon: "success",});
                                    }else {
                                        swal("<?=Languege::_('DeletdError in deleth plugin')?>", {
                                            icon: "error",
                                        });
                                    }
                                },
                            });

                        }
                        // else {
                        //     swal("Your imaginary file is safe!");
                        // }
                    });
            });

            $("#install_btn").click(function () {
                swal({
                    title: "<?=Languege::_('Are you sure?')?>",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            upload();
                        }
                    });
            });

            function upload() {
                var file_data = $('#package').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax({
                    url: 'plugin_manager.php?action=install', // point to server-side PHP script
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(msg){
                        if (msg.trim()=="ok"){
                            swal("<?=Languege::_('ok')?>",{icon: "success",});
                        } else {
                            swal(msg,{icon: "error",});
                            // alert(msg);
                        }
                    }
                });
            }
        });
        

    </script>
    <style>
        .card{
            margin-top: 2%;
        }
        .btn{
            margin-left: 2%;
        }
    </style>
</head>
<body>
<div class="col-md-12">
    <div class="card">
        <h5 class="card-header"><?= Languege::_("install")?></h5>
        <div class="card-body">
            <h5 class="card-title"><?=Languege::_("Please enter a install package")?></h5>
            <form action="" id="install_form" class="form-inline" enctype="multipart/form-data">
                <input id="package" type="file" class="btn btn-warning" name="package" value="<?=Languege::_('package')?>" >
                <input id="install_btn" name="install" type="button" class="btn btn-primary" value="<?=Languege::_('install')?>">
            </form>
        </div>
    </div>
</div>
<div class="col-md-12">
<table class="table table-responsive-md table-hover">
    <thead class="thead-dark">
    <tr>
        <th><?= Languege::_("Row")?></th>
        <th><?= Languege::_("Name")?></th>
        <th><?= Languege::_("version")?></th>
        <th><?= Languege::_("Develop")?></th>
        <th><?= Languege::_("action")?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $num=1;
    foreach (MenuPlugin::listPlugins() as $value){ ?>
        <tr>
            <td><?php echo $num;$num++;?></td>
            <td><?= $value['name']?></td>
            <td><?= $value['version']?></td>
            <td><?= $value['aut']?></td>
            <td><i  title="<?= Languege::_('Deleth')?>" id="<?= $value['name']?>" class="fas fa-trash"></i></td>

        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
</div>
</body>
</html>

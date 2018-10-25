<?php
require_once __DIR__."/../core/All_One.php";
require_once __DIR__."/../core/MenuPlugin.php";

Security::checkAccess("manager");


//________________________________________
$webservice=new WebService();
echo "<pre>";
var_dump($webservice->Post_Data("prodect"));
die();
//$customer['lastname']="fffffff";
//$customer['firstname']="rrrrrr";
//$customer['email']="ali222@test.com";
$str="ID;Active;Name;Categories;Price tax excluded or Price tax included;Tax rules ID;Wholesale price;On sale;Discount amount;Discount percent;Discount from;Discount to;Reference;Supplier reference;Supplier;Manufacturer;EAN13;UPC;Ecotax;Width;Height;Depth;Weight;Quantity;Minimal quantity;Visibility;Additional shipping cost;Unity;Unit price;Short description;Description;Tags;Meta title;Meta keywords;Meta description;URL rewritten;Text when in stock;Text when backorder allowed;Available for order;Product available date;Product creation date;Show price;Image URLs;Delete existing images;Feature;Available online only;Condition;Customizable;Uploadable files;Text fields;Out of stock;ID / Name of shop;Advanced stock management;Depends On Stock;Warehouse";
$sra=explode(";",$str);
$xml ="<prestashop><product>";
$f="";
//foreach ($sra as $value){
//    $f .= "<$value></$value>\n";
//}
$xml .= $f ."
//</prestashop>
//            </product>";
echo $xml;
die();

//print $xml;
$webservice=new WebService();
//$out  = $webservice->getCustomers($customer);
file_put_contents("test.txt",trim($out));
die();

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

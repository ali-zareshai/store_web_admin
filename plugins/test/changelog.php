<?php
require __DIR__."/../../core/All_One.php";
require __DIR__."/../../config/prodect.php";
require_once __DIR__."/controller/WebService.php";
Security::checkAccess("test");

$webservice = new WebService();
//var_dump($webservice->getChangesProdect());
//die();


?>
<html>
<head>
    <?php getALLcss(); ?>
    <script>
        $(document).ready(function () {
            $("#sync").click(function () {
                $.ajax({
                    type:'PUT',
                    url:"<?=$webservice->getAddressProdect()?>",
                    data:"<?=$webservice->getChangeXml()?>",
                    success:function (data, textStatus, xhr) {
                       if (xhr.status=="200"){
                           clearChange();
                       }else {
                           swal("<?=Languege::_("error_update")?>", {icon: "error",});
                       }

                    }
                });
            });
        });

        function clearChange() {
            $.ajax({
                type:'GET',
                url:'controller/ajaxMan.php?action=clear',
                success:function (msg) {
                    if (msg.trim()=="ok"){
                        swal("<?=Languege::_("ok")?>", {icon: "success",});
                        $("#sync").hide();
                    }
                }
            });
        }
    </script>
    <style>
        tbody{
            text-align: center;
        }
        thead{
            text-align: center;
        }
        th{
            text-align: left;
        }
    </style>
</head>
<div class="col-md-12">
    <div class="card" style="margin-top: 1%">
        <h5 class="card-header"><?= Languege::_("changelog")?></h5>
        <div class="card-body">
           <table class="table table-hover" style="width: 100%">
               <thead class="thead-dark">
               <th><?= Languege::_("ID") ?></th>
               <th><?= Languege::_("name") ?></th>
               <th><?= Languege::_("ref") ?></th>
               <th><?= Languege::_("price") ?></th>
               <th><?= Languege::_("kharid") ?></th>
               <th><?= Languege::_("weight") ?></th>
               <th><?= Languege::_("active") ?></th>
               </thead>
               <tbody>
               <?php
               foreach ($webservice->getChangesProdect() as $prodect){ ?>
               <tr>
                   <td><?= $prodect['id_']?></td>
                   <td><?= $prodect['meta_description']?></td>
                   <td><?= $prodect['reference']?></td>
                   <td><?= $prodect['price']?></td>
                   <td><?= $prodect['wholesale_price']?></td>
                   <td><?= $prodect['weight']?></td>
                   <td><?php
                       if ($prodect['active']=="1"){ ?>
                           <img width='15' height='15' src='icon/if_accept.png'/>
                       <?php
                       }
                       ?></td>
               </tr>
               <?php
               }
               ?>
               </tbody>
           </table>
        </div>

    </div>
    <div class="col-md-12" style="margin-top: 1%">
        <div style="text-align: center">
            <button class="btn btn-info" id="sync"><?=Languege::_("sync")?></button>
        </div>
    </div>
</div>
</html>

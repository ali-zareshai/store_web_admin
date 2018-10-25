<?php
require __DIR__."/../../core/All_One.php";
require __DIR__."/../../config/prodect.php";
Security::checkAccess("test");


$prodect = R::getAll('SELECT * FROM `kavir_ele`.`prodect`');
$prodect2=array();
foreach ($prodect as $item){
    $num[]=$item['image'];
    $config=getConfig();
    if (isset($num[0]) && isset($num[1]) &&isset($num[2]) &&isset($num[3])){
        $url   =$config['image_prodect'].$num[0]."/".$num[1]."/".$num[2]."/".$num[3]."/".$item['image']."-small_default.jpg";
        $item['image']="<img class='infoImage' src='".$url."' >";
    }

    $prodect2[]=$item;
}

$prodect =json_encode($prodect2);


?>
<html>
<head>
   <?php getALLcss(); ?>
    <script>
        $(document).ready(function () {
            $("#downdata").click(function () {
                $(this).removeClass("btn-primary");
                $(this).addClass("btn-warning");
                $.ajax({
                    type:"post",
                    url:"controller/ajaxMan.php?action=down",
                    success:function (msg) {
                        if (msg.trim()=="ok"){
                            $(this).removeClass("btn-warning");
                            $(this).addClass("btn-primary");
                            swal("<?=Languege::_("ok")?>", {icon: "success",});
                        }
                    }
                });
            });
        });
    </script>
    <style>
        .infoImage {
            height:95px;
            width:95px;
            cursor:pointer;
        }

        .btn{
            margin-top: 2%;
            margin-bottom: 2%;
            margin-left: 2%;
        }
    </style>
</head>
<body>
<div class="col-md-12">
    <div class="card" style="margin-top: 2%">
        <h5 class="card-header"><?= Languege::_("action")?></h5>
        <div class="card-body">
            <button class="btn btn-primary" id="downdata"><?=Languege::_("Download Data")?><img width="15" height="15" src="icon/refresh-button.png"></button>
        </div>
    </div>
<div>
    <input class="btn btn-info" type="button" id="exportpdf" value="<?= Languege::_("pdf") ?>">
    <input class="btn btn-info" type="button" id="exportcsv" value="<?= Languege::_("excel") ?>">
</div>
<div id="example-table"></div>
</div>
</body>
<script>
    //custom max min header filter
    var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

        var container = $("<span></span>")

        //create and style inputs
        var start = $("<input type='number' placeholder='Min'/>");
        var end = $("<input type='number' placeholder='Max'/>");

        container.append(start).append(end);

        var inputs = $("input", container);

        inputs.css({
            "padding":"4px",
            "width":"50%",
            "box-sizing":"border-box",
        })
            .val(cell.getValue());

        function buildValues(){
            return {
                start:start.val(),
                end:end.val(),
            };
        }

        //submit new value on blur
        inputs.on("change blur", function(e){
            success(buildValues());
        });

        //submit new value on enter
        inputs.on("keydown", function(e){
            if(e.keyCode == 13){
                success(buildValues());
            }

            if(e.keyCode == 27){
                cancel();
            }
        });

        return container;
    }

    //custom max min filter function
    function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
        if(rowValue){
            if(headerValue.start != ""){
                if(headerValue.end != ""){
                    return parseInt(rowValue) >= parseInt(headerValue.start) && parseInt(rowValue) <= parseInt(headerValue.end);
                }else{
                    return parseInt(rowValue) >= parseInt(headerValue.start);
                }
            }else{
                if(headerValue.end != ""){
                    return parseInt(rowValue) <= parseInt(headerValue.end);
                }
            }
        }

        return false; //must return a boolean, true if it passes the filter.
    }
    var tableData = <?=$prodect ?>;

    $("#exportcsv").click(function(){
        $("#example-table").tabulator("download", "csv", "data.csv");
    });

    $("#exportpdf").click(function(){
        // $("#example-table").tabulator("download", "pdf", "report.pdf", {
        //     orientation:"portrait", //set page orientation to portrait
        //     title:"Export Data", //add title to report
        // });
        var data = $("#example-table").tabulator("getData");
        console.log(data);
    });

    $("#example-table").tabulator({
        height:"80%",
        layout:"fitColumns",
        responsiveLayout:"hide",
        pagination:"local",
        paginationSize:10,
        movableColumns:true,
        data:tableData, //set initial table data
        langs:{
            "de-de":{
                "pagination":{
                    "first":"<?= Languege::_("First") ?>", //text for the first page button
                    "first_title":"<?= Languege::_("First Page") ?>", //tooltip text for the first page button
                    "last":"<?= Languege::_("Last") ?>",
                    "last_title":"<?= Languege::_("Last Page") ?>",
                    "prev":"<?= Languege::_("Prev") ?>",
                    "prev_title":"<?= Languege::_("Prev Page") ?>",
                    "next":"<?= Languege::_("Next") ?>",
                    "next_title":"<?= Languege::_("Next Page") ?>",
                },
                "headerFilters":{
                    "default":"<?= Languege::_("filter column...") ?>", //default header filter placeholder text
                }
            }
        },

    columns:[
            {title:"<?= Languege::_("ID") ?>", field:"id_"},
            {title:"<?= Languege::_("image") ?>", field:"image",width:100, align:"center",formatter:"html",height:100},
            {title:"<?= Languege::_("category") ?>", field:"category", sorter:"number", headerFilter:"input"},
            {title:"<?= Languege::_("ref") ?>", field:"reference", headerFilter:"input",editor:"input"},
            {title:"<?= Languege::_("price") ?>", field:"wholesale_price", headerFilter:"input",editor:"number"},
            {title:"<?= Languege::_("weight") ?>", field:"weight", headerFilter:"input",editor:"number"},
            {title:"<?= Languege::_("kharid") ?>", field:"kharid", align:"center", headerFilter:"input",editor:"number"},
            {title:"<?= Languege::_("available") ?>", field:"available_for_order",editor:"input"},
            {title:"<?= Languege::_("show_price") ?>", field:"show_price", sorter:"number",editor:"input"},
            {title:"<?= Languege::_("name") ?>", field:"meta_description", align:"center", headerFilter:"input",editor:"input"},
            {title:"<?= Languege::_("mojodi") ?>", field:"mojodi",width:90, headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction,editor:"number"},
            {title:"<?= Languege::_("update_") ?>", field:"update_",editor:"input"},
            {title:"<?= Languege::_("combine") ?>", field:"combine", align:"center",editor:"input"},
            {title:"<?= Languege::_("combine_id") ?>", field:"combine_id", align:"center",editor:"input"},
            {title:"<?= Languege::_("Track Number") ?>", field:"tracknumber", align:"center",editor:"input"},
            {title:"<?= Languege::_("Description") ?>", field:"des", align:"center",editor:"input"},
        ],
        cellEdited:function(cell){
            var value=cell.getValue();
            var id   =cell.getRow().getData().id_;
            var field=cell.getField();

            $.ajax({
                url: "controller/updateFileld.php?action=update",
                data: {"id":id,"field":field,"value":value},
                type: "post",
                success: function(req){
                    var req=req.trim();
                    var respone=req.split("#");
                    var ok=respone[0];
                    if (ok =="ok"){
                        $.notify(respone[1],"success",{ position:"right bottom" });
                    } else {
                        $.notify(respone[1],"error",{ position:"right bottom" });
                    }
                },
                error: function(){
                    swal("Ajx Error");
                }
            })
        },
    });
    // $("table").setLocale("de-de");
</script>
</html>

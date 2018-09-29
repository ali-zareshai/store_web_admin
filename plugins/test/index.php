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
    <script type="text/javascript" src="public/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="public/jquery-ui.min.js"></script>
    <link href="public/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="public/tabulator.min.js"></script>
    <script type="text/javascript" src="public/jspdf.min.js"></script>
    <script type="text/javascript" src="public/jspdf.plugin.autotable.js"></script>
    <style>
        .infoImage {
            height:95px;
            width:95px;
            cursor:pointer;
        }
    </style>
</head>
<body>
<div>
    <input type="button" id="exportpdf" value="<?= Languege::_("pdf") ?>">
    <input type="button" id="exportcsv" value="<?= Languege::_("excel") ?>">
</div>
<div id="example-table"></div>
</body>
<script>
    //custom max min header filter
    var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

        var container = $("<span></span>")

        //create and style inputs
        var start = $("<input type='number' placeholder='Min' min='0' max='100'/>");
        var end = $("<input type='number' placeholder='Max' min='0' max='100'/>");

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
        //headerValue - the value of the header filter element
        //rowValue - the value of the column in this row
        //rowData - the data for the row being filtered
        //filterParams - params object passed to the headerFilterFuncParams property

        if(rowValue){
            if(headerValue.start != ""){
                if(headerValue.end != ""){
                    return rowValue >= headerValue.start && rowValue <= headerValue.end;
                }else{
                    return rowValue >= headerValue.start;
                }
            }else{
                if(headerValue.end != ""){
                    return rowValue <= headerValue.end;
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
        $("#example-table").tabulator("download", "pdf", "report.pdf", {
            orientation:"portrait", //set page orientation to portrait
            title:"Export Data", //add title to report
        });
    });

    $("#example-table").tabulator({
        height:"80%",
        layout:"fitColumns",
        pagination:"local",
        paginationSize:10,
        movableColumns:true,
        data:tableData, //set initial table data
        columns:[
            {title:"<?= Languege::_("ID") ?>", field:"id_"},
            {title:"<?= Languege::_("image") ?>", field:"image",width:100, align:"center",formatter:"html",height:100},
            {title:"<?= Languege::_("category") ?>", field:"category", sorter:"number", headerFilter:"input"},
            {title:"<?= Languege::_("ref") ?>", field:"ref", headerFilter:"input"},
            {title:"<?= Languege::_("price") ?>", field:"price", headerFilter:"input"},
            {title:"<?= Languege::_("kharid") ?>", field:"kharid", align:"center", headerFilter:"input"},
            {title:"<?= Languege::_("available") ?>", field:"available"},
            {title:"<?= Languege::_("show_price") ?>", field:"show_price", sorter:"number"},
            {title:"<?= Languege::_("name") ?>", field:"name", align:"center", headerFilter:"input"},
            {title:"<?= Languege::_("mojodi") ?>", field:"mojodi",width:90, headerFilter:minMaxFilterEditor, headerFilterFunc:minMaxFilterFunction},
            {title:"<?= Languege::_("update_") ?>", field:"update_"},
            {title:"<?= Languege::_("combine") ?>", field:"combine", align:"center"},
            {title:"<?= Languege::_("combine_id") ?>", field:"combine_id", align:"center"},
        ],
    });
</script>
</html>

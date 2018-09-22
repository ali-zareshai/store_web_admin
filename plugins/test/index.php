<?php
require __DIR__."/../../core/rb.php";
require __DIR__."/../../config/DB.php";
require __DIR__."/../../config/prodect.php";

$infoDB=DB_info();
$address=$infoDB['address'];
$db     =$infoDB['DB'];
$user   =$infoDB['username'];
$pass   =$infoDB['password'];

R::setup( 'mysql:host='.$address.';dbname='.$db, $user, $pass );

$prodect = R::getAll('SELECT * FROM `kavir_ele`.`prodect`');
$prodect2=array();
foreach ($prodect as $item){
    $num[]=$item['image'];
    $config=getConfig();
    if (isset($num[0]) && isset($num[1]) &&isset($num[2]) &&isset($num[3])){
        $url   =$config['image_prodect'].$num[0]."/".$num[1]."/".$num[2]."/".$num[3]."/".$item['image']."-small_default.jpg";
        $item['image']=$url;
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
    <style>
        .infoImage {
            height:16px;
            width:16px;
            cursor:pointer;
        }
    </style>
</head>
<body>
<div id="example-table"></div>
</body>
<script>
    var tableData = <?=$prodect ?>;
    var infoIcon = function(value, data, cell, row, options){
        alert(value);
        return "<img class='infoImage' src='"+data+"'>";
    };
    $("#example-table").tabulator({
        height:"80%",
        paginationSize:20,
        data:tableData, //set initial table data
        columns:[
            {title:"ID", field:"id_"},
            {title:"image", field:"image",formatter:infoIcon,width:40, align:"center"},
            {title:"category", field:"category", sorter:"number"},
            {title:"ref", field:"ref"},
            {title:"price", field:"price"},
            {title:"kharid", field:"kharid", align:"center"},
            {title:"available", field:"available"},
            {title:"show_price", field:"show_price", sorter:"number"},
            {title:" name", field:" name", align:"center"},
            {title:"mojodi", field:"mojodi"},
            {title:" update_", field:" update_"},
            {title:"combine", field:"combine", align:"center"},
            {title:" combine_id", field:" combine_id", align:"center"},
        ],
    });
</script>
</html>

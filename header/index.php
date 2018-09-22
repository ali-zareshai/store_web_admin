<?php
require __DIR__."/../core/MenuPlugin.php";
require __DIR__."/../core/Languege.php";
require __DIR__."/../core/rb.php";

?>
<html lang=''>
<head>

   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles.css">
   <?php
   echo "<script>";
   echo file_get_contents(__DIR__."/jquery-3.3.1.min.js");
   echo "</script>\n";
   echo "<style>";
   echo file_get_contents(__DIR__."/style.css");
   echo "</style>";
   ?>
    <style>
        .has-sub{
            cursor: pointer!important;
        }
    </style>
   <title>CSS MenuMaker</title>
    <script>
        function replacepage($address) {
           $("#iframeshow").attr("src",$address);
           // alert($address);
        }
    </script>
</head>
<body>

<div id='cssmenu'>
<ul>
   <li><a href='#'><span><?= Languege::_("home") ?></span></a></li>
   <li class='active has-sub'><a href='#'><span><?= Languege::_("plugin") ?></span></a>
      <ul>
          <?php echo MenuPlugin::showListPlugin();?>
      </ul>
   </li>
   <li><a href='#'><span>About</span></a></li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
</ul>
</div>
<iframe id="iframeshow" style="width: 100%;margin-top: 0%;height: 100%" src="">

</iframe>
</body>
<html>

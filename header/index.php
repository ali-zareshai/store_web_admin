<?php
require_once __DIR__."/../core/All_One.php";
require_once __DIR__."/../core/MenuPlugin.php";

Security::checkAccess("main");
$login=new Login();

if (isset($_GET['logout'])){
    $login->logOut();
    header("location: login/index.php");
}
?>
<html lang=''>
<head>
    <?php getALLcss(); ?>
    <style>
        .has-sub{
            cursor: pointer!important;
        }
    </style>
   <title><?=Config::getConfig("app_name") ?></title>
    <script>
        function replacepage($address) {
           $("#iframeshow").attr("src","../"+$address);
           $(".ptitle").removeClass("active");
           $("#plugin").addClass("active");
        }
        $(document).ready(function () {
            $(".ptitle").click(function () {
                var url = $(this).attr("id");

                if (url!="plugin"){
                    $("#iframeshow").attr("src",url);
                    $(".ptitle").removeClass("active");
                    $(this).addClass("active");
                }

            });
        });

        function logout() {
            window.location.href="index.php?logout";
        }

    </script>

    <style>
        .ptitle{
            height: 9%;
        }
    </style>

</head>
<body>

<div id='cssmenu'>
<ul>
   <li class="ptitle"><a href='#'><span><?= Languege::_("home") ?></span></a></li>
   <li id="plugin" class='has-sub ptitle'><a href='#'><span><?= Languege::_("plugin") ?></span></a>
      <ul>
          <?php echo MenuPlugin::showListPlugin();?>
      </ul>
   </li>
   <li id="users.php" class="ptitle" ><a href='#'><span><?=Languege::_("users") ?></span></a></li>
   <li id="setting.php" class='last ptitle'><a href='#'><span><?=Languege::_("setting") ?></span></a></li>
   <li style="float: right"  class="has-sub ptitle"><a href="#"><span><?=Languege::_("welcome") ?><br><?=$login->getName()?></span></a>
       <ul>
           <li id="user.php" class="has-sub ptitle"><a href="#"><span><?=Languege::_("setting") ?></span></a> </li>
           <li onclick="logout()" class="has-sub"><a href="#"><span><?=Languege::_("logout") ?></span></a></li>
       </ul>
   </li>
</ul>
</div>
<iframe id="iframeshow" style="width: 100%;margin-top: 0%;height: 100%" src="">

</iframe>
</body>
<html>

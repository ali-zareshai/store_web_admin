<?php
require __DIR__."/../../core/All_One.php";
if (isset($_GET["lang"])){
    $_SESSION['lang']=Security::get("lang");
    LogAction::Log("user change langtuage to ".Security::get("lang"));
}
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <title><?=Config::getConfig("title_login") ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <script src="js/api.js"></script>
    <?php getALLcss(); ?>
    <script>
        function loginform() {
            var username=$("#username").val();
            var pass    =$("#pass").val();
            var csrf    =$("#g-recaptcha-response").val();
            if (username=="" || pass==""){
                swal("<?= Languege::_("Please type your username and password") ?>");
                return;
            }
            //if (csrf==""){
            //    swal("<?//= Languege::_("Please check the the captcha form") ?>//");
            //    return;
            //}
            $.ajax({
                type:"POST",
                url:"checkLogin.php",
                data:{"user":username,"pass":pass,"captcha":csrf},
                success:function (data) {
                   if (data.trim()=="ok"){
                       window.location.href = '../index.php';
                   } else {
                       $.notify(data,"warn",{ position:"right bottom" });
                   }
                }
            });
        }
        function change(val) {
            // alert(val.value);
            $.ajax({
                type:"GET",
                url:"index.php",
                data:{"lang":val.value},
                success:function (data) {
                    window.location.reload();
                }
            });
        }
    </script>

      <link rel="stylesheet" href="css/style.css">
    <style>
        .rc-anchor{
            width:80%;
            float:right;
        }
        .notifyjs-corner{
            right: 0px!important;
            bottom: 0px!important;
            font-size: 20px!important;
            margin-right: 2%!important;
        }
    </style>

  
</head>

<body>

  <div class="cont">
  <div class="demo">
    <div class="login" style="width: 106%;">
      <div class="login__check"></div>
      <div class="login__form">
          <div class="login__row col-md-6" style="margin-left: auto;margin-right: auto">
              <select class="form form-control" name="changezaban" onchange="change(this)">
                  <option
                      <?php
                      if ($_SESSION['lang']=="fa"){
                      echo "selected=true";
                  }
                  ?> value="fa">فارسی</option>
                  <option <?php
                  if ($_SESSION['lang']=="en"){
                      echo "selected=true";
                  }
                  ?>  value="en">English</option>
              </select>
          </div>
        <div class="login__row">
          <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
          </svg>
          <input id="username" type="text" class="login__input name" placeholder="<?= Languege::_("Username") ?>"/>
        </div>
        <div class="login__row">
          <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
          </svg>
          <input id="pass" type="password" class="login__input pass" placeholder="<?= Languege::_("Password") ?>"/>
        </div>
        <div class="g-recaptcha login__row" data-sitekey="6LdGt3EUAAAAANRYv424sokqhpm6j5fmsHGFLjLH"></div>
        <button onclick="loginform()" type="button" class="login__submit"><?= Languege::_("Sign in") ?></button>
      </div>
    </div>

  </div>
</div>





</body>

</html>

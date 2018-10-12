<?php
require_once __DIR__."/../core/All_One.php";
$login=new Login();
if (!$login->isLogin()){
    header("location: login/index.php");
}
if (isset($_POST['new_email'])){
    $email=Security::post("email");
    $id=$login->idUser();
    R::exec("UPDATE `users` SET `email` = '$email' WHERE `users`.`id` = $id;");
    LogAction::Log($login->getName()." change email to $email");
    showMsg();
}
if (isset($_POST['new_pass'])){
    $cur_pass=Security::post("cur_pass");
    $new1=Security::post("new_pass1");
    $new2=Security::post("new_pass2");

    if ($login->checkCurrentPass($cur_pass)){
        if ($new1!=$new2){
            showMsg(Languege::_("new passwords not match"));
        }else{
            if (strlen($new1)<=8){
                showMsg(Languege::_("new password is less of 8 charater"));
            }else{
                $convert=md5($new1);
                $id=$login->idUser();
                R::exec("UPDATE `users` SET `pass` = '$convert' WHERE `users`.`id` = $id;");
                LogAction::Log($login->getName()." change password");
                showMsg();
            }

        }
    }else{
        showMsg(Languege::_("current password is wrong"));
    }
}
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
        .card{
            margin-top: 2%;
        }

        .btn{
            margin-left: 2%;
        }

        input[type=password]{
            margin-left: 2%;
        }

        .alert{
            margin-top: 2%;
        }
    </style>
    <script>
        function checkForm() {
            var current =$("input[name=cur_pass").val();
            var n1      =$("input[name=new_pass1").val();
            var n2      =$("input[name=new_pass2").val();

            if (current=="" || n1=="" || n2==""){
                swal("<?=Languege::_('please enter data') ?>");
                return false;
            } else {
                return true;
            }
        }
    </script>
</head>
<body>
<div class="col-md-12">
    <div class="col-md-12 alert alert-info">
        <span><?=Languege::_("Last Login")?></span>
        <br>
        <span><?=$login->lastLogin()?></span>
    </div>
    <div class="card">
        <h5 class="card-header"><?= Languege::_("Email")?></h5>
        <div class="card-body">
            <h5 class="card-title"><?=Languege::_("Please enter new Email")?></h5>
            <form method="post" class="form-inline">
                <input type="email" class="form-control" name="email" value="<?=$login->getEmail()?>" placeholder="<?=Languege::_('Email')?>">
                <input name="new_email" type="submit" class="btn btn-warning" value="<?=Languege::_('save')?>">
            </form>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header"><?= Languege::_("Password")?></h5>
        <div class="card-body">
            <h5 class="card-title"><?=Languege::_("Please enter new password")?></h5>
            <form method="post" onsubmit="return checkForm()">
                <input type="password" class="form-control col-md-3" name="cur_pass"  placeholder="<?=Languege::_('current password')?>">
                <hr>
                <div class="form-inline">
                   <input type="password" class="form-control" name="new_pass1" placeholder="<?=Languege::_('new password')?>">
                    <input type="password" class="form-control" name="new_pass2" placeholder="<?=Languege::_('repeat new password')?>">
                </div>
                <br>
                <input name="new_pass" type="submit" class="btn btn-warning" value="<?=Languege::_('save')?>">
            </form>
        </div>
    </div>
</div>
</body>
</html>

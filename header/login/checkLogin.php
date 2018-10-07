<?php
require __DIR__."/../../core/All_One.php";

$username=Security::post("user");
$pass    =Security::post("pass");
$captcha =Security::post("captcha");

//$secretKey = "6LdGt3EUAAAAAA4PdKMNLJnwaUawoFmf0UbUFcVQ";
//$ip = $_SERVER['REMOTE_ADDR'];
//$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
//$responseKeys = json_decode($response,true);
//if(intval($responseKeys["success"]) !== 1) {
//    echo Languege::_("Error in Robot");
//    die();
//}
//else {
//    Login::checkPass($username,$pass);
    $login=new Login();
    $login->checkPass($username,$pass);
//}
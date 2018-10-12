<?php
require_once  __DIR__."/rb.php";
require_once __DIR__."/../config/DB.php";
require_once __DIR__."/../core/Languege.php";

$infoDB=DB_info();
$address=$infoDB['address'];
$db     =$infoDB['DB'];
$user   =$infoDB['username'];
$pass   =$infoDB['password'];

R::setup( 'mysql:host='.$address.';dbname='.$db, $user, $pass );
class Login
{
    public function checkPass($username,$pass){
        $user2=R::getRow("SELECT * FROM `users` WHERE username='$username';");
        $user = new stdClass();
        foreach ($user2 as $key => $value)
        {
            $user->$key = $value;
        }
//        var_dump($user);
//        die();
        $pass_user= $user->pass;
        if (isset($pass_user)){
            if (md5($pass)==$pass_user){
                $user_info=$user;
                $_SESSION['info']=serialize($user_info);
//                var_dump(self::$user_info);die();
                if ($user_info->enable==1){
                    $date=$user->last_login=date("Y-m-d H:i:s");
                    $id  =$user->id;
                    R::exec("UPDATE `users` SET `last_login` = '$date' WHERE `users`.`id` = $id; ");
                    $_SESSION['login']=true;
                    LogAction::Log("login success");
                    echo "ok";
                }else{
                    $_SESSION['login']=false;
                    LogAction::Log("username is Disable");
                    self::bad_respone(Languege::_("username is Disable"));
                }


            }else{
                $_SESSION['login']=false;
                LogAction::Log("username or password is incorect");
                self::bad_respone(Languege::_("username or password is incorect"));
            }
        }else{
            $_SESSION['login']=false;
            LogAction::Log("username or password is incorect");
            self::bad_respone(Languege::_("username or password is incorect"));
        }
    }

    public function isLogin(){
        return (isset($_SESSION['login']))? $_SESSION['login']:false;
    }

    public function getUserName(){
        $user_info=unserialize($_SESSION['info']);
        return (!is_null(($user_info->username)))?$user_info->username:null;
    }

    public function isAdmin(){
        $user_info=unserialize($_SESSION['info']);
        if (!is_null($user_info->isadmin) && $user_info->isadmin==1){
            return true;
        }else{
            return false;
        }
    }

    public function checkCurrentPass($password){
        $username = $this->getUserName();
        $user=R::find("users","username=?",["$username"]);
        $pass_user= $user[1]->pass;
        if (isset($pass_user)) {
            if (md5($password) == $pass_user) {
                return true;
            }
        }
        return false;
    }

    public function lastLogin(){
        $user_info=unserialize($_SESSION['info']);
        return (!is_null(($user_info->last_login)))?$user_info->last_login:null;
    }

    public function idUser(){
        $user_info=unserialize($_SESSION['info']);
        return (!is_null(($user_info->id)))?$user_info->id:null;
    }

    public function getDepartemnt(){
        $user_info=unserialize($_SESSION['info']);
        return (!is_null($user_info->departemt))?$user_info->departemt:null;
    }

    public function getEmail(){
        $user_info=unserialize($_SESSION['info']);
        return $user_info->email;
    }

    public function getName(){
        $user_info=unserialize($_SESSION['info']);
        return (!is_null($user_info->name))?$user_info->name:null;
    }

    public function logOut(){
        $_SESSION['login']=false;
        $user_info=null;
        LogAction::Log("user logout");
    }

    private function bad_respone($msg){
        $_SESSION['login']=false;
        echo $msg;
    }


}
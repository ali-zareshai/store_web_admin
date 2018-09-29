<?php
/**
 * Created by PhpStorm.
 * User: Ali
 * Date: 23/09/2018
 * Time: 09:40 PM
 */



class LogAction
{
    public static function Log($msg){
        if (isset($_SESSION['login']) && $_SESSION['login']){
            $login=new Login();
            $user=$login->getName();
        }else{
            $user=$_SERVER['REMOTE_ADDR'];
        }
        $log=date("Y-m-d H:i:s").",".$user.",".$msg."\n";
        file_put_contents(__DIR__."/../etc/log.csv",$log,FILE_APPEND);
    }

}
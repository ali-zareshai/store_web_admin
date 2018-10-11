<?php
require_once __DIR__."/Login.php";
require_once __DIR__."/LogAction.php";
require_once __DIR__."/rb.php";

class Security
{


    public static function get($name){
        return trim(strip_tags($_GET[$name]));
    }

    public static function post($name){
        return trim(strip_tags($_POST[$name]));
    }



    public static function checkAccess($page_name){
//        var_dump(self::getDepartemnt($page_name));die();
        $login=new Login();
        if ($page_name=="login"){
            return true;
        }

        if (!$login->isLogin()){
            self::noAccessPage();
        }
        if ($login->isAdmin() || $page_name=="main"){
            return true;
        }
        if (self::getDepartemnt($page_name)==0){
            self::noAccessPage();
        }
    }

    private static function noAccessPage()
    {
        LogAction::Log("Access Denied");
        die("Access denid!!!!");
    }
    private static function getDepartemnt($page){
        $login=new Login();
        $number=$login->getDepartemnt();
        $number=R::getRow( 'SELECT * FROM `departman` WHERE `name`=?',[ $number ]);
        $number=$number["id"];



        $page_info=R::getRow( 'SELECT * FROM `departement` WHERE `page`=?',[ $page ]);
//        echo "<pre>";
//        var_dump($page_info["group1"]);
//        die();
//        echo $number;die();
//        var_dump($page_info[1]->group1);die();
        try{
            switch ($number){
                case 1:
                    return $page_info["group1"];
                case 2:
                    return $page_info["group2"];
                case 3:
                    return $page_info["group3"];
                case 4:
                    return $page_info["group4"];
                case 5:
                    return $page_info["group5"];
                case 6:
                    return $page_info["group6"];
                case 7:
                    return $page_info["group7"];
                case 8:
                    return $page_info["group8"];
                case 9:
                    return $page_info["group9"];
                case 10:
                    return $page_info["group10"];

            }
        }catch (Exception $exception){
            return 0;
        }
        return 0;
    }


}
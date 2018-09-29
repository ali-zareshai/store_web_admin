<?php
require_once __DIR__."/../lang/lang.php";
class Languege
{

    public function changeLang($lan){
        $this->lang=$lan;
    }

    public static function _($word_old){
        if (!isset($_SESSION['lang']) || is_null($_SESSION['lang']) ){
            $_SESSION['lang']="fa";
        }
        switch ($_SESSION['lang']){
            case "fa":
              $words=fa();
              break;
            case "en":
                $words=array();
                break;
            default:
                $words=fa();

        }
        if (isset($words[$word_old])){
            return $words[$word_old];
        }else{
            return $word_old;
        }
    }


}
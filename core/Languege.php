<?php
require __DIR__."/../lang/lang.php";
class Languege
{
    private static $lang="fa";

    public function changeLang($lan){
        $this->lang=$lan;
    }

    public static function _($word_old){
        switch (self::$lang){
            case "fa":
              $words=fa();
              break;

        }
        return $words[$word_old];
    }


}